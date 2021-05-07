<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['id_stock', 'tgl_input', 'description', 'stock', 'harga', 'created_at', 'updated_at'];
    protected $table = "stocks";
    protected $primaryKey = 'id_stock';
}