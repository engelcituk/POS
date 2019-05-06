@extends('layouts.dashboard')
@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('rolesapi.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">


                    <div class="card-content">
                        <i class="fas fa-h-square"></i>
                        El id del Rol {{$apiRol}}
                        <!-- <a href="#pablo" class="btn btn-rose btn-round">Follow</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection