@extends('layouts.dashboard')
@section('content') 
<div class="content">
    <div class="container-fluid">
        @php
            $mcPermisocrear= Session::get('MenusCarta.crear');              
        @endphp
        <a href="{{ route('menuscartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($mcPermisocrear==1)
            <form method="POST" action="{{ route('menuscartas.store')}}" id='monsters'>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            @if ($cartas!="")
                                            <select class="form-control" name="idCarta" required>
                                                <option value="">Elija carta</option>
                                                    @foreach($cartas as $carta)
                                                        <option value="{{$carta->id}}">{{$carta->name}}</option>
                                                    @endforeach
                                            </select>  
                                            @else
                                                <select class="form-control" name="idCarta" required>
                                                    <option value="">Aun no hay cartas</option>                           
                                                </select> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="well well-sm"><strong>No repita productos al ir generando la lista para el menú</strong></div>
                                </div>                                                                
                            <div class="panel-body">
                                	
                                <div class="viewcontent">                                
                                 <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                            <tr class="info">
                                                <th><strong>Producto</strong></th>
                                                <th><strong>Precio</strong></th>
                                                <th><strong>Centro Preparación</strong></th>
                                                <th><strong>Acciones</strong></th>
                    
                                            </tr>
                                        </thead>                 
                                            <tr id="id1" class="clonarTr">
                                                <td>
                                                    @if ($productos!="")
                                                    <div class="lista ">
                                                        <select class="form-control listaProductos combobox" id="lstProductos1" name="idProducto[]" required>
                                                        <option value="">Elija producto</option>
                                                            @foreach($productos as $producto)
                                                                <option precio="{{$producto->precio}}" value="{{$producto->id}}">{{$producto->nombreProducto}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                      
                                                    @else
                                                        <select class="form-control" id="lstProductos1" name="idProducto[]" required>
                                                            <option value="">Aun no hay productos</option>                           
                                                        </select> 
                                                    @endif
                                                </td>
                                                <td>
                                                    <input id="precio1" type="number" step="0.01" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="precio[]"  required>                                                    
                                                </td>
                                                <td>
                                                    @if ($centrosPreparacion!="")
                                                        <select class="form-control" id="lstCP1" name="idCentroPrep[]" required>
                                                            <option value="">Centro Preparacion</option>
                                                                @foreach($centrosPreparacion as $cp)
                                                                    <option value="{{$cp->id}}">{{$cp->name}}</option>
                                                                @endforeach
                                                        </select>  
                                                    @else
                                                        <select class="form-control" id="lstCP1" name="idCentroPrep[]" required>
                                                            <option value="">No hay centros de preparacion</option>                           
                                                        </select> 
                                                    @endif                                                               
                                                </td>
                                                <td>
                                                    @if ($centrosP!="")
                                                        <select class="form-control" id="lstCPR1" name="idCentroProd[]" required>
                                                            <option value="">Centros productivos</option>
                                                                @foreach($centrosP as $cpr)
                                                                    <option value="{{$cpr->id}}">{{$cpr->codigo}}</option>
                                                                @endforeach
                                                        </select>  
                                                    @else
                                                        <select class="form-control" id="lstCPR1" name="idCentroProd[]" required>
                                                            <option value="">No hay centros productivos</option>                           
                                                        </select> 
                                                    @endif                                                               
                                                </td>                                                     
                                                <td>
                                                    <a class='btn btn-primary btn-sm addCloneTr'> <i class="fas fa-plus"></i></a> 
                                                    <a class='btn btn-danger btn-sm clonTr_remove'> <i class="fas fa-remove"></i></a>
                                                </td>
                                            </tr>
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
                            <h3>Usted no tiene permiso para registrar</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div> 
        @endif        
    </div>
</div> 
<script>    

// $('.listaProductos').selectize();
</script>
@endsection