<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\desa;
use App\model\tps;
use Session;

class TPSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = tps::where("isDeleted",false)->with("desa.kecamatan.dapil")->get();
        return view("tps.index")
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desa = desa::where("isDeleted",false)->with("kecamatan.dapil")->get();
        return view("tps.create")
            ->with("desa",$desa);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('tps') && $request->has('id_desa') && $request->has('max_suara')) {
            $tambah = new tps;
                $tambah->id_desa=$request->id_desa;
                $tambah->nama_tps=$request->tps;
                $tambah->max_suara=$request->max_suara;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('tps.create'));
        }

        return redirect(Route('tps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = tps::where("id_tps",$id)->with('desa')->first();
        $desa = desa::where("isDeleted",false)->get();
        if($data==null) return redirect(route('tps.index'));
        return view("tps.edit")
            ->with('desa',$desa)
            ->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($id==null) Session::flash("error","Akses tidak valid!"); else
        if($request->has('tps') && $request->has('id_desa') && $request->has('max_suara')) {
            $update = tps::where("id_tps",$id)->update([
                "id_desa" => $request->id_desa,
                "nama_tps" => $request->tps,
                "max_suara" => $request->max_suara,
            ]);
            if($update)
                Session::flash("success","Data tps berhasil diupdate!");
            else
                Session::flash("error","Data tps gagal diupdate!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('tps.create'));
        }

        return redirect(Route('tps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id!=null) {
            $hapus = tps::where("id_tps",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data tps berhasil dihapus!");
            else
                Session::flash("error","Data tps gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('tps.index'));
    }
}
