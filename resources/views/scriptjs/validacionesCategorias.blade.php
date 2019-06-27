<script>    
//bloqueo no escribir letras y caracteres, solo numeros en categorias/create  
$(document).on("input", "#ordenCategoria", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    })  
</script>