<script>
    $.fn.dataTableExt.sErrMode = 'throw'; /*para eliminar el warning de DataTables warning: table id=roles - Cannot reinitialise DataTable.*/ 
   
    //datatableHistorico.blade.php
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    $('#historico').DataTable({
        processing: true,       
        serverSide: true,        
        ajax: {
            url: "{{ url('all/historico') }}",
            type: 'POST',
            data: function (filtro) {
                filtro.inicio = $('#fechaInicioHist').val();
                filtro.final = $('#fechaFinalHist').val();                
            }
        },
        columns: [{
                data: 'folio',
                name: 'folio'
            },
            {
                data: 'habitacion',
                name: 'habitacion'
            },
            {
                data: 'reserva',
                name: 'reserva'
            },
            {
                data: 'nombreCliente',
                name: 'nombreCliente'
            },
             {
                data: 'pax',
                name: 'pax'
            },
            {
                data: 'subtotalCuenta',
                name: 'subtotalCuenta'
            },
            {
                data: 'descuentoPorc',
                name: 'descuentoPorc'
            },
            {
                data: 'totalCuenta',
                name: 'totalCuenta'
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
            [10,15, 25, 50, -1],
            [10,15, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
            sLengthMenu: "Mostrar _MENU_ registros",
            processing: "Procesando",
            search: "_INPUT_",
            searchPlaceholder: "Buscar registros",
            infoEmpty: "Mostrando 0 de 0 de 0 entradas",
            emptyTable: "No hay datos disponibles en la tabla",            
            sInfo: "Mostrando _START_ registro(s) a _END_ de un total de _TOTAL_ registros",
            oPaginate: {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
    function filtrarFecha(){
         var fechaInicioInput=$("#fechaInicioHist").val();     
         var fechaFinalInput=$("#fechaFinalHist").val();
         if (fechaInicioInput!='' && fechaFinalInput!= '') {
				
		    if(fechaInicioInput<=fechaFinalInput){   
                $('#historico').DataTable().draw(true);                                      				
		    }else if(fechaInicioInput>fechaFinalInput){
            swal ("Oops","La fecha de inicio "+fechaInicioInput+" es mayor que la fecha final "+fechaFinalInput, "error");   
		    }
	} else{
        swal ( "Oops","No dejes campos de fecha vacios", "error");
    }
}

</script>