<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\dapil;
use Session;

class DapilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = dapil::where("isDeleted",false)->get();
        return view("dapil.index")
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dapil.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('nama_dapil')) {
            $tambah = new dapil;
                $tambah->nama_dapil=$request->nama_dapil;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else
            Session::flash("error","Nama dapil belum diinput!");

        return redirect(Route('dapil.index'));
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
        $data = dapil::find($id);
        if($data==null) return redirect(route('dapil.index'));
        return view("dapil.edit")
            ->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {
        if($id==null) Session::flash("error","Akses tidak valid!"); else
        if($request->has('nama_dapil')) {
            $update = dapil::where("id_dapil",$id)->update([
                "nama_dapil" => $request->nama_dapil,
            ]);
            if($update)
                Session::flash("success","Data dapil berhasil diupdate!");
            else
                Session::flash("error","Data dapil gagal diupdate!");
        } else
            Session::flash("error","Nama dapil belum diinput!");

        return redirect(Route('dapil.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=null)
    {
        if($id!=null) {
            $hapus = dapil::where("id_dapil",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data dapil berhasil dihapus!");
            else
                Session::flash("error","Data dapil gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('dapil.index'));
    }
}
