@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('restaurantes.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @php
            $usuarioPermisActualizar= Session::get('Usuarios.actualizar');                                    
        @endphp
        @if ($usuarioPermisActualizar==1)
            <form method="POST" action="{{ route('restaurantes.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$restaurante->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre Restaurante</label>
                                            <input id="name" type="text" class="form-control" name="name" value="{{$restaurante->name}}" required autofocus>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-utensils"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" name="idHotel" required>
                                                <option value="{{$hotelRestaurante->id}}" selected>{{$hotelRestaurante->name}}</option>
                                                @foreach($hoteles as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-print"></i>
                                        </span>
                                        <div class="form-group">
                                            <!-- <label for="sel1">Select list:</label> -->
                                            <select class="form-control" name="idImpresora" required>
                                                <option value="{{$impresora->id}}" selected>{{$impresora->name}}</option>
                                                @foreach($impresoras as $impresora)
                                                <option value="{{ $impresora->id }}">{{ $impresora->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">Descripcion:</label>
                                        <textarea class="form-control" rows="2" name="descripcion" required>{{$restaurante->descripcion}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4>Seleccione si se muestra importe de cierre y el regimen</h4>                                                                  
                                    <div class="col-md-4 col-md-offset-4">
                                        <div class="checkbox checkbox-group">                              
                                                <label class="labelCheckbox ">
                                                <input type="checkbox" id="checkImporte" name="importeCierre" value="{{$restaurante->id}}" onclick="activarImporteCierre()" ><strong>Importe en cierre</strong>
                                                </label>                                            
                                        </div> 
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <h5>Seleccione regimen</h5>                                                                  

                                        <div class="col-md-4">
                                            <div class="checkbox checkbox-group">                              
                                                <label class="labelCheckbox ">
                                                <input type="checkbox" id="checkImporte1" class="checkRegimen" name="regimen" value="1" onclick="selectRegimen(1)"><strong>Regimen 1</strong>
                                                </label>                                            
                                            </div> 
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="checkbox checkbox-group">                              
                                                <label class="labelCheckbox ">
                                                <input type="checkbox" id="checkImporte2" class="checkRegimen" name="regimen" value="2" onclick="selectRegimen(2)"><strong>Regimen 2</strong>
                                                </label>                                            
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="checkbox checkbox-group">                              
                                                <label class="labelCheckbox ">
                                                <input type="checkbox" id="checkImporte3" class="checkRegimen" name="regimen" value="3" onclick="selectRegimen(3)" checked><strong>Regimen 2</strong>
                                                </label>                                            
                                            </div> 
                                        </div>

                                </div>
                                   
                                
                                <button type="submit" class="btn btn-primary pull-right">{{ __('Guardar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>            
        @else
           <div class="card">                    
                <div class="card-content">
                    <div class="col-md-2 text-center">
                        <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                    </div>
                    <div class="col-md-10">
                            <h3>Usted no cuenta con permisos para editar un punto de venta</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div> 
        @endif
        
    </div>
</div>
<script>


function activarImporteCierre() {  
    valorCheck = $("#checkImporte").prop("checked");//obtengo true o false 
    selected = () => Array.from(document.getElementsByName("regimen")).filter(cur => cur.type === 'checkbox' && cur.checked).length > 0;
    

    // if(selected() && valorCheck ) { // Si NO hay ningun checkbox chequeado.
    //     console.log("al menos un chequeado..");    
    //     $("#checkImporte").prop("checked", false);
    // }else if ( !selected() && !valorCheck) {
    //     console.log("Ningún chequeado..");
    //     $("#checkImporte").prop("checked", true);
    // }
}
function selectRegimen(idRegimen) {  
    valorCheck = $("#checkImporte").prop("checked");//obtengo true o false 

    console.log(valorCheck);
    if (valorCheck) {               
        $("#checkImporte"+idRegimen).prop("checked", true);        
    }
}     
</script>
@endsection
