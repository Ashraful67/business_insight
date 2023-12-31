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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Billable\Database\Factories\BillableProductFactory;
use Modules\Core\Models\Model;

class BillableProduct extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * Avoid lazy loading violation exception when saving products to Billable
     *
     * @var array
     */
    protected $with = ['billable', 'originalProduct'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'qty',
        'unit',
        'tax_rate',
        'tax_label',
        'discount_type',
        'discount_total',
        'display_order',
        'note',
        'product_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'unit_price' => 'decimal:3',
        'tax_rate' => 'decimal:3',
        'qty' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'amount' => 'decimal:3',
        'billable_id' => 'int',
        'display_order' => 'int',
        'product_id' => 'int',
    ];

    /**
     * The fields for the model that are searchable.
     */
    protected static array $searchableFields = [
        'originalProduct.sku',
        'name' => 'like',
    ];

    /**
     * Boot the BillableProduct model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->amount = $model->totalAmountBeforeTax();
        });
    }

    /**
     * Get the underlying original product
     *
     * Note that the original product may be null as well if deleted
     */
    public function originalProduct(): BelongsTo
    {
        return $this->belongsTo(\Modules\Billable\Models\Product::class, 'product_id');
    }

    /**
     * Get the sku attribute
     */
    public function sku(): Attribute
    {
        return Attribute::get(fn () => $this->originalProduct?->sku);
    }

    /**
     * A product belongs to a billable model
     */
    public function billable(): BelongsTo
    {
        return $this->belongsTo(Billable::class);
    }

    /**
     * Get the taxRate attribute
     */
    public function taxRate(): Attribute
    {
        return Attribute::get(function () {
            // In case the billable is saved with no tax but the product tax_rate attribute has tax
            if (! $this->billable->isTaxable()) {
                return 0;
            }

            return $this->castAttribute('tax_rate', $this->attributes['tax_rate'] ?? 0);
        });
    }

    /**
     * Get the product total amount with discount included
     */
    public function totalAmountWithDiscount(): float
    {
        $unitPrice = $this->unit_price;
        $qty = $this->qty;

        return Billable::round(
            ($unitPrice * $qty) - $this->totalDiscountAmount()
        );
    }

    /**
     * Get the product total discount amount
     */
    public function totalDiscountAmount(): float
    {
        if ($this->discount_type === 'fixed') {
            return floatval($this->discount_total);
        }

        $discountRate = $this->discount_total;
        $unitPrice = $this->unit_price;
        $qty = $this->qty;

        if ($this->billable->isTaxInclusive()) {
            // (Discount %) x (Unit Price) x Qty
            return Billable::round(($discountRate / 100) * ($unitPrice) * $qty);
        }

        // (Discount %) x (Unit Price x Qty)
        return Billable::round(($discountRate / 100) * ($unitPrice * $qty));
    }

    /**
     * Get the product total tax amount
     */
    public function totalTaxAmount(): int|float
    {
        if (! $this->billable->isTaxable()) {
            return 0;
        }

        $unitPrice = $this->unit_price;
        $qty = $this->qty;
        $taxRate = $this->tax_rate;

        if ($this->billable->isTaxInclusive()) {
            // Qty x [(Unit Price – Discount Amount) – (Unit Price – Discount Amount / (1+ Tax %))]
            $amount = $qty * (
                ($unitPrice - $this->totalDiscountAmount()) -
                ($unitPrice - $this->totalDiscountAmount()) / (1 + ($taxRate / 100))
            );
        } else {
            // Qty x ((Unit Price - Discount Amount) x (Tax %))
            $amount = $qty * (($unitPrice - $this->totalDiscountAmount()) * ($taxRate / 100));
        }

        return Billable::round($amount);
    }

    /**
     * Get the product total amount including taxes and discount
     */
    public function totalAmount(): float
    {
        $taxAmount = $this->totalTaxAmount();

        // Tax amount + Amount before tax
        return Billable::round(
            ($taxAmount + $this->totalAmountBeforeTax())
        );
    }

    /**
     * Get the total product amount before tax
     */
    public function totalAmountBeforeTax(): float
    {
        if (! $this->billable->isTaxable()) {
            return $this->totalAmountWithDiscount();
        }

        $unitPrice = $this->unit_price;
        $qty = $this->qty;
        $taxRate = $this->tax_rate;

        if ($this->billable->isTaxInclusive()) {
            // Qty x ((Unit Price – Discount Amount) / (1+ Tax %))
            $amount = $qty * (($unitPrice - $this->totalDiscountAmount()) / (1 + ($taxRate / 100)));
        } else {
            // Qty x (Unit Price – Discount Amount)
            $amount = $qty * ($unitPrice - $this->totalDiscountAmount());
        }

        return Billable::round($amount);
    }

    /**
     * Get the billable products default discount type
     */
    public static function defaultDiscountType(): ?string
    {
        return settings('discount_type');
    }

    /**
     * Set the billable products default discount type
     */
    public static function setDefaultDiscountType(?string $value): void
    {
        settings(['discount_type' => $value]);
    }

    /**
     * Get the billable products default tax label
     */
    public static function defaultTaxLabel(): ?string
    {
        return settings('tax_label');
    }

    /**
     * Set the billable products default tax label
     */
    public static function setDefaultTaxLabel(?string $value): void
    {
        settings(['tax_label' => $value]);
    }

    /**
     * Get the billable products default tax rate
     */
    public static function defaultTaxRate(): float|int|null
    {
        return settings('tax_rate');
    }

    /**
     * Set the billable products default tax label
     */
    public static function setDefaultTaxRate(float|int|null $value): void
    {
        settings(['tax_rate' => $value]);
    }

    /**
     * Get the document attributes that are used in a form
     */
    public static function formAttributes(): array
    {
        return [
            'name',
            'description',
            'unit_price',
            'qty',
            'discount_total',
            'discount_type',
            'tax_rate',
            'tax_label',
            'unit',
            'note',
            'product_id',
            'display_order',
        ];
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): BillableProductFactory
    {
        return BillableProductFactory::new();
    }
}
