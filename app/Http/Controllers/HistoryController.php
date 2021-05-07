<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Helpers\ResponseHelper;
use JWTAuth;
use DB;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function report(Request $request) {
        $sortBy = $request->sortBy;
        $id_pelanggan = $request->id_pelanggan;
        $id_supplier = $request->id_supplier;
        $sortByDate = $request->sortByDate;
        $until = $request->until;
        $startFrom = $request->startFrom;

        if ($sortBy == 'stock_in') {
            $data["report"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_supplier', 'like', "%$id_supplier%"]])->whereBetween('created_at', [$startFrom, $until])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->get();
        } else {
            $data["report"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_pelanggan', 'like', "%$id_pelanggan%"]])->whereBetween('created_at', [$startFrom, $until])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->get();
        }
        $data["count"] = $data["report"]->count();
        return $data;
    }

    public function sortBy(Request $request, $limit = null , $offset = null){
        $sortBy = $request->sortBy;
        $id_pelanggan = $request->id_pelanggan;
        $id_supplier = $request->id_supplier;
        $sortByDate = $request->sortByDate;
        // $sortBy = 'stock_in' ? $id_pelanggan = NULL : $id_supplier = NULL;
        
        if($limit == NULL && $offset == NULL){
            if ($sortBy == 'stock_in') {
                $data["history"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_supplier', 'like', "%$id_supplier%"]])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->get();
            } else {
                $data["history"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_pelanggan', 'like', "%$id_pelanggan%"]])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->get();
            }
            $data["count"] = $data["history"]->count();
        } else {
            if ($sortBy == 'stock_in') {
                $data["history"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_supplier', 'like', "%$id_supplier%"]])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->take($limit)->skip($offset)->get();
            } else {
                $data["history"] = History::where([['type', $sortBy], ['created_at','like', "%$sortByDate%"], ['id_pelanggan', 'like', "%$id_pelanggan%"]])->orderBy('created_at', 'desc')->with('supplier','pelanggan')->take($limit)->skip($offset)->get();
            }
            $data["count"] = $data["history"]->count();
        }
        return response()->json([
            'success' => 1,
            'message' => 'Berhasil Mendapatkan data History',
            'data' => $data
        ]);
    }
    public function getHistoryById($id) 
    {
        $data["history"] = History::where('id_history', $id)->orderBy('id_history', 'desc')->with('supplier', 'pelanggan')->get();
        
        return response()->json([
            'success' => 1,
            'message' => 'Berhasil Mendapatkan data History',
            'data' => $data
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByType(Request $request, $type) 
    {
        $history['history'] = History::where('type', $type)->with('pelanggan', 'supplier')->orderBy('updated_at', 'desc')->get();
        $history['count'] = $history['history']->count();
        return response()->json([
            'success' => 1,
            'message' => 'Berhasil Mendapatkan data History',
            'data' => $history
        ]);
    }

    public function index()
    {
        $history['history'] = History::get();
        return response()->json([
            'success' => 1,
            'message' => 'Berhasil Mendapatkan data History',
            'data' => $history
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $history = History::create($request->all());
        return $history; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $history = History::find($id)->first();
        return $history;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $history = History::find($id);
        $History::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $history = History::delete($id);
        return 'halo, berhasil delete';
        // return response()->json([
        //     'status' => 1,
        //     'message' => 'halo',
        //     'data' => $history
        // ]);
    }
}
