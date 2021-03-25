<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stage;


class TypeProcedure extends Model
{
    protected $table = 'type_procedures';

    use HasFactory;
    protected $fillable = ['name', 'amount'];

    public function Stages()
    {
        return $this->hasMany(Stage::class, 'id', 'type_procedure_id');
    }
}
