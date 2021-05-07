<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['id_pelanggan', 'nik', 'no_rekening', 'nama', 'telp', 'alamat'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = "pelanggans";
    protected $primaryKey = 'id_pelanggan';
}
