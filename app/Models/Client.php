<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'tax_id',
        'notes',
        'recurring_enabled',
        'recurring_frequency',
        'recurring_frequency_months',
        'business_start_date',
        'next_invoice_date',
    ];

    protected function casts(): array
    {
        return [
            'recurring_enabled' => 'boolean',
            'business_start_date' => 'date',
            'next_invoice_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            collect([$this->city, $this->state, $this->postal_code])->filter()->implode(', '),
            $this->country,
        ])->filter()->implode("\n");
    }
}
