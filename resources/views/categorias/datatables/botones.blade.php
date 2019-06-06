<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('categorias.show', ['categoria' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('categorias.edit', ['categoria' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('categorias.destroy', ['categoria' => $id])}}";
$idCategoria = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteCategoria({{$idCategoria}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
