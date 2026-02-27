<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'company_logo_path',
        'default_currency',
        'default_tax_rate',
        'default_terms',
        'invoice_prefix',
        'next_invoice_number',
    ];

    protected function casts(): array
    {
        return [
            'default_tax_rate' => 'decimal:2',
            'next_invoice_number' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function generateInvoiceNumber(): string
    {
        return DB::transaction(function () {
            $setting = self::where('id', $this->id)->lockForUpdate()->first();
            $number = $setting->invoice_prefix . str_pad($setting->next_invoice_number, 5, '0', STR_PAD_LEFT);
            $setting->increment('next_invoice_number');
            return $number;
        });
    }
}
