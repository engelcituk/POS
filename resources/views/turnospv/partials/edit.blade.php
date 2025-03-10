@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        @php            
            $turnoPermisoActualizar= Session::get('TurnosPV.actualizar');                                
        @endphp
        <a href="{{ route('turnos.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        @if ($turnoPermisoActualizar==1)
            <form method="POST" action="{{ route('turnos.actualizar')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        {{-- {{ method_field('PUT') }} --}}
                        <input id="name" type="hidden" class="form-control" name="id" value="{{$turno->id}}" required>
                        <div class="row">
                            <div class="card-content">
                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora inicio en formato 24:00 hrs</label>
                                            <input id="horaInicio" type="text" class="form-control" name="horaInicio" value="{{$turno->horaInicio}}" required autofocus>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Hora inicio en formato 24:00 hrs</label>
                                            <input id="horaFin" type="text" class="form-control" name="horaFin" value="{{$turno->horaFin}}" required >
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-outdent"></i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Turno</label>
                                            <input id="turnoPV" type="number" min="1" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="turno" value="{{$turno->turno}}" required>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- <small>En la api se registar el <cite title="idHotel">idHotel</cite></small> -->
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
                            <h3>Usted no cuenta con permisos para editar la información</h3>
                            <p>Primero tiene que tener permisos para la operación que pretende realizar<br/>Por favor solicita que se le asigne este permiso a su usuario.</p>                               
                    </div>
                </div>                    
            </div>
        @endif        
    </div>
</div>
<script>
 /*Para poner la hora inicio en formato de 24:00 hrs  del area de turnos de la ruta-> turnos/create */
    $('#horaInicio').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: true,
        showMeridian: false,
        defaultTime: false
    });
    $('#horaFin').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: true,
        showMeridian: false,
        defaultTime: false
    });
    $(document).on("input", "#turnoNumber", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    }) 

</script>
@endsection