<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'invoice_number',
        'status',
        'issue_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'total',
        'currency',
        'pdf_path',
        'sent_at',
        'viewed_at',
        'paid_at',
        'notes',
        'terms',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'subtotal' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total' => 'decimal:2',
            'sent_at' => 'datetime',
            'viewed_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(InvoiceActivity::class)->latest();
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items()->sum(\DB::raw('quantity * unit_price'));
        $taxAmount = round($subtotal * ($this->tax_rate / 100), 2);
        $total = $subtotal + $taxAmount - $this->discount_amount;

        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => max(0, $total),
        ]);
    }

    public function markAsSent(): void
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
        $this->logActivity('status_change', $oldStatus, 'sent', 'Invoice sent to client');
    }

    public function markAsViewed(): void
    {
        if ($this->viewed_at) {
            return;
        }
        $oldStatus = $this->status;
        $this->update([
            'status' => 'viewed',
            'viewed_at' => now(),
        ]);
        $this->logActivity('status_change', $oldStatus, 'viewed', 'Invoice viewed by client');
    }

    public function markAsPaid(): void
    {
        $oldStatus = $this->status;
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        $this->logActivity('status_change', $oldStatus, 'paid', 'Invoice marked as paid');
    }

    public function markAsOverdue(): void
    {
        $oldStatus = $this->status;
        $this->update(['status' => 'overdue']);
        $this->logActivity('status_change', $oldStatus, 'overdue', 'Invoice marked as overdue');
    }

    public function logActivity(string $type, ?string $fromStatus = null, ?string $toStatus = null, string $description = '', ?array $metadata = null): void
    {
        $this->activities()->create([
            'type' => $type,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue';
    }
}
