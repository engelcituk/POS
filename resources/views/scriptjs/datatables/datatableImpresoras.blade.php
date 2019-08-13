<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/       
    // //tabla de Impresoras    
    // var tablaImpresoras = $('#impresoras').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('all.impresoras') }}",
    //     columns: [{
    //             data: 'id', 
    //             name: 'id'
    //         },            
    //         {
    //             data: 'name',
    //             name: 'name'
    //         },
    //         {
    //             data: 'ipImpresora',
    //             name: 'ipImpresora'
    //         },
    //         {
    //             data: 'status',
    //             name: 'status'
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
//     $('#impresoras').DataTable({ 
//         processing: true,
//         serverSide: true,
//         ajax: "{{ route('all.impresoras') }}",           
//             "pagingType": "full_numbers",
//             "lengthMenu": [
//                 [15, 25, 50, -1],
//                 [15, 25, 50, "Todos"]
//             ],
//             responsive: true,
//             language: {
//             sLengthMenu: "Mostrar _MENU_ registros",
//             processing: "Procesando",
//             search: "_INPUT_",
//             searchPlaceholder: "Buscar registros",
//             sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
//             oPaginate: {
//                 "sFirst": "Primero",
//                 "sLast": "Último",
//                 "sNext": "Siguiente",
//                 "sPrevious": "Anterior"
//             }
//         }
//     });
// });
</script>