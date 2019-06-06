<!-- Estos botones los muestro si el user tiene permisos -->

<a href="{{ route('subcategorias.show', ['subcategoria' => $id])}}" class="btn btn-xs btn-success"><i class="fas fa-eye"></i></a>

<a href="{{ route('subcategorias.edit', ['subcategoria' => $id])}}" class="btn btn-xs btn-info"><i class="fas fa-edit"></i> </a>
@php
$cadenaObtenerNumero="{{ route('subcategorias.destroy', ['subcategoria' => $id])}}";
$idsubCategoria = intval(preg_replace('/[^0-9]+/', '', $cadenaObtenerNumero), 10);
@endphp
<a onclick="deleteSubCategoria({{$idsubCategoria}})" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></a>
