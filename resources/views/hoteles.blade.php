@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('hoteles.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo hotel</a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content"> 
                        <h4 class="card-title">Lista de Hoteles</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                             @if ($hoteles!="")
                              <table id="hoteles" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Empresa</th>
                                        <th>codigo</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($hoteles as $hotel)                                            
                                        <tr>
                                            <td>{{$hotel->id}}</td>
                                            <td>{{$hotel->name}}</td>
                                            <td>{{$hotel->empresa}}</td>
                                            <td>{{$hotel->codHotel}}</td>                                           
                                            <td>
                                                <a href="{{ route('hoteles.show', $hotel->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('hoteles.edit', $hotel->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                        
                                                <a onclick="deleteDataHotel({{$hotel->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     no hay hoteles 
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