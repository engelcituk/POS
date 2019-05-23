<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('cartas.show', ['carta' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('cartas.edit', ['carta' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('cartas.destroy', ['carta' => $id])}}";
$idCarta = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteCarta({{$idCarta}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
