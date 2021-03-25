<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stage;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'comment', 'stage_id'];


    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'id');
    }
}
