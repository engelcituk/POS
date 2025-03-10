<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/                              
    //tabla de usuarios
    var tablaUsuarios = $('#usuarios').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('all.usuarios') }}",
        columns: [{
                data: 'id', //la propiedad de data tiene que coincidir con la columna de la tabla de la BD
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
            sLengthMenu: "Mostrar _MENU_ registros",
            search: "_INPUT_",
            searchPlaceholder: "Buscar registros",
            sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
            oPaginate: {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
    //tabla de roles    
    var tablaRoles = $('#roles').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('all.roles') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name', //la propiedad de data tiene que coincidir con la columna de la tabla de la BD
                name: 'name'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'acciones',
                name: 'acciones',
                orderable: false,
                searchable: false
            }
        ],
        "pagingType": "full_numbers",
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
            sLengthMenu: "Mostrar _MENU_ registros",
            search: "_INPUT_",
            searchPlaceholder: "Buscar registros",
            sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
            oPaginate: {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
    
    
    
    
</script>