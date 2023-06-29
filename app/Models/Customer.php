<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Laravel\Sanctum\HasApiTokens; 

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory; 

    protected $table = 'customer'; 

    protected $primaryKey = 'IdCustomer';

    protected $fillable = [ 
        'Name',
        'Email',
        'Phone',
        'Password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];
}
