<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'alt_name',
        'longitude',
        'latitude'
    ];
}
