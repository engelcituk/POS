@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
         @php
            $mcPermisoActualizar= Session::get('MenusCarta.actualizar'); 
        @endphp  
        <a href="{{ route('menuscartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($mcPermisoActualizar==1)
            <form method="POST" action="{{route('menuscartas.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                       @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$menucarta->id}}" required>
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idCarta" required>
                                            <option value="{{$datosCarta->id}}">{{$datosCarta->name}}</option>
                                                    @foreach($cartas as $carta)
                                                        <option value="{{$carta->id}}">{{$carta->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="panel-body">
                                <div class="viewcontent">
                                    <table id="tblMenuCartas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Centro Preparación</th>
                                            <th></th>
                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="addr0" data-id="0">
                                            <td data-name="idProducto">
                                            <select class="form-control listaProductos" name="idProducto" required>
                                                <option value="{{$datosProducto->id}}">{{$datosProducto->nombreProducto}}</option>
                                                    @foreach($productos as $producto)
                                                        <option value="{{$producto->id}}">{{$producto->nombreProducto}}</option>
                                                    @endforeach
                                            </select>
                                            </td>
                                            <td data-name="precio">
                                            <input id="precio" type="number" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="precio" value="{{$menucarta->precio}}" required>
                                            </td>
                                            <td data-name="idCentroPrep">
                                            <select class="form-control" name="idCentroPrep" required>
                                                    <option value="{{$datosCP->id}}">{{$datosCP->name}}</option>
                                                        @foreach($centrosPreparacion as $cp)
                                                            <option value="{{$cp->id}}">{{$cp->name}}</option>
                                                        @endforeach
                                                </select>
                                            </td>                                             
                                        </tr>                                   
                                    </tbody>
                                    </table>     
                                </div>    
                              
                                <button type="submit" class="btn btn-primary pull-left"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>            
        @else
            <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                            <h3>Usted no tiene permiso para editar la información</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif                        
    </div>
</div>

<script>
$(document).ready(function() {
    $('.listaProductos').select2();
});    
</script>
@endsection
