<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = "userdata";
    protected $fillable = ['user_id'];
    public $timestamps = false;
}
