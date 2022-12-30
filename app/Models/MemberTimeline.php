<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MemberTimeline extends Model
{
    use HasApiTokens,HasFactory,Notifiable;

    protected $fillable=[
        'member_id',
        'old_occupation_id',
        'new_occupation_id'

    ];

}
