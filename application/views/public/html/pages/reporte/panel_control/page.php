<script src="public/panel_control/mvcjs/"></script>

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
        <h6 class="panel-title"><i class="icon-bubble4"></i> Panel de Control</h6>
    </div>
    <div class="panel-body">
        <form id="frm" role="form" action="javascript:;" >
            <!--            <div class="alert alert-warning fade in block-inner">
                            El rango de fecha maxima no debe ser mayor a dos semanas para que el tiempo de respuesta sea rapido 
                        </div>-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label> Tipo de información:</label>
                        <select name="rpte_tipo_informacion" data-placeholder="NO APLICA" class="select-full select-search" tabindex="0">
                            <?php
                            foreach ($cboTipoInformacion as $key => $data) {
                                ?>
                                <option value="<?php echo $data['code'] ?>"><?php echo $data['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
                <div class="col-md-6 view_sub_informacion">
                    <div class="form-group has-feedback">
                        <label> Tipo de información:</label>
                        <select name="rpte_tipo_sub_informacion" data-placeholder="NO APLICA" class="select-full select-search" tabindex="0">
                            <?php
                            foreach ($cboTipoSubInformacion as $key => $data) {
                                ?>
                                <option value="<?php echo $data['code'] ?>"><?php echo $data['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <label>Seleccione el año, mes y día:</label>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group has-feedback">
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
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group has-feedback">
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
                        <div class="col-lg-3 view_day">
                            <div class="form-group has-feedback">
                                <select name="day" data-placeholder="" class="select-full select-search" tabindex="0">
                                </select>
                                <span class="help-block">DÍA</span>
                            </div>
                        </div>
                        <div class="col-lg-3 view_day_week">
                            <div class="form-group has-feedback">
                                <select name="day_week" data-placeholder="" class="select-full select-search" tabindex="0">
                                    <?php
                                    foreach ($cboDayWeek as $DayWeek) {
                                        ?>
                                        <option value="<?php echo $DayWeek['code'] ?>" <?php echo $DayWeek['code'] == date('m') ? 'selected' : '' ?>>
                                            <?php echo $DayWeek['name'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="help-block">DÍA</span>
                            </div>
                        </div>
                    </div>
                    <!--<span class="label label-block label-danger text-left">Centered label</span>-->
                </div>
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label> Seleccione área:</label>
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
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <select name="rpte_t_descarga" class="select-full" tabindex="0">
                            <?php
                            foreach ($cboTPrint as $key => $data) {
                                ?>
                                <option value="<?php echo $data['code'] ?>"><?php echo $data['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="label label-block label-danger text-left">Centered label</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <button class="btn btn-success action-desacargar" type="submit"><i class="icon-file-excel"></i>Descargar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- /spinner -->