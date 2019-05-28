<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('centrospreparacion.show', ['cpreparacion' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('centrospreparacion.edit', ['cpreparacion' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('centrospreparacion.destroy', ['cpreparacion' => $id])}}";
$idCentroPreparacion = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteCentroPreparacion({{$idCentroPreparacion}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
