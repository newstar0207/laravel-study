<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    protected $listeners = [
        'userSelected',
    ];

    public $userId;

    public function userSelected($userId)
    {
        // dd($userId);
        $this->userId = $userId;
    }

    public function render()
    {
        return view('livewire.user-list', ['users' => User::latest()->paginate(5)]);
    }
}
