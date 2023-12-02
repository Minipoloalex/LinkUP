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

class User extends Authenticatable
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
        'email',
        'password',
        'description',
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
    public function getProfilePicture()
    {
        $imageController = new ImageController('users');
        return $imageController->getFile($this->photo);
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
        // $users = DB::select("SELECT * FROM users
        //             WHERE tsvectors @@ plainto_tsquery('english', ?)
        //             ORDER BY ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$search, $search]);
        $users = User::whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$search])
        ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$search])
        ->get();
        Log::debug($users);
        return $users;
    }
}
