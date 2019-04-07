<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\partai;
use Session;
use Image;

class PartaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = partai::where("isDeleted",false)->get();
        return view("partai.index")
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("partai.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('nama_partai') && $request->hasFile('logo_partai')) {
            $logo = $request->file('logo_partai');
            $filename = time().'.'.$logo->getClientOriginalExtension();
            Image::make($logo)->resize(300, 300)->save(public_path('/uploads/'.$filename ));
            $tambah = new partai;
                $tambah->nama_partai=$request->nama_partai;
                $tambah->logo_partai=$filename;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('partai.create'));
        }

        return redirect(Route('partai.index'));
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
        $data = partai::where("id_partai",$id)->first();
        if($data==null) return redirect(route('partai.index'));
        return view("partai.edit")
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
        if($request->has('nama_partai') && $request->hasFile('logo_partai')) {
            $logo = $request->file('logo_partai');
            $filename = time().'.'.$logo->getClientOriginalExtension();
            Image::make($logo)->resize(300, 300)->save(public_path('/uploads/'.$filename ));
            $update = partai::where("id_partai",$id)->update([
                "nama_partai" => $request->nama_partai,
                "logo_partai" => $filename,
            ]);
            if($update)
                Session::flash("success","Data partai berhasil diupdate!");
            else
                Session::flash("error","Data partai gagal diupdate!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('partai.edit',$id));
        }

        return redirect(Route('partai.index'));
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
            $hapus = partai::where("id_partai",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data partai berhasil dihapus!");
            else
                Session::flash("error","Data partai gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('partai.index'));
    }
}
