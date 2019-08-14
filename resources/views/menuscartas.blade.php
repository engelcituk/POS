@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mcPermisocrear= Session::get('MenusCarta.crear');                                                         
            $mcPermisoLeer= Session::get('MenusCarta.leer'); 
            $mcPermisoActualizar= Session::get('MenusCarta.actualizar'); 
            $mcPermisoBorrar= Session::get('MenusCarta.borrar');                         
        @endphp        
        @if ($mcPermisocrear==1)
            <a href="{{route('menuscartas.create') }}" class="btn btn-success"><i class="fas fa-list-alt"></i> Nuevo menú carta</a>    
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Menú Cartas</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            
                            @if ($menucartas!="")
                            <table id="metodosPago" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Carta</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Centro</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menucartas as $mc)                                                      
                                        <tr>
                                            <td>{{$mc->id}}</td>
                                            <td>{{$mc->carta}}</td>                                           
                                            <td>{{$mc->producto}}</td>                                                         
                                            <td>{{$mc->precio}}</td> 
                                            <td>{{$mc->centro}}</td> 

                                            <td>
                                                @if ($mcPermisoLeer==1)
                                                    <a href="{{ route('menuscartas.show', $mc->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>                                                    
                                                @endif
                                                @if ($mcPermisoLeer==1 && $mcPermisoActualizar==1)
                                                    <a href="{{ route('menuscartas.edit', $mc->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a> 
                                                @endif
                                                @if ($mcPermisoBorrar==1)
                                                    <a onclick="deleteMenuCarta({{$mc->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>                                                  
                                                @endif                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay menú cartas 
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