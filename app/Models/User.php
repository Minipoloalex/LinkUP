<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\ImageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
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

    protected function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'id_created_by');
    }

    protected function followers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'id_user', 'id_followed')->orderBy('username');
    }

    protected function following() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'id_followed', 'id_user')->orderBy('username');
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
}
