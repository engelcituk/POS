<script>    
    //funcion con sweetalert para borrar un turno
    function deleteTurno(id) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: '¿Seguro de borrar este turno?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, borrarlo!',
            cancelButtonText: '¡No, desistir!'
        }).then(function() {
            $.ajax({
                url: "{{ url('turnos') }}" + '/' + id,
                type: "POST",
                data: {
                    '_method': 'POST',
                    '_token': csrf_token
                },
                success: function(data) {
                                    
                    swal({
                        title: 'Info!',
                        text: data,
                        type: 'info'                        
                    });
                    setTimeout(() => {
                        location.reload();                        
                    }, 4000);
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
        }).catch(swal.noop);
    }    
</script>