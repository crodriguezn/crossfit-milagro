<script src="public/reporte_resumen/mvcjs/"></script>

<br>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:;">Reporte</a></li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
</div>


<!-- Basic inputs -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-bubble4"></i> Resumen de cámaras</h6>
    </div>
    <div class="panel-body">
        <form id="frm" role="form" action="javascript:;">
<!--            <div class="alert alert-warning fade in block-inner">
                El rango de fecha maxima no debe ser mayor a dos semanas para que el tiempo de respuesta sea rapido 
            </div>-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label> Tipo de Reporte:</label>
                        <select name="rpte_tipo" data-placeholder="NO APLICA" class="select-full select-search" tabindex="0">
                            <?php
                            foreach ($cboReporte as $key => $dataRpte) {
                                ?>
                                <option value="<?php echo $dataRpte['code'] ?>"><?php echo $dataRpte['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
                <div class="col-md-6 view_grupo">
                    <div class="form-group has-feedback">
                        <label> Grupo de Camaras: </label>
                        <select name="rpte_grupo" data-placeholder="Buscar Grupos de camras" class="select-search" tabindex="2">                                   
                            <?php
//                            foreach ($cboGrupo as $key => $dataRpteGrupo) {
                            ?>
                                <!--<option value="<?php echo $dataRpteGrupo['code'] ?>"><?php echo $dataRpteGrupo['name'] ?></option>-->
                            <?php
//                            }
                            ?>
                        </select>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
            </div>
            <div class="row view_fecha">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label>Fecha</label>
                        <div class="row">
                            <div class="col-lg-4">
                                <select name="year" data-placeholder="" class="select-full select-search" tabindex="0">
                                    <?php
                                    foreach ($cboYear as $Year) {
                                        ?>
                                        <option value="<?php echo $Year ?>" <?php echo $Year == date('Y') ? 'selected' : '' ?>>
                                            <?php echo $Year ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block">AÑO</span>
                            </div>
                            <div class="col-lg-8">
                                <select name="month" data-placeholder="" class="select-full select-search" tabindex="0">
                                    <?php
                                    foreach ($cboMonth as $Month) {
                                        ?>
                                        <option value="<?php echo $Month['code'] ?>" <?php echo $Month['code'] == date('m') ? 'selected' : '' ?>>
                                            <?php echo $Month['name'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block">MES</span>
                            </div>
                        </div>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>

            </div>
            <div class="row view_range_fecha">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label>Fecha inicio</label>
                        <input type="text" name="date_begin" title="9999-99-99" data-trigger="focus" data-toggle="tooltip" class="form-control tip" data-mask="9999-99-99" />
                        <span class="help-block">AÑO-MES-DÍA</span>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback">

                        <label>Fecha fin</label>
                        <input type="text" name="date_end" title="9999-99-99" data-trigger="focus" data-toggle="tooltip" class="form-control tip" data-mask="9999-99-99" />
                        <span class="help-block">AÑO-MES-DÍA</span>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-3">
                        <select name="rpte_t_descarga" class="select-full" tabindex="0">
                            <?php
                            foreach ($cboTPrint as $key => $data) {
                                ?>
                                <option value="<?php echo $data['code'] ?>"><?php echo $data['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success action-desacargar" type="submit"><i class="icon-file-excel"></i>Descargar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- /spinner -->