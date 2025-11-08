<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{

    use WithPagination; // Add this line

    #[Url]
    public $search = '';

    #[Url]
    public $category = '';

    #[Url]
    public $sort = 'desc';

    #[Url]
    public $popular = false;

    public function getCategoryNameAttribute()
    {
        // Assuming you have a Category model and a relationship set up
        $category = Category::where('slug', $this->category)->first();
        return $category ? $category->title : null;
    }

    public function setSort($sort)
    {
        $this->sort = ($sort === 'asc') ? 'asc' : 'desc';
    }

    #[On('searchUpdated')]
    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('filterByCategory')]
    public function updatedCategory($category)
    {
        $this->category = $category;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    #[Computed()]
    public function getPostsProperty()
    {
        return Post::published()
            ->with("categories", "author")
            ->when($this->category, fn($query) =>
                $query->whereHas('categories', fn($q) =>
                    $q->where('slug', $this->category)
                )
            )
            ->when($this->popular, fn($query) =>
                $query->popular()
            )
            ->when($this->search, fn($query) =>
                $query->search($this->search)
            )
            ->orderBy('published_at', $this->sort)
            ->paginate(3);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
