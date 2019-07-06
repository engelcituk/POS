@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('centrospreparacion.create') }}" class="btn btn-success"><i class="fas fa-h-square"></i> Nuevo Centro Prep</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Lista de centros de preparación</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="centrosPreparacion" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>                                        
                                        <th>Impresora</th>
                                        <th>Impresora B</th>
                                        <th>Descripción</th> 
                                        <th>Imprime</th>                                        
                                        <th>Estado</th>                                        
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>                                
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
</div>
@endsection