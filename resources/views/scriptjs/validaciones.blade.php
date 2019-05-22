<script>
    //Para validar se ingrese ip de impresoras respetando la sintaxis de la ruta impresoras/create
    var pattern = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
    x = 46;
    $("#ipImpresora").keypress(function(e) {
        $(".alert").remove();
        if (e.which != 8 && e.which != 0 && e.which != x && (e.which < 48 || e.which > 57)) {
            // console.log(e.which);
            return false;
        }
    }).keyup(function() {
        var this1 = $(this);
        if (!pattern.test(this1.val())) {
            $("#mensajeIpValido").html('<h3><span class="label label-warning"><strong>Ip inválida</strong></span></h3>');
            while (this1.val().indexOf("..") !== -1) {
                this1.val(this1.val().replace('..', '.'));
            }
            x = 46;
        } else {
            x = 0;
            var lastChar = this1.val().substr(this1.val().length - 1);
            if (lastChar == '.') {
                this1.val(this1.val().slice(0, -1));
            }
            var ip = this1.val().split('.');
            if (ip.length == 4) {
                $("#mensajeIpValido").html('<h3><span class="label label-success"><strong>Ip válida</strong></span></h3>');
            }
        }
    })
    /*Para poner la hora inicio en formato de 24:00 hrs  del area de turnos de la ruta-> turnos/create */
    $('#horaInicio').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: true,
        showMeridian: false,
        defaultTime: false
    });
    $(document).on("input", "#turnoPV", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    })
</script>