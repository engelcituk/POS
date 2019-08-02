<script>    
   //funcion con sweetalert para borrar un alergeno
    function deleteAlergeno(id,nombreImagen) {
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        // var nombreImagen=$(this).attr("imgNombre");         
        // console.log("img"+nombreImagen);      
        swal({
            title: '¿Seguro de borrar este alergeno?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, borrarlo!',
            cancelButtonText: '¡No, desistir!'
        }).then(function() {
            $.ajax({
                url: "{{ url('alergenos') }}" + '/' + id,
                type: "POST",
                data: {
                    '_method': 'POST',
                    'nombreImagen': nombreImagen,
                    '_token': csrf_token
                },
                success: function(data) {
                    // tablaAlergenos.ajax.reload();
                    swal({
                        title: '¡Exito!',
                        text: '¡Su dato ha sido borrado!',
                        type: 'success',
                        timer: '1500'
                    })
                    location.reload();
                },
                error: function(data) {
                    swal({
                        title: 'Oops...',
                        text: '¡Algo salió mal!'+data,
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
    }  
</script>