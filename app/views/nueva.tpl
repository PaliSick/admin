{include="templates/head"}
<style type="text/css">
    .image-preview-holder {float: left; position:relative;}
    
    #img-preview-1 {margin-top:3px; border:solid 1px #BDBDBD;}
    #img-preview-2 {margin-top:3px; border:solid 1px #BDBDBD;}
    #img-preview-3 {margin-top:3px; border:solid 1px #BDBDBD;}
    #img-preview-4 {margin-top:3px; border:solid 1px #BDBDBD;}
    #img-preview-5 {margin-top:3px; border:solid 1px #BDBDBD;}
    .image-preview-holder a.button{display:block;text-align:center;}
    .filtros{width: 170px; float: left; border: 1px #ccc solid; margin: 5px; padding: 5px;}
    .check{width: 15px !important;}
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
                        <div class="col-lg-8" id="info">
                        {if="$msg"}
                            {$msg|echomsg:$msgType}
                        {/if}
                        </div>
                        <h1 class="page-header">Pelicula</h1>
                        <form role="form" action="index/submit_pelicula" name="peli-nueva" id="peli-nueva" method="get" enctype="multipart/form-data">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input class="form-control" name="Pelicula" id="Pelicula" value="{$Pelicula}"  placeholder="Título">
                                </div>
                                <div class="form-group">
                                    <label>Marcar para Series</label>
                                    <input type="checkbox" class="form-control" name="Tipo" id="Tipo" value="1"   placeholder="Tipo">
                                </div>


                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" id="Descripcion" name="Descripcion" rows="3">{$Descripcion}</textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="submit" class="btn btn-success" value="Guardar">
                                    <input type="hidden" name="id" id="id" value={$Id}>
                                </div>

                            </div>


                        </form>
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

<script type="text/javascript" src="tinymce/tinymce.min.js"></script>

    <script type="text/javascript">
        tinymce.init({
            selector: "#Descripcion",
            language: "es",
            height : 300
        });

        
        $(document).ready(function(e) {

            $('#peli-nueva').submit(function(e) {
                tinyMCE.triggerSave();
                var $this = $(this);
                e.preventDefault();
               
                var  params = $this.serialize();

               
                $.post($this.attr('action'), params, function(data){
                    
                    if (data.status == 'ok') {
                        window.location = "{$base_path}/index/quiero/alert/success/"+data.info;
                        
                        return;
                    } else {
                        $('#info').echomsg(data.info, 'danger').slideDown();
                    }

                }, 'json');
            });

        });

    </script>

</body>

</html>