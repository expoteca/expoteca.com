<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

 
    /**
     * The users that belong to the organization.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
