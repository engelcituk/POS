@extends('layouts.dashboard')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> NombreHotel</a></li>
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-concierge-bell"></i> CentroConsumo</a></li>
                        <li class="breadcrumb-item active listaZonas" aria-current="page"> <i class="fas fa-map-marker-alt"></i> Zonas <i class="fas fa-hand-point-right"></i>
                            <select id="zonaElige">
                                <option value="zona0">Elija un area</option>
                                <option value="zona1">zona 1</option>
                                <option value="zona2">zona 2</option>
                                <option value="zona3">zona 3</option>
                            </select>
                        </li>
                        <li class="breadcrumb-item actualizarMesas"><a href="#"><i class="fas fa-sync-alt"></i> Actualizar</a></li>
                    </ol>
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
                        <h4 class="card-title">Tomar Orden</h4>
                        <div id="zona1">
                            <strong>Zona 1</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="1">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="2">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="3">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="4">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="5">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 6
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="6">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 6
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="7">
                                    <a href="#mesa-7" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 7
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="8">
                                    <a href="#mesa-8" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 8
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="9">
                                    <a href="#mesa-9" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 9
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="zona2">
                            <strong>Zona 2</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="1">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="2">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="3">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="4">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="5">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 6
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="6">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 6
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="zona3">
                            <strong>Zona 3</strong>
                            <ul class="nav nav-pills nav-pills-icons" role="tablist">
                                <li class="abrirMesa" idMesa="1">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="true">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 1

                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="2">
                                    <a href="#mesa-1" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 2
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="3">
                                    <a href="#mesa-3" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 3
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="4">
                                    <a href="#mesa-4" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 4
                                    </a>
                                </li>
                                <li class="abrirMesa" idMesa="5">
                                    <a href="#mesa-6" role="tab" data-toggle="tab" aria-expanded="false">
                                        <img src="{{asset('img/mesa2.png')}}"> Mesa 5
                                    </a>
                                </li>
                            </ul>
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
                        <a href="{{ route('ordenar.index') }}" class="btn btn-warning btn-sm pull-right"><i class="fas fa-undo-alt"></i></i> Volver</a>
                        <h4 class="card-title">Tomar Orden</h4>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta cum deserunt voluptatibus doloremque, expedita dicta sint earum libero ipsam porro excepturi esse, tenetur, dolorum labore eaque, recusandae quos voluptate saepe!</p>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
    </div>
</div>
@endsection