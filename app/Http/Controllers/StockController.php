<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Stock;
use App\Models\History;
use App\Http\Requests\ValidateStock;
use App\Http\Requests\ValidateStockUpdate;
use JWTAuth;
use DB;
use Carbon\Carbon;

class StockController extends Controller
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
            $data["stock"] = Stock::orderBy('created_at', 'desc')->get();
        } else {
            $data["stock"] = Stock::orderBy('created_at', 'desc')->take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["stock"] = Stock::where('id_stock', $id)->get();

        return $this->response->successData($data);
    }
    public function insert(ValidateStock $request)
    {
		$stock = new Stock();
		$stock->created_at       = $request->created_at;
		$stock->description     = $request->description;
		$stock->stock           = $request->stock;
		$stock->harga           = $request->harga;
		$stock->save();

        $data = Stock::where('id_stock','=', $stock->id_stock)->first();
        return $this->response->successResponseData('Data Stock berhasil ditambahkan', $data);
    }

    public function update(ValidateStockUpdate $request, $id)
    {   
		$stock = Stock::where('id_stock', $id)->first();
		$stock->description     = $request->description;
		$stock->updated_at      = $request->updated_at;
		$stock->stock           = $request->stock;
		$stock->harga           = $request->harga;
		$stock->save();

        return $this->response->successResponse('Data Stock berhasil diubah');
    }
    public function findStock(Request $request, $limit = 10, $offset = 0){
        $find = $request->find;
        $description = $request->findByCode;
        $data["count"] = Stock::count();
        
        if($limit == NULL && $offset == NULL){
            $data["stock"] = Stock::where([['updated_at','like', "%$find%"], ['description','like', "%$description%"]])->orderBy('created_at', 'desc')->get();
        } else {
            $data["stock"] = Stock::where([['updated_at','like', "%$find%"], ['description','like', "%$description%"]])->orderBy('created_at', 'desc')->take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }
    public function delete($id)
    {
        $delete = Stock::where('id_stock', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data stock berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data stock gagal dihapus');
        }
    }
}