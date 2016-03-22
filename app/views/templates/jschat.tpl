	re



  var registrarMensajes=function(){
    var data = $('#formChat').serialize();
    $('#send').on("click", function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url : "{$base_path}/index/guardaChat",
            data: data
        });
    });
};

        var cargaMensajes=function(){              
           
            $.ajax({
                type: "POST",
                url : "{$base_path}/index/cargaChat"
            }).done(function(info){
                $("#conversation").html(info);

            });
                          
        }