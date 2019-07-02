@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 card">                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="form-group label-floating">                                            
                                <input id="fechaInicioHist" type="date" class="form-control" name="fechaInicioHist" value="{{$fechaHoy}}" autofocus>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="form-group label-floating">                                            
                                <input id="fechaFinalHist" type="date" class="form-control" value="{{$fechaHoy}}" name="fechaFInalHist" >                  
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group">
                            <button class="btn btn-success" onclick="filtrarFecha()"><i class="fas fa-search"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
               
                    <div class="card-content">
                        {{-- <h4 class="card-title">Historico de ordenes</h4> --}}
                        <div class="toolbar">
                            
                            {{-- Here you can write extra buttons/actions for the toolbar {{$fechaHoy}}              --}}
                        </div>
                        <div class="material-datatables">
                            <table id="historico" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                               <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Habitación</th>
                                        <th>Reserva</th>
                                        <th>NombreCliente</th>
                                        <th>Pax</th>
                                        <th>SubTotal</th>
                                        <th>% Descuento</th>
                                        <th>Total</th>
                                        <th class="disabled-sorting text-right">Herramientas</th>
                                    </tr>
                                </thead>
                                
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                {{-- </div> --}}
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    @include('historico.partials.modalShow')
</div>
@endsection

 