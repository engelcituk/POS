<script> 

/*Para validar que se seleccione un permiso al estar creando un permiso RUTA: rolesapi/create*/
$(document).on("click", ".saveRolPermisos", function(){	
    //verifico si los values son true o false
    var nameRol= $("#nameRol").val().length > 0;
    var descripcionRol= $("#descripcionRol").val().length > 0;
    //verifico si hay checkbox checkeados (true/false)
    var check = $('div.checkbox-group.required :checkbox:checked').length > 0; 

    if(!nameRol || !descripcionRol){
        swal({
            title: 'Oops...',
            text: '¡Por favor no deje campos vacios!',
            type: 'error',
            timer: '1500'
        })
        return false;                 
    } else if (!check){
        swal({
            title: 'Oops...',
            text: '¡Por favor selecciona un permiso!',
            type: 'error',
            timer: '1500'
        })						
        return false;
    }  			
}); 
</script>