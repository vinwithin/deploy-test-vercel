<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $table = 'publikasi';
    public $publikasi = 'publikasi';
    protected $fillable = [
        'title',
        'slug',
        'status',
        'content',
    ];
}
