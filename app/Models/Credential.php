<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;
    protected $table = 'oauth_clients';
    protected $fillable = ['user_id','name','secret','provider','password_client','redirect','personal_access_client','revoked'];
}
