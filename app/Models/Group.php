<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'created_at',
        'id_owner',
    ];
    protected $dates = [
        'created_at',
    ];
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_member', 'id_group', 'id_user');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'id_owner');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'id_group');
    }
}
