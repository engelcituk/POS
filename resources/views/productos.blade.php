@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

        <a href="{{ route('productos.create') }}" class="btn btn-success"><i class="fas fa-user"></i> Nuevo producto</a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de Productos</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="productos" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>codProducto</th>
                                        <th>Nombre</th>
                                        <th>fechaAlta</th>
                                        <th>propina</th>
                                        <th>Complemento</th>
                                        <th>Estado</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($productos as $producto)                                            
                                        <tr>
                                            <td>{{$producto->id}}</td>
                                            <td>{{$producto->codigoProducto}}</td>
                                            <td>{{$producto->nombreProducto}}</td>
                                            <td>{{$producto->fechaAlta}}</td>
                                            <td>{{$producto->propina}}</td>
                                            <td>{{$producto->complemento}}</td>
                                            <td>{{$producto->status}}</td>
                                            <td>
                                                <a href="{{ route('productos.show', $producto->id)}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('productos.edit', $producto->id)}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
                                                <a onclick="productoModos({{$producto->id}})" class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModalModos">M</a>
                                                <a onclick="deleteProducto({{$producto->id}})" class="btn btn-xs btn-danger" ><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    @include('productos.partials.modalProductoModos')
</div>
@endsection
