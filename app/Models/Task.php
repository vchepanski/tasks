<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status', 'due_date', 'created_by'];

    public function users(){
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
