<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name',
        'desc',
        'SKU',
        'category',
        'price',
        'image',
        'sales_id',
    ]; 
    public function sales()
    {
        return $this->hasOne(Sales::class, 'sales_id'); // mỗi Product sẽ có một Sales.
    }
}
