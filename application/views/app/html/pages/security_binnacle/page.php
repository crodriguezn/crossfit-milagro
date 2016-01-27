<script src="<?php echo site_url('app/security_binnacle/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-history"></i> Administración de Bitacora</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Seguridad</a></li>
        <li class="active">Bitacora</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table2"></i> Listado de Bitacora</h6>
    </div>
    <div class="panel-body">
        <form action="javascript:;" role="form">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group has-feedback">
                        <label>Acciones: </label>
                        <select class="clear-results" multiple="multiple" name="accion">
                            <?php foreach ($combo_action as $option) { ?>
                                <option value="<?php echo $option['id'] ?>" selected="selected" ><?php echo $option['text'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="help-block">Campos de acción</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>Fecha Inicio: </label>
                    <input type="text" name="date_begin" value="<?php echo date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d')))) ?>" placeholder="YYYY-MM-DD" data-mask="9999-99-99" class="form-control">
                    <span class="help-block">Formato de Fecha "AÑO-MES-DÍA"</span>
                </div>
                <div class="col-md-4">
                    <label>Fecha Fin: </label> 
                    <input type="text" name="date_end" value="<?php echo date('Y-m-d') ?>" placeholder="YYYY-MM-DD" data-mask="9999-99-99" class="form-control">
                    <span class="help-block">Formato de Fecha "AÑO-MES-DÍA"</span>
                </div>
            </div>

            <div class="datatable">
                <table class="table">
                    <thead>
                        <tr>

                            <th style="text-align: center">Tipo</th>
                            <th style="text-align: center">Usuario</th>
                            <th style="text-align: center">Fecha</th>
                            <th style="text-align: center">IP</th>
                            <th style="text-align: center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> Bitacora</h4>
            </div>
            <!-- Form inside modal -->
            <form action="javascript:;" role="form">
                <input type="hidden" name="id_binnacle" value="0" />
                <div class="modal-body with-padding">
                    <!-- Task -->
                    <div class="block task task-low">
                        <div class="row with-padding">
                            <div class="col-sm-9">
                                <div class="task-description">
                                    <a href="javascript:;" id="url">Loading.... </a>
                                    <i id="username">Loading.... </i>
                                    <span>
                                        <div class="form-group">
                                            <textarea style="width: 100%; height: 154px; resize: none" rows="5" cols="5" class="elastic form-control" id="info" placeholder="Loading.... "></textarea>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="task-info">
                                    <span id="date_time">Loading.... </span>
                                    <span id="action">Loading.... </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-left">
                                <span id="time">Loading.... </span>
                            </div>
                        </div>
                    </div>
                    <!-- /task -->
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