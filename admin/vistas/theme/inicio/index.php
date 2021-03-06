<?php require('./vistas/theme/header_adm.php'); ?>


      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-list-alt"></i> Users</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
					</ol>
				</div>
			</div>
              <div class="row">
                  <div class="col-lg-12">
                    <!-- busqueda -->
                    <?php $buscar = $_POST['buscar']; ?>
                      <form id="rendered-form" method="post" action="<?php echo URL_LINKS; ?>admin/index.php?cargar=inicio">
                        <div class="rendered-form">
                          <div class="fb-text form-group field-buscar">
                              <input type="text" value="<?php echo $buscar; ?>" placeholder="Buscar" id="buscar" class="form-control" name="buscar">
                          </div>
                          <div class="fb-button form-group field-button-buscar">
                            <button type="submit" class="btn btn" name="button-buscar" value="Buscar" style="warning" id="button-buscar">Buscar Usuario</button>
                          </div>
                        </div>
                      </form>
                      <!-- end busqueda -->
                      <!--notification start-->
                      <section class="panel">
                          <header class="panel-heading">
                            Tabla de Usuarios
                          </header>
                          <div class="panel-body">
                            <!-- ordenamiento 1 de 3 -->
                            <?php $order = $_GET["order"];
                            $columorder = $_GET["columorder"];
                            if($columorder == ''){
                              $columorder = 'id';
                            }
                            if (($order == '')||($order == 'ASC')){
                                $orderif = 'DESC';
                            } else {
                                $orderif = 'ASC';
                            }
                            if($order == ''){
                              $order = 'ASC';
                            }
                             ?>
                             <!-- fin ordenamiento 1 de 3 -->
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th><a href="<?php echo URL_LINKS; ?>admin/index.php?cargar=inicio&order=<?php echo $orderif; ?>&columorder=id">#</a></th>
                                    <th><a href="<?php echo URL_LINKS; ?>admin/index.php?cargar=inicio&order=<?php echo $orderif; ?>&columorder=username">Username</a></th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                              </thead>
                              <tbody>
                            <?php
                             $dir = dirname(dirname(dirname(dirname(__FILE__))));
                             require_once($dir.'/controlador/ControladorUsuarios.php');
                             $usuario = new ControladorUsuarios();
                            if($buscar == ''){
                               $num_total_registros = $usuario->contarUsuarios();
                            } else {
                               $num_total_registros = $usuario->contarUsuarios_busqueda($buscar);
                            }
                             $TAMANO_PAGINA = TAMANO_PAGINADOR;

                             //examino la página a mostrar y el inicio del registro a mostrar
                             $pagina = $_GET["pagina"];
                             if (!$pagina) {
                               $inicio = 0;
                               $pagina = 1;
                             } else {
                               $inicio = ($pagina - 1) * $TAMANO_PAGINA;
                             }
                             //calculo el total de páginas
                             $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
                          if($buscar == ''){
                             $resultados = $usuario->mostrarConPaginador($inicio,$TAMANO_PAGINA,$order,$columorder);
                           } else {
                             $resultados = $usuario->mostrarConPaginador_busqueda($inicio,$TAMANO_PAGINA,$buscar,$order,$columorder);
                           }
                             while ($row = mysqli_fetch_array($resultados)) :
                             ?>
                              <tr>
                                  <td><?php echo $row['id']; ?></td>
                                  <td><?php echo $row['username']; ?></td>
                                  <td><?php echo $row['tipo']; ?></td>
                                  <td><div class="btn-group">
                                      <a class="btn btn-primary" href="<?php echo URL_LINKS; ?>admin/index.php?cargar=editUser&id=<?php echo $row['id']; ?>"><i class="icon_pencil"></i></a>
                                      <a class="btn btn-success" href="<?php echo URL_LINKS; ?>admin/index.php?cargar=verUser&id=<?php echo $row['id']; ?>"><i class="icon_documents"></i></a>
                                      <a class="btn btn-danger" href="<?php echo URL_LINKS; ?>admin/index.php?cargar=deleteUser&id=<?php echo $row['id']; ?>" onclick="if(confirm('Esta seguro que desea eliminar este registro?') == false){return false;}"><i class="icon_close_alt2"></i></a>
                                  </div></td>
                              </tr>
                            <?php endwhile; ?>
                              </table>

                    <!--pagination start-->
                        <section class="panel">
                          <div class="panel-body">
                              <div>
                                <ul class="pagination pagination-lg">
                            <?php
                                if ($total_paginas > 1) {
                                 if ($pagina != 1)
                                    echo '<li><a href="'.URL_LINKS.'admin/index.php?cargar=inicio&pagina='.($pagina-1).'">«</a></li>';
                                    for ($i=1;$i<=$total_paginas;$i++) {
                                       if ($pagina == $i)
                                          //si muestro el índice de la página actual, no coloco enlace
                                          echo '<li><a href="" onclick="return false;">'.$pagina.'</a></li>';
                                       else
                                          //si el índice no corresponde con la página mostrada actualmente,
                                          //coloco el enlace para ir a esa página
                                          echo '  <li><a href="'.URL_LINKS.'admin/index.php?cargar=inicio&pagina='.$i.'">'.$i.'</a></li>';
                                    }
                                    if ($pagina != $total_paginas)
                                       echo '<li><a href="'.URL_LINKS.'admin/index.php?cargar=inicio&pagina='.($pagina+1).'">»</a></li>';
                                }
                            ?>
                          </ul>
                          </div>
                        </div>
                    </section>
                    <!--pagination end-->


                              <a class="btn btn-primary" href="<?php echo URL_LINKS; ?>admin/index.php?cargar=addUser" title="Bootstrap 3 themes generator"><span class="icon_profile"></span> Agregar Usuario</a>
                          </div>
                      </section>
                      <!--notification end-->



                  </div>

              </div>
          </section>
      </section>
      <!--main content end-->
  <?php require('./vistas/theme/foother_adm.php'); ?>
