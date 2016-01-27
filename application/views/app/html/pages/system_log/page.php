<script src="<?php echo site_url('app/system_log/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3><i class="icon-user4"></i> Administración de Logs</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Sistema</a></li>
        <li class="active">Log</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table2"></i> Listado de Logs</h6>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-body"> 
                <div id="fileTreeDemo_2" class="sortable-file">--</div>
            </div>
        </div>
    </div>
</div>
<!-- Form modal -->
<div id="form_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-file6"></i><span></span> File <span class="name_file"></span></h4>
            </div>
            <div class="modal-body with-padding">
                <div class="form-group">
                    <textarea style="width: 100%; height: 354px; resize: none" rows="5" cols="5" class="elastic form-control text-justify file_text" id="info" placeholder="File Loading.... "></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-xs-8">
                    <div id="form-loading" class="loading" style="text-align:left;"><i class="icon-file-check"></i> &nbsp;  <span></span></div>
                </div>
                <div class="col-xs-4">
                    <button type="button" class="btn btn-danger action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>