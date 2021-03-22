<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';
    public $action = '';
    public $name;
    public $status;
    public $user_id;
    public $update = false;

    public function render()
    {
        return view('livewire.users.index',[
            'users' => User::where("name", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage)
        ]);
    }
}
