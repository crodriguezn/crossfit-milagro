<?php /* @var $eAppVersion eAppVersion */ ?>
<script src="<?php echo site_url('app/system_db_back_up/mvcjs'); ?>"></script>
<br/>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Sistema</a></li>
        <li class="active">BackUp Data Base</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-home6"></i> DATA BASE</h6>
    </div>
    <div class="well" id="dataTableGeneral">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"> Generar BackUp</h6>
            </div>
            <div class="panel-body">    
                <div class="alert alert-dismissable fade in block-inner">
                    <i class="icon-database2"></i> Base de Datos Actual <span class="label label-warning"><?php echo $eAppVersion->name ?></span>
                </div>
                <form action="javascript:;" role="form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Acción: </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <select data-placeholder="" class="select-full" tabindex="2" name="accion">
                                        <option value="NO_DOWNLOAD" selected="selected">NO DOWNLOAD</option>
                                        <option value="DOWNLOAD">DOWNLOAD</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-success db-backup" type="button"><i class="icon-database2"></i> Generar BackUp</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>		