<?php

namespace App\Http\Controllers;

use App;
use Gate;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function listar(){
        $proyectos = App\Proyecto::orderBy('nombre','asc')->get();

        return response()->json([
            $proyectos
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $consulta = $request->buscar;
            $proyectos = App\Proyecto::where('nombre', 'LIKE', '%' . $consulta . '%')
                                        ->orderby('nombre','asc')
                                        ->paginate(5);
            return view('proyecto.index', compact('proyectos','consulta'));
        }

        $proyectos = App\Proyecto::orderby('nombre','asc')->paginate(5);
        return view('proyecto.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('crear-proyecto')) {
            return redirect(route('proyecto.index'));
        }
        return view('proyecto.create');
        //return view('proyecto.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->ajax())
        {
            App\Proyecto::create($request->all());
            return response()->json([
                'mensaje' => 'Creado'
            ]);
        }
    // //validar que lleguen todos los campos          
    //    $request->validate([
    //         'nombre' => 'required',
    //         'duracion' => 'required' ]);

    //    App\Proyecto::create($request->all());

    //    return redirect()->route('proyecto.index')
    //                     ->with('exito','Se ha creado el proyecto correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyecto = App\Proyecto::findorfail($id);

        return view('proyecto.view', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('editar-proyecto')) {
            return redirect()->route('proyecto.index');
        }
        $proyecto = App\Proyecto::findorfail($id);

        return response()->json([
            $proyecto
        ]);

        
        //return view('proyecto.edit', compact('proyecto'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'nombre' => 'required',
            'duracion' => 'required'
        ]);
        
        $proyecto = App\Proyecto::findorfail($id);

        $proyecto->update($request->all());

        return response()->json(
            ["mensaje" => "modificado"]
        );

        // return redirect()->route('proyecto.index')
        //                 -> with('exito','Proyecto modificado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (Gate::denies('eliminar-proyecto')) {
            return redirect()->route('proyecto.index');
        }

        $proyecto = App\Proyecto::findorfail($id);

        $proyecto->delete();

        return redirect()->route('proyecto.index')
                        -> with('exito','Proyecto eliminado correctamente!');
    }


    public function darProyectos(){
        $proyectos = App\Proyecto::orderBy('nombre','asc')->get();

        return response()->json($proyectos);
    }

    public function guardarProyecto(Request $request){
        return App\Proyecto::create($request->all());
    }
}
