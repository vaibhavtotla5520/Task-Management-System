<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardModel extends Model
{
    protected $fillable = ['user_id', 'description', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}