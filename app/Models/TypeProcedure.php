<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stage;
use App\Models\Procedure;



class TypeProcedure extends Model
{
    protected $table = 'type_procedures';

    use HasFactory;
    protected $fillable = ['name', 'amount'];

    public function Stages()
    {
        return $this->hasMany(Stage::class, 'type_procedure_id', 'id');
    }

    public function Procedures()
    {
        return $this->hasMany(Procedure::class, 'id', 'type_procedure_id');
    }
}
