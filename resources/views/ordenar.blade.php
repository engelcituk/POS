@extends('layouts.dashboard')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> NombreHotel</a></li>
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-concierge-bell"></i> CentroConsumo</a></li>                 
                        {{-- <li class="breadcrumb-item actualizarMesas"><a href="#"><i class="fas fa-sync-alt"></i> Actualizar</a></li>  --}}
                    </ol>                                       
                </nav>
            </div>
            <div class="col-md-offset-1 col-md-3">
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
                                $nombreMesa=$mesa->name;
                                $estadoMesa= $mesa->status;
                                $mesaStatus = ($estadoMesa == 1) ? "disponible" : "ocupado";
                                $mesaCss = ($estadoMesa != 1) ? "bordeMesaOcupada" : "";
                                @endphp
                                    <li class="abrirMesa {{$mesaCss}}" idMesa="{{$idMesa}}">
                                        <a id="mesaAbrir{{$idMesa}}" class="" role="tab" data-toggle="tab" aria-expanded="true" onclick="aperturaMesa({{$idMesa}})" estadoMesa="{{$mesaStatus}}">
                                            <img  class="{{$mesaStatus}}" src="{{asset('img/mesa.png')}}"> {{$nombreMesa}} 
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
                                    <div id="receiptData">
                                        <div class="no-print">
                                        </div>
                                        <div id="receipt-data">
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
                                                        {{-- <tr>
                                                            <th colspan="2">Total</th>
                                                            <th colspan="3" class="text-right">30.00</th>
                                                        </tr> --}}
                                                    </tfoot>
                                                </table>

                                                {{-- <div class="well well-sm" style="margin-top:10px;">
                                                    <div style="text-align: center;">This is receipt footer for store</div>
                                                </div> --}}
                                            </div>
                                           
                                        </div>                                         

                                        <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                {{-- <div class="btn-group" role="group">
                                                    <button onclick="window.print();" class="btn btn-block btn-primary">Opcion 1</button> </div>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-block btn-success" href="#" id="email">Opcion 2</a>
                                                </div>  --}}
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-success" id="btnEnviarCP" data-dismiss="modal" onclick="enviarCentroPrep()"><i class="fas fa-paper-plane"></i> Enviar</button>
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
                                                    <a class="btn btn-block btn-info" id="btnPrintTicket"> <i class="fas fa-ticket-alt"></i> Ticket</a>
                                                </div>                                               
                                            </div>                                          
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7" id="idMesaAddProducts">                              
                                <ul class="nav nav-tabs navPersonalizado" id="tabs">
                                    @foreach($categorias as $categoria)
                                    <li><a href="#cate{{$categoria->id}}" data-toggle="tab">{{$categoria->name}}</a></li>                   
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach($categorias as $categoria)                                        
                                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="cate{{$categoria->id}}">                 
                                            <ul class="nav nav-tabs navPersonalizado">
                                                @php                                
                                                    $idCategoria=$categoria->id;                          
                                                    $subCats=App\Http\Controllers\OrdenController::getSCategoriasByCategoria($idCategoria); 
                                                @endphp                                                    
                                                    @if($subCats!=0)
                                                        @foreach($subCats as $subCat) 
                                                            <li><a href="#sub{{$subCat->id}}" data-toggle="tab" onclick="GetProductosBySubCat({{$subCat->id}})">{{$subCat->name}}</a></li>
                                                        @endforeach
                                                        @else
                                                           <p>Sin subcategorias</p>     
                                                    @endif                                                            
                                            </ul>           
                                            <div class="tab-content">                                               
                                                @if($subCats!=0)                                                
                                                    @foreach($subCats as $subCat)
                                                    @php                                
                                                        $idSubCat=$subCat->id;                                                        
                                                    @endphp                                                        
                                                        <div class="tab-pane" id="sub{{$subCat->id}}">
                                                            <ul class="nav nav-pills nav-pills-icons" id="UlList{{$subCat->id}}" role="tablist">
                                                               
                                                            </ul>
                                                        </div>                                                            
                                                    @endforeach
                                                @else
                                                    <p>Sin productos para esta Subcategoria</p>     
                                                @endif 
                                            </div>  
                                        </div>             
                                    @endforeach                                                                        
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
    @include('ordenar.partials.modalAlergenos')
    @include('ordenar.partials.modalCantidad')
    @include('ordenar.partials.modalCancelarProducto')
    @include('ordenar.partials.modalAgregarDesc')
    @include('ordenar.partials.modalMetodoPago')

</div>
@endsection

