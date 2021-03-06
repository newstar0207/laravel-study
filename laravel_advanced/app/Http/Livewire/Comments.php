<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $image;
    public $newComment;
    public $userId;

    protected $listeners = [
        'delete' => 'remove',
        'commentUpdated' => 'getComments',
        'userSelected',
    ];

    public function userSelected($userId)
    {
        $this->userId = $userId;
    }

    public function getComments()
    {
    }

    // public function mount()
    // {
    //     $this->newComment = 'Hello World!';
    // }

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        // dd($comment);
        Storage::disk('public')->delete('images/' . $comment->image);
        $comment->delete();

        session()->flash('message', 'Comment deleted sucessfully');
    }

    protected $rules = [
        'newComment' => 'required',
        'image' => 'image|max:10240|nullable',
    ];

    public function render()
    {
        if ($this->userId) {
            return view('livewire.comments', [
                'comments' => Comment::where('user_id', $this->userId)->latest()->paginate(10),
            ]);
        } else {
            return view('livewire.comments', [
                'comments' => Comment::latest()->paginate(10)
            ]);
        }
    }

    public function updated($propertyName)
    {
        // dd('ok');
        $this->validateOnly($propertyName);
        // dd('ok');
        // if ($this->getErrorBag()->get('image')) {
        //     $this->image = null;
        // };
    }

    public function storeImage()
    {
        $img = ImageManagerStatic::make($this->image)->resize(300, 300)->encode('jpg');
        $name = Str::random() . '.jpg';
        // $this->image->storeAs('public/images', $name);
        Storage::disk('public')->put('images/' . $name, $img);

        return $name;
    }

    public function addComment()
    {
        $this->validate(); // -> $rules ??????

        $imageFileName = null;

        if ($this->image) {
            $imageFileName = $this->storeImage();
        }

        Comment::create([
            'user_id' => auth()->user()->id,
            'content' => $this->newComment,
            'image' => $imageFileName,
        ]);

        $this->newComment = '';
        $this->image = '';

        session()->flash('message', 'Comment created sucessfully');
    }
}
