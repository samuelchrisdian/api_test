<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['id_history', 'id_stock', 'id_supplier', 'id_pelanggan', 'material_code', 'tgl_input', 'description', 'stock', 'unit', 'harga', 'note', 'type', 'total', 'created_at', 'updated_at'];
    protected $table = "histories";
    protected $primaryKey = 'id_history';


    public function supplier() {
        return $this->belongsTo('App\Models\Supplier','id_supplier','id_supplier');
    }
    public function pelanggan() {
        return $this->belongsTo('App\Models\Pelanggan','id_pelanggan','id_pelanggan');
    }
}