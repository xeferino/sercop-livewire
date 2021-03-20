<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class Departments extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';
    public $action = '';
    public $name;
    public $status;
    public $department_id;
    public $update = false;

    protected $messages = [
        'name.required'     => 'El nombre es requerido.',
        'name.min'          => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'       => 'El nombre debe ser unico.',
        'status.required'   => 'El estado es requerido.',
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.departments.index',[
            'departments' => Department::where("name", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage)
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:5|unique:departments,name,'.$this->department_id,
            'status' => 'required'
        ];
    }

    private function resetInput()
    {
        $this->name = null;
        $this->status = '';
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


    public function create()
    {
        $this->update  = false;
        $this->resetInput();
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Department::create([
            'name'   => $this->name,
            'status' => $this->status
        ]);
        $this->resetInput();
        $this->action = 'store';

    }

    public function edit($id)
    {
        $department          = Department::findOrFail($id);
        $this->department_id = $id;
        $this->name          = $department->name;
        $this->status        = $department->status;
        $this->update        = true;
        $this->resetValidation();
        $this->action = '';

    }

    public function update()
    {
        if ($this->department_id) {

            $this->validate();

            $department = Department::find($this->department_id);

            $department->update([
                'name'    => $this->name,
                'status'  => $this->status
            ]);

            $this->resetInput();
            $this->update = false;
            $this->action = 'update';
        }
    }

    public function destroy($id)
    {
        Department::destroy($id);
        $this->action = 'delete';
        $this->create();
    }
}
