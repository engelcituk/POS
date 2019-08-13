@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $zonaPermisocrear= Session::get('Zonas.crear');                                                         
            $zonaPermisoLeer= Session::get('Zonas.leer'); 
            $zonaPermisoActualizar= Session::get('Zonas.actualizar'); 
            $zonaPermisoBorrar= Session::get('Zonas.borrar');                         
        @endphp
        @if ($zonaPermisocrear==1)
            <a href="{{ route('zonas.create') }}" class="btn btn-success"><i class="fas fa-utensils"></i> Nueva zona</a>            
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Zonas</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($zonas!="")
                              <table id="zonas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                     @foreach($zonas as $zona) 
                                     @php
                                        $color = $zona->status==1 ? 'success' : 'warning' ;
                                        $estado = $zona->status==1 ? 'Activo' : 'Desactivado' ;
                                     @endphp                                          
                                        <tr>
                                            <td>{{$zona->id}}</td>
                                            <td>{{$zona->name}}</td>
                                            <td>{{$zona->pv}}</td>
                                            <td>{{$zona->descripcion}}</td>                                           
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td> 
                                            <td>
                                                @if ($zonaPermisoLeer==1)
                                                  <a href="{{ route('zonas.show', $zona->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>  
                                                @endif
                                                @if ($zonaPermisoLeer==1 && $zonaPermisoActualizar==1)
                                                  <a href="{{ route('zonas.edit', $zona->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a> 
                                                @endif
                                                @if ($zonaPermisoBorrar==1 )
                                                    <a onclick="deleteZona({{$zona->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                                @endif                                     
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     no hay zonas aún 
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
 -->