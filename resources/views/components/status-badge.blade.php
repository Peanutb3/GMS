<!-- <div>
    If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius
</div>  -->

@props(['status' => 'unknown'])

@php
    $s = strtolower(trim($status ?? 'unknown'));
    $map = [
        'open'        => 'bg-green-100 text-green-800',
        'pending'     => 'bg-yellow-100 text-yellow-800',
        'in_progress' => 'bg-yellow-100 text-yellow-800',
        'in progress' => 'bg-yellow-100 text-yellow-800',
        'resolved'    => 'bg-blue-100 text-blue-800',
        'closed'      => 'bg-gray-200 text-gray-800',
        'dismissed'   => 'bg-red-100 text-red-800',
        'unknown'     => 'bg-gray-100 text-gray-700',
    ];
    $classes = $map[$s] ?? $map['unknown'];
    $label = ucwords(str_replace(['_','-'], [' ', ' '], $s ?: 'Unknown'));
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {$classes}"]) }}>
    {{ $label }}
</span>