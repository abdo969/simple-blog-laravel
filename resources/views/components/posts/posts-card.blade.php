@props(['post'])
<div>
    <a wire:navigate href="{{ route('posts.show', $post) }}">
        <div>
            <img class="w-full rounded-xl" src="{{ $post->getThumbnailImage() }}" alt="thumbnail">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2">
            <div class="me-3">
            @foreach ($post->categories as $category)
                <x-posts.category-badge :category="$category">{{ $category->title }}</x-posts.category-badge>
            @endforeach
            </div>
            <p class="text-gray-500 text-sm">{{ $post->published_at->format('F j, Y') }}</p>
        </div>
        <a wire:navigate href="{{ route('posts.show', $post) }}" class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
    </div>

</div>
