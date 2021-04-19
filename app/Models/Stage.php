<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeProcedure;
use App\Models\Section;


class Stage extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'short_name'];

    public function type()
    {
        return $this->belongsTo(TypeProcedure::class, 'type_procedure_id', 'id');
    }

    public function Sections()
    {
        return $this->hasMany(Section::class, 'stage_id', 'id');
    }

    public function typeProcedures()
    {
        return $this->belongsToMany(TypeProcedure::class, 'stages_type_procedures', 'stage_id', 'type_procedure_id');
    }
}
