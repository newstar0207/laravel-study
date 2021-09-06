<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{

    public $newComment;

    protected $listeners = [
        'delete' => 'remove',
    ];

    // public function mount()
    // {
    //     $this->newComment = 'Hello World!';
    // }

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();

        session()->flash('message', 'Comment deleted sucessfully');
    }

    protected $rules = [
        'newComment' => 'required',
    ];

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::latest()->paginate(10),
        ]);
    }

    public function addComment()
    {
        $this->validate(); // -> $rules 거침
        Comment::create([
            'user_id' => auth()->user()->id,
            'content' => $this->newComment,
            // 'image' => '',
        ]);

        session()->flash('message', 'Comment created sucessfully');
    }
}
