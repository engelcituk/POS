<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/       
   //tabla de Restaurantes o puntos de venta   
    // var tablaRestaurantes = $('#restaurantes').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('all.restaurantes') }}",
    //     columns: [
    //         {
    //             data: 'name',
    //             name: 'name'
    //         },
    //         {
    //             data: 'hotel',
    //             name: 'hotel'
    //         },
    //         {
    //             data: 'descripcion',
    //             name: 'descripcion'
    //         },
    //         {
    //             data: 'homoclave',
    //             name: 'homoclave'
    //         },
    //         {
    //             data: 'impresora',
    //             name: 'impresora'
    //         },
    //         {
    //             data: 'centroProd',
    //             name: 'centroProd'
    //         },
    //         {
    //             data: 'moneda',
    //             name: 'moneda'
    //         },
    //         {
    //             data: 'cifrfc',
    //             name: 'cifrfc'
    //         },
    //         {
    //             data: 'acciones',
    //             name: 'acciones',
    //             orderable: false,
    //             searchable: false
    //         }
    //     ],
    //     "pagingType": "full_numbers",
    //     "lengthMenu": [
    //         [15, 25, 50, -1],
    //         [15, 25, 50, "Todos"]
    //     ],
    //     responsive: true,
    //     language: {
    //         sLengthMenu: "Mostrar _MENU_ registros",
    //         processing: "Procesando",
    //         search: "_INPUT_",
    //         searchPlaceholder: "Buscar registros",
    //         sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
    //         oPaginate: {
    //             "sFirst": "Primero",
    //             "sLast": "Último",
    //             "sNext": "Siguiente",
    //             "sPrevious": "Anterior"
    //         }
    //     }
    // });

    // $(document).ready(function() {
    //     var tablaHotel = $('#restaurantes').DataTable( {
    //         "processing": true,
    //         "serverSide": true,
    //         language: {
    //         sLengthMenu: "Mostrar _MENU_ registros",
    //         processing: "Procesando",
    //         search: "_INPUT_",
    //         searchPlaceholder: "Buscar registros",
    //         sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
    //         oPaginate: {
    //             "sFirst": "Primero",
    //             "sLast": "Último",
    //             "sNext": "Siguiente",
    //             "sPrevious": "Anterior"
    //         }
    //     },
    //         "ajax":{
    //             url :"{{ route('all.hoteles') }}", // json datasource
    //             type: "get",  // method  , by default get
    //             error: function(){  // error handling
    //                 $(".employee-grid-error").html("");
    //                 $("#restaurantes").append('<tbody class="employee-grid-error"><tr><th colspan="3">No hay hoteles en la base de datos</th></tr></tbody>');
    //                 $("#restaurantes_processing").css("display","none");
 
    //             }
    //         }
    //     } );        
    // } );
</script>