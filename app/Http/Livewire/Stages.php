<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stage;
use App\Models\TypeProcedure;
use Livewire\WithPagination;

class Stages extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';
    public $action = '';
    public $name;
    public $short_name;
    public $type_procedure_id;
    public $procedures = [];
    public $stage_id;
    public $update = false;

    protected $messages = [
        'name.required'         => 'El nombre es requerido.',
        'name.min'              => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'           => 'El nombre debe ser unico.',
        'short_name.required'   => 'El nombre corto es requerido.',
        'short_name.min'        => 'El nombre corto es requiere minimo :min caracteres.',
        'short_name.unique'     => 'El nombre corto debe ser unico.',
        'type_procedure_id.required'   => 'El tipo de procedimiento es requerido.',
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.procedures.stages.index',[
            'stages' => Stage::where("name", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage),
            'types' => TypeProcedure::all(),
            'procedures' => $this->procedures,

        ]);
    }

    protected function rules()
    {
        return [
            'name'               => 'required|min:4|unique:stages,name,'.$this->stage_id,
            'short_name'         => 'required|min:3|unique:stages,short_name,'.$this->stage_id,
            'type_procedure_id'  => 'required'
        ];
    }

    private function resetInput()
    {
        $this->name              = null;
        $this->short_name        = null;
        $this->type_procedure_id = null;
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

        Stage::create([
            'name'         => $this->name,
            'short_name'   => $this->short_name
        ])->typeProcedures()->sync($this->type_procedure_id, false);

        $this->resetInput();
        $this->action = 'store';
    }

    public function edit($id)
    {
        $stage                      = Stage::findOrFail($id);
        $this->stage_id             = $id;
        $this->name                 = $stage->name;
        $this->short_name           = $stage->short_name;
        $this->procedures           = $stage->typeProcedures;
        $this->update               = true;
        $this->resetValidation();
        $this->action = '';

    }

    public function update()
    {
        if ($this->stage_id) {

            $this->validate();

            $stage = Stage::find($this->stage_id);

            $stage->update([
                'name'              => $this->name,
                'short_name'        => $this->short_name,
            ]);
            $stage->typeProcedures()->sync($this->type_procedure_id);

            $this->resetInput();
            $this->update = false;
            $this->action = 'update';
        }
    }

    public function destroy($id)
    {
        Stage::destroy($id);
        $this->action = 'delete';
        $this->create();
    }
}

