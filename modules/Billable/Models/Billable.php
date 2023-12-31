<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Billable\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Billable\Database\Factories\BillableFactory;
use Modules\Billable\Enums\TaxType;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Models\Model;

class Billable extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tax_type' => TaxType::class,
    ];

    /**
     * Indicates if the model has timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tax_type', 'terms', 'notes'];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->products->each->delete();
        });
    }

    /**
     * Billable has many products
     */
    public function products(): HasMany
    {
        return $this->hasMany(\Modules\Billable\Models\BillableProduct::class)->orderBy('display_order');
    }

    /**
     * Check whether the billable is tax exclusive
     */
    public function isTaxExclusive(): bool
    {
        return $this->tax_type === TaxType::exclusive;
    }

    /**
     * Check whether the billable is tax inclusive
     */
    public function isTaxInclusive(): bool
    {
        return $this->tax_type === TaxType::inclusive;
    }

    /**
     * Check whether the billable has tax
     */
    public function isTaxable(): bool
    {
        return $this->tax_type !== TaxType::no_tax;
    }

    /**
     * Get the owning imageable model.
     */
    public function billableable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the subTotal attribute
     */
    public function subTotal(): Attribute
    {
        return Attribute::get(fn () => static::round(
            $this->products->reduce(function ($total, $product) {
                return $total += $product->totalAmountWithDiscount();
            }, 0)
        ));
    }

    /**
     * Get the totalDiscount attribute
     */
    public function totalDiscount(): Attribute
    {
        return Attribute::get(fn () => static::round(
            $this->products->reduce(function ($total, $product) {
                return $total + $product->totalDiscountAmount();
            }, 0)
        ));
    }

    /**
     * Get the hasDiscount attribute
     */
    public function hasDiscount(): Attribute
    {
        return Attribute::get(fn () => $this->total_discount > 0);
    }

    /**
     * Get the totalTax attribute
     */
    public function totalTax(): Attribute
    {
        return Attribute::get(fn () => static::round(
            collect($this->getAppliedTaxes())->reduce(function ($total, $tax) {
                return $total + $tax['total'];
            }, 0)
        ));
    }

    /**
     * Get the total attribute
     */
    public function total(): Attribute
    {
        return Attribute::get(fn () => static::round(
            $this->subTotal + (! $this->isTaxInclusive() ? $this->totalTax : 0)
        ));
    }

    /**
     * Get the applied taxes on the billable
     */
    public function getAppliedTaxes(): array
    {
        if (! $this->isTaxable()) {
            return [];
        }

        return collect($this->products->unique(function ($product) {
            return $product->tax_label.$product->tax_rate;
        })
            ->sortBy('tax_rate')
            ->where('tax_rate', '>', 0)
            ->reduce(function ($groups, $tax) {
                $groups[] = [
                    'key' => $tax->tax_label.$tax->tax_rate,
                    'rate' => $tax->tax_rate,
                    'label' => $tax->tax_label,
                    'total' => $this->products->filter(function ($product) use ($tax) {
                        return $product->tax_label === $tax->tax_label && $product->tax_rate === $tax->tax_rate;
                    })->reduce(fn ($total, $product) => $total + $this->totalTaxInAmount(
                        $product->totalAmountWithDiscount(),
                        $product->tax_rate,
                        $this->isTaxInclusive()
                    ), 0),
                ];

                return $groups;
            }, []))->map(function ($tax) {
                $tax['total'] = static::round($tax['total']);

                return $tax;
            })->all();
    }

    /**
     * Round the given number/money
     */
    public static function round(mixed $number): float
    {
        return floatval(
            number_format($number, currency(Innoclapps::currency())->getPrecision(), '.', '')
        );
    }

    /**
     * Calculate total tax in the given amount for the given tax rate
     */
    protected function totalTaxInAmount(float $fromAmount, string|int|float $taxRate, bool $isTaxInclusive): float
    {
        $taxRate = floatval($taxRate);

        if ($isTaxInclusive) {
            // [(Unit Price) – (Unit Price / (1+ Tax %))]
            return $fromAmount - ($fromAmount / (1 + ($taxRate / 100)));
        }

        // ((Unit Price) x (Tax %))
        return $fromAmount * ($taxRate / 100);
    }

    /**
     * Get the billable products default tax type
     */
    public static function defaultTaxType(): ?TaxType
    {
        $default = settings('tax_type');

        if ($default) {
            return TaxType::find($default);
        }

        return null;
    }

    /**
     * Set the billable products default tax type
     */
    public static function setDefaultTaxType(null|string|TaxType $value): void
    {
        settings(['tax_type' => $value instanceof TaxType ? $value->name : $value]);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): BillableFactory
    {
        return BillableFactory::new();
    }
}
