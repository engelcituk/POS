<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/                
//tabla de Modos  
    var tablaModos = $('#modos').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('all.modos') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'descripcion',
                name: 'descripcion'
            },
            {
                data: 'fechaAlta',
                name: 'fechaAlta'
            },
            {
                data: 'horaAlta',
                name: 'horaAlta'
            },
            {
                data: 'idUsuarioAlta',
                name: 'idUsuarioAlta'
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