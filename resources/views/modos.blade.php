@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('modos.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo modo</a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de modos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($modos!="")
                            <table id="modos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descripción</th>
                                        <th>Fecha Alta</th>                                        
                                        <th>Hora Alta</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modos as $modo)
                                    @php
                                        $fecha = substr($modo->fechaAlta, 0,10);
                                        $hora = $modo->horaAlta;
                                    @endphp                    
                                        <tr>
                                            <td>{{$modo->id}}</td>
                                            <td>{{$modo->descripcion}}</td> 
                                            <td>{{$fecha}}</td>                                                                
                                            <td>{{$hora}}</td>                                                                      
                                            <td>
                                                <a href="{{ route('modos.show', $modo->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('modos.edit', $modo->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                
                                                <a onclick="deleteModo({{$modo->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay modos 
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