@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        @php
            $usuarioPermisocrear= Session::get('Usuarios.crear');                                                         
            $usuarioPermisoLeer= Session::get('Usuarios.leer'); 
            $usuarioPermisoActualizar= Session::get('Usuarios.actualizar'); 
            $usuarioPermisoBorrar= Session::get('Usuarios.borrar');                         
        @endphp

        @if ($usuarioPermisocrear==1)                    
            <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-user"></i> Nuevo usuario</a>           
        @endif
        
        {{-- {{Session::get('Usuarios.leer')}}  --}}

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Usuarios</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($users!="")
                            <table id="users" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>FechaAlta</th>                                        
                                        <th>Estado</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $usuario)  
                                    @php
                                        $fecha = substr($usuario->fechaAlta, 0,10);
                                        $color = $usuario->status==1 ? 'success' : 'warning' ;
                                        $estado = $usuario->status==1 ? 'Activo' : 'Desactivado' ;
                                    @endphp                                                     
                                        <tr>
                                            <td>{{$usuario->id}}</td>
                                            <td>{{$usuario->name}}</td>                                           
                                            <td>{{$usuario->usuario}}</td>                                                         
                                            <td>{{$fecha}}</td> 
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>                      
                                            <td>
                                                @if($usuarioPermisoLeer==1)
                                                    <a href="{{ route('users.show', $usuario->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                                   
                                                @endif
                                                @if ($usuarioPermisoLeer==1 && $usuarioPermisoActualizar==1)
                                                    <a href="{{ route('users.edit', $usuario->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                    
                                                @endif
                                                @if ($usuarioPermisoLeer==1 && $usuarioPermisoActualizar==1)
                                                    <a onclick="showPermisosModal({{$usuario->id}})" class="btn btn-xs btn-primary" ><i class="fas fa-key"></i></a>                                                   
                                                @endif                                             
                                                @if ($usuarioPermisoBorrar==1 )
                                                    <a onclick="deleteUsuario({{$usuario->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                                                   
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
    @include('users.partials.modalPermisosUser')
</div>
@endsection