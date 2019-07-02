
@php
$cadenaObtenerNumero="{{ route('historico.destroy', ['cuenta' => $id])}}";
$idCuenta = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="verCuentaDetalles({{$idCuenta}})" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>
<a onclick="imprimirCuenta({{$idCuenta}})" class="btn btn-xs btn-info"><i class="fas fa-print"></i></a>
<a onclick="cancelarCuenta({{$idCuenta}})" class="btn btn-xs btn-danger"><i class="fas fa-ban"></i></a>
{{-- <a onclick="cancelarCuenta({{$idCuenta}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a> --}}
