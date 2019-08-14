@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mpPermisocrear= Session::get('MetodosPago.crear');                                                         
            $mpPermisoLeer= Session::get('MetodosPago.leer'); 
            $mpPermisoActualizar= Session::get('MetodosPago.actualizar'); 
            $mpPermisoBorrar= Session::get('MetodosPago.borrar');                         
        @endphp
        @if ($mpPermisocrear==1)
            <a href="{{ route('metodospago.create') }}" class="btn btn-success"><i class="fas fa-money-bill-alt"></i> Nuevo metodoPago</a>            
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Formas de Pago</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                             @if ($metodosPago!="")
                            <table id="metodosPago" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($metodosPago as $metodoPago)                                                      
                                        <tr>
                                            <td>{{$metodoPago->id}}</td>
                                            <td>{{$metodoPago->name}}</td>                                           
                                            <td>{{$metodoPago->descripcion}}</td>  
                                            <td>
                                                @if ($mpPermisoLeer==1)
                                                    <a href="{{ route('metodospago.show', $metodoPago->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                         
                                                @endif
                                                @if ($mpPermisoLeer==1 && $mpPermisoActualizar==1)
                                                    <a href="{{ route('metodospago.edit', $metodoPago->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
                                                @endif
                                                @if ($mpPermisoBorrar==1)
                                                    <a onclick="deleteMetodoPago({{$metodoPago->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                                              
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay metodosPago 
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