@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $categoriaPermisocrear= Session::get('Categorias.crear');                                                         
            $categoriaPermisoLeer= Session::get('Categorias.leer'); 
            $categoriaPermisoActualizar= Session::get('Categorias.actualizar'); 
            $categoriaPermisoBorrar= Session::get('Categorias.borrar');                         
        @endphp

        @if ($categoriaPermisocrear==1)                   
            <a href="{{ route('categorias.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nueva categoría</a>     
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de categorias</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            
                            @if ($categorias!="")
                            <table id="categorias" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>FechaAlta</th>                                                                                
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categorias as $categoria)                                                                    @php
                                        $fecha = substr($categoria->fechaAlta, 0,10);
                                    @endphp                       
                                        <tr>
                                            <td>{{$categoria->id}}</td>
                                            <td>{{$categoria->name}}</td>
                                            <td>{{$fecha}}</td>                           
                                            <td>
                                                @if ($categoriaPermisoLeer==1)
                                                    <a href="{{ route('categorias.show', $categoria->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                        
                                                @endif
                                                @if ($categoriaPermisoLeer==1 && $categoriaPermisoActualizar==1)
                                                    <a href="{{ route('categorias.edit', $categoria->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                          
                                                @endif                                                
                                                @if ($categoriaPermisoBorrar==1)
                                                    <a onclick="deleteCategoria({{$categoria->id}},'{{$categoria->imagen}}')" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                               
                                                @endif                                              
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay categorias 
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
