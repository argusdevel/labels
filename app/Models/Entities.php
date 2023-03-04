<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'entities';

    protected $fillable = [
        'id',
        'type',
        'title',
        'labels'
    ];
}
