<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('mesas.show', ['mesa' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('mesas.edit', ['mesa' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('mesas.destroy', ['mesa' => $id])}}";
$idMesa = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteMesa({{$idMesa}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
