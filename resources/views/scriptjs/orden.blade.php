<script>
    $(document).on("click", ".actualizarMesas", function(e) {
        event.preventDefault();
        $("#zonaMesas").load(" #zonaMesas");
    })
    $("#zonaElige").change(function() {
        var valorSelect = $("option:selected", this).val(); //obtener el value de un select
        if (valorSelect != "") {            
            $(".zonas").hide();
            $("#" + valorSelect).show();
                if (valorSelect == "todos") {
                    $(".zonas").show();
                }
        } else {
            swal({
                title: 'Oopss...',
                text: '¡Por favor elija una zona!',
                type: 'error',
                timer: '1500'
            })
        }
    });
    //funcion obtener numero de un string
    function obtenerNumeroDeCadena(cadena) {
        var tmp = cadena.split("");
        var map = tmp.map(function(current) {
            if (!isNaN(parseInt(current))) {
                return current;
            }
        });

        var numbers = map.filter(function(value) {
            return value != undefined;
        });

        return numbers.join("");
    }
    //Abrir mesa
    $(document).on("click", ".abrirMesa", function() {
        var idMesa = $(this).attr("idMesa");
        swal({
            title: '¿Seguro de abrir la mesa ' + idMesa + ' ?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, Abrir!',
            cancelButtonText: '¡No, desistir!'
        }).then(function() {
            generarVariableMesa(idMesa); //genero las variables localstorage    
            $("#zonaTomarOrden").removeClass("hidden");
            $("#zonaMesas").addClass("hidden");
            $(".listaZonas").addClass("hidden");
            $(".actualizarMesas").addClass("hidden");

        }).catch(swal.noop);
    })
    //volver a las mesas
    $(document).on("click", ".volverMesas", function(e) {
        event.preventDefault();
        $("#zonaMesas").removeClass("hidden");
        $("#zonaTomarOrden").addClass("hidden");
        $(".listaZonas").removeClass("hidden");
        $(".actualizarMesas").removeClass("hidden");
    })
    var listaMesas = [];
    var listaProductosMesa = [];

    function generarVariableMesa(idMesa) {
        var numeroMesa = idMesa;
        var lsMesaIdNumero = "mesaIdNumero" + numeroMesa;

        listaMesas.push(lsMesaIdNumero);
        var sinRepetidos = listaMesas.filter((valor, indiceActual, arreglo) => arreglo.indexOf(valor) === indiceActual);

        sinRepetidos.forEach(function(variableLS) { //recorro los array y genero variables localstorage  
            valorIdMesaLS = obtenerNumeroDeCadena(variableLS); //obtengo el numero de la variable
            var productosIdMesa = "productosMesaIdNum" + valorIdMesaLS;
            localStorage.setItem(variableLS, valorIdMesaLS);
            // var duplicadosEliminados = eliminarObjetosDuplicados(listaProductosMesa, 'idMesa');
            var arrayVariableProductos = "arrayProductos" + numeroMesa;
            var arrayProductos = [];

            // localStorage.setItem(productosIdMesa, JSON.stringify(listaProductosMesa));
            $("#mesaTablaProductos").html(numeroMesa);
            console.log("su array es", arrayProductos);
            // localStorage.getItem("mesaIdNumero8");
            // return console.log(variableLS + " ");
        });
    }
    //elimina propiedades duplicadas en un array
    function eliminarObjetosDuplicados(arr, prop) {
        var nuevoArray = [];
        var lookup = {};

        for (var i in arr) {
            lookup[arr[i][prop]] = arr[i];
        }

        for (i in lookup) {
            nuevoArray.push(lookup[i]);
        }

        return nuevoArray;
    }

    $(document).on("click", ".addProducto", function() {
        var idProducto = $(this).attr("idProducto");
        var numeroDeMesa = $("#mesaTablaProductos").text();
        var productosMesa = "productosEnlaMesa" + numeroDeMesa;
        var productosMesa = [];
        var mesaIdNumero = "mesaIdNumero" + numeroDeMesa;
        var variableLSMesaId = "productosMesaIdNum" + numeroDeMesa;
        valorIdMesa = localStorage.getItem(mesaIdNumero);

        productosMesa.push({
            "idMesa": numeroDeMesa,
            "idProducto": idProducto
        })
        localStorage.setItem(variableLSMesaId, JSON.stringify(productosMesa));
        arrayLSProductos = localStorage.getItem(variableLSMesaId);
        // console.log("arrayLSProductos", arrayLSProductos);
        console.log("valorIDMESA", valorIdMesa);
        console.log("productosenlamesa" + numeroDeMesa, productosMesa);

    })
</script>