<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Hash;
use App\Models\Supplier;
use App\Http\Requests\ValidateSupplier;

class SupplierController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
    
    public function getAll($limit = NULL, $offset = NULL)
    {
        $data["count"] = Supplier::count();
        
        if($limit == NULL && $offset == NULL){
            $data["supplier"] = Supplier::get();
        } else {
            $data["supplier"] = Supplier::take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["supplier"] = Supplier::where('id_supplier', $id)->get();

        return $this->response->successData($data);
    }

    public function insert(ValidateSupplier $request)
    {
		$supplier = new Supplier();
		$supplier->nama 	    = $request->nama;
		$supplier->telp 	    = $request->telp;
		$supplier->alamat 	    = $request->alamat;
		$supplier->save();

        $data = Supplier::where('id_supplier', $supplier->id_supplier)->first();
        return $this->response->successResponseData('Data Supplier berhasil ditambahkan', $data);
    }

    public function update(ValidateSupplier $request, $id)
    {
		$supplier = Supplier::where('id_supplier', $id)->first();
		$supplier->nama 	= $request->nama;
		$supplier->telp 	= $request->telp;
		$supplier->alamat 	= $request->alamat;
		$supplier->save();

        return $this->response->successResponse('Data Supplier berhasil diubah');
    }

    public function delete($id)
    {
        $delete = Supplier::where('id_supplier', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data Supplier berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data Supplier gagal dihapus');
        }
    }
}
