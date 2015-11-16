{include="templates/head"}

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         {include="templates/menu"}
        <!-- Fin menu -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bs-example" data-example-id="contextual-panels">  
                            <!-- /.panel-heading -->

                            <div class="panel panel-primary">
                                <a href="index/setEstado/{$Id}/1" class="btn btn-success setEstado">Quiero</a>
                                <a href="index/setEstado/{$Id}/0" class="btn btn-danger setEstado">Paso</a>
                                 <a href="index/setEstado/{$Id}/5" class="btn btn-warning setEstado">Bajada</a>
                                <div class="panel-heading">
                                    <h3 class="panel-title">{$Pelicula} <span class="pull-right" style="font-size:11px;">{$Nombre} - {$Fecha}</span></h3>
                                </div>
                                <div class="panel-body">{$Descripcion}</div>
                            </div>
                            <div class="well"></div>
                            <!-- /Cometarios -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Comentarios
                                </div>
                                <!-- .panel-heading -->
                                <div class="panel-body">
                                    <div id="accordion" class="panel-group">
                                         {$final=(count($comentarios)-1)}
                                        {loop="comentarios"}
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="#collapse{$key}" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="collapsed">{$value.Nombre}      <span class="pull-right" style="font-size:11px;"> {$value.Fecha}</span></a>
                                                </h4>
                                            </div>
                                            <div  id="collapse{$key}" {if="$final==$key"} class="panel-collapse collapse in" aria-expanded="true" style="height: 141px;" {else} class="panel-collapse collapse" aria-expanded="false" {/if} style="height: 0px;">
                                                <div class="panel-body">
                                                 {$value.Comentario}
                                                </div>
                                            </div>
                                        </div>
                                        {/loop}
                                    </div>
                                </div>
                                <!-- .panel-body -->
                            </div>
                            <!-- /Cometarios -->

                           <!-- /Nuevo Comentario -->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                Agregar Comentario
                                </div>
                                <form role="form" action="index/submit_comentario" name="comentario-nuevo" id="comentario-nuevo" method="get" >
                                    <div class="panel-body">
                                        <label>Nuevo Comentario</label>
                                        <textarea rows="3" name="Comentario" id="Comentario" class="form-control"></textarea>
                                    </div>
                                    <div class="panel-footer">
                                       <input type="submit" id="submit-comentario" class="btn btn-success" value="Enviar Comentario" >  {if="$Tipo==1"}   <input type="submit" id="submit-capitulo" class="btn btn-warning" value="Nuevo Capitulo" onclick="CambiaAction(1)"> {/if}
                                    </div>
                                    <input type="hidden" name="ID_pelicula" id="ID_pelicula" value="{$Id}">
                                    <input type="hidden" name="Tipo" id="Tipo" value="0">
                                </form>
                            </div>  
                            <!-- /Nuevo Comentario -->    
                        </div>
                            
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- js -->
    {include="templates/js"}

    <script type="text/javascript">

        $(document).ready(function() {

            $('.setEstado').click(function(e) {
                e.preventDefault();
                $l = $(this);

                $.get($l.attr('href'), function(data) {
                    if (data.status == 'ok') {
                         window.location = "{$base_path}/index/nuevas/alert/success/"+data.info;
                      
                    } else $('#info').echomsg(data.info, 'danger').slideDown()
                }, 'json');

            });


            $('#comentario-nuevo').submit(function(e) {
               
                var $this = $(this);
                e.preventDefault();
                if($('textarea#Comentario').val().length<=2){
                    alert('Poné algo en el comentario chavón!')
                    return;
                }
                var  params = $this.serialize();

               
                $.post($this.attr('action'), params, function(data){
                    
                    if (data.status == 'ok') {
                        F=new Date();
                        $('#accordion').fadeIn(1000).append('<div class="panel panel-default">\
                                            <div class="panel-heading">\
                                                <h4 class="panel-title">\
                                                    <a href="#collapseN" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="collapsed"><span class="pull-right" style="font-size:11px;">'+F.getDate()+'/'+(F.getMonth()+1)+'/'+F.getFullYear()+' </span></a>\
                                                </h4>\
                                            </div>\
                                            <div  id="collapseN"  class="panel-collapse collapse in" aria-expanded="true" style="height: 141px;">\
                                                <div class="panel-body">'+$('textarea#Comentario').val()+'</div>\
                                            </div>\
                                        </div>');
                        
                        $('#comentario-nuevo')[0].reset();
                        return;
                    } else {
                        $('#info').echomsg(data.info, 'danger').slideDown();
                    }

                }, 'json');
            });

        });

    function CambiaAction(id){
        
        $('#Tipo').val(id);
    };

    </script>
</body>

</html>
