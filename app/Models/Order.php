<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Order extends Model
{
    use HasFactory; 

    protected $table = 'order';

    protected $primaryKey = 'IdOrder';

    protected $fillable = [ 
        'IdCustomer',
        'Payment',
        'SubTotal',
    ];

    public function details() 
    {
        return $this->hasMany(DetailOrder::class, 'IdOrder');
    }
}
