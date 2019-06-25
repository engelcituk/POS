@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">assignment</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Historico de ordenes</h4>
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="historico" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                               <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Folio</th>
                                        <th>NombreCliente</th>
                                        <th>fechaAlta</th>
                                        <th>Reserva</th>
                                        <th>habitacion</th>
                                        <th>pax</th>
                                        <th class="disabled-sorting text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Folio</th>
                                        <th>NombreCliente</th>
                                        <th>fechaAlta</th>
                                        <th>Reserva</th>
                                        <th>habitacion</th>
                                        <th>pax</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </tfoot>
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
    @include('historico.partials.modalShow')
</div>
@endsection

 