<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = ['id_stock_out', 'id_stock', 'id_pelanggan', 'stock', 'tgl_input', 'created_at', 'updated_at'];
    protected $table = "stock_outs";
    protected $primaryKey = 'id_stock_out';

    public function stock() {
        return $this->belongsTo('App\Models\Stock','id_stock','id_stock');
    }
    public function pelanggan() {
        return $this->belongsTo('App\Models\Pelanggan','id_pelanggan','id_pelanggan');
    }
}