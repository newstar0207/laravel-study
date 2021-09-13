<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class EditComment extends ModalComponent
{
    use WithFileUploads;

    public $commentId;
    public $orgComment; // original data
    public $newComment;
    public $image;


    public function render()
    {
        return view('livewire.edit-comment');
    }

    public function mount($commentId)
    {
        $this->commentId = $commentId;
        $this->orgComment = Comment::find($commentId);
        $this->newComment = $this->orgComment->content;

        // dd($this->orgComment);
    }

    protected $listeners = [
        'update' => 'updateComment',
    ];

    public function updateComment()
    {
        $this->closeModal();
    }
}
