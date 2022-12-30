<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memberSkills extends Model
{
    use HasFactory;

    protected $fillable=[
        'members_id',
        'other_occupation_id'
    ];
}
