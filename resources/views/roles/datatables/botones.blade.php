<!-- Estos botones los muestro si el user tiene permisos -->
@can('roles.show')
<a href="{{ route('roles.show', ['role' => $id])}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
@endcan
@can('roles.edit')
<a href="{{ route('roles.edit', ['role' => $id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>
@endcan
@php
    $cadenaObtenerNumero="{{ route('roles.destroy', ['role' => $id])}}";
    $idRole = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
@can('roles.destroy')
<a onclick="deleteDataRol({{$idRole}})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
@endcan