<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('zonas.show', ['zona' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('zonas.edit', ['zona' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('zonas.destroy', ['zona' => $id])}}";
$idZona = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteZona({{$idZona}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
