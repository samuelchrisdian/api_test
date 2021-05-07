<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = ['id_stock_in', 'id_stock', 'id_supplier', 'stock', 'created_at', 'updated_at'];
    protected $table = "stock_ins";
    protected $primaryKey = 'id_stock_in';

    public function stock() {
        return $this->belongsTo('App\Models\Stock','id_stock','id_stock');
    }
    public function supplier() {
        return $this->belongsTo('App\Models\Supplier','id_supplier','id_supplier');
    }
}