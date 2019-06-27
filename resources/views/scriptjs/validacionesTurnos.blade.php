<script>
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