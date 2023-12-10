<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;
    protected $table = 'group_member';
    public $timestamps = false;
    protected $fillable = [
        'id_group',
        'id_user',
    ];
    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public static function isMember($user, int $group_id) : bool
    {
        return GroupMember::where('id_group', $group_id)->where('id_user', $user->id)->exists();
    }
}
