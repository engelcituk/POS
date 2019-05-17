@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('metodospago.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-content">                        
                        <div class="well well-sm">
                            <p>El id del metodoPago {{$metodoPago->id}}</p>
                        </div>
                        <div class="well well-sm">
                            <p>El nombre del metodoPago {{$metodoPago->name}}</p>
                        </div>
                        <div class="well well-sm">
                            <p>La descripcion es {{$metodoPago->descripcion}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection