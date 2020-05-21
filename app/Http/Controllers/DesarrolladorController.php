<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Gate;

class DesarrolladorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrollador = App\Desarrollador::orderby('nombre','asc')->get();
        return view('desarrollador.index', compact('desarrollador'));
    
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos = App\Proyecto::orderby('nombre', 'asc')->get();
        return view('desarrollador.insert', compact('proyectos'));
    }
    
    
    /**s
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validar que lleguen todos los campos          
       $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'telefono' => 'required',
        'direccion' => 'required',
        'idproyecto' => 'required'
         ]);

   App\Desarrollador::create($request->all());

   return redirect()->route('desarrollador.index')
                    ->with('exito','Se ha creado el desarrollador correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $desarrollador = App\Desarrollador::join('proyectos', 'desarrolladors.idproyecto','proyectos.id')
                                            ->select('desarrollador.*','proyectos.nombre as proyecto')
                                            ->where('desarrolladors.id',$id)
                                            ->first();

        return view('desarrollador.view', compact('desarrollador'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        if (Gate::denies('editar-desarrollador')) {
            return redirect(route('desarrollador.index'));
        }

        $proyectos = App\Proyecto::orderby('nombre','asc')->get();
        $desarrollador = App\Desarrollador::findorfail($id);

        return view('desarrollador.edit', compact('desarrollador', 'proyectos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'idproyecto' => 'required'
        ]);
        
                $desarrollador = App\Desarrollador::findorfail($id);
        
                $desarrollador->update($request->all());
        
                return redirect()->route('desarrollador.index')
                                -> with('exito','Desarrollador modificado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Desarrollador  $desarrollador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (Gate::denies('eliminar-desarrollador')) {
            return redirect()->route('desarrollador.index');
        }
    
        $desarrollador = App\Desarrollador::findorfail($id);

        $desarrollador->delete();

        return redirect()->route('desarrollador.index')
                        -> with('exito','Desarrollador eliminado correctamente!');



    }
}
