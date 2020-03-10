@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $cpPermisocrear= Session::get('Zonas.crear');                                                         
            $cpPermisoLeer= Session::get('Zonas.leer'); 
            $cpPermisoActualizar= Session::get('Zonas.actualizar'); 
            $cpPermisoBorrar= Session::get('Zonas.borrar');                         
        @endphp
        @if ($cpPermisocrear==1)
            <a href="{{ route('centrosprod.create') }}" class="btn btn-success"><i class="fas fa-utensils"></i> Nuevo centro</a>            
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Centros productivos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($centrosProd!="")
                              <table id="centrosProd" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Nombre</th>
                                        <th>Punto de Venta</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($centrosProd as $cp) 
                                     @php
                                        $color = $cp->status==1 ? 'success' : 'warning' ;
                                        $estado = $cp->status==1 ? 'Activo' : 'Desactivado' ;
                                     @endphp                                          
                                        <tr>
                                            <td>{{$cp->id}}</td>
                                            <td>{{$cp->name}}</td>
                                            <td>{{$cp->pv}}</td>
                                            <td>{{$cp->descripcion}}</td>                                           
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td> 
                                            <td>
                                                
                                                @if ($cpPermisoLeer==1 && $cpPermisoActualizar==1)
                                                  <a href="{{ route('centrosprod.edit', $cp->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a> 
                                                @endif
                                                @if ($cpPermisoBorrar==1 )
                                                    <a onclick="deleteCentroProd({{$cp->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                                @endif                                     
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     no hay centrosProd aún 
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
<!-- 
