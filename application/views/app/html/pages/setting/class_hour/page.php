<script src="app/setting_class_hour/mvcjs"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Mantenimiento de Horario de Clases</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Mantenimiento</a></li>
        <li class="active">Horario de Clases</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-clock2"></i> Listado de Horarios de Clases</h6>
        <!--<span class="label label-danger pull-right">+289</span>--> 
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
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center">Hora Inicio</th>
                        <th style="text-align: center">Hora Final</th>
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

<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-clock4"></i><span></span> Horario de Clase</h4>
            </div>
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_form" value="0" />
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