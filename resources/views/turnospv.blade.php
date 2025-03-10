@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $turnoPermisocrear= Session::get('TurnosPV.crear');                                                         
            $turnoPermisoLeer= Session::get('TurnosPV.leer'); 
            $turnoPermisoActualizar= Session::get('TurnosPV.actualizar'); 
            $turnoPermisoBorrar= Session::get('TurnosPV.borrar');                         
        @endphp
        @if ($turnoPermisocrear==1)            
            <a href="{{ route('turnos.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo turno</a>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de turnos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($turnos!="")
                            <table id="turnos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Fin</th>
                                        <th>Turno</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($turnos as $turno) 
                                                                                                       
                                        <tr>
                                            <td>{{$turno->id}}</td>
                                            <td>{{$turno->horaInicio}}</td>
                                            <td>{{$turno->horaFin}}</td>
                                            <td>{{$turno->turno}}</td>                                                                                                                                 
                                            <td>
                                                @if ( $turnoPermisoLeer==1)
                                                    <a href="{{ route('turnos.show', $turno->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a> 
                                                @endif

                                                @if ($turnoPermisoLeer==1 && $turnoPermisoActualizar==1)
                                                     <a href="{{ route('turnos.edit', $turno->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a> 
                                                @endif                                                
                                                @if ($turnoPermisoBorrar==1)
                                                     <a onclick="deleteTurno({{$turno->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a> 
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay turnos
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