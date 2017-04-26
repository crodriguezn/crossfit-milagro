<?php
/*
 * @autor Carlos Luis Rodriguez Nieto (taylorluis93@gmail.com)
 * @date 17-abr-2017
 * @time 22:31:13
 * @link http://luis-rodriguez-ec.herokuapp.com/site/index
 */
?>

<script src="<?php echo site_url('app/management_calendar/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Gestión de Calendario</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Gestión</a></li>
        <li class="active">Calendario</li>
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
                <h4 class="modal-title"><i class="icon-clock4"></i><span></span> Horario de Clase</h4>
            </div>
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_schedule" value="0" />
                <div class="modal-body with-padding">
                    <div class="form-group has-feedback">
                        <label> <i class="icon-spell-check"></i> Hora Inicio</label>
                        <input type="text" placeholder="Hora Inicio" class="form-control" name="start_hour">
                        <span class="help-block"> 00:00 -24 horas-</span>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label> <i class="icon-spell-check"></i> Hora Final</label>
                        <input type="text" placeholder="Hora Final" class="form-control" name="final_hour">
                        <span class="help-block"> 00:00 -24 horas-</span>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                    <div class="form-group has-feedback">
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
                        <button type="submit" class="btn btn-success action-save"><i class="icon-disk"></i>Guardar</button>
                        <button type="button" class="btn btn-primary action-edit"><i class="icon-pencil3"></i>Editar</button>
                        <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>