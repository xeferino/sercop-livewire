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
    public $amount;
    public $type_id;
    public $update = false;

    protected $messages = [
        'name.required'     => 'El nombre es requerido.',
        'name.min'          => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'       => 'El nombre debe ser unico.',
        'amount.required'   => 'El monto es requerido.',
       // 'amount.min'        => 'El monto tiene una cifra minima :min digitos',
        //'amount.max'        => 'El monto tiene una cifra maxima :max digitos',
        'amount.integer'    => 'El monto debe ser numerico',
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
            'name'    => 'required|min:4|unique:type_procedures,name,'.$this->type_id,
            'amount'  => 'required|integer'
        ];
    }

    private function resetInput()
    {
        $this->name     = null;
        $this->amount   = null;
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
            'name'   => $this->name,
            'amount' => $this->amount
        ]);
        $this->resetInput();
        $this->action = 'store';

    }

    public function edit($id)
    {
        $type                = TypeProcedure::findOrFail($id);
        $this->type_id       = $id;
        $this->name          = $type->name;
        $this->amount        = $type->amount;
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
                'name'    => $this->name,
                'amount'  => $this->amount
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

