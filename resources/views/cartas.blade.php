@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $cartaPermisoCrear= Session::get('Cartas.crear');                                                         
            $cartaPermisoLeer= Session::get('Cartas.leer'); 
            $cartaPermisoActualizar= Session::get('Cartas.actualizar'); 
            $cartaPermisoBorrar= Session::get('Cartas.borrar');                         
        @endphp
        @if ($cartaPermisoCrear==1)
            <a href="{{ route('cartas.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nueva carta</a>            
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de cartas</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                           
                            @if ($cartas!="")
                            <table id="cartas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>PV</th>
                                        <th>Turno</th>
                                        <th>Estado</th> 
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartas as $carta)                                                                               @php
                                            $color = $carta->status==1 ? 'success' : 'warning' ;
                                            $estado = $carta->status==1 ? 'Activo' : 'Desactivado' ;
                                           @endphp               
                                        <tr>
                                            <td>{{$carta->id}}</td>
                                            <td>{{$carta->name}}</td>
                                            <td>{{$carta->pv}}</td>
                                            <td>{{$carta->turno}}</td>
                                            <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>
                                            <td>
                                                @if ($cartaPermisoLeer==1)
                                                    <a href="{{ route('cartas.show', $carta->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                                    
                                                @endif
                                                @if ($cartaPermisoLeer==1 && $cartaPermisoActualizar==1)
                                                    <a href="{{ route('cartas.edit', $carta->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>                                                    
                                                @endif
                                                @if ($cartaPermisoBorrar==1)
                                                    <a onclick="deleteCarta({{$carta->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                                                  
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay cartas 
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