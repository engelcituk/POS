<!-- Estos botones los muestro si el user tiene permisos -->
@can('usuarios.show')
<a href="{{ route('usuarios.show'),['usuario' => $usuario] }}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
@endcan
@can('usuarios.edit')
<a class="btn btn-sm btn-info"><i class="fas fa-edit"></i> </a>
@endcan
@can('usuarios.destroy')
<a class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
@endcan 