<?php
/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 17-abr-2017
 * @time 22:31:13
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */
?>

<script src="<?php echo site_url('app/management_class_scheduling/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Gestión de Programación de Clases</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Gestión</a></li>
        <li class="active">Programación de Clases</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>

<!-- Calendar inside panel body -->
<div class="panel panel-primary">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-calendar2"></i> Agenda de Actividades</h6>
        <div class="dropdown pull-right"> <a href="#" class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown"> <i class="icon-cog3"></i> <b class="caret"></b> </a>
            <ul class="dropdown-menu icons-right dropdown-menu-right">
                <li><a href="javascript:;" action="action-refresh"><i class="icon-spinner7"></i> Actualizar</a></li>
                <li><a href="javascript:;" action="action-print"><i class="icon-print2"></i> Imprimir</a></li>
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
        <div class="fullcalendar"></div>
    </div>
</div>
<!-- /calendar inside panel body -->

<!-- Form modal view informacion -->
<div id="form_modal_view_info" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-calendar4"></i><span></span> Información de la Actividad</h4>
            </div>
            <!-- Form inside modal -->
            <form class="form-horizontal" action="#" role="form">
                <div class="modal-body with-padding">
                    <!-- Static control -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right"><strong>Titulo:</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static activity-titulo"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right"><strong>Fecha:</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static activity-fecha"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right"><strong>Inicio:</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static activity-inicio"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right"><strong>Fin:</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static activity-fin"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right"><strong>Entrenador:</strong></label>
                                <div class="col-sm-9">
                                    <p class="form-control-static activity-entrenador"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /static control -->
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form modal nuevo -->
<div id="form_modal_new_activity" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-calendar"></i><span></span> Programación de Clases</h4>
            </div>
            <form action="javascript:;" role="form" class="">
                <input type="hidden" name="id_form" value="0" />
                <input type="hidden" name="id_schedule" value="0" />
                <div class="modal-body with-padding">

                    <div class="alert alert-success fade in block-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Aquellos campos que contenga este símbolo/icono <span><i class="icon-spell-check"></i></span> son campos obligatorios
                    </div>
                    <div class="form-group has-feedback">
                        <div class="row">
                            <div class="col-sm-6 class-error">
                                <label class="control-label"> <i class="icon-spell-check"> </i> Titulo:</label>
                                <input type="text" placeholder="Titulo" class="form-control" name="name">
                                <span class="label label-danger label-block text-center">Left aligned label</span>
                            </div>
                            <div class="col-sm-3 class-error">
                                <label class="control-label"> <i class="icon-spell-check"></i> Fecha:</label>
                                <input class="form-control" type="text" name="start_day" placeholder="<?php echo date('Y-m-d') ?>">
                                <span class="label label-danger label-block text-center">Left aligned label</span>
                            </div>
                            <div class="col-sm-3 class-error">
                                <label class="control-label">&nbsp;</label>
                                <div class="block-inner">
                                    <label class="checkbox-inline checkbox-primary">
                                        Activo?
                                        <div class="checker">
                                            <span class="checked">
                                                <input type="checkbox" name="isActive" class="styled">
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="datatable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Coach</th>
                                    <th class="text-center">Inicio</th>
                                    <th class="text-center">Fin</th>
                                    <th class="text-center">
                                        <div class="checkbox">
                                            <label class="checkbox-info">
                                                <input type="checkbox" name="id_hour_all" class="styled"> 
                                            </label>
                                            <!--Marcar/Desmarcar-->
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hours as $eClassHour) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <select data-placeholder="Seleccionar el coach" class="select-full select-search" name="id_coach" _id_coach="<?php echo $eClassHour['id_hour']; ?>">
                                                <?php foreach ($coachs as $coach) { ?>
                                                    <option value="<?php echo $coach['id_coach'] ?>" <?php echo ($eClassHour['id_coach']==$coach['id_coach']) ? 'selected="selected"':'' ?>><?php echo $coach['coach'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $eClassHour['start_hour']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $eClassHour['final_hour']; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="checkbox">
                                                <label class="checkbox-success">
                                                    <input type="checkbox" name="id_hours[]" class="styled" _id_hour="<?php echo $eClassHour['id_hour']; ?>"> 
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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