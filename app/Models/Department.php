<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public function Users()
    {
        return $this->hasMany(User::class);
    }
}
