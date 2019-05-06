<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('metodospago.show', ['metodosPago' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('metodospago.edit', ['metodosPago' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('metodospago.destroy', ['metodosPago' => $id])}}";
$idProducto = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteProducto({{$idProducto}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
