<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stage;
use App\Models\Document;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'short_name', 'comment', 'stage_id'];


    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id', 'id');
    }

    public function Documents()
    {
        return $this->hasMany(Document::class);
    }
}
