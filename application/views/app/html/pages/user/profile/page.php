<script src="<?php echo site_url('app/user_profile/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Administración de mi Perfil</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Usuario</a></li>
        <li class="active">Perfil</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<!--<span class="subtitle">Mi Perfil</span>-->
<div class="row">
    <div class="col-lg-3">
        <div class="block">
            <div class="block">
                <div class="thumbnail">
                    <div class="thumb">
                        <img class="styled logo-preview" src="resources/img/nologo.png" width="100%" />
                        <!--<img alt="" id="id_picture" class="styled img-user-profile" src="resources/assets/app/images/demo/users/user2.jpg">-->
                        <div class="thumb-options">
                            <span>
                                <a href="javascript:;" class="btn btn-icon btn-success action-upload">
                                    <i class="icon-pencil"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-icon btn-success action-delete-picture">
                                    <i class="icon-remove"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="caption text-center">
                        <h6 id="name_h6"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="well block">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tabDatos" data-toggle="tab">Datos del Perfil</a></li>
                    <li><a href="#tabCuenta" data-toggle="tab">Datos del Usuario</a></li>
                </ul>
                <div class="tab-content with-padding">
                    <div class="tab-pane fade in active" id="tabDatos">
                        <!-- Vertical form outside panel -->
                        <form role="form" action="javascript:;" name="frmProfile">
                            <div class="block">
                                <h6 class="heading-hr"><i class="icon-profile"></i> Información Personal</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Tipo de identificación:</label>
                                            <span class="el-finding el-fin-tipo-documeno text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="tipo_documento"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Identificación:</label>
                                            <input type="text" class="form-control" name="document">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nombres:</label>
                                            <input type="text" class="form-control" name="name">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Apellidos:</label>
                                            <input type="text" class="form-control" name="surname">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Género:</label>
                                            <span class="el-finding el-fin-genero text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="gender"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Fecha de Nácimiento:</label>
                                            <input type="text" data-mask="9999-99-99" placeholder="YYYY-MM-DD" class="form-control pull-right" name="birthday">
                                            <span class="help-block text-left">YYYY-MM-DD</span>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Estado Civil:</label>
                                            <span class="el-finding el-fin-estado-civil text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="estado_civil"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Tipo de Sangre:</label>
                                            <span class="el-finding el-fin-tipo-sangre text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="tipo_sangre"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Télefonos:</label>
                                            <input type="text" class="form-control" name="phone_cell">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" class="form-control" name="email">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <h6 class="heading-hr"><i class="icon-location2"></i> Información de Residencia</h6>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Pais:</label>
                                            <span class="el-finding el-fin-pais text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="id_pais"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Provincia:</label>
                                            <span class="el-finding el-fin-provincia text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="id_provincia"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Ciudad:</label>
                                            <span class="el-finding el-fin-ciudad text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                            <select class="select-full select-search" name="id_ciudad"></select>
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Dirección:</label>
                                            <input type="text" class="form-control" name="address">
                                            <span class="label label-danger label-block">Left aligned label</span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-actions">
                                        <div class="col-sm-3 text-left">
                                            <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span class="text">Espere...</span></div>
                                        </div>
                                        <div class="col-sm-9 text-right">
                                            <button class="btn btn-default action-cancel" type="button"><i class="icon-cancel-circle"></i> Cancelar</button>
                                            <button class="btn btn-primary action-edit" type="button"><i class="icon-pencil3"></i> Editar</button>
                                            <button class="btn btn-success action-save" type="submit"><i class="icon-disk"></i> Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /vertical form outside panel -->
                    </div>
                    <div class="tab-pane fade" id="tabCuenta">
                        <form action="javascript:;" role="form" name="frmUser">
                            <h6 class="heading-hr"><i class="icon-lock"></i> Información de Seguridad:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label> Nombre Usuario: </label>
                                        <input type="text" placeholder="username" class="form-control" name="username">
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label> Clave Actual: </label>
                                        <input type="password" placeholder="Ingrese Clave Actual" class="form-control" name="password_current">
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label> Nueva Clave: </label>
                                        <input type="password" placeholder="Ingrese Nueva Clave" class="form-control" name="password_new">
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label> Repetir Nueva Clave:</label>
                                        <input type="password" placeholder="Repita Nueva Clave" class="form-control" name="password_new_repeat">
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-actions">
                                    <div class="col-sm-3 text-left">
                                        <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span class="text">Espere...</span></div>
                                    </div>
                                    <div class="col-sm-9 text-right">
                                        <button class="btn btn-default action-cancel" type="button"><i class="icon-cancel-circle"></i> Cancelar</button>
                                        <button class="btn btn-primary action-edit" type="button"><i class="icon-pencil3"></i> Editar</button>
                                        <button class="btn btn-success action-save" type="submit"><i class="icon-disk"></i> Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Img modal -->
<div id="modal_upload_img" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Subir Imagen de Perfil</h4>
            </div>
            <!-- Form inside modal -->
            <form enctype="multipart/form-data" class="form-horizontal" role="form" name="upload_img_profile" action="javascript:;">    
                <div class="panel panel-default panel-logo">
<!--                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-image4"></i> Imagen de Perfil</h6>
                    </div>-->
                    <div class="panel-body">
<!--                        <div class="form-group">
                            <div class="col-sm-12">
                                <img class="styled logo-preview" src="resources/img/nologo.png" width="100%" height="200px" />
                                <input type="image" class="styled logo-preview" src="resources/img/nologo.png" width="100%" />
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-right">Picture:</label>
                            <div class="col-sm-10">
                                <input type="file" class="styled" name="profile" />
                                <span class="help-block">Formato Permitido: "PNG" Max file size 5Mb</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 view_pre_upload">
                                <div class="progress block-inner">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"><span></span></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions text-right">
                            <button class="btn btn-success action-upload-modal" type="button"><i class="icon-disk"></i> Subir</button>
                            <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-close"></i> Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>