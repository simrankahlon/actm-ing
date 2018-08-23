<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }
}
