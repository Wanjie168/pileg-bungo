<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\dapil;
use App\model\kecamatan;
use Session;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = kecamatan::where("isDeleted",false)->with("dapil")->get();
        return view("kecamatan.index")
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dapil = dapil::where("isDeleted",false)->get();
        return view("kecamatan.create")
            ->with("dapil",$dapil);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('kecamatan') && $request->has('id_dapil')) {
            $tambah = new kecamatan;
                $tambah->id_dapil=$request->id_dapil;
                $tambah->kecamatan=$request->kecamatan;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('kecamatan.create'));
        }

        return redirect(Route('kecamatan.index'));
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
        $data = kecamatan::where("id_kecamatan",$id)->with('dapil')->first();
        $dapil = dapil::where("isDeleted",false)->get();
        if($data==null) return redirect(route('kecamatan.index'));
        return view("kecamatan.edit")
            ->with('dapil',$dapil)
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
        if($request->has('kecamatan') && $request->has('id_dapil')) {
            $update = kecamatan::where("id_kecamatan",$id)->update([
                "id_dapil" => $request->id_dapil,
                "kecamatan" => $request->kecamatan,
            ]);
            if($update)
                Session::flash("success","Data kecamatan berhasil diupdate!");
            else
                Session::flash("error","Data kecamatan gagal diupdate!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('kecamatan.edit',$id));
        }

        return redirect(Route('kecamatan.index'));
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
            $hapus = kecamatan::where("id_kecamatan",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data kecamatan berhasil dihapus!");
            else
                Session::flash("error","Data kecamatan gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('kecamatan.index'));
    }
}
