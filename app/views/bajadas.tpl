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
                        <h1 class="page-header">Peliculas a descargar.</h1>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-categoria">
                                        <thead>
                                            <tr>
                                                <th>Pelicula</th>.
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {loop="peliculas"}
                                            <tr class="success">
                                                <td>{$value.Pelicula}</td>
                                                <td>{$value.Fecha}</td>
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




        });

    </script>
</body>

</html>
