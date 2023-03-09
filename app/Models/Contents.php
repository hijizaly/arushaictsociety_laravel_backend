<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Contents extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable=[
        'content_head',
        'content_body',
        'content_image',
        'component_id'
    ];
}
