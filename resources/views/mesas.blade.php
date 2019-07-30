@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('mesas.create') }}" class="btn btn-success"><i class="fas fa-table"></i> Nueva mesa</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Mesas</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            {{-- <table id="mesas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Zona</th>                                        
                                        <th>status</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>                                
                                <tbody>

                                </tbody>
                            </table> --}}
                            @if ($mesas!="")
                            <table id="mesas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Zona</th>                                        
                                        <th>status</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mesas as $mesa) 
                                        @php
                                            $color = $mesa->status==1 ? 'success' : 'warning' ;
                                            $estado = $mesa->status==1 ? 'Activo' : 'Desactivado' ;
                                        @endphp                                                        
                                        <tr>
                                            <td>{{$mesa->id}}</td>
                                            <td>{{$mesa->zona}}</td>
                                             <td><button class="btn btn-{{$color}} btn-xs">{{$estado}}</button></td>                                                                                                                                                                          
                                            <td>
                                                <a href="{{ route('mesas.show', $mesa->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('mesas.edit', $mesa->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                
                                                <a onclick="deleteRestaurante({{$mesa->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                    No hay mesas
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