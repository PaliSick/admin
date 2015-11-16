<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("templates/head") . ( substr("templates/head",-1,1) != "/" ? "/" : "" ) . basename("templates/head") );?>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
         <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("templates/menu") . ( substr("templates/menu",-1,1) != "/" ? "/" : "" ) . basename("templates/menu") );?>

        <!-- Fin menu -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bs-example" data-example-id="contextual-panels">  
                            <!-- /.panel-heading -->

                            <div class="panel panel-primary">
                                <a href="http://eefol.eu/seedbox/index/setEstado/<?php echo $Id;?>/1" class="btn btn-success setEstado">Quiero</a>
                                <a href="http://eefol.eu/seedbox/index/setEstado/<?php echo $Id;?>/0" class="btn btn-danger setEstado">Paso</a>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $Pelicula;?> <span class="pull-right" style="font-size:11px;"><?php echo $Nombre;?> - <?php echo $Fecha;?></span></h3>
                                </div>
                                <div class="panel-body"><?php echo $Descripcion;?></div>
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
                                         <?php $final=$this->var['final']=(count($comentarios)-1);?>

                                        <?php $counter1=-1; if( isset($comentarios) && is_array($comentarios) && sizeof($comentarios) ) foreach( $comentarios as $key1 => $value1 ){ $counter1++; ?>

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="http://eefol.eu/seedbox/#collapse<?php echo $key1;?>" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="collapsed"><?php echo $value1["Nombre"];?>      <span class="pull-right" style="font-size:11px;"> <?php echo $value1["Fecha"];?></span></a>
                                                </h4>
                                            </div>
                                            <div  id="collapse<?php echo $key1;?>" <?php if( $final==$key1 ){ ?> class="panel-collapse collapse in" aria-expanded="true" style="height: 141px;" <?php }else{ ?> class="panel-collapse collapse" aria-expanded="false" <?php } ?> style="height: 0px;">
                                                <div class="panel-body">
                                                 <?php echo $value1["Comentario"];?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

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
                                <form role="form" action="http://eefol.eu/seedbox/index/submit_comentario" name="comentario-nuevo" id="comentario-nuevo" method="get" >
                                    <div class="panel-body">
                                        <label>Nuevo Comentario</label>
                                        <textarea rows="3" name="Comentario" id="Comentario" class="form-control"></textarea>
                                    </div>
                                    <div class="panel-footer">
                                       <input type="submit" id="submit-comentario" class="btn btn-success" value="Enviar Comentario" >  <?php if( $Tipo==1 ){ ?>   <input type="submit" id="submit-capitulo" class="btn btn-warning" value="Nuevo Capitulo" onclick="CambiaAction(1)"> <?php } ?>

                                    </div>
                                    <input type="hidden" name="ID_pelicula" id="ID_pelicula" value="<?php echo $Id;?>">
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
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("templates/js") . ( substr("templates/js",-1,1) != "/" ? "/" : "" ) . basename("templates/js") );?>


    <script type="text/javascript">

        $(document).ready(function() {

            $('.setEstado').click(function(e) {
                e.preventDefault();
                $l = $(this);

                $.get($l.attr('href'), function(data) {
                    if (data.status == 'ok') {
                         window.location = "<?php echo $base_path;?>/index/nuevas/alert/success/"+data.info;
                      
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
                                                    <a href="http://eefol.eu/seedbox/#collapseN" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="collapsed"><span class="pull-right" style="font-size:11px;">'+F.getDate()+'/'+(F.getMonth()+1)+'/'+F.getFullYear()+' </span></a>\
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
