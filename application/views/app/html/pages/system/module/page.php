<script src="<?php echo site_url('app/system_module/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-menu2"></i>Administración de Módulos/SubMódulos</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Sistema</a></li>
        <li class="active">Módulos</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-menu5"></i> Módulos/SubMódulos</h6>
                <div class="dropdown pull-right"> <a href="#" class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
                        <ul class="dropdown-menu icons-right dropdown-menu-right">
                            <li><a href="javascript:void(0);" action="action-new-module"><i class="icon-disk" ></i> Módulo/Submódulo</a></li>
                            <li><a href="javascript:void(0);" action="action-save-order"><i class="icon-numbered-list" ></i> Guardar orden</a></li>
                            <li><a href="javascript:void(0);" action="action-refresh"><i class="icon-spinner7" ></i> Actualizar</a></li>
                            <!--<li><a href="javascript:void(0);"><i class="icon-print2"></i> Imprimir</a></li>-->
                        </ul>
                    </div>
                <!--<button class="pull-right btn btn-xs btn-info" type="button" action="action-refresh"><i class="icon-loop4"></i> Refrescar</button>-->
                <!--<button class="pull-right btn btn-xs btn-success" type="button" action="action-new-module"><i class="icon-disk"></i> Nuevo Módulo/Submódulo</button>-->
                <!--<button class="pull-right btn btn-xs btn-primary" type="button" action="action-save-order"><i class="icon-numbered-list"></i> Guardar orden</button>-->
            </div>
            
            <div class="panel-body">
                <div class="sortable-module">--</div>
            </div>
        </div>
    </div>
</div>
<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Modulo</h4>
            </div>
            <!-- Form inside modal -->
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_module" value="0" />
                <div class="modal-body with-padding">
                    <div class="form-group">
                        <label> <i class="icon-spell-check"> </i>Módulo:</label>
                        <select data-placeholder="Seleccionar Modulo..." class="select-full" name="id_parent_module">
                        </select>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label"> <i class="icon-spell-check"> </i>Nombre</label>
                        <input type="text" placeholder="Nombre" class="form-control" name="name">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label"> <i class="icon-spell-check"></i> Nombre ID </i></label>
                        <input type="text" placeholder="Nombre" class="form-control" name="name_key">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label"> <i class="icon-spell-check"></i> Descripción </label>
                        <input type="text" placeholder="Descripcion" class="form-control" name="description">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback view_icon_class">
                        <label class="control-label"> 
                            <i class="icon-icon"></i> Nombre Icon-Class <button class="btn btn-success btn-xs" name="consultarIconClass" type="button"><i class="icon-search2"></i> Consular</button>
                        </label>
                        <input type="text" placeholder="Icon Class" class="form-control" name="id_icon">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="block-inner">
                            <label class="checkbox-inline checkbox-primary">
                                Activo?
                                <div class="checker">
                                    <span class="checked">
                                        <input type="checkbox" name="isActive" class="styled">
                                    </span>
                                </div>

                            </label>
                            <label class="checkbox-inline checkbox-primary">
                                Administrador?
                                <div class="checker">
                                    <span class="checked">
                                        <input type="checkbox" name="isAdmin" class="styled">
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-permission"><i class="icon-lock"></i> Permisos</a></li>
                            <!--<li class=""><a data-toggle="tab" href="#tab-transactions"><i class="icon-transmission"></i> Transacciones</a></li>-->
                        </ul>
                        <div class="tab-content">
                            <div id="tab-permission" class="tab-pane fade in active">
                                <div class="panel panel-default">
                                    <ul class="panel-toolbar">
                                        <li><a title="" class="action-popup-new-permission" href="javascript:;"><i class="icon-plus-circle"></i> Nuevo</a></li>
                                    </ul>
                                    <div class="table pre-scrollable">
                                        <table class="table table-striped table-bordered data-permisions" name="permissions">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Nombre ID</th>
                                                    <th>Descripcion</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div id="tab-transactions" class="tab-pane fade in">
                                                            <div class="panel panel-default">
                                                                <ul class="panel-toolbar">
                                                                    <li><a title="" class="action-popup-new-transaction" href="javascript:;"><i class="icon-plus-circle"></i> Nuevo</a></li>
                                                                </ul>
                                                                <div class="table pre-scrollable">
                                                                    <table class="table table-striped table-bordered data-transaction">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Nombre</th>
                                                                                <th>Nombre ID</th>
                                                                                <th>Descripcion</th>
                                                                                <th>Opciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>-->
                        </div>
                    </div>

                </div>
            </form>
            <div class="modal-footer">
                <div class="col-xs-4">
                    <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span>Espere...</span></div>
                </div>
                <div class="col-xs-8">
                    <button type="submit" class="btn btn-success action-save" data-loading-text="<i class='icon-clock spin'></i>Guardando..."><i class="icon-disk"></i>Guardar</button>
                    <button type="button" class="btn btn-primary action-edit"><i class="icon-pencil3"></i>Editar</button>
                    <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form modal Permission -->
