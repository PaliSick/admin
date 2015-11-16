<?php if(!class_exists('raintpl')){exit;}?><?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("templates/head") . ( substr("templates/head",-1,1) != "/" ? "/" : "" ) . basename("templates/head") );?>

<style type="text/css">
    .btn{padding: 6px 12px !important;}
#paginado {text-align:right;}
#paginado ul {}
#paginado ul li {display:inline-block; width: auto; height:25px; line-height: 20px; text-align: center; border: solid 1px #bdbdbd; margin: 6px; padding: 3px;}
#paginado ul li a{display:block;}
#paginado ul li a:hover{background-color:#1C5AC4; color: #fff}
#paginado ul li.current {background-color:#1C5AC4; font-weight:bold;color: #fff;}
</style>
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
                        <h1 class="page-header">Peliculas Nuevas.</h1>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                              
                                <?php if( $action=='todas' ){ ?>    
                                <form role="form" action="http://eefol.eu/seedbox/index/nuevas" name="form-search" id="form-search" method="get" >
                                    <div class="form-group input-group col-lg-6">
                                    <input type="text" name="filter_query" id="filter_query" value="<?php echo $search["q"];?>" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="button" id="search" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="search_d" id="search_d" <?php if( $search["search_d"]==1 ){ ?> checked <?php } ?>   value="1">Descripción
                                        </label>
                                    </div>
                                </form>
                                <?php } ?>   
                             
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-categoria">
                                        <thead>
                                            <tr>
                                                <th>Pelicula</th>
                                                <th>Ver</th>
                                                <th>Quiero</th>
                                                <th>Paso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter1=-1; if( isset($peliculas) && is_array($peliculas) && sizeof($peliculas) ) foreach( $peliculas as $key1 => $value1 ){ $counter1++; ?>

                                            <tr class="<?php echo $value1["info"];?><?php echo $mostrar;?>">
                                                <td><?php echo $value1["Pelicula"];?></td>
                                                <td class="col-lg-1"><a href="http://eefol.eu/seedbox/index/ver/<?php echo $value1["Id"];?>" class="btn btn-primary">Detalles</a></td>
                                                <td class="col-lg-1"><a href="http://eefol.eu/seedbox/index/setEstado/<?php echo $value1["Id"];?>/1" class="btn btn-success setEstado">Quiero</a></td>
                                                <td class="col-lg-1"><a href="http://eefol.eu/seedbox/index/setEstado/<?php echo $value1["Id"];?>/0" class="btn btn-danger setEstado">Paso</a></td>
                                            </tr>
                                            <?php }else{ ?>

                                            <tr>
                                                <td  colspan="3">No hay resultados</td>
                                            </tr>
                                            <?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" id="paginado"><?php echo $paginado;?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
                        $l.parents('tr').fadeOut('slow', function(e) {
                            $(this).remove();
                        });
                    } else $('#info').echomsg(data.info, 'danger').slideDown()
                }, 'json');

            });


            $('#search').click(function(e) {
                $('#form-search').submit();
            });

            $('#form-search').submit(function(e) {
                e.preventDefault();
                var q = $('#filter_query').val() || '*';
                var d=0;
                if($('#search_d').is(':checked')) d=1;
                window.location = '<?php echo $base_path;?>/index/todas/q/'+q+'/descripcion/'+d;
                return true;
            });

        });

    </script>
</body>

</html>
