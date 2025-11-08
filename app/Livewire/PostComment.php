<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostComment extends Component
{

    use WithPagination;
    public Post $post;
    public string $comment;

    public function postComment()
    {

        if (auth()->guest()) {
            session()->flash('error', 'You must be logged in to post a comment.');
            return;
        }

        $this->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $this->comment,
        ]);

        $this->comment = '';

        session()->flash('message', 'Comment posted successfully.');
    }

    public function comments()
    {
        return $this?->post?->comments()->with("user")->latest()->paginate(5);
    }

    public function deleteComment($commentId)
    {
        $comment = $this->post->comments()->where('id', $commentId)->first();

        if ($comment && $comment->user_id === auth()->id()) {
            $comment->delete();
            session()->flash('message', 'Comment deleted successfully.');
        } else {
            session()->flash('error', 'You are not authorized to delete this comment.');
        }
    }

    public function render()
    {
        return view('livewire.post-comment', [
            'comments' => $this->comments(),
        ]);
    }
}
