<div class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-gray-800 text-lg flex items-center">
            @if ($search || $category)
                <button class="p-2 me-3 bg-gray-200 rounded-full hover:bg-gray-300 inline-flex items-center justify-center" wire:click="clearFilters">
                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-6 rotate-45">
                        <path
                            d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z">
                        </path>
                    </svg>
                </button>
            @endif
            @if ($search && $category)
                {{ __('blog.searching') }} <span class="font-semibold mx-1">{{ $search }}</span> {{ __('blog.and') . ' ' . __('blog.filtering_by_category') }} <span class="font-semibold mx-1">{{ $this->getCategoryNameAttribute() }}</span>
            @elseif ($category)
                {{ __('blog.filtering_by_category') }} <span class="font-semibold mx-1">{{ $this->getCategoryNameAttribute() }}</span>
            @elseif ($search)
                {{ __('blog.searching') }} <span class="font-semibold mx-1">{{ $search }}</span>
            @else
                {{ __('blog.all_posts') }}
            @endif
        </div>
        <div class="flex items-center space-x-4 font-light ">
            <x-checkbox wire:model.live='popular' />
            <x-label>{{ __('blog.filters.popular') }}</x-label>
            <button
                class="{{ $this->sort === 'desc' ? 'text-gray-900 py-4 border-b border-gray-700' : 'text-gray-500' }} py-4"
                wire:click="setSort('desc')">{{ __('blog.filters.latest') }}</button>
            <button
                class="{{ $this->sort === 'asc' ? 'text-gray-900 py-4 border-b border-gray-700' : 'text-gray-500' }} py-4"
                wire:click="setSort('asc')">{{ __('blog.filters.older') }}</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $post)
            <x-posts.post-item wire:key="{{$post->id}}" :post="$post" />
        @endforeach
    </div>

    <div class="my-6">
        {{ $this->posts->onEachSide(1)->links() }}
    </div>
</div>
