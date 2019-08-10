@extends('layouts.dashboard')

@section('content')
<div class="content">
    <div class="container-fluid">

           <div class="row">
            <div class="col-md-12">
                <div class="card">                    
                    <div class="card-content">
                      <div class="col-md-2 text-center">
                            <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Código: 403</p>
                      </div>
                        <div class="col-md-10">
                                <h3>Usted no cuenta con permisos</h3>
                                <p>Primero tiene que tener permisos para las operaciones que pretenda hacer<br/>Por favor solicita que se le asignen permisos a su usuario.</p>
                                {{-- <a class="btn btn-danger" href="javascript:history.back()">Go Back</a> --}}
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