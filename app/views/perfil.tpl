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
                        <h1 class="page-header">Perfil</h1>
                        <form role="form" action="index/submit_perfil" name="form_perfil" id="form_perfil" method="post" >
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Nombre  *1:</label>
                                    <input class="form-control" name="Nombre" id="Nombre" value="{$Nombre}"  placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label>*E-mail *2:</label>
                                    <input class="form-control" class="form-control" name="Email" id="Email" value="{$Email}"   placeholder="E-mail">
                                </div>


                                <div class="form-group">
                                    <label>Contraseña</label>
                                   <input class="form-control" id="Password" name="Password" value="{$Password}">
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
            <div class="panel  col-lg-6">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                            <p>*1 Nick que aparece al insertar una película y/o comentario</p>
                            <p>*2 Nombre del usuario, usado para el login</p>
                        </div>
                        <div class="panel-footer">
                            
                        </div>
                    </div> 
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- js -->
    {include="templates/js"}



    <script type="text/javascript">


        
        $(document).ready(function(e) {

            $('#form_perfil').submit(function(e) {
             
                var $this = $(this);
                e.preventDefault();
               
                var  params = $this.serialize();

               
                $.post($this.attr('action'), params, function(data){
                    
                    if (data.status == 'ok') {
                        window.location = "{$base_path}/index/perfil/alert/success/"+data.info;
                        
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