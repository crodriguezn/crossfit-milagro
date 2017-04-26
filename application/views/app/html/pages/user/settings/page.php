<script src="<?php echo site_url('app/user_settings/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Administración de Cuentas de Usuarios</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Usuario</a></li>
        <li class="active">Cuentas</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table2"></i> Listado de Cuentas</h6>
        <div class="dropdown pull-right"> <a href="#" class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
            <ul class="dropdown-menu icons-right dropdown-menu-right">
                <li><a href="javascript:;" action="action-refresh"><i class="icon-spinner7"></i> Actualizar</a></li>
                <li><a href="javascript:;"><i class="icon-print2"></i> Imprimir</a></li>
            </ul>
        </div>
    </div>
    <ul class="panel-toolbar">        
        <li>
            <a title="" class="action-popup-new" href="javascript:;">
                <i class="icon-plus-circle"></i> Nuevo
            </a>
        </li>
    </ul>
    <div class="panel-body">
        <div class="datatable">
            <table class="table" >
                <thead>
                    <tr>
                        <th style="text-align: center">Documento</th>
                        <th style="text-align: center">Apellidos/Nombres</th>
                        <th style="text-align: center">Usuario</th>
                        <th style="text-align: center">Perfil</th>
                        <th style="text-align: center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Cuenta</h4>
            </div>
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_form" value="0" />
                <input type="hidden" name="id_user" value="0" />
                <input type="hidden" name="id_person" value="0" />
                <div class="modal-body with-padding">
                    <div class="well block">
                        <div class="tabbable">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabDatos" data-toggle="tab">Persona</a></li>
                                <li><a href="#tabCuenta" data-toggle="tab">Usuario</a></li>
                            </ul>
                            <div class="tab-content with-padding">
                                <div class="tab-pane fade in active" id="tabDatos">
                                    <!-- Vertical form outside panel -->
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
                                                    <label><i class="icon-spell-check"></i> Número de Identificación: <span class="el-finding-document" style="color: rgb(253, 123, 18);">Buscando...</span></label>
                                                    <input type="text" class="form-control" name="document">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Nombres:</label>
                                                    <input type="text" class="form-control" name="name">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Apellidos:</label>
                                                    <input type="text" class="form-control" name="surname">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Género:</label>
                                                    <span class="el-finding el-fin-genero text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                    <select class="select-full select-search" name="gender"></select>
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Fecha de Nácimiento:</label>
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
                                                    <label><i class=""></i> Télefonos:</label>
                                                    <input type="text" class="form-control" name="phone_cell">
                                                    <span class="label label-danger label-block">Left aligned label</span> 
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><i class="icon-spell-check"></i> Email:</label>
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
                                    </div>
                                    <!-- /vertical form outside panel -->
                                </div>
                                <div class="tab-pane fade" id="tabCuenta">
                                    <h6 class="heading-hr"><i class="icon-user4"></i> Información del Perfil:</h6>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group has-feedback">
                                                <label>Perfil: </label>
                                                <span class="el-finding el-fin-perfil text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                <select class="select-full select-search" name="id_profile"></select>
                                                <span class="label label-block label-danger text-left">Centered label</span>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group has-feedback">
                                                <label><i class="icon-spell-check"></i> Sedes: </label>
                                                <span class="el-finding el-fin-company-branchs text-success" style="text-align:left;" ><img src="resources/img/loading.gif" /> <span class="text">Cargando...</span></span>
                                                <select name="id_company_branchs" data-placeholder="Buscar Sedes" class="select-multiple" multiple="multiple" tabindex="2">                                   
                                                </select>
                                                <span class="label label-block label-danger text-left">Centered label</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group has-feedback">
                                                <label class="checkbox-inline checkbox-success">
                                                    ¿Esta Activo?
                                                    <input type="checkbox" class="form-control styled" name="isActive">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="heading-hr"><i class="icon-lock"></i> Información de Seguridad:</h6>
                                    <div class="form-group msg-clave">                                            
                                        <span class=" label label-block label-info text-left"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label><i class="icon-spell-check"></i> Nombre Usuario: </label>
                                                <input type="text" placeholder="username" class="form-control" name="username">
                                                <span class="label label-block label-danger text-left">Centered label</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label>Contraseña: </label>
                                                <input type="password" placeholder="Ingrese Nueva Clave" class="form-control" name="password_new">
                                                <span class="label label-block label-danger text-left">Centered label</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-feedback">
                                                <label>Verificar Contraseña:</label>
                                                <input type="password" placeholder="Repita Nueva Clave" class="form-control" name="password_new_repeat">
                                                <span class="label label-block label-danger text-left">Centered label</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-4">
                        <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span>Espere...</span></div>
                    </div>
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-success action-save"><i class="icon-disk"></i>Guardar</button>
                        <button type="button" class="btn btn-primary action-edit"><i class="icon-pencil3"></i>Editar</button>
                        <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>