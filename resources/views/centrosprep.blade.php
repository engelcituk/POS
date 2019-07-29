@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('centrospreparacion.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo Centro Prep</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de centros de preparación</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">                            
                            @if ($centrosP!="")
                              <table id="CP" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Impresora</th>
                                        <th>Impresora B</th>
                                        <th>Descripción</th> 
                                        <th>Imprime</th>                                        
                                        <th>Estado</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($centrosP as $cp)                                            
                                        <tr>
                                            <td>{{$cp->id}}</td>
                                            <td>{{$cp->name}}</td>
                                            <td>{{$cp->impresora}}</td>
                                            <td>{{$cp->impresoraB}}</td>
                                            <td>{{$cp->descripcion}}</td>
                                            <td>{{$cp->imprime}}</td>
                                            <td>{{$cp->status}}</td>                                          
                                            <td>
                                                <a href="{{ route('centrospreparacion.show', $cp->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('centrospreparacion.edit', $cp->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                
                                                <a onclick="deleteCentroPreparacion({{$cp->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     No hay Centros de preparación 
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