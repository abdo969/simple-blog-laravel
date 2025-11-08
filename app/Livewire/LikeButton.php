<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LikeButton extends Component
{

    //#[Reactive]
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function like()
    {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();
        $hasLiked = $user->hasLiked($this->post);
        if($hasLiked) {
            $user->likes()->detach($this->post->id);
        } else {
            $user->likes()->attach($this->post->id);
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
