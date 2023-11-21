<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follow';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_followed',
        'since',
    ];
    protected $dates = [
        'since',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function userFollowed()
    {
        return $this->belongsTo(User::class, 'id_followed');
    }
}
