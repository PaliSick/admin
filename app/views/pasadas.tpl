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
                        <h1 class="page-header">Peliculas pasadas.</h1>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <form role="form" action="index/pasadas" name="form-search" id="form-search" method="get" >
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
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-categoria">
                                        <thead>
                                            <tr>
                                                <th>Pelicula</th>.
                                                <th>Ver</th>
                                                <th>Quiero</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {loop="peliculas"}
                                            <tr class="danger">
                                                <td>{$value.Pelicula}</td>
                                                <td class="col-lg-1"><a href="index/ver/{$value.Id}" class="btn btn-primary">Detalles</a></td>                                    
                                                <td class="col-lg-1"><a href="index/setEstado/{$value.Id}/1" class="btn btn-success setEstado">Quiero</a></td>
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
                window.location = '{$base_path}/index/pasadas/q/'+q+'/descripcion/'+d;
                return true;
            });

        });

    </script>
</body>

</html>
