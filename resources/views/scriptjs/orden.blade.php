<script>
    $(document).on("click", ".actualizarMesas", function(e) {
        event.preventDefault();
        $("#zonaMesas").load(" #zonaMesas");
    })
    $("#zonaElige").change(function() {
        var nombreZona = $("option:selected", this).val(); //obtener el value de un select
        if (nombreZona != "") {
            var numero = parseInt(obtenerNumeroDeCadena(nombreZona));
            switch (numero) {
                case 0:
                    $("#zona1").removeClass("hidden");
                    $("#zona2").removeClass("hidden");
                    $("#zona3").removeClass("hidden");
                    $("#zona4").removeClass("hidden");
                    $("#zona5").removeClass("hidden");
                    break;
                case 1:
                    $("#zona1").removeClass("hidden");
                    $("#zona2").addClass("hidden");
                    $("#zona3").addClass("hidden");
                    $("#zona4").addClass("hidden");
                    $("#zona5").addClass("hidden");
                    break;
                case 2:
                    $("#zona1").addClass("hidden");
                    $("#zona2").removeClass("hidden");
                    $("#zona3").addClass("hidden");
                    $("#zona4").addClass("hidden");
                    $("#zona5").addClass("hidden");
                    break;
                case 3:
                    $("#zona1").addClass("hidden");
                    $("#zona2").addClass("hidden");
                    $("#zona3").removeClass("hidden");
                    $("#zona4").addClass("hidden");
                    $("#zona5").addClass("hidden");
                    break;
                case 4:
                    $("#zona1").addClass("hidden");
                    $("#zona2").addClass("hidden");
                    $("#zona3").addClass("hidden");
                    $("#zona4").removeClass("hidden");
                    $("#zona5").addClass("hidden");
                    break;
                case 5:
                    $("#zona1").addClass("hidden");
                    $("#zona2").addClass("hidden");
                    $("#zona3").addClass("hidden");
                    $("#zona4").addClass("hidden");
                    $("#zona5").removeClass("hidden");
                    break;
                default:
                    console.log("default");
                    break;
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
</script>