<script src="<?php echo site_url('app/system_setting_param/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-user4"></i> Administración de Parametros del Sistema</h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Sistema</a></li>
        <li class="active">Configuración de Parametros</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form enctype="multipart/form-data" class="form-horizontal" role="form" name="setting_param" action="javascript:;">    
            <!--<form action="javascript:;" role="form" name="company">-->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">Nombre del Sistema: <span class="mandatory">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name_system" placeholder="Nombre del Sistema" />
                            <span class="label label-block label-danger text-left">Centered label</span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">Nombre Corto del Sistema: <span class="mandatory">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name_key_system" placeholder="Nombre Corto del Sistema" />
                            <span class="label label-block label-danger text-left">Centered label</span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">Tiempo de Inactividad Minima: <span class="mandatory">*</span></label>
                        <div class="col-sm-8">
                            <select name="session_time_limit_min" class="select-full select-search">
                                <?php
                                if (!empty($arrTime)) {
                                    foreach ($arrTime as $time) {
                                        ?>
                                        <option value="<?php echo $time['code'] ?>" <?php echo (($time['code'] == 60) ? 'selected="selected"' : '') ?>><?php echo $time['name'] ?></option>
                                        <?php
                                    }
                                    ?>

                                <?php } ?>
                            </select>
                            <!--<input type="text" class="form-control" name="session_time_limit_min" placeholder="Tiempo de Inactividad Minima" />-->
                            <span class="label label-block label-danger text-left">Centered label</span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">Tiempo de Inactividad Maxima: <span class="mandatory">*</span></label>
                        <div class="col-sm-8">
                            <select name="session_time_limit_max" class="select-full select-search">
                                <?php
                                if (!empty($arrTime)) {
                                    foreach ($arrTime as $time) {
                                        ?>
                                        <option value="<?php echo $time['code'] ?>" <?php echo (($time['code'] == 60) ? 'selected="selected"' : '') ?>><?php echo $time['name'] ?></option>
                                        <?php
                                    }
                                    ?>

                                <?php } ?>
                            </select>
                            <!--<input type="text" class="form-control" name="session_time_limit_max" placeholder="Tiempo de Inactividad Maxima" />-->
                            <span class="label label-block label-danger text-left">Centered label</span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">¿Guardar Bitacora en Base de Dato?</label>
                        <div class="col-sm-8">
                            <label class="checkbox-inline checkbox-success">
                                <input type="checkbox" class="styled form-control" checked="checked" name="isSaveBinnacle">
                            </label>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label text-right">Logo Sistema: <span class="mandatory">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" class="styled form-control" name="logo">
                            <span class="help-block">Formato Permitido: "PNG" Max file size 5Mb</span>
                            <span class="label label-block label-danger text-left">Centered label</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="col-sm-3 text-left">
                            <div id="form-loading" class="loading" style="text-align:left;"><img src="resources/img/loading.gif" /> <span class="text">Espere...</span></div>
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
        <div class="panel panel-default panel-logo">
            <div class="panel-heading">
                <h6 class="panel-title">Logo del Sistema</h6>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        <img class="styled logo-preview" src="resources/img/nologo.png" width="100%" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
