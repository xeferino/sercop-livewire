<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeProcedure;
use App\Models\Section;


class Stage extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type_procedure_id'];

    public function type()
    {
        return $this->belongsTo(TypeProcedure::class, 'type_procedure_id', 'id');
    }

    public function Sections()
    {
        return $this->hasMany(Section::class, 'id', 'stage_id');
    }
}
