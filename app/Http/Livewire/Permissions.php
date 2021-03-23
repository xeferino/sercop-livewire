<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $search  = '';
    public $perPage = '10';

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.permissions.index', [
            'roles' => Role::all(),
            'permissions' => Permission::where("name", "LIKE", "%{$this->search}%")->orwhere("description", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage),
            'allPermissions' => Permission::all()
        ]);
    }

    public function clear()
    {
       $this->search = '';
       $this->page = 1;
       $this->perPage = '10';
    }
}
