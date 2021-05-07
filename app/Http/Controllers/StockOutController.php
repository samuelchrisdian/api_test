<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pelanggan;
use App\Models\Stock;
use App\Models\StockOut;
use App\Models\History;
use App\Http\Requests\ValidateStockout;
use JWTAuth;
use DB;
use Carbon\Carbon;

class StockOutController extends Controller
{
    public $response;
    public $user;
    public function __construct(){
        $this->response = new ResponseHelper();

        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function getAll($limit = NULL, $offset = NULL)
    {
        $data["count"] = Stock::count();
        
        if($limit == NULL && $offset == NULL){
            $data["stock"] = Stock::orderBy('tgl_input', 'desc')->with('supplier')->get();
        } else {
            $data["stock"] = Stock::orderBy('tgl_input', 'desc')->with('supplier')->take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["stock"] = Stock::where('id_stock', $id)->with('supplier')->get();

        return $this->response->successData($data);
    }

    public function getByIdSupplier($id)
    {   
        $data["stock"] = Stock::where('id_supplier', $id)->orderBy('id_stock', 'desc')->with('supplier')->get();

        return $this->response->successData($data);
    }

    public function insert(ValidateStockOut $request)
    {   
        StockOut::create($request->all());

        $stock = Stock::where('id_stock', $request->id_stock)->first();
		$stock->stock     -= $request->stock;
		$stock->timestamps = false;
		$stock->save();
        
        // $createhistory = new History();
        // $createhistory->id_stock = $request->id_stock;
        // $createhistory->id_pelanggan = $request->id_pelanggan;
        // $createhistory->material_code = $stock->material_code;
        // $createhistory->description = $stock->description;
        // $createhistory->stock = $request->stock;
        // $createhistory->unit = $stock->unit;
        // $createhistory->harga = $stock->harga;
        // $createhistory->note = $stock->note;
        // $createhistory->type = 'stock_out';
        // $createhistory->created_at = $request->created_at;
        // $createhistory->total = $request->stock * $stock->harga;
        // $createhistory->save();
        
        $stock['type'] = 'stock_out';
        $stock['id_pelanggan'] = $request->id_pelanggan;
        $stock['stock'] = $request->stock;
        $stock['total'] = $request->stock * $stock->harga;
        $stock['created_at'] = $request->created_at;
        $history = History::create($stock->toArray());

        return $this->response->successResponseData('Data Stock yang keluar berhasil diinputkan', $stock);
    }

    public function update(ValidateStockIn $request, $id)
    {   
		$stockin = StockIn::where('id_stock_in', $id)->first();
        $stockin->update($request->all());

        $stock = Stock::where('id_stock', $request->id_stock);
		$stock->id_supplier     = $request->id_supplier;
		$stock->stock           = $request->stock;
		$stock->tgl_input       = $request->tgl_input;
		$stock->save();

        return $this->response->successResponse('Data Stock berhasil diubah');
    }
    public function findStock(Request $request, $limit = 10, $offset = 0){
        $find = $request->find;
        $id_supplier = $request->id_supplier;
        $data["count"] = Stock::count();
        
        if($limit == NULL && $offset == NULL){
            $data["stock"] = Stock::where([['tgl_input','like', "%$find%"], ['id_supplier','like', "%$id_supplier%"]])->orderBy('tgl_input', 'desc')->with('supplier')->get();
        } else {
            $data["stock"] = Stock::where([['tgl_input','like', "%$find%"], ['id_supplier','like', "%$id_supplier%"]])->orderBy('tgl_input', 'desc')->with('supplier')->take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }
    public function delete($id)
    {
        $delete = StockIn::where('id_stock_in', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data stock berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data stock gagal dihapus');
        }
    }
}

