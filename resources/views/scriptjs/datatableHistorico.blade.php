<script>
    
// var fechaInicio=$("#fechaInicioHist").val();
//     var fechaFInal=$("#fechaFinalHist").val(); 
//     var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//     var yyyy = today.getFullYear();

//     fechaInicialDef = yyyy + '-' + 25 + '-' + mm;
//     fechaFinalDef = yyyy + '-' + dd + '-' + mm;
//     var urlFechas=fechaInicialDef+'/'+fechaFinalDef;
//     // var rangoFechas=filtrarFecha();
//                 // tablaHistorico.ajax.reload();
//     var url="all/historico/"+urlFechas;
    var tablaHistorico= $('#historico').DataTable({
        processing: true,
        serverSide: true,
        // url: "{{ url('buscar/alergenos') }}"+'/'+idProducto,               
        ajax: "{{ route('all.historico') }}",
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

function filtrarFecha(){
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var fechaInicioInput=$("#fechaInicioHist").val();     
    var fechaFinalInput=$("#fechaFinalHist").val();
    // var urlFechas=fechaInicialDef+'/'+fechaFinalDef;
    if (fechaInicioInput!='' && fechaFinalInput!= '') {
		// console.log("fechaInicial",fechaInicioInput);		
		if(fechaInicioInput<=fechaFinalInput){			
            var urlFechas=fechaInicioInput+'/'+fechaFinalInput;
            // tablaHistorico.ajax.reload();                      
            $.ajax({
            url: "{{ url('historico/filtro') }}",
            type: "POST",
            data: {
                '_method': 'POST',
                'fechaInicial':fechaInicioInput, 
                'fechaFinal':fechaFinalInput,
                '_token': csrf_token
            },        
            success: function(respuesta) {
            console.log("su respuesta desde CONtroller", respuesta);
               
               
            },
            error: function() {
                console.log(respuesta);
        }
    });

            // tablaHistorico.ajax.url( url).load(); 

            // console.log("formato de fecha correcto",urlFechas); 
            // console.log("urlfinal",url); 
                      				
		}else{
            swal ("Oops","La fecha de inicio "+fechaInicioInput+" es mayor que la fecha final "+fechaFinalInput, "error");           
		}
	} else{
        swal ( "Oops","No dejes campos de fecha vacios", "error");
    }
    // console.log("fechasAusar",urlFechas);
    return urlFechas;
}
</script>