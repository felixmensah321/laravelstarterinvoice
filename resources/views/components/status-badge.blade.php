@props(['status'])

@php
$classes = match($status) {
    'draft' => 'bg-gray-100 text-gray-800',
    'sent' => 'bg-blue-100 text-blue-800',
    'viewed' => 'bg-yellow-100 text-yellow-800',
    'paid' => 'bg-green-100 text-green-800',
    'overdue' => 'bg-red-100 text-red-800',
    'cancelled' => 'bg-gray-100 text-gray-500',
    'pending' => 'bg-yellow-100 text-yellow-800',
    'processing' => 'bg-blue-100 text-blue-800',
    'completed' => 'bg-green-100 text-green-800',
    'failed' => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800',
};
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $classes }}">
    {{ ucfirst($status) }}
</span>
