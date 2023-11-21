<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $table = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'id_created_by');
    }
}
