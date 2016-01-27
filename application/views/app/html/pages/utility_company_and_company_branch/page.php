<script src="<?php echo site_url('app/utility_company_and_company_branch/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Administración de Empresa y Sucursales</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Utilitarios</a></li>
        <li class="active">Empresa y Sucursales</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>

<div class="tabbable">
    <ul class="nav nav-pills nav-justified-">
        <li class="active"><a data-toggle="tab" href="#tab_company_data"><i class="icon-paragraph-justify2"></i> Datos Empresa</a></li>
        <li class=""><a data-toggle="tab" href="#tab_company_branches"><i class="icon-office"></i> Sucursales</a></li>
    </ul>
    <div class="tab-content pill-content">
        <div id="tab_company_data" class="tab-pane fade active in">
            <div class="row">
                <div class="col-lg-8">
                    <form action="javascript:;" role="form" class="form-horizontal" name="company">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group has-feedback">
                                    <label class="col-sm-3 control-label text-right">Nombre: <span class="mandatory">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" placeholder="Nombre" />
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-3 control-label text-right">Nombre ID: <span class="mandatory">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name_key" placeholder="Nombre ID" />
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-3 control-label text-right">Descripción: <span class="mandatory">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="description" placeholder="Descripción" />
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-3 control-label text-right">Teléfono: <span class="mandatory">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phone" placeholder="Teléfono" />
                                        <span class="label label-block label-danger text-left">Centered label</span>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="col-sm-3 text-left">
                                        <!--<div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span class="text">Espere...</span></div>-->
                                    </div>
                                    <div class="col-sm-9 text-right">
                                        <button class="btn btn-success action-save" type="button"><i class="icon-disk"></i> Guardar</button>
                                        <button class="btn btn-primary action-edit" type="button"><i class="icon-pencil3"></i> Editar</button>
                                        <button class="btn btn-danger action-cancel" type="button"><i class="icon-cancel-circle"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
<!--                    <form action="<?php echo site_url('app/utility_company_and_company_branchx/process/upload-company-logo'); ?>" class="form-horizontal" role="form" id="frm_company" method="post" enctype="multipart/form-data">-->
                    <form enctype="multipart/form-data" class="form-horizontal" role="form" name="upload_logo" action="javascript:;">    
                        <div class="panel panel-default panel-logo">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <img class="styled logo-preview" src="resources/img/nologo.png" width="100%" />
                                        <!--<input type="image" class="styled logo-preview" src="resources/img/nologo.png" width="100%" />-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label text-right">Logo Empresarial:</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="styled" name="logo" />
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
                                    <button class="btn btn-success action-save" type="button"><i class="icon-disk"></i> Guardar</button>
                                    <button class="btn btn-primary action-edit" type="button"><i class="icon-pencil3"></i> Editar</button>
                                    <button class="btn btn-danger action-cancel" type="button"><i class="icon-cancel-circle"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="tab_company_branches" class="tab-pane fade">
            <div class="panel panel-default">
                <ul class="panel-toolbar">
                    <li><a title="Nuevo" href="javascript:;" class="action-new"><i class="icon-plus-circle"></i> Nuevo</a></li>
                </ul>
                <div class="datatable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Dirección</th>
                                <th style="text-align: center">Telefono</th>
                                <th style="text-align: center">Estado</th>
                                <th style="text-align: center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form modal - Creacion y edicion de sedes -->
<div id="modal_branch_form" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Sucursales</h4>
            </div>
            <!-- Form inside modal -->
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_company_branch" value="0" />
                <div class="modal-body with-padding">
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Nombre</label>
                        <input type="text" placeholder="Nombre" class="form-control" name="name">
                        <i class="icon icon-checkmark3 form-control-feedback"></i>
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Dirección</label>
                        <input type="text" placeholder="Dirección" class="form-control" name="address">
                        <i class="icon icon-checkmark3 form-control-feedback"></i>
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Teléfono</label>
                        <input type="text" placeholder="Numero de Teléfono" class="form-control" name="phone">
                        <i class="icon icon-checkmark3 form-control-feedback"></i>
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> País</label>
                        <select name="id_pais" class="select-search el-fin-pais"></select>
                        <!--<span class="el-finding el-fin-pais text-success">Cargando...</span>-->
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Provincia</label>
                        <select name="id_provincia" class="select-search el-fin-provincia"></select>
                        <!--<span class="el-finding el-fin-provincia text-success">Cargando...</span>-->
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Ciudad</label>
                        <select name="id_ciudad" class="select-search el-fin-ciudad"></select>
                        <!--<span class="el-finding el-fin-ciudad text-success">Cargando...</span>-->
                        <span class="label label-block label-danger text-left"></span>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-inline checkbox-success">
                            <input type="checkbox" class="styled form-control" checked="checked" name="isActive">
                            Está Activo?
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-xs-4">
                        <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span>Espere...</span></div>
                    </div>
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-success action-save"><i class="icon-disk"></i> Guardar</button>
                        <button type="button" class="btn btn-primary action-edit"><i class="icon-pencil3"></i> Editar</button>
                        <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-close"></i> Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="el-templates" style="display:none;">
    <div element="table-permission-row-actions">
        <div class="table-controls">
            <a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Edit entry"><i class="icon-search3"></i></a>
            <a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
        </div>
    </div>
</div>