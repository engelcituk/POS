<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/                
//tabla de productos    
    var tablaProductos = $('#productos').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('all.productos') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'codigoProducto',
                name: 'codigoProducto'
            },
            {
                data: 'nombreProducto',
                name: 'nombreProducto'
            },
            {
                data: 'fechaAlta',
                name: 'fechaAlta'
            },
            {
                data: 'propina',
                name: 'propina'
            },
            {
                data: 'complemento',
                name: 'complemento'
            },
            {
                data: 'status',
                name: 'status'
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
            [15, 25, 50, -1],
            [15, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
            sLengthMenu: "Mostrar _MENU_ registros",
            processing: "Procesando",
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