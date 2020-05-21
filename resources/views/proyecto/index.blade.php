@extends('layouts.layouts')

@section('titulo')
Proyectos
@endsection

@section('contenido')
    @include('proyecto.modal')
    <h1 class="text-center">Proyectos</h1>
    <br><br>

    @if ($consulta)
    <div class="alert alert-primary">
        <p>Los resultados de la bùsqueda <strong>{{$consulta}}</strong> son:</p>
    </div>
    @endif

    @if($message = Session::get('exito'))
    <div class="alert alert-success">
        <p>{{$message}}</p>
    </div>
    @endif

    <table class="table table-bordered">

        <thead>
            <th>Nombre</th>
            <th>Duración</th>
            <th>Acciones</th>
        </thead>

        <tbody id="tablaDatos">
            @foreach ($proyectos as $proyecto)
            <tr>
                <td>{{$proyecto -> nombre}}</td>
                <td>{{$proyecto -> duracion}}</td>
                <td>
                    <form action="{{route('proyecto.destroy', $proyecto->id)}}" method="post">
                        <a href="{{route('proyecto.show', $proyecto->id)}}" class="btn btn-info float-left">Ver</a>&nbsp;
                        @can('editar-proyecto')
                            {{-- <a href="{{route('proyecto.edit', $proyecto->id)}}" class="btn btn-primary">Editar</a> --}}
                            
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar" value="{{$proyecto->id}}" onclick="mostrar(this)">
                                Editar
                            </button>
                        @endcan

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <br>

    {{-- {{$proyectos->links()}} --}}

    <br><br>
    <div class="row">
        <a href="{{route('proyecto.create')}} "><button class="btn btn-success">Crear Proyecto</button></a>
    </div>
    
    <script>
        function mostrar(btn){
            console.log(btn.value);
            var ruta = "proyecto/" + btn.value + "/edit";
            $.get(ruta, function(respuesta){
                console.log(respuesta[0]);
                $('#nombre').val(respuesta[0].nombre);
                $('#duracion').val(respuesta[0].duracion);
                $('#id').val(respuesta[0].id);
            });
        }

        $('#actualizar').click(function(){
            var id = $('#id').val();
            var datos = $('#formulario').serialize();
            var ruta = 'proyecto/' + id;

            $.ajax({
                data: datos,
                url: ruta,
                type: 'PUT',
                dataType: 'json',
                success: function(){
                    alert('Datos Modificados');
                    cargarDatos();
                }
            });
        });

        function cargarDatos(){
            var tabla = $('#tablaDatos');
            var ruta = 'proyectos';

            tabla.empty();

            $.get(ruta, function(respuesta){
                console.log(respuesta);
                respuesta[0].forEach(element => {
                    tabla.append("<tr><td>" + element.nombre + "</td><td>" + element.duracion  + "</td><td> <button class='btn btn-info'>Ver</button> <button class='btn btn-primary'>Editar</button> <button class='btn btn-danger'>Eliminar</button></td></tr>");
                });
            });
        }
    </script>

@endsection
