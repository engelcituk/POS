@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $productoPermisocrear= Session::get('Productos.crear');                                                         
            $productoPermisoLeer= Session::get('Productos.leer'); 
            $productoPermisoActualizar= Session::get('Productos.actualizar'); 
            $productoPermisoBorrar= Session::get('Productos.borrar');                         
        @endphp
        @if ($productoPermisocrear==1)
            <a href="{{ route('productos.create') }}" class="btn btn-success"><i class="fab fa-product-hunt"></i> Nuevo producto</a>   
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Productos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            @if ($productos!="")
                              <table id="productos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>codProducto</th>
                                        <th>Nombre</th>
                                        {{-- <th>fechaAlta</th> --}}
                                        <th>propina</th>
                                        <th>Complemento</th>
                                        <th>Precio Manual</th>
                                        <th>Estado</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($productos as $producto)  
                                    @php
                                        // $fecha = substr($producto->fechaAlta, 0,10); 

                                        $colorPropina = $producto->propina==1 ? 'success' : 'warning' ;
                                        $conPropina = $producto->propina==1 ? 'Si' : 'No';

                                        $colorComplemento = $producto->complemento==1 ? 'success' : 'warning' ;
                                        $esComplemento = $producto->complemento==1 ? 'Si' : 'No';

                                        $colorTemporada = $producto->temporada==1 ? 'success' : 'warning' ;
                                        $deTemporada = $producto->temporada==1 ? 'Si' : 'No';
                                        
                                        $colorEstado = $producto->status==1 ? 'success' : 'warning' ;
                                        $estado = $producto->status==1 ? 'Activo' : 'Desactivado';                                       
                                    @endphp                                          
                                        <tr>
                                            <td>{{$producto->id}}</td>
                                            <td>{{$producto->codigoProducto}}</td>
                                            <td>{{$producto->nombreProducto}}</td>
                                            {{-- <td>{{$fecha}}</td>                                            --}}
                                            <td><button class="btn btn-{{$colorPropina}} btn-xs">{{$conPropina}}</button></td> 
                                            <td><button class="btn btn-{{$colorComplemento}} btn-xs">{{$esComplemento}}</button></td>
                                            <td><button class="btn btn-{{$colorTemporada}} btn-xs">{{$deTemporada}}</button></td>
                                            <td><button class="btn btn-{{$colorEstado}} btn-xs">{{$estado}}</button></td> 
                                            <td>
                                                @if ($productoPermisoLeer==1)
                                                    <a href="{{ route('productos.show', $producto->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                       
                                                @endif
                                                @if ($productoPermisoLeer==1 && $productoPermisoActualizar==1)
                                                    <a href="{{ route('productos.edit', $producto->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a> 
                                                @endif
                                                @if ($productoPermisoLeer==1)
                                                    <a onclick="productoModos({{$producto->id}})" class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModalModos">M</a>                             
                                                @endif
                                                @if ($productoPermisoBorrar==1)
                                                    <a onclick="deleteProducto({{$producto->id}},'{{$producto->imagen}}')" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                     
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     No hay productos aun
                             @endif
                            {{--  --}}
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    @include('productos.partials.modalProductoModos')
</div>
@endsection
