@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $rolPermisocrear= Session::get('Roles.crear');                                                         
            $rolPermisoLeer= Session::get('Roles.leer'); 
            $rolPermisoActualizar= Session::get('Roles.actualizar'); 
            $rolPermisoBorrar= Session::get('Roles.borrar');                         
        @endphp

        @if ($rolPermisocrear==1)                    
            <a href="{{ route('rolesapi.create') }}" class="btn btn-success"><i class="fas fa-user-tag"></i> Nuevo Rol</a>
        @endif
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de roles</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($roles!="")
                            <table id="rolesAPI" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>FechaAlta</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $rol)  
                                    @php
                                        $fecha = substr($rol->fechaAlta, 0,10);
                                    @endphp                                                     
                                        <tr>
                                            <td>{{$rol->id}}</td>
                                            <td>{{$rol->name}}</td>                                           
                                            <td>{{$rol->descripcion}}</td>                                                         
                                            <td>{{$fecha}}</td> 
                                            <td>
                                                @if($rolPermisoLeer==1)
                                                    <a href="{{ route('rolesapi.show', $rol->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                                    
                                                @endif
                                                @if ($rolPermisoLeer==1 && $rolPermisoActualizar==1)
                                                   <a href="{{ route('rolesapi.edit', $rol->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>  
                                                @endif
                                                @if($rolPermisoBorrar==1)
                                                    <a onclick="deleteRol({{$rol->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                                                  
                                                @endif                                            
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay roles registrados 
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