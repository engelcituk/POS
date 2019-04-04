<!-- Estos botones los muestro si el user tiene permisos -->
@can('usuarios.show')
<a href="{{ route('usuarios.show', ['usuario' => $id])}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
@endcan
@can('usuarios.edit')
<a href="{{ route('usuarios.edit', ['usuario' => $id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>
@endcan
@php
    $cadenaObtenerNumero="{{ route('usuarios.destroy', ['usuario' => $id])}}";
    $idUsuario = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
@can('usuarios.destroy')
<a onclick="deleteData({{$idUsuario}})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
@endcan