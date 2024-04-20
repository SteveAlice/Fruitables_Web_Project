<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'name',
        'desc',
        'sales_percent',

    ];
    public function product()
    {
        return $this->belongsTo(Product::class ,'id'); // mỗi Sales sẽ thuộc về một Product.
    }

}
