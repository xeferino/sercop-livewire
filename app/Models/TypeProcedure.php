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
    protected $fillable = ['name', 'short_name', 'amount', 'max_amount'];

    public function Procedures()
    {
        return $this->hasMany(Procedure::class, 'id', 'type_procedure_id');
    }

    public function StageProcedures()
    {
        return $this->belongsToMany(Stage::class, 'stages_type_procedures', 'type_procedure_id', 'stage_id');
    }
}
