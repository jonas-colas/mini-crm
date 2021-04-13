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
        <th>Email</th>
        <th>Logotipo</th>
        <th>Sitio Web </th>
        <th>opciones</th> 
      </tr>
    </thead>
    <tbody>
      @if($empresas)
        @foreach($empresas as $emp)
          <tr>
            <td>{{$emp->nombre}}</td>
            <td>{{$emp->email}}</td>
            <td><img src="{{ asset('storage/'.$emp->logotipo) }}" width="100" /> </td>
            <td>{{$emp->website}}</td>
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
                      <form action="{{ url('empresas/edit') }}" method="post" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf
                        <div class="form-group">
                          <label class=""> <b>Nombre de la Empresa </b><small class="text-danger">(*)</small></label>
                          <input type="text" class="form-control" name="nombre" value="{{ $emp->nombre }}">
                          <input type="hidden" name="id" value="{{ $emp->id }}">
                        </div>
                        <div class="form-group">
                          <label class=""> <b>Email de la empresa</b></label>
                          <input type="text" class="form-control" name="email" value="{{ $emp->email }}">
                        </div>
                        <div class="form-group">
                          <label class=""> <b>Sitio Web (*)</b></label>
                          <input type="text" class="form-control" name="website" value="{{ $emp->website }}">
                        </div>
                        <div class="form-group">
                          <label class=""> <b>Logotipo</b></label>
                          <span><img src="{{ asset('storage/'.$emp->logotipo) }}" width="100" /></span>
                          <input type="file" class="form-control" name="logotipo" >
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
                      <form action="{{ url('empresas/destroy') }}" method="post" accept-charset="utf-8">
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
      @if(($empresas) != null)
        {{ $empresas->links() }}
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
          <form action="{{ url('empresas/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label class=""> <b>Nombre de la Empresa </b><small class="text-danger">(*)</small></label>
              <input type="text" class="form-control" name="nombre" placeholder="ingrese nombre">
            </div>
            <div class="form-group">
              <label class=""> <b>Email de la Empresa</b></label>
              <input type="text" class="form-control" name="email" placeholder="ingrese email">
            </div>
            <div class="form-group">
              <label class=""> <b>Sitio Web  (Si posee)</b></label>
              <input type="text" class="form-control" name="website" placeholder="ingrese website">
            </div>
            <div class="form-group">
              <label class=""> <b>Logotipo</b></label>
              <input type="file" class="form-control" name="logotipo" >
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