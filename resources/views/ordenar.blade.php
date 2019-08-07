@extends('layouts.dashboard')

@section('content')

<div class="content">
    <div class="container-fluid">        
        <div class="row" id="zonaMesas">                        
            <div class="col-md-12">
                <div class="card">                    
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <nav aria-label="breadcrumb" role="navigation">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <div class="form-group">                               
                                            <select class="form-control" id="zonaElige">                             
                                            @foreach($zonas as $zona)
                                            <option value="zona{{$zona->id}}">{{$zona->name}}</option>
                                            @endforeach                                
                                            </select>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-6">
                                <button class="btn btn-success pull-right" onclick="cerrarDia({{Session::get('idPuntoVenta')}})"><i class="far fa-window-close"></i> Cerrar día</button>
                            </div>
                        </div>
                         <div id="zonasPV">
                            
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
                        {{-- <h4 class="card-title">Tomar Orden</h4> --}}
                       
                        <div class="row">
                            <div class="col-md-5">
                                <div id="wrapper">
                                    <div id="receiptData">                                         
                                        <div id="receipt-data">
                                            <div class="well well-sm">
                                                <strong>Mesa: </strong><span id="nombreMesaSpan"></span> 
                                                <strong>Cliente: </strong><span id="clienteMesaSpan"></span> 
                                                <strong>Cuenta: </strong><span id="cuentaMesaSpan"></span> 
                                                <strong>Habitación: </strong><span id="habMesaSpan"></span>                            
                                            </div>
                                            <div class="table-responsive" id="tablaItemProductos">                                             
                                                <table  class="table table-striped tablaProductos">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center"><i class="fas fa-table"></i> <span id="idCuentaSpan"></span></th>
                                                            <th class="text-center">Nombre</th>                                              
                                                            <th class="text-center" >Cantidad</th>
                                                            <th class="text-center" >Precio</th>
                                                            <th class="text-center" >Total</th>        
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                        
                                                                                                              
                                                    </tbody>
                                                    <tfoot>                                                        
                                                    </tfoot>
                                                </table>                                                
                                            </div>                                           
                                        </div>                                         

                                        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                               <div class="btn-group" role="group" id="btnAddRoom">                                               <button type="button" class="btn btn-info" id="btnAddRoomCuenta" data-dismiss="modal" onclick="asignarHabitacionModal()"><i class='fas fa-bed'></i>  Habitación</button>                                                                   
                                                </div>
                                                <div class="btn-group" role="group">                                                              
                                                    <button type="button" class="btn btn-success" id="btnEnviarCP" data-dismiss="modal" onclick="enviarCentroPrep() "><i class="fas fa-paper-plane"></i> Enviar</button>
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div id="buttons2" style="text-transform:uppercase;" class="no-print">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-block btn-danger"  id="btnCerrarCuenta" onclick="cerrarCuentaModal()"> <i class="fas fa-window-close"></i> Cerrar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-block btn-warning" id="btnAddDescuento" onclick="addDescuentoCuentaModal()"> <i class="fas fa-percentage"></i> Descuento</a>
                                                </div>  
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-block btn-info" id="btnPrintTicket" onclick="imprimirCuenta()"> <i class="fas fa-ticket-alt"></i> Ticket</a>
                                                </div>                                               
                                            </div>                                          
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7" id="idMesaAddProducts">
                                
                                <div class="row">
                                    <div id="opcionesTiempo">
                                        <span class="btn btn-success btn-sm pull-left" id="tiempo1" tiempo="1"><i class="fas fa-clock"></i> 1</span> 
                                        <span class="btn btn-sm pull-left " id="tiempo2" tiempo="2"><i class="fas fa-clock"></i> 2</span>
                                        <span class="btn btn-sm pull-left" id="tiempo3" tiempo="3"><i class="fas fa-clock"></i> 3</span>
                                    </div> 
                                    <a href="{{ route('ordenar.index') }}" class="btn btn-warning btn-sm pull-right volverMesas"><i class="fas fa-undo-alt"></i></i> Volver</a>
                                </div>
                                <div id="sliderProductos" class="owl-carousel">
                                    <div class="slideProductos">
                                        <div class="post-img">                                            
                                            <div class="product" id="categoria_0" onclick="getProductosMasVendidos()">
                                                <img style="cursor: pointer;" src="{{asset('img/faces/masvendidos.png')}}"/>       
                                                {{-- <span class="label" categoria="masVendidos">Más vendidos</span>          --}}
                                            </div>
                                        </div>
                                        <p class="post-title bg-primary" categoria="masVendidos">
                                            Más vendidos
                                        </p>                                        
                                    </div>
                                    @foreach($categorias as $categoria)
                                        <div class="slideProductos">
                                            <div class="post-img">                                                
                                                <div class="product" id="categoria_{{$loop->iteration}}" onclick="GetProductosByCat({{$categoria->id}})"><img style="cursor: pointer;" src="/sandostpv/storage/categorias/{{$categoria->imagen}}" />
                                                    {{-- <span class="label label-default" categoria="{{$categoria->name}}">{{$categoria->name}}</span>          --}}
                                                </div>
                        
                                            </div>
                                            <p class="post-title bg-success">{{$categoria->name}}</p>
                                        </div>                
                                    @endforeach                                    
                                </div>                                         
                              
                                <div id="lstProductos">
                                    <ul class="nav nav-pills nav-pills-icons" id="UlList" role="tablist">                                                               
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
    @include('ordenar.partials.modalAddRoom')
    @include('ordenar.partials.modalAlergenos')
    @include('ordenar.partials.modalModosProducto')
    @include('ordenar.partials.modalCancelarProducto')
    @include('ordenar.partials.modalAgregarDesc')
    @include('ordenar.partials.modalMetodoPago')

</div>

@endsection

