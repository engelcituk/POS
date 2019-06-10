<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('menuscartas.show', ['menuscarta' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('menuscartas.edit', ['menuscarta' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>

@php
$cadenaObtenerNumero="{{ route('menuscartas.destroy', ['menuscarta' => $id])}}";
$idMenuCarta = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteMenuCarta({{$idMenuCarta}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
