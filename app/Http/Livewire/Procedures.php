<?php

namespace App\Http\Livewire;

use App\Models\Procedure;
use Livewire\Component;
use Livewire\WithPagination;

class Procedures extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = '10';

    protected $queryString = [
        'search'    => ['except' => ''],
        'perPage'   => ['except' => '10']
    ];

    public function render()
    {
        return view('livewire.procedures.index',[
            'procedures' => Procedure::where("number", "LIKE", "%{$this->search}%")->orderBy('id', 'DESC')->paginate($this->perPage)
        ]);
    }

    public function clear()
    {
       $this->search = '';
       $this->page = 1;
       $this->perPage = '10';
    }
}
