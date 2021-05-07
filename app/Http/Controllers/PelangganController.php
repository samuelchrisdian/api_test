<?php
namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Hash;
use Validator;
use App\Models\Pelanggan;
use App\Http\Requests\ValidatePelanggan;

class PelangganController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
    
    public function getAll($limit = NULL, $offset = NULL)
    {
        $data["count"] = Pelanggan::count();
        
        if($limit == NULL && $offset == NULL){
            $data["pelanggan"] = Pelanggan::get();
        } else {
            $data["pelanggan"] = Pelanggan::take($limit)->skip($offset)->get();
        }

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["pelanggan"] = Pelanggan::where('id_pelanggan', $id)->get();

        return $this->response->successData($data);
    }

    public function insert(ValidatePelanggan $request)
    {
		$pelanggan = new Pelanggan();
        $pelanggan->nik  	    = $request->nik;
        $pelanggan->no_rekening = $request->no_rekening;
		$pelanggan->nama 	    = $request->nama;
		$pelanggan->telp 	    = $request->telp;
		$pelanggan->alamat 	    = $request->alamat;
		$pelanggan->save();

        $data = Pelanggan::where('id_pelanggan', $pelanggan->id_pelanggan)->first();
        return $this->response->successResponseData('Data Pelanggan berhasil ditambahkan', $data);
    }

    public function update(ValidatePelanggan $request, $id)
    {
		$pelanggan = Pelanggan::where('id_pelanggan', $id)->first();
		$pelanggan->nama 	= $request->nama;
		$pelanggan->nik 	= $request->nik;
		$pelanggan->telp 	= $request->telp;
		$pelanggan->no_rekening 	= $request->no_rekening;
		$pelanggan->alamat 	= $request->alamat;
		$pelanggan->save();

        return $this->response->successResponse('Data Pelanggan berhasil diubah');
    }

    public function delete($id)
    {
        $delete = Pelanggan::where('id_pelanggan', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data Pelanggan berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data Pelanggan gagal dihapus');
        }
    }
}
