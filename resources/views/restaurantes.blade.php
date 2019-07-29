@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('restaurantes.create') }}" class="btn btn-success"><i class="fas fa-utensils"></i> Nuevo restaurante</a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Restaurantes</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            {{-- <table id="restaurantes" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Hotel</th>
                                        <th>Descripcion</th>
                                        <th>Clave folio ticket</th>
                                        <th>Impresora</th>
                                        <th>Centro Productivo</th>
                                        <th>Moneda</th>
                                        <th>CIF/RFC</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>

                                </tbody>
                            </table> --}}
                            @if ($restaurantes!="")
                              <table id="restaurantes" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Hotel</th>
                                        <th>Descripción</th>
                                        <th>Homoclave</th>
                                        <th>Impresora</th>
                                        <th>Centro producción</th>
                                        <th>Moneda</th>
                                        <th>Cifrfc</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($restaurantes as $restaurante)                                            
                                        <tr>
                                            <td>{{$restaurante->id}}</td>
                                            <td>{{$restaurante->name}}</td>
                                            <td>{{$restaurante->hotel}}</td>
                                            <td>{{$restaurante->descripcion}}</td>
                                            <td>{{$restaurante->homoclave}}</td>
                                            <td>{{$restaurante->impresora}}</td>
                                            <td>{{$restaurante->centroProd}}</td>
                                            <td>{{$restaurante->moneda}}</td>                                         
                                            <td>{{$restaurante->cifrfc}}</td>
                                            <td>
                                                <a href="{{ route('restaurantes.show', $restaurante->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('restaurantes.edit', $restaurante->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>                                                </a>
                                                <a onclick="deleteRestaurante({{$restaurante->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                             @else
                                     No hay restaurantes 
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