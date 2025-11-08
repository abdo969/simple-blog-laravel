<div id="recommended-topics-box">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('blog.recommended_categories') }}</h3>
    <div class="topics flex flex-wrap justify-start">
    </div>
    @foreach ($categories as $category)
        <x-posts.category-badge :category="$category">{{ $category->title }}</x-posts.category-badge>
    @endforeach
</div>
