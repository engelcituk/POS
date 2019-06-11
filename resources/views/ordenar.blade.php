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
                        {{-- <li class="breadcrumb-item actualizarMesas"><a href="#"><i class="fas fa-sync-alt"></i> Actualizar</a></li> --}}
                    </ol> 
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-h-square"></i>
                            </span>
                            <div class="form-group">
                                <!-- <label for="sel1">Select list:</label> -->
                                <select class="form-control" id="zonaElige">
                                {{-- <option value="">Elija un area</option> --}}
                                @foreach($zonas as $zona)
                                <option value="zona{{$zona->id}}">{{$zona->name}}</option>
                                @endforeach
                                {{-- <option value="todos">MOSTRAR TODOS</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>                   
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
                         
                        @foreach($zonas as $zona)                            
                            <div id="zona{{$zona->id}}" class="zonas">
                            <strong>{{$zona->name}}</strong>
                            @php                                
                               $idZona=$zona->id;                          
                               $mesas=App\Http\Controllers\OrdenController::obtenerMesasPorZona($idZona); 
                            @endphp                                                            
                             <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                @foreach($mesas as $mesa)
                                @php                                
                                $idMesa=$mesa->id;
                                @endphp
                                    <li class="abrirMesa" idMesa="{{$mesa->id}}">
                                        <a href="#mesa-{{$mesa->id}}" class="launch-modal" role="tab" data-toggle="tab" aria-expanded="true" onclick="aperturaMesa({{$idMesa}})">
                                            <img src="{{asset('img/mesa2.png')}}"> {{$mesa->name}}
                                        </a>
                                    </li>
                                @endforeach                                
                            </ul> 
                        </div>
                        @endforeach
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
    @include('ordenar.partials.modalOpenMesa')
</div>
@endsection