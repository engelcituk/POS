@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('alergenos.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo alergeno</a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de alergenos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            {{-- <table id="alergenos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>name</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>name</th>                                        
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table> --}}
                            @if ($alergenos!="")
                            <table id="alergenos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>name</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alergenos as $alergeno)                     
                                        <tr>
                                            <td>{{$alergeno->id}}</td>
                                            <td>{{$alergeno->name}}</td>                                                                      
                                            <td>
                                                <a href="{{ route('alergenos.show', $alergeno->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('alergenos.edit', $alergeno->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                
                                                <a imgNombre="{{$alergeno->icono}}" onclick="deleteAlergeno({{$alergeno->id}},'{{$alergeno->icono}}')" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay alergenos 
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