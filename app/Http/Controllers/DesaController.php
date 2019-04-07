<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\kecamatan;
use App\model\desa;
use Session;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = desa::where("isDeleted",false)->with("kecamatan.dapil")->get();
        return view("desa.index")
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = kecamatan::where("isDeleted",false)->with("dapil")->get();
        return view("desa.create")
            ->with("kecamatan",$kecamatan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('desa') && $request->has('id_kecamatan')) {
            $tambah = new desa;
                $tambah->id_kecamatan=$request->id_kecamatan;
                $tambah->desa=$request->desa;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('desa.create'));
        }

        return redirect(Route('desa.index'));
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
        $data = desa::where("id_desa",$id)->with('kecamatan')->first();
        $kecamatan = kecamatan::where("isDeleted",false)->get();
        if($data==null) return redirect(route('desa.index'));
        return view("desa.edit")
            ->with('kecamatan',$kecamatan)
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
        if($request->has('desa') && $request->has('id_kecamatan')) {
            $update = desa::where("id_desa",$id)->update([
                "id_kecamatan" => $request->id_kecamatan,
                "desa" => $request->desa,
            ]);
            if($update)
                Session::flash("success","Data desa berhasil diupdate!");
            else
                Session::flash("error","Data desa gagal diupdate!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('desa.edit',$id));
        }

        return redirect(Route('desa.index'));
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
            $hapus = desa::where("id_desa",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data desa berhasil dihapus!");
            else
                Session::flash("error","Data desa gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('desa.index'));
    }
}
