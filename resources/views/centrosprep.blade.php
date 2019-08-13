@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $cpPermisocrear= Session::get('CentrosPreparacion.crear');                                                         
            $cpPermisoLeer= Session::get('CentrosPreparacion.leer'); 
            $cpPermisoActualizar= Session::get('CentrosPreparacion.actualizar'); 
            $cpPermisoBorrar= Session::get('CentrosPreparacion.borrar');                         
        @endphp
        @if ($cpPermisocrear==1)
            <a href="{{ route('centrospreparacion.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo Centro Prep</a>        
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de centros de preparación</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            @if ($centrosP!="")
                            <table id="centroP" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Impresora</th>
                                        <th>Impresora B</th>
                                        <th>Descripción</th> 
                                        <th>Imprime</th>                                        
                                        <th>Estado</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($centrosP as $cp) 
                                        @php
                                            $color = $cp->status==1 ? 'success' : 'warning' ;
                                            $estado = $cp->status==1 ? 'Activo' : 'Desactivado'; 
                                        
                                            $colorImprime = $cp->imprime==1 ? 'success' : 'warning' ;
                                            $imprime = $cp->imprime==1 ? 'SI' : 'NO';
                                        @endphp                                                                
                                        <tr>
                                            <td>{{$cp->id}}</td>
                                            <td>{{$cp->name}}</td>
                                            <td>{{$cp->impresora}}</td>
                                            <td>{{$cp->impresoraB}}</td>
                                            <td>{{$cp->descripcion}}</td>
                                            <td><button class="btn btn-{{$colorImprime}} btn-xs">{{$imprime}}</button></td>
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>                                          
                                            <td>
                                                @if ($cpPermisoLeer==1)
                                                   <a href="{{ route('centrospreparacion.show', $cp->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a> 
                                                @endif
                                                @if ($cpPermisoLeer ==1 && $cpPermisoActualizar==1)
                                                   <a href="{{ route('centrospreparacion.edit', $cp->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
                                                @endif 
                                                @if ($cpPermisoBorrar ==1 )
                                                   <a onclick="deleteCentroPreparacion({{$cp->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                                @endif                                               
                                                                                                
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay Centros de preparación 
                            @endif 
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
</div>
@endsection