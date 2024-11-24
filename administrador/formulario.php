<html>
    <head>
        <title>Ajax / Jquery</title>
        <style>
        #mensaje {
            color:#F00;
            font-size:16px;
        }
        </style>
        <script src="jquery-3.3.1.min.js"></script>
<script>
    function enviaAjax(){
        var numero = $("#numero").val();
       if(numero==''|| numero <= 0){
              $("#mensaje").html("Faltan campos por llenar");
              setTimeout(function() { $("#mensaje").html(''); }, 5000);
         }else{
            $.ajax({
                url: 'respuesta.php',
                type: 'post',
                dataType: 'text',
                data: 'numero='+numero,
                success: function(res){
                    // Espera respuesta
                    console.log(res);
                    if(res == 1){
                        $("#mensaje").html("APROBASTE");
                    }else{
                        $("#mensaje").html("REPROBASTE");
                    }
                }, error:function(){
                    alert('Error archivo no encontrado...');
                }
            });
       }
    }

</script>
</head>
<body>
    <input type="text" name="numero" id="numero"/> <br>
    <a href="javascript:void(0);" onclick="enviaAjax();">
        Enviar con Ajax 
    </a><br>
    <div id="mensaje"></div>
    </body>
    </html>