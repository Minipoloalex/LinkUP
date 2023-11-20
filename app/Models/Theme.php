<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $table = 'theme';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
    public function groups() {
        return $this->belongsToMany(Group::class, 'group_theme', 'id_theme', 'id_group');
    }
}
