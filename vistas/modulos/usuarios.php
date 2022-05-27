<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar usuarios
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar usuarios</li>
    </ol>
  </section>
  <section class="content">
    <!-- Default box rqwerwq-->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
          Agregar Usuario
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped table-responsive tablas">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Foto</th>
              <th>Perfil</th>
              <th>Estado</th>
              <th>Ultimo Login</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $item = null;
              $valor = null;
              $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

              foreach ($usuarios as $key => $value) {
                echo '<tr>
                        <td>1</td>
                        <td>'.$value["usua_nombre"].'</td>
                        <td>'.$value["usua_login"].'</td>';

                        if($value["usua_foto"] != ""){
                          echo '<td>
                                  <img src="'.$value["usua_foto"].'" class="img-thumbnail" width="40px">
                                </td>';
                        }else{
                          echo '<td>
                                  <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px">
                                </td>';
                        }

                        echo '
                        <td>'.$value["usua_perfil"].'</td>
                        <td><button class="btn btn-success btn-xs">'.$value["usua_estado"].'</button></td>
                        <td>'.$value["usua_ultimo_login"].'</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["usua_usuario"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                      </tr>';
              }

            ?>
            
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- MODAL AGREGAR USUARIO -->
<!-- Modal -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc; color: white">
          <h5 class="modal-title" id="exampleModalLongTitle">Agregar usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <!-- Nombre -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar Nombre" required>
              </div>
            </div>
            <!-- Usuario -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoUsuario" placeholder="Ingresar Usuario" required>
              </div>
            </div>
            <!-- Contrasenia -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="nuevoContrasenia" placeholder="Ingresar Contrasenia" required>
              </div>
            </div>
            <!-- Seleccionar perfil -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="nuevoPerfil">
                  <option value="">Seleccione Perfil</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <!-- Foto -->
            <div class="form-group">
              <div class="panel">Subir Foto</div>
              <input type="file" class="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso maximo 2 MB</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>
            <!-- Estado -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <select class="form-control input-lg" name="nuevoEstado">
                  <option value="">Seleccione Estado</option>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

        <?php
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();
        ?>

      </form>
    </div>
  </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<!-- Modal -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc; color: white">
          <h5 class="modal-title" id="exampleModalLongTitle">Editar usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <!-- Nombre -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
              </div>
            </div>
            <!-- Usuario -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>
              </div>
            </div>
            <!-- Contrasenia -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control input-lg" name="editarContrasenia" placeholder="Escriba la nueva Contrasenia" required>
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>
            </div>
            <!-- Seleccionar perfil -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="editarPerfil">
                  <option value="" id="editarPerfil"></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>
            <!-- Foto -->
            <div class="form-group">
              <div class="panel">Subir Foto</div>
              <input type="file" class="nuevaFoto" name="editarFoto">
              <p class="help-block">Peso maximo 2 MB</p>
              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" name="fotoActual" id="fotoActual">
            </div>
            <!-- Estado -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <select class="form-control input-lg" name="editarEstado">
                  <option value="" id="editarEstado"></option>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>

        <?php
          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();
        ?>

      </form>
    </div>
  </div>
</div>