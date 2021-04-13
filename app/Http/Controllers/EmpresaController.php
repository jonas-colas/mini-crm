<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::orderBy('nombre', 'asc')->paginate(10);
        return view('admin.empresas')->with(['empresas' => $empresas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->nombre)){
            Session::flash('error', 'Nombre obligario');
            return redirect('empresas');
        }
        if($request->file('logotipo')) {
            $request->validate([
                'logotipo' => 'mimes:png,jpg,jpeg,svg|max:2048'
            ]);
            $storagePath = Storage::disk('local')->put('public', $request->file('logotipo'));
            $storageName = basename($storagePath);
        }else{
            $storageName = '';
        }
        $emp = new Empresa;
        $emp->nombre   = $request->nombre;
        $emp->email    = $request->email;
        $emp->logotipo = $storageName;
        $emp->website  = $request->website;
        
        $newEmp = $emp->save();
        if($newEmp){
            Session::flash('message', 'Empresa agregada con exito!');
            return redirect('empresas');
        }else{
            Session::flash('error', 'Hubo un error al guardar las informaciones');
            return redirect('empresas');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(empty($request->nombre)){
            Session::flash('error', 'Nombre obligario');
            return redirect('empresas');
        }
        if($request->file('logotipo')) {
            $request->validate([
                'logotipo' => 'mimes:png,jpg,jpeg,svg|max:2048'
            ]);
            $storagePath = Storage::disk('local')->put('public', $request->file('logotipo'));
            $storageName = basename($storagePath);
        }
        $emp = Empresa::findOrFail($request->id);
        $emp->nombre   = $request->nombre;
        $emp->email    = $request->email;
        if(!empty($storageName)){
            $emp->logotipo = $storageName;    
        }
        $emp->website  = $request->website;
        
        $newEmp = $emp->save();
        if($newEmp){
            Session::flash('message', 'Empresa actualizada con exito!');
            return redirect('empresas');
        }else{
            Session::flash('error', 'Hubo un error al guardar las informaciones');
            return redirect('empresas');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $emp = Empresa::findOrFail($request->id);
        $del = $emp->delete();

        if($del){
            Session::flash('message', 'Registro Eliminado con exito !');
            return redirect('empresas');
        }else{
            Session::flash('error', 'No se pudo eliminar el registro !');
            return redirect('empresas');
        }
    }
}
