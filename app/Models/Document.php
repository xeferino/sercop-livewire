<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Procedure;
use App\Models\Section;


class Document extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'file_name', 'file_path', 'file_path_delete', 'file_size', 'file_type', 'procedure_id', 'section_id'];


    public function Procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function Section()
    {
        return $this->belongsTo(Section::class);
    }
}
