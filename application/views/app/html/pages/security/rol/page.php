<script src="app/security_rol/mvcjs"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-user4"></i> Administración de Roles</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Seguridad</a></li>
        <li class="active">Rol</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table2"></i> Listado de Roles</h6>
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
        <div class="alert alert-info fade in block-inner">
            <i class="icon-info"></i> Roles usados para todas las sucursales.
        </div>
        <div class="datatable">
            <table class="table" >
                <thead>
                    <tr>
                        <th style="text-align: center">Nombre</th>
                        <th style="text-align: center">Nombre ID</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Rol</h4>
            </div>
            <!-- Form inside modal -->
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_form" value="0" />
                <input type="hidden" name="id_rol" value="0" />
                <div class="modal-body with-padding">
                    <div class="form-group has-feedback">
                        <label> <i class="icon-spell-check"></i> Nombre</label>
                        <input type="text" placeholder="Nombre" class="form-control" name="name">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label> <i class="icon-spell-check"></i> Nombre ID</label>
                        <input type="text" placeholder="Nombre ID" class="form-control" name="name_key">
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title"><i class="icon-page-break2"></i> Listado Módulos/SubMódulos</h6>
                        </div>
                        <div class="table pre-scrollable">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox">
                                                <label class="checkbox-info">
                                                    <input type="checkbox" name="id_modules_all" class="styled"> 
                                                </label>
                                            </div>
                                        </th>
                                        <th>Módulo</th>
                                        <th>Submodulos</th>
                                        <th>Permisos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($arrModulesPermissions as $module) { ?>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label class="checkbox-success">
                                                        <input type="checkbox" name="id_modules[]" class="styled" _id_module="<?php echo $module->id; ?>"> 
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $module->name; ?>
                                            </td>
                                            <td>&nbsp;</td>
                                            <td>
                                                <ul>
                                                    <?php foreach ($module->_permissions as $permission) { ?>
                                                        <li>
                                                            <?php echo $permission->description; ?>
                                                        </li>    
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php foreach ($module->_submodules as $submodule) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label class="checkbox-success">
                                                            <input type="checkbox" name="id_modules[]" class="styled" _id_module="<?php echo $submodule->id; ?>"> 
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>&nbsp; <i class="icon-minus"></i></td>
                                                <td>
                                                    <?php echo $submodule->name; ?>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <?php foreach ($submodule->_permissions as $subpermission) { ?>
                                                            <li>
                                                                <?php echo $subpermission->description; ?>
                                                            </li>    
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
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