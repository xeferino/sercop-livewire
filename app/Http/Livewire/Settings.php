<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Settings extends Component
{
    use WithPagination;

    public $search  = '';
    public $perPage = '10';
    public $action  = '';
    public $name;
    public $description;
    public $syncPermissions = [];
    public $roles_has_permissions =  [];
    public $role_id;
    public $update = false;
    public $store  = false;

    protected $messages = [
        'name.required'             => 'El nombre es requerido.',
        'name.min'                  => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'               => 'El nombre debe ser unico.',
        'description.required'      => 'La descripcion es requerida.',
        'syncPermissions.required'  => 'Debe seleccionar al menos un permiso.',
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.settings.index', [
            'roles' => Role::all(),
            'permissions' => Permission::where("name", "LIKE", "%{$this->search}%")->orwhere("description", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage),
            'allPermissions' => Permission::all()
        ]);
    }

    protected function rules()
    {
        return [
            'name'              => 'required|min:4|unique:roles,name,'.$this->role_id,
            'description'       => 'required',
            'syncPermissions'   => 'required'
        ];
    }

    private function resetInput()
    {
        $this->name = null;
        $this->description = '';
        $this->syncPermissions = [];
    }

    public function create()
    {
        $this->store  = true;
        $this->resetInput();
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Role::create([
            'name'        => $this->name,
            'description' => $this->description
        ])->syncPermissions($this->syncPermissions, true);
        $this->cancel();
        $this->action = 'store';
    }

    public function edit($id)
    {
        $role                = Role::findOrFail($id);
        $this->role_id       = $id;
        $this->name          = $role->name;
        $this->description   = $role->description;
        $this->syncPermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id',  $id)->pluck('permission_id')->toArray();
        $this->update        = true;
        $this->store         = false;
        $this->resetValidation();
        $this->action = '';
    }

    public function update()
    {
        if ($this->role_id) {

            $this->validate();

            $role = Role::find($this->role_id);

            $role->update([
                'name'         => $this->name,
                'description'  => $this->description
            ]);
            $role->syncPermissions($this->syncPermissions, true);

            $this->cancel();
            $this->action = 'update';
        }
    }

    public function destroy($id)
    {
        Role::destroy($id);
        $this->action = 'delete';
    }

    public function cancel()
    {
        $this->update  = false;
        $this->store  = false;
        $this->resetInput();
        $this->resetValidation();
    }

    public function clear()
    {
       $this->search = '';
       $this->page = 1;
       $this->perPage = '10';
    }

    public function dismiss()
    {
        $this->action = '';
    }
}
