<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['id_supplier', 'nama', 'telp', 'alamat'];
    protected $table = "suppliers";
    protected $primaryKey = 'id_supplier';
}