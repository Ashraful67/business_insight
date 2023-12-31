<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Documents\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\Model;
use Modules\Documents\Database\Factories\DocumentSignerFactory;

class DocumentSigner extends Model
{
    use HasFactory;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['document'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'sent_at', 'send_email'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'document_id' => 'int',
        'signed_at' => 'datetime',
        'sent_at' => 'datetime',
        'send_email' => 'bool',
    ];

    /**
     * Get the document the signers belongs to
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(\Modules\Documents\Models\Document::class);
    }

    /**
     * Check whether the signer has signed the document
     */
    public function hasSignature(): bool
    {
        return ! is_null($this->signature) && ! is_null($this->signed_at) && ! is_null($this->sign_ip);
    }

    /**
     * Check whether the signer is missing the signature
     */
    public function missingSignature(): bool
    {
        return ! $this->hasSignature();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): DocumentSignerFactory
    {
        return DocumentSignerFactory::new();
    }
}
