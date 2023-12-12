<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ImageController;

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
    public function pendingMembers()
    {
        return $this->belongsToMany(User::class, 'group_notification', 'id_group', 'id_user');
    }
    public function getPicture()    
    {
        $imageController = new ImageController('groups');
        $fileName = $imageController->getFileNameWithExtension(str($this->id));
        return $imageController->getFile($fileName);
    }
    public static function search(string $search) {
        return Group::whereRaw("tsvectors @@ plainto_tsquery('portuguese', ?)", [$search])
            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) DESC", [$search]);
    }
}
