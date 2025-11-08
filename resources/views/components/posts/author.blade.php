@props(['author', 'size'])

@php
    $imageSize = match ($size ?? 'sm') {
        'sm' => 'w-7 h-7',
        'md' => 'w-10 h-10',
        'lg' => 'w-14 h-14',
        default => 'w-7 h-7',
    };

    $textSize = match ($size ?? 'sm') {
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-lg',
        default => 'text-xs',
    };
@endphp

<img class="{{ $imageSize }} rounded-full mr-3" src="{{ $author->profile_photo_url }}" alt="{{ $author->name }}">
<span class="mr-1 {{ $textSize }}">{{ $author->name }}</span>
