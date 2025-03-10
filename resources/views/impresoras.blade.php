@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            @php
                $impresoraPermisocrear= Session::get('Impresoras.crear');                                                         
                $impresoraPermisoLeer= Session::get('Impresoras.leer'); 
                $impresoraPermisoActualizar= Session::get('Impresoras.actualizar'); 
                $impresoraPermisoBorrar= Session::get('Impresoras.borrar');                         
            @endphp
            @if ($impresoraPermisocrear==1)
                <a href="{{ route('impresoras.create') }}" class="btn btn-success"><i class="fas fa-print"></i> Nueva impresora</a>     
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Impresoras</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($impresoras!="")
                              <table id="impresoras" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Ip Impresoras</th>
                                        <th>Estado</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                     @foreach($impresoras as $impresora) 
                                        @php
                                            $color = $impresora->status==1 ? 'success' : 'warning' ;
                                            $estado = $impresora->status==1 ? 'Activo' : 'Desactivado' ;
                                        @endphp                                        
                                        <tr>
                                            <td>{{$impresora->id}}</td>
                                            <td>{{$impresora->name}}</td>
                                            <td>{{$impresora->ipImpresora}}</td>
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>                     
                                            <td>
                                                @if ($impresoraPermisoLeer==1)
                                                    <a href="{{ route('impresoras.show', $impresora->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>   
                                                @endif    
                                                @if ($impresoraPermisoLeer==1 && $impresoraPermisoActualizar==1)
                                                    <a href="{{ route('impresoras.edit', $impresora->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>    
                                                @endif                                            
                                                @if ($impresoraPermisoBorrar==1)
                                                    <a onclick="deleteImpresora({{$impresora->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>    
                                                @endif                                                   
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     No hay Impresoras 
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