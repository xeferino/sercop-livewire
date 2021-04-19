<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stage;
use App\Models\Section;
use Livewire\WithPagination;

class Sections extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';
    public $action = '';
    public $name;
    public $short_name;
    public $comment;
    public $section_id;
    public $stage_id;
    public $update = false;

    protected $messages = [
        'name.required'         => 'El nombre es requerido.',
        'name.min'              => 'El nombre es requiere minimo :min caracteres.',
        'name.unique'           => 'El nombre debe ser unico.',
        'short_name.required'   => 'El nombre corto es requerido.',
        'short_name.min'        => 'El nombre corto es requiere minimo :min caracteres.',
        'short_name.unique'     => 'El nombre corto debe ser unico.',
        'stage_id.required'     => 'La etapa es requerida.',
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.procedures.sections.index',[
            'sections'  => Section::where("name", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage),
            'stages'     => Stage::all()
        ]);
    }

    protected function rules()
    {
        return [
            'name'          => 'required|min:4|unique:sections,name,'.$this->section_id,
            'short_name'    => 'required|min:3|unique:sections,short_name,'.$this->section_id,
            'stage_id'      => 'required'
        ];
    }

    private function resetInput()
    {
        $this->name         = null;
        $this->short_name   = null;
        $this->comment      = null;
        $this->stage_id     = '';
    }

    public function clear()
    {
       $this->search    = '';
       $this->page      = 1;
       $this->perPage   = '10';
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

        Section::create([
            'name'          => $this->name,
            'short_name'    => $this->short_name,
            'stage_id'      => $this->stage_id,
            'comment'       => $this->comment
        ]);
        $this->resetInput();
        $this->action = 'store';

    }

    public function edit($id)
    {
        $section             = Section::findOrFail($id);
        $this->section_id    = $id;
        $this->name          = $section->name;
        $this->short_name    = $section->short_name;
        $this->comment       = $section->comment;
        $this->stage_id      = $section->stage_id;
        $this->update        = true;
        $this->resetValidation();
        $this->action = '';

    }

    public function update()
    {
        if ($this->section_id) {

            $this->validate();

            $section = Section::find($this->section_id);

            $section->update([
                'name'          => $this->name,
                'short_name'    => $this->short_name,
                'stage_id'      => $this->stage_id,
                'comment'       => $this->comment
            ]);

            $this->resetInput();
            $this->update = false;
            $this->action = 'update';
        }
    }

    public function destroy($id)
    {
        Section::destroy($id);
        $this->action = 'delete';
        $this->create();
    }
}

