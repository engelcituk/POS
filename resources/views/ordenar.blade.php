@extends('layouts.dashboard')

@section('content')

<div class="content">
    
    <div class="container-fluid" id="moduloOrdenar">  
        <div class="row">
            <div class="col-md-7">
                
            </div>
        </div>
        <div class="row" id="zonaMesas">                                             
            <div class="col-md-12">
                <div class="card">                    
                    <div class="card-content">                       
                        <div class="row">                           
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                @php
                                    $abrirMesa = Session::get('AbrirMesa.leer');                                                         
                                @endphp
                               <strong><span id="nombrePVSpan">{{$datosRestaurantePV->name}}</span> / <span id="nombreZona"></span></strong>                              
                               {{-- condiciono el valor del span si usuario tiene permiso para solo abrir mesa --}}
                                @if ($abrirMesa==1 )
                                    <span class="hidden" id="userOpenMesaSpanPermission">1</span>
                                @else
                                    <span class="hidden"  id="userOpenMesaSpanPermission">0</span>
                                @endif
                                <div id="sliderZonas" class="owl-carousel btnZonas">                                    
                                    @foreach($zonas as $zona)                                        
                                        <button class="btn buttonZonas" id="zonaBtn{{$zona->id}}" idZonaBtn="{{$zona->id}}" onclick="cambiarZona({{$zona->id}})">{{$zona->name}}</button>                                             
                                    @endforeach                                    
                                </div>                                                                
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
                                <table class="table">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>
                                                @include('ordenar.partials.zonasMesas') {{--listado de zonas y sus mesas--}}
                                            </th>
                                            <th>
                                                <a href="{{ route('ordenar.index') }}" class="btn btn-warning pull-right volverMesas"><i class="fas fa-arrow-left"></i> Volver</a>
                                            </th>            
                                        </tr>
                                    </thead>
                                </table>                                                                                                  
                                    <div class="well well-sm">
                                        <strong>Mesa: </strong><span id="nombreMesaSpan"></span> 
                                        <strong>Cliente: </strong><span id="clienteMesaSpan"></span> 
                                        <strong>Cuenta: </strong><span id="cuentaMesaSpan"></span> 
                                        <strong>Habitación: </strong><span id="habMesaSpan"></span>                            
                                    </div>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar" id="tablaItemProductos">   
                                        <table  class="table tablaItems">
                                            <thead class="">
                                                <tr class="">
                                                    <th></th>                              
                                                    <th>Nombre</th>
                                                    <th>Ca.</th>                                      
                                                    <th>Pr.</th>                                      
                                                    <th>To.</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                        
                                                                                                        
                                            </tbody>
                                            <tfoot>                                                        
                                            </tfoot>
                                        </table>                                                
                                    </div>                                                                        
                                <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-block btn-warning" id="btnAddDescuento" onclick="addDescuentoCuentaModal()"></a>
                                        </div>
                                        <div class="btn-group" role="group" id="btnAddRoom">
                                        <button type="button" class="btn btn-info" id="btnAddRoomCuenta" data-dismiss="modal" onclick="asignarHabitacionModal()"></button>                                                                   
                                        </div> 
                                        <div class="btn-group" role="group">      
                                            <button type="button" class="btn btn-success" id="btnEnviarCP" data-dismiss="modal" onclick="enviarCentroPrep() "></button>
                                        </div>
                                    </div>                                          
                                </div>
                                <div id="buttons2" style="text-transform:uppercase;" class="no-print">
                                    <div class="btn-group btn-group-justified" role="group">   
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-block btn-success" id="btnPrintTicket" onclick="imprimirCuenta()"> <i class="fas fa-ticket-alt"></i> Ticket</a>
                                        </div>                                               
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-block btn-danger"  id="btnCerrarCuenta" onclick="cerrarCuentaModal()"> <i class="fas fa-window-close"></i> Cerrar cuenta</button>
                                        </div>
                                    </div>                                          
                                </div> 
                                    
                            </div>
                            <div class="col-md-7" id="idMesaAddProducts">                                                                
                                <div class="row">
                                    <div class="col-md-6" id="divBtnClientes">                                         
                                        <div id="lstBtnClientes" class="btnComensalScroll">

                                        </div>
                                        <div id="divCheckAlergia">
                                            <div class="checkbox checkbox-group required">                              
                                                <label class="">
                                                <input type="checkbox" id="checkAlergia" name="alergia" value="">
                                                <strong>Con alergia</strong>
                                                </label>                                            
                                            </div>
                                        </div>                                         
                                    </div>
                                                                        
                                    <div class="col-md-6">
                                        <div id="opcionesTiempo">
                                            <span class="btn btnTiempo btn-sm pull-right" id="tiempo4" tiempo="4"><i class="fas fa-clock"></i> 4</span>                                       
                                            <span class="btn btnTiempo btn-sm pull-right" id="tiempo3" tiempo="3"><i class="fas fa-clock"></i> 3</span>
                                            <span class="btn btnTiempo btn-sm pull-right " id="tiempo2" tiempo="2"><i class="fas fa-clock"></i> 2</span>
                                            <span class="btn btnTiempo btn-success btn-sm pull-right" id="tiempo1" tiempo="1"><i class="fas fa-clock"></i> 1</span> 
                                        </div>
                                    </div>                                                                        
                                </div>
                                
                                <br>                                                                                                
                                <div class="sliderCategorias">
                                    <div class="slides">
                                        <div class="slideItemCats" onclick="getProductosMasVendidos()" id="itemSlide0">
                                            <p id="itemCaption0" class="caption-slide slide-active">Más vendidos</p>    
                                            <img src="{{asset('img/faces/masvendidos.png')}}" class="img-responsive-slide"> 
                                        </div>
                                        @foreach($categorias as $categoria)
                                            @php                                               
                                                $img = ($categoria->imagen == "SIN IMAGEN") ? "img/faces/catSinFoto.png" : "storage/categorias/".$categoria->imagen;                                                
                                            @endphp                                    
                                        <div class="slideItemCats" onclick="GetProductosByCat({{$categoria->id}})" id="itemSlide{{$categoria->id}}">                 
                                            <p id="itemCaption{{$categoria->id}}" class="caption-slide"> {{$categoria->name}} </p>
                                            <img src="{{asset($img)}}" class="img-responsive-slide">
                                        </div>                                                                        
                                        @endforeach                                       
                                    </div>                                    
                                </div>
                                
                                <br>
                                <span class="text-center"><i id="spinLoader" class="fas fa-spinner fa-spin fa-3x hidden"></i></span>
                                {{-- <div id="lstProductos">
                                    <ul class="nav nav-pills nav-pills-icons" id="UlList" role="tablist">                                                               
                                    </ul> 
                                    
                                </div> --}}
                                <div class="row display-flex" >
                                    <div class="scrollProductosCat" id="UlList2">

                                    </div>
                                        
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
    @include('ordenar.partials.modalCargando')
    @include('ordenar.partials.modalTab')
</div>

@endsection

