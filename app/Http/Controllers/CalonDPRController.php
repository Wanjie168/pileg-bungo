<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\calon_dpr;
use App\model\partai;
use App\model\dapil;
use Session;
use Image;

class CalonDPRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = calon_dpr::where("isDeleted",false)
                ->with("partai")
                ->with("dapil")
                ->whereHas("partai", function($query) {
                    $query->where("isDeleted",false);
                })
                ->whereHas("dapil", function($query) {
                    $query->where("isDeleted",false);
                })
                ->get();
        return view("calonDPR.index")
            ->with("data",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partai = partai::where("isDeleted",false)->get();
        $dapil = dapil::where("isDeleted",false)->get();
        return view("calonDPR.create")
            ->with("partai",$partai)
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
        if($request->has('nama_calon') && $request->hasFile('foto_calon') && $request->has('id_partai') && $request->has('id_dapil')) {
            $foto = $request->file('foto_calon');
            $filename = time().'.'.$foto->getClientOriginalExtension();
            Image::make($foto)->resize(300, 350)->save(public_path('/uploads/'.$filename ));
            $tambah = new calon_dpr;
                $tambah->id_dapil=$request->id_dapil;
                $tambah->id_partai=$request->id_partai;
                $tambah->nama_calon=$request->nama_calon;
                $tambah->foto_calon=$filename;
            if($tambah->save())
                Session::flash("success","Data berhasil disimpan!");
            else
                Session::flash("error","Data gagal disimpan!");
        } else {
            Session::flash("error","Inputan belum lengkap!");
            return redirect(Route('calonDPR.create'));
        }

        return redirect(Route('calonDPR.index'));
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
    public function edit(Request $request, $id)
    {
        $partai = partai::where("isDeleted",false)->get();
        $dapil = dapil::where("isDeleted",false)->get();
        $data  = calon_dpr::where("id_calon",$id)->first();
        return view("calonDPR.edit")
            ->with("data",$data)
            ->with("partai",$partai)
            ->with("dapil",$dapil);
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
        //dd($request);
        $update = false; $updateFoto = false;

        if($request->has('nama_calon') && $request->has('id_partai') && $request->has('id_dapil')) {
            $update = calon_dpr::where("id_calon",$id)->update([
                "nama_calon" => $request->nama_calon,
                "id_partai" => $request->id_partai,
                "id_dapil" => $request->id_dapil,
            ]);
        } else {
            Session::flash("error","Inputan belum lengkap!");
        }
        if($request->hasFile('foto_calon')) {
            $foto = $request->file('foto_calon');
            $filename = time().'.'.$foto->getClientOriginalExtension();
            Image::make($foto)->resize(300, 350)->save(public_path('/uploads/'.$filename ));
            $updateFoto = calon_dpr::where("id_calon",$id)->update([
                "foto_calon" => $filename,
            ]);
        };

        if($update || $updateFoto) {
                Session::flash("success","Data berhasil disimpan!");
                return redirect(Route('calonDPR.index'));
        } else
                Session::flash("error","Data gagal disimpan!");

        return redirect(Route('calonDPR.edit',$id));
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
            $hapus = calon_dpr::where("id_calon",$id)->update([
                "isDeleted" => true,
            ]);
            if($hapus)
                Session::flash("success","Data calon DPR berhasil dihapus!");
            else
                Session::flash("error","Data calon DPR gagal dihapus!");
        } else
            Session::flash("error","Akses tidak valid!");

        return redirect(Route('calonDPR.index'));
    }
}
