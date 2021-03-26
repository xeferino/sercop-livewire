<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeProcedure;
use App\Models\Department;
use App\Models\User;
use App\Models\Document;


class Procedure extends Model
{
    use HasFactory;
    protected $fillable = ['number', 'description', 'year', 'status', 'departmet_id', 'user_id'];

    public function Department()
    {
        return $this->belongsTo(Department::class);
    }

    public function Type()
    {
        return $this->belongsTo(TypeProcedure::class, 'type_procedure_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Documents()
    {
        return $this->hasMany(Document::class);
    }
}
