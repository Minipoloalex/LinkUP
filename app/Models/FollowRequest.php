<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowRequest extends Model
{
    use HasFactory;
    protected $table = 'follow_request';
    public $timestamps = false;
    protected $fillable = [
        'id_user_from',
        'id_user_to',
        'timestamp',
    ];
    protected $dates = [
        'timestamp',
    ];
    public function userNotified()
    {
        return $this->belongsTo(User::class, 'id_user_to');
    }
    public function userRequesting()
    {
        return $this->belongsTo(User::class, 'id_user_from');
    }
}
