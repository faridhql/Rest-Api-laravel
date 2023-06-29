<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;   

class DetailOrder extends Model  
{
    use HasFactory; 

    protected $table = 'detailorder'; 

    protected $primaryKey = 'IdDetail'; 

    protected $fillable = [ 
        'IdOrder',
        'IdMenu',
        'Quantity',
        'Price',
    ];

    public function menu() 
    {
        return $this->belongsTo(Menu::class, 'IdMenu');
    }
}
