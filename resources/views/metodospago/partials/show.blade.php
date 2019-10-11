@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php
            $mpPermisoLeer= Session::get('MetodosPago.leer'); 
        @endphp
        <a href="{{ route('metodospago.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                @if ($mpPermisoLeer==1)
                    
                    <div class="col-md-12">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <img class="img" src="{{asset('img/faces/Money.png')}}">
                            </div>
                            <div class="card-content">
                                
                                <h3 class="category text-black">Metodo de pago: <strong>{{$metodoPago->name}}</strong></h3><br>
                                
                                <h4 class="card-title">Descripcion: {{$metodoPago->descripcion}}</h4>

                                <div class="form-group">
                                    <strong>Cargo habitacion</strong>
                                    <div class="radio">
                                        @php
                                        $conCargoHab= $metodoPago->cargoHab;//para obtener el estado de la impresora
                                        $radios = ($conCargoHab == 1) ?
                                        "<label><input type='radio' name='cargoHab' onclick='return false;'' value='True' checked>Si</label>
                                        <label><input type='radio' name='cargoHab' onclick='return false;'' value='False'>No</label>" :
                                        "<label><input type='radio' name='cargoHab' onclick='return false;'' value='True'>Si</label>
                                        <label><input type='radio' name='cargoHab' onclick='return false;'' value='False' checked>No</label>";
                                        echo $radios;
                                        @endphp
                                    </div>
                                </div>

                                <a href="{{ route('metodospago.index') }}" class="btn btn-rose btn-round"><i class="fas fa-arrow-left"></i> Volver</a>
                                
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">                    
                        <div class="card-content">
                            <div class="col-md-2 text-center">
                                <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                            </div>
                            <div class="col-md-10">
                                    <h3>Usted no tiene permiso para ver un método de pago</h3>
                                    <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                            </div>
                        </div>                    
                    </div>
                @endif                
            </div>
        </div>
    </div>
</div>
@endsection