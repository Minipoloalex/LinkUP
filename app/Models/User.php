<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\ImageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'faculty',
        'course',
        'email',
        'password',
        'bio',
        'is_private',
        'is_banned',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'id_created_by');
    }

    public function followers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'id_followed', 'id_user')->orderBy('username');
    }

    public function following() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'id_user', 'id_followed')->orderBy('username');
    }
    public function isFollowing(User $user) : bool
    {
        return $this->following()->where('id_followed', $user->id)->exists();
    }

    protected function groups() : HasMany
    {
        return $this->hasMany(GroupMember::class, 'id_user');
    }

    protected function liked() : HasMany
    {
        return $this->hasMany(Liked::class, 'id_user');
    }

    public function getProfilePicture()
    {
        $imageController = new ImageController('users');
        $fileName = $imageController->getFileNameWithExtension(str($this->id));
        return $imageController->getFile($fileName);
    }
    public function followRequestsReceived() : HasMany
    {
        return $this->hasMany(FollowRequest::class, 'id_user_to');
    }
    public function followRequestsSent() : HasMany
    {
        return $this->hasMany(FollowRequest::class, 'id_user_from');
    }
    public function requestedToFollow(User $user) : bool
    {
        return $this->followRequestsSent()->where('id_user_to', $user->id)->exists();
    }
    public static function search(string $search) {
        return User::whereRaw("tsvectors @@ plainto_tsquery('portuguese', ?)", [$search])
        ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?)) DESC", [$search]);
    }
}
