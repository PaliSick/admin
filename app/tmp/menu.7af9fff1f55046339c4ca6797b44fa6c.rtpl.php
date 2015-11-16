<?php if(!class_exists('raintpl')){exit;}?>        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://eefol.eu/seedbox/index.html">Seedbox</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

        
 
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="http://eefol.eu/seedbox/#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="http://eefol.eu/seedbox/#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="http://eefol.eu/seedbox/#"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <li><a href="http://eefol.eu/seedbox/#"><i class="fa fa-gear fa-fw"></i> Configurar</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="http://eefol.eu/seedbox/index/logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="http://eefol.eu/seedbox/#"><i class="fa fa-fw"></i> Peliculas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/nuevas" <?php echo $menu["8"];?>>Nuevas</a>
                                </li>
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/quiero" <?php echo $menu["2"];?>>Quiero</a>
                                </li> 
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/agregar" <?php echo $menu["3"];?>>Agregar</a>
                                </li>
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/bajadas" <?php echo $menu["6"];?>>Bajadas</a>
                                </li>
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/pasadas" <?php echo $menu["4"];?>>Pasadas</a>
                                </li>
                                <li>
                                    <a href="http://eefol.eu/seedbox/index/todas" <?php echo $menu["5"];?>>Todas/Buscar</a>
                                </li>
                            </ul>                            
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>