@extends('layouts.dashboard')
@section('content') 
<div class="content">
    <div class="container-fluid">
        <a href="{{ route('menuscartas.index')}}" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Volver</a>
        <form method="POST" action="{{ route('menuscartas.store')}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile">
                        @csrf
                        <div class="row">
                            <div class="card-content">                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fas fa-grip-horizontal"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" name="idCarta" required>
                                                <option value="">Elija carta</option>
                                                    @foreach($cartas as $carta)
                                                        <option value="{{$carta->id}}">{{$carta->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="panel-body">
                                <div class="viewcontent">
                                    <table id="tblMenuCartas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Centro Preparación</th>
                                            <th></th>
                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="addr0" data-id="0" id="listaClon">
                                            <td data-name="idProducto" >        
                                                <select class="form-control listaProductos" id="templateLista" name="idProducto[]" required>
                                                    <option value="">Elija producto</option>
                                                            @foreach($productos as $producto)
                                                    <option value="{{$producto->id}}">{{$producto->nombreProducto}}</option>
                                                            @endforeach
                                                </select>                                                                                              
                                            </td>
                                            <td data-name="precio">
                                                <input id="precio" type="number" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="precio[]"  required>
                                            </td>
                                            <td data-name="idCentroPrep">
                                            <select class="form-control" name="idCentroPrep[]" required>
                                                    <option value="">Centro Preparacion</option>
                                                        @foreach($centrosPreparacion as $cp)
                                                            <option value="{{$cp->id}}">{{$cp->name}}</option>
                                                        @endforeach
                                                </select>
                                            </td> 
                                            <td data-name="del">
                                                <button name="del0" class='btn btn-danger fa fa-remove btn-sm row-remove'></button>
                                            </td>
                                        </tr>
                                   

                                    </tbody>
                                    </table>     
                                </div>    
                                <a id="add_row" class="btn btn-success btn-circle pull-right fa fa-plus" onclick="addrowTarifa()"></a>                    
                                <button type="submit" class="btn btn-primary pull-left"> <i class="fas fa-save"></i> {{ __('Guardar') }}</button>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection