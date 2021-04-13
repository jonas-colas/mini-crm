<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $empleados = Empleado::orderBy('nombre', 'asc')->paginate(10);
        // return view('admin.empleados')->with(['empleados' => $empleados]);

        $empleados = Empleado::join('empresas', 'empresas.id', '=', 'empleados.empresa_id')
                    ->select('empleados.*', 'empleados.empresa_id', 'empresas.nombre as empresa')
                    ->orderBy('empleados.nombre', 'desc')->paginate(10);

        return view('admin.empleados')->with(['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(empty($request->nombre) || empty($request->apellido)){
            Session::flash('error', 'Campos Nombre y Apellido obligatorios');
            return redirect('empleados');
        }
        if(empty($request->empresa_id) || !is_numeric($request->empresa_id)){
            Session::flash('error', 'Elige una empresa');
            return redirect('empleados');
        }

        $empl = new Empleado();
        $empl->nombre     = $request->nombre;
        $empl->apellido   = $request->apellido;
        $empl->email      = $request->email;
        $empl->empresa_id = $request->empresa_id;
        $empl->telefono   = $request->telefono;

        $newEmpl = $empl->save();

        if ($newEmpl) {
            Session::flash('message', "Empleado creado con exito!");
            return redirect('empleados');
        }else{
            Session::flash('error', 'Hubo un error al crear el empleado');
            return redirect('empleados');
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(empty($request->nombre) || empty($request->apellido)){
            Session::flash('error', 'Campos Nombre y Apellido obligatorios');
            return redirect('empleados');
        }

        $empl = Empleado::findOrFail($request->id);
        $empl->nombre     = $request->nombre;
        $empl->apellido   = $request->apellido;
        $empl->email      = $request->email;
        $empl->empresa_id = $request->empresa_id;
        $empl->telefono   = $request->telefono;

        $newEmpl = $empl->save();

        if ($newEmpl) {
            Session::flash('message', "Empleado actualizado con exito!");
            return redirect('empleados');
        }else{
            Session::flash('error', 'Hubo un error al actualizar el registro');
            return redirect('empleados');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $empl = Empleado::findOrFail($request->id);
        $del = $empl->delete();

        if($del){
            Session::flash('message', 'Registro Eliminado con exito !');
            return redirect('empleados');
        }else{
            Session::flash('error', 'No se pudo eliminar el registro !');
            return redirect('empleados');
        }
    }
}
