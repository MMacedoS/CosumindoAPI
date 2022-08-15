<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configApi extends Model
{
    use HasFactory;


    protected $table =  'config_api';

    protected $fillable = [
        'appId','secretKey','url','siteId',
        'authorization', 'state'
    ];
}
