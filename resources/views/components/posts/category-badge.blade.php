@props(['category'])
<button wire:navigate wire:click="updatedCategory({{ $category }})" href="{{ route('posts.index', ['category' => $category->slug]) }}" class="rounded-xl px-3 py-1 text-base gap-2" style="background-color: {{ $category->bg_color }}; color: {{ $category->text_color }};">{{ $slot }}</button>
