<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('modos.show', ['modo' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('modos.edit', ['modo' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('modos.destroy', ['modo' => $id])}}";
$idModo = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteModo({{$idModo}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
