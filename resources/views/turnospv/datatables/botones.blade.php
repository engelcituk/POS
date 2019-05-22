<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('turnos.show', ['turno' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('turnos.edit', ['turno' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('turnos.destroy', ['turno' => $id])}}";
$idTurno = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteTurno({{$idTurno}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>