<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('alergenos.show', ['alergeno' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('alergenos.edit', ['alergeno' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('alergenos.destroy', ['alergeno' => $id])}}";
$idAlergeno = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteAlergeno({{$idAlergeno}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
