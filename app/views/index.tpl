{include="templates/head"}
<style type="text/css">
    #selectores{
    z-index: 1000;
    background-color: lightgrey;
    opacity: 0.6;
    pointer-events: none;
    width: 137px;
    }
</style>
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
                        <h1 class="page-header">Peliculas Nuevas.</h1>

                            <a href="index/pasoTodo" id="pasoTodo" class="btn btn-danger">Botón Seba (paso a todo)</a>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                              
                                {if="$action=='todas'"}    
                                <form role="form" action="index/nuevas" name="form-search" id="form-search" method="get" >
                                    <div class="form-group input-group col-lg-6">
                                    <input type="text" name="filter_query" id="filter_query" value="{$search.q}" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="button" id="search" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="search_d" id="search_d" {if="$search.search_d==1"} checked {/if}   value="1">Descripción
                                        </label>
                                    </div>
                                </form>
                                {/if}   
                             
                                <div class="dataTable_wrapper">
                                    <form action="" method="post" name="form_selector" id="form_selector">
                                    <div id="selectores"  ng-class="{disabled: !status}" ><a href="#" id="quieros" class="btn btn-success " >Quiero</a>  &nbsp;<a href="#" class="btn btn-danger " id="pasos">Paso</a></div>
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-categoria">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Pelicula</th>
                                                <th>Ver</th>
                                                <th>Quiero</th>
                                                <th>Paso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {loop="peliculas"}
                                            <tr class="{$value.info}{$mostrar}">
                                                <td><input type="checkbox" name="Pelicula[]" id="Id-{$key}" class="seleccion" value="{$value.Id}"  ></td>
                                                <td>{$value.Pelicula}</td>
                                                <td class="col-lg-1"><a href="index/ver/{$value.Id}" class="btn btn-primary">Detalles</a></td>
                                                <td class="col-lg-1"><a href="index/setEstado/{$value.Id}/1" class="btn btn-success setEstado">Quiero</a></td>
                                                <td class="col-lg-1"><a href="index/setEstado/{$value.Id}/0" class="btn btn-danger setEstado">Paso</a></td>
                                            </tr>
                                            {else}
                                            <tr>
                                                <td  colspan="3">No hay resultados</td>
                                            </tr>
                                            {/loop}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" id="paginado">{$paginado}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" id="tipo" name="tipo" value="0">
                                    </form>
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
    {include="templates/js"}

    <script type="text/javascript">
        var total=0;
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
                window.location = '{$base_path}/index/todas/q/'+q+'/descripcion/'+d;
                return true;
            });
            $('#pasoTodo').click(function(e) {
                e.preventDefault();
                $l = $(this);
                if (!confirm('Si continua todas las películas/series nuevas se marcarán como \"Paso\".\nEstá seguro que desea continuar?')) return false;

                $.get($l.attr('href'), function(data) {
                    if (data.status == 'ok') {
                        window.location = '{$base_path}/index/nuevas';
                    } else alert(data.info);
                }, 'json');

            });

            $('.seleccion').click(function(){

                total=0;

                 $('.seleccion').each(function(i, e){
                    
                    if( $(e).prop('checked')){                       
                        total=1;
                    }

                 });
                
                 if(total==1){
                    
                    $('#selectores').css({"background-color":"#fff", "opacity":"1","pointer-events":"auto"});
                 }else{
                     $('#selectores').css({"background-color":"lightgrey", "opacity":"0.6","pointer-events":"none"});
                 }
            
            });
            $('#form_selector').submit(function(e) {
                e.preventDefault();
                var form = $(this), to = 0;
                var data = form.serialize();
                

                $.post('{$base_path}/index/varios', data, function(data) {
                    
                    if(data.status=='ok'){
                         window.location = '{$base_path}/index/nuevas';
                    }else{
                        alert('Se produjo un error, intente luego');
                       
                    }
                }, 'json');
            });

             $('#quieros').click(function(e) {
                $('#tipo').val(1);
                $('#form_selector').submit();
            }); 
             $('#pasos').click(function(e) {
                $('#tipo').val(2);
                $('#form_selector').submit();
            });           

 
        });

    </script>
</body>

</html>