<div id="form_modal_permission" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span></span> Permiso</h4>
            </div>
            <!-- Form inside modal -->
            <form action="javascript:;" role="form">
                <input type="hidden" name="permission_id" value="0" />
                <div class="modal-body with-padding">
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Nombre</label>
                        <input type="text" placeholder="Nombre" class="form-control" name="permission_name">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><i class="icon-spell-check"></i> Nombre ID</label>
                        <input type="text" placeholder="Nombre ID" class="form-control" name="permission_name_key">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label> <i class="icon-spell-check"></i> Descripción</label>
                        <input type="text" placeholder="Descripcion" class="form-control" name="permission_description">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-success action-add"><i class="icon-checkmark-circle2"></i>Aceptar</button>
                        <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form modal Icon Class -->
<div id="form_modal_icon" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-paragraph-justify2"></i><span></span> Icon Classes</h4>
            </div>

            <div class="panel-body">
                <div class="content-icon-class"></div>
            </div>

        </div>
        <div class="modal-footer">
            <div class="col-xs-12">
                <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="el-templates" style="display:none;">
    <?php // ======================================================== ?>
    <?php // ======================================================== ?>
    <div element="table-permission-row"><table><tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="table-controls">
                            <a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit-permission" href="javascript:;" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
                            <a title="" class="btn btn-danger btn-icon btn-xs tip dt-action-remove-permission" href="javascript:;" data-original-title="Edit entry"><i class="icon-remove"></i></a>
                        </div>
                    </td>
                </tr>
            </tbody></table></div>
    <?php // ======================================================== ?>
    <?php // ======================================================== ?>
    <div element="table-permission-row-actions">
        <div class="table-controls">
            <a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-view" href="javascript:;" data-original-title="Edit entry"><i class="icon-search3"></i></a>
            <a title="" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" href="javascript:;" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
        </div>
    </div>
    <?php // ======================================================== ?>
    <?php // ======================================================== ?>
    <div element="panel-module">
        <div class="panel panel-info">
            <input type="hidden" name="id_module" value="<?php //echo $eModule_Parent->id;               ?>" />
            <div class="panel-heading">
                <h6 class="panel-title"> <?php //echo $eModule_Parent->name;               ?></h6>
                <span class="pull-right label label-primary sortable-module-handle"><i class="icon-arrow4"></i></span>
                <div class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                        <li><a href="javascript:void(0);" action="view-module"><i class="icon-search3"></i> Ver</a></li>
                        <li><a href="javascript:void(0);" action="edit-module"><i class="icon-pencil"></i> Editar</a></li>                        
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Nombre</th>
                            <th>Nombre ID</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-submodule">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div element="panel-module-table-tr">
        <table>
            <tbody>
                <tr>
                    <td><span class="pull-right label label-primary sortable-submodule-handle"><i class="icon-arrow4"></i></span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="table-controls">
                            <a data-original-title="Edit entry" href="javascript:;" action="action-view" class="btn btn-primary btn-icon btn-xs tip dt-action-view" title=""><i class="icon-search3"></i></a>
                            <a data-original-title="Edit entry" href="javascript:;" action="action-edit" class="btn btn-primary btn-icon btn-xs tip dt-action-edit" title=""><i class="icon-pencil"></i></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php // ======================================================== ?>
    <?php // ======================================================== ?>
    <div element="table-rol-row">
        <table>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <input type="checkbox" class="styled" checked="checked">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>