<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $table = 'village';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'district_id',
        'name',
        'alt_name',
        'longitude',
        'latitude'
    ];
}
