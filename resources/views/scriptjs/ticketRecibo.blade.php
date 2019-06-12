<script>
function imprimirTicket() {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ url('printrecibo')}}",
        type: "POST",
        data: {
            '_method': 'POST',
            '_token': csrf_token
        },
        success: function(respuesta) {
        // console.log(respuesta);
        },
        error: function() {
        // console.log(respuesta);
        }
    });        
}
</script>