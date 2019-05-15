@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('hoteles.index') }}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-content">
                        <div class="well well-sm">
                            <p>El id del hotel {{$hotel->id}}</p>
                        </div>
                        <div class="well well-sm">
                            <p>El nombre del hotel {{$hotel->name}}</p>
                        </div>
                        <div class="well well-sm">
                            <p>La empresa es {{$hotel->empresa}}</p>
                        </div>                        
                        <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection