@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo usuario</a>

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
                            {{-- <table id="users" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>FechaAlta</th>
                                        <th>idRol</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>FechaAlta</th>
                                        <th>idRol</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table> --}}
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
                                    @foreach($users as $rol)  
                                    @php
                                        $fecha = substr($rol->fechaAlta, 0,10);

                                        $color = $rol->status==1 ? 'success' : 'warning' ;
                                        $estado = $rol->status==1 ? 'Activo' : 'Desactivado' ;
                                    @endphp                                                     
                                        <tr>
                                            <td>{{$rol->id}}</td>
                                            <td>{{$rol->name}}</td>                                           
                                            <td>{{$rol->usuario}}</td>                                                         
                                            <td>{{$fecha}}</td> 
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>                      
                                            <td>
                                                <a href="{{ route('users.show', $rol->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('users.edit', $rol->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                
                                                <a onclick="deleteRol({{$rol->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
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