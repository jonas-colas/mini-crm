@extends('layouts.app')

@section('content')
<div class="container">
  <div class="py-3 text-center">
    <h2>Empresas Registradas</h2>
  </div>
  <div class="float-right my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEmpresa">
      <i class="fa fa-plus-circle"> &nbsp;Agregar Empresa</i> 
    </button>
  </div><br>
  @if(session()->has('message'))
    <div class="mt-5">
      <p class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;{{Session::get('message')}}</p>
    </div>
  @endif 
  @if(session()->has('error'))
    <div class="mt-5">
      <p class="alert alert-danger"><i class="fa fa-times-circle"></i>&nbsp;{{Session::get('error')}}</p>
    </div>
  @endif
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Empresa</th>
        <th>Email </th>
        <th>Telefono </th>
        <th>opciones</th> 
      </tr>
    </thead>
    <tbody>
      @if($empleados)
        @foreach($empleados as $emp)
          <tr>
            <td>{{$emp->nombre}}</td>
            <td>{{$emp->apellido}}</td>
            <td>{{$emp->empresa}}</td>
            <td>{{$emp->email}}</td>
            <td>{{$emp->telefono}}</td>
            <td>
              <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#update-{{ $emp->id }}">
                <i class="fa fa-edit"></i>
              </button>
              <div class="modal fade" id="update-{{ $emp->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-warning">
                      <h5 class="modal-title" id="exampleModalLabel">Actualizar Empresa</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ url('empleados/edit') }}" method="post">
                        {{ method_field('PUT') }}
                        @csrf
                        <div class="form-group">
                          <label> <b>Nombre  (*)</b></label>
                          <input type="text" class="form-control" name="nombre" value="{{ $emp->nombre }}">
                          <input type="hidden" name="id" value="{{ $emp->id }}">
                        </div>
                        <div class="form-group">
                          <label> <b>Apellido  (*)</b></label>
                          <input type="text" class="form-control" name="apellido" value="{{ $emp->apellido }}">
                          <input type="hidden" name="id" value="{{ $emp->id }}">
                        </div>
                        <div class="form-group">
                          <label> <b>Seleccione Empresa</b></label>
                          <select name="empresa_id" class="form-control">
                            <option value={{ $emp->empresa_id }}>{{ $emp->empresa }}</option>
                            <?php $em = DB::table('empresas')->orderBy('nombre', 'asc')->get(); ?>
                              @if($em)
                                @foreach($em as $e)
                                  <option value={{$e->id}} >{{$e->nombre}}</option>
                                @endforeach
                              @endif
                          </select>
                        </div>
                        <div class="form-group">
                          <label> <b>Email </b></label>
                          <input type="text" class="form-control" name="email" value="{{ $emp->email }}">
                        </div>
                        <div class="form-group">
                          <label> <b>Telefono</b></label>
                          <input type="text" class="form-control" name="telefono" value="{{ $emp->telefono }}">
                        </div>
                        <div class="float-right">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#destroy-{{ $emp->id }}">
                <i class="fa fa-trash"></i>
              </button>
              <div class="modal fade" id="destroy-{{ $emp->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content modal-sm">
                    <div class="modal-header bg-warning">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ url('empleados/destroy') }}" method="post" accept-charset="utf-8">
                        {{ method_field('DELETE') }}
                        @csrf
                        <p>Eliminar Registro</p>
                        <input type="hidden" name="id" value="{{ $emp->id }}">
                        <div class="float-right">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-primary">Eliminar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </td>
          </tr>
        @endforeach
      @else
        <p class="alert alert-danger">No Hay Empresa Registrada !</p>
      @endif
    </tbody>
  </table>

  <div class="pagination-bar text-center">
    <nav aria-label="Page navigation " class="d-inline-b">
      @if(($empleados) != null)
        {{ $empleados->links() }}
      @endif
    </nav>
  </div>

</div>



<!-- Modal Agregar-->
<div class="modal fade" id="addEmpresa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white" id="exampleModalLabel">Agregar Nueva Empresa</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('empleados/create') }}" method="post" >
            @csrf
            <div class="form-group">
              <label> <b>Nombre </b><small class="text-danger">(*)</small></label>
              <input type="text" class="form-control" name="nombre" placeholder="ingrese nombre">
            </div> 
            <div class="form-group">
              <label> <b>Apellido  </b><small class="text-danger">(*)</small></label>
              <input type="text" class="form-control" name="apellido" placeholder="ingrese apellido">
            </div>
            <div class="form-group">
              <label> <b>Seleccione Empresa</b></label>
              <select name="empresa_id" class="form-control">
                <option value="0">Seleccione empresa</option>
                <?php $em = DB::table('empresas')->orderBy('nombre', 'asc')->get(); ?>
                  @if($em)
                    @foreach($em as $e)
                      <option value={{$e->id}} >{{$e->nombre}}</option>
                    @endforeach
                  @endif
              </select>
            </div>
            <div class="form-group">
              <label> <b>Email</b></label>
              <input type="text" class="form-control" name="email" placeholder="ingrese email">
            </div>
            <div class="form-group">
              <label> <b>Telefono</b></label>
              <input type="text" class="form-control" name="telefono" placeholder="ingrese telefono">
            </div>
            <div class="float-right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--fin Modal Agregar-->
@endsection