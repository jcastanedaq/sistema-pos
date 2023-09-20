<script>
    $('.tblscroll').nicescroll({
        cursorcolor: '#516365',
        cursorwidth: "30px",
        background: "rgba(2',2',20,0.3)",
        cursorborder: "0px",
        cursorborderradius: "3"
    });

    function Confirm(id,eventName, text)
    {
        swal({
            'title':'CONFIRMAR',
            'text':text,
            'type':'warning',
            'showCancelButton':true,
            'cancelButtonText':'Cerrar',
            'canceButtonColor':'#fff',
            'confirmButtonColor':'#3b3f5c',
            'confirmButtonText':'Aceptar',
        }).then(function(result){
            if(result.value){
                window.livewire.emit(eventName, id);
                swal.close();
            }
        })
    }

</script>