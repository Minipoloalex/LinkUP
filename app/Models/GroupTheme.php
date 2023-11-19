<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTheme extends Model
{
    use HasFactory;
    protected $table = 'group_theme';
    public $timestamps = false;
    protected $fillable = [
        'id_group',
        'id_theme',
    ];
    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group');
    }
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'id_theme');
    }
}
