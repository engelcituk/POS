<script>   
//funcion con sweetalert para metodos de pago
    function deleteMetodoPago(id) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: '¿Borrar este metodo de pago?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, borrarlo!',
            cancelButtonText: '¡No, desistir!'
        }).then(function() {
            $.ajax({
                url: "{{ url('metodospago') }}" + '/' + id,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(data) {
                    // tablaMetodosPago.ajax.reload();
                    swal({
                        title: '¡Exito!',
                        text: '¡Su dato ha sido borrado!',
                        type: 'success',
                        timer: '1500'
                    })
                    location.reload();
                },
                error: function() {
                    swal({
                        title: 'Oops...',
                        text: '¡Algo salió mal!',
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
    }   
</script>