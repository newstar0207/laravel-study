<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

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
    }

    protected $listeners = [
        'update' => 'updateComment',
    ];

    public function storeImage()
    {
        $img = ImageManagerStatic::make($this->image)->resize(300, 300)->encode('jpg');
        $name = Str::random() . '.jpg';
        // $this->image->storeAs('public/images', $name);
        Storage::disk('public')->put('images/' . $name, $img);

        return $name;
    }

    public function updateComment()
    {
        $this->validate([
            'newComment' => 'required',
            'image' => 'nullable|image|max:10240',
        ]);

        $imageFileName = null;

        if ($this->image) {

            if ($this->orgComment->image) {
                Storage::delete('images/' . $this->orgComment->image);
            }

            $imageFileName = $this->storeImage();
            $this->orgComment->image = $imageFileName;
        }
        $this->orgComment->content = $this->newComment;
        $this->orgComment->save();

        $this->image = '';

        // Comment::create([
        //     'user_id' => auth()->user()->id,
        //     'content' => $this->newComment,
        //     'image' => $imageFileName,
        // ]);

        $this->newComment = '';
        $this->image = '';

        session()->flash('message', 'Comment created sucessfully');
        $this->closeModal();

        $this->emit('commentUpdated');
    }
}
