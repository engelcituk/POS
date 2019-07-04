<script>
function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.png)$/i;

    if(!allowedExtensions.exec(filePath)){
        if (fileInput.value != ''){
            $.notify({	
                message: '<i class="fas fa-sun"></i><strong>Nota:</strong> No se ha podigo cargar la imagen:'+filePath+', favor de seleccionar solo formato:<trong>png</strong>' 
                },{	
                    type: 'danger',
                    delay: 5000
                });

        }
        fileInput.value = '';
        return false;
    }else{
    //Image preview
        if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>