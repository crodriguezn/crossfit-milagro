<?php
/* @var $eProfile eProfile */
?>
<script src="<?php echo site_url('app/permissions/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-user4"></i> Administración de Permisos</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Seguridad</a></li>
        <li>Profile</li>
        <li class="active">Permisos</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<form action="javascript:;"  role="form" name="listing">
    <input type="hidden" name="id_profile" value="<?php echo $eProfile->id ?>">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-accessibility2"></i> Listado de Permisos de <?php echo $eProfile->name ?>
            </h6>
            <div class="ControlsBottom">
                <button type="submit" class="pull-right btn btn-success action-save"><i class="icon-disk"></i>Guardar</button>
                <button type="button" class="pull-right btn btn-primary action-edit"><i class="icon-pencil3"></i>Editar</button>
                <button type="button" class="pull-right btn btn-danger action-close"><i class="icon-cancel-circle2"></i>Cancelar</button>
            </div>
        </div>
        <div class="panel-body">
            <div id="form-loading" class="loading" style="text-align:left;">
                <img src="resources/img/loading.gif" /> <span>Espere...</span>
            </div>
            <div class="datatable">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 30%">Módulo</th>
                            <th style="width: 30%">Submodulos</th>
                            <th style="width: 40%">Permisos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($arrModuleResult)) { ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="checkbox-info">
                                            <input type="checkbox" name="id_permission_all" class="styled"> 
                                        </label>
                                        Marcar/Desmarcar Todos los Permisos
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($arrModuleResult as $module) { ?>
                            <tr>
                                <td>
                                    <?php echo $module->name; ?>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <?php foreach ($module->_permissions as $permission) { ?>
                                        <div class="checkbox">
                                            <label class="checkbox-success">
                                                <?php $isChecked = in_array($permission->id, $arrProfilePermissionResult); ?>
                                                <input type="checkbox" name="id_permissions[]" class="styled" <?php echo $isChecked ? 'checked' : ''; ?> _id_permission="<?php echo $permission->id; ?>"> 
                                            </label>
                                            <?php echo $permission->description; ?>
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php foreach ($module->_submodules as $submodule) { ?>
                                <tr>
                                    <td>&nbsp; <i class="icon-minus"></i></td>
                                    <td>
                                        <?php echo $submodule->name; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($submodule->_permissions as $subpermission) { ?>
                                            <div class="checkbox">
                                                <label class="checkbox-success">
                                                    <?php $isChecked = in_array($subpermission->id, $arrProfilePermissionResult); ?>
                                                    <input type="checkbox" name="id_permissions[]" class="styled" <?php echo $isChecked ? 'checked' : ''; ?> _id_permission="<?php echo $subpermission->id; ?>"> 
                                                </label>
                                                <?php echo $subpermission->description; ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>