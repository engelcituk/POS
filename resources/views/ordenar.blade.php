@extends('layouts.dashboard')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> NombreHotel</a></li>
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-concierge-bell"></i> CentroConsumo</a></li>
                        <li class="breadcrumb-item active listaZonas" aria-current="page"> <i class="fas fa-map-marker-alt"></i> Zonas <i class="fas fa-hand-point-right"></i>
                            <select id="zonaElige">
                                <option value="">Elija un area</option>
                                <option value="zona1">zona 1</option>
                                <option value="zona2">zona 2</option>
                                <option value="zona3">zona 3</option>
                                <option value="todos">MOSTRAR TODOS</option>
                            </select>
                        </li>
                        <li class="breadcrumb-item actualizarMesas"><a href="#"><i class="fas fa-sync-alt"></i> Actualizar</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row" id="zonaMesas">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="red">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <div class="card-content">
                    <h4 class="card-title">Tomar Orden </h4>
                        <div id="zona1" class="zonas">
                            <strong>Zona 1</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="1">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="2">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="3">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="4">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="5">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 5
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="7">
                                    <a href="#mesa-7" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 7
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="8">
                                    <a href="#mesa-8" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 8
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="9">
                                    <a href="#mesa-9" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 9
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="zona2" class="zonas">
                            <strong>Zona 2</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="10">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="11">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="12">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="13">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="14">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 5
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="15">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 6
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="zona3" class="zonas">
                            <strong>Zona 3</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="16">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="17">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="18">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="19">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="20">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 5
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
        <div class="row hidden" id="zonaTomarOrden">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <a href="#" class="btn btn-warning btn-sm pull-right volverMesas"><i class="fas fa-undo-alt"></i></i> Volver</a>
                        <h4 class="card-title">Tomar Orden</h4>
                        <div class="row">
                            <div class="col-md-5">
                                <div id="wrapper">
                                    <div id="receiptData" style="width: auto; max-width: 580px; min-width: 250px; margin: 0 auto;">
                                        <div class="no-print">
                                        </div>
                                        <div id="receipt-data">
                                            <div>
                                                <div style="clear:both;"></div>
                                                <table class="table table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd;"><i class="fas fa-table"></i> <strong><span id="mesaTablaProductos"></span></strong></th>
                                                            <th class="text-center" style="width: 50%; border-bottom: 2px solid #ddd;">Descripción</th>
                                                            <th class="text-center" style="width: 12%; border-bottom: 2px solid #ddd;">Cantidad</th>
                                                            <th class="text-center" style="width: 24%; border-bottom: 2px solid #ddd;">Precio</th>
                                                            <th class="text-center" style="width: 26%; border-bottom: 2px solid #ddd;">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
                                                            <td>Minion Hi</td>
                                                            <td style="text-align:center;">1.00</td>
                                                            <td class="text-right">15.00</td>
                                                            <td class="text-right">15.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td><button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button></td>
                                                            <td>Minion Banana</td>
                                                            <td style="text-align:center;">1.00</td>
                                                            <td class="text-right">15.00</td>
                                                            <td class="text-right">15.00</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2">Total</th>
                                                            <th colspan="3" class="text-right">30.00</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                                <div class="well well-sm" style="margin-top:10px;">
                                                    <div style="text-align: center;">This is receipt footer for store</div>
                                                </div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>

                                        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                <!-- <div class="btn-group" role="group">
                                                    <button onclick="window.print();" class="btn btn-block btn-primary">Print</button> </div>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-block btn-success" href="#" id="email">Email</a>
                                                </div> -->
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div id="zonaPr class=" zonas"oductos">
                                    <strong>carta</strong>
                                    <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                        <li class="addProducto" idProducto="1">
                                            <a href="#producto-1" role="tab" data-toggle="tab" aria-expanded="true">
                                                <i class="fab fa-product-hunt"></i> producto 1
                                            </a>
                                        </li>
                                        <li class="addProducto" idProducto="2">
                                            <a href="#producto-2" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fab fa-product-hunt"></i> producto 2
                                            </a>
                                        </li>
                                        <li class="addProducto" idProducto="3">
                                            <a href="#producto-3" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fab fa-product-hunt"></i> producto 3
                                            </a>
                                        </li>
                                        <li class="addProducto" idProducto="4">
                                            <a href="#producto-4" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fab fa-product-hunt"></i> producto 4
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
    </div>
</div>
@endsection