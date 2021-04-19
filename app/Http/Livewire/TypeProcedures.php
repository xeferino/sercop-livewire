<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TypeProcedure;
use Livewire\WithPagination;

class TypeProcedures extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';
    public $action = '';
    public $name;
    public $short_name;
    public $amount;
    public $max_amount;
    public $type_id;
    public $update = false;

    protected $messages = [
        'name.required'         => 'El nombre es requerido.',
        'short_name.required'   => 'El nombre corto es requerido.',
        'name.min'              => 'El nombre es requiere minimo :min caracteres.',
        'short_name.min'        => 'El nombre corto requiere minimo :min caracteres.',
        'name.unique'           => 'El nombre debe ser unico.',
        'short_name.unique'     => 'El nombre corto debe ser unico.',
        'amount.integer'        => 'El debe ser entero.',
        'max_amount.integer'    => 'El monto maximo debe ser entero.',
        'amount.integer'        => 'El monto minimo debe ser entero',
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.procedures.types.index',[
            'types' => TypeProcedure::where("name", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage)
        ]);
    }

    protected function rules()
    {
        return [
            'name'        => 'required|min:4|unique:type_procedures,name,'.$this->type_id,
            'short_name'  => 'required|min:3|unique:type_procedures,short_name,'.$this->type_id,
            'amount'      => 'nullable|integer',
            'max_amount'  => 'nullable|integer',
        ];
    }

    private function resetInput()
    {
        $this->name         = null;
        $this->short_name   = null;
        $this->amount       = null;
        $this->max_amount   = null;
    }

    public function clear()
    {
       $this->search  = '';
       $this->page    = 1;
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

        TypeProcedure::create([
            'name'         => $this->name,
            'short_name'   => $this->short_name,
            'amount'       => $this->amount,
            'max_amount'   => $this->max_amount
        ]);
        $this->resetInput();
        $this->action = 'store';

    }

    public function edit($id)
    {
        $type                = TypeProcedure::findOrFail($id);
        $this->type_id       = $id;
        $this->name          = $type->name;
        $this->short_name    = $type->short_name;
        $this->amount        = $type->amount;
        $this->max_amount    = $type->max_amount;
        $this->update        = true;
        $this->resetValidation();
        $this->action = '';

    }

    public function update()
    {
        if ($this->type_id) {

            $this->validate();

            $type = TypeProcedure::find($this->type_id);

            $type->update([
                'name'         => $this->name,
                'short_name'   => $this->short_name,
                'amount'       => $this->amount,
                'max_amount'   => $this->max_amount
            ]);

            $this->resetInput();
            $this->update = false;
            $this->action = 'update';
        }
    }

    public function destroy($id)
    {
        TypeProcedure::destroy($id);
        $this->action = 'delete';
        $this->create();
    }
}

