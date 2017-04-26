<script src="<?php echo site_url('app/dashboard/mvcjs'); ?>"></script>
<div class="page-header">
    <div class="page-title">
        <h3>Panel de Control</h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="javascript:void(0);">Inicio</a></li>
        <li class="active">Dashboard</li>
    </ul>
    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
            <i class="icon-menu2"></i>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="thumbnail">
                <div class="thumb">
                    <img src="<?php echo base_url("resources/img/10155775_317952871729932_9210782196300188023_n.jpg"); ?>" style="margin: 2px;float: right;">
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (Helper_App_Session::isSuperAdminProfile() || Helper_App_Session::isAdminProfile()) { ?>
    <ul class="info-blocks">
        <li class="bg-primary">
            <div class="top-info"><a href="<?php echo site_url('app/setting_customer_crossfit'); ?>">Mantenimiento</a><small>Clientes Crossfiteros</small></div>
            <a href="<?php echo site_url('app/setting_customer_crossfit'); ?>"><i class="icon-users"></i></a><span class="bottom-info bg-danger">No updates</span></li>
        <li class="bg-success">
            <div class="top-info"><a href="<?php echo site_url('app/setting_class_schedule'); ?>">Mantenimiento</a><small>Horario de Clases</small></div>
            <a href="<?php echo site_url('app/setting_class_schedule'); ?>"><i class="icon-clock4"></i></a><span class="bottom-info bg-primary">No updates</span></li>
        <li class="bg-danger">
            <div class="top-info"><a href="<?php echo site_url('app/management_class_scheduling'); ?>">Gestión</a><small>Programación de Clases</small></div>
            <a href="<?php echo site_url('app/management_class_scheduling'); ?>"><i class="icon-calendar2"></i></a><span class="bottom-info bg-primary">No updates</span></li>
        <li class="bg-info">
            <div class="top-info"><a href="#">My messages</a><small>messages history</small></div>
            <a href="#"><i class="icon-bubbles3"></i></a><span class="bottom-info bg-primary">24 new messages</span></li>
        <li class="bg-warning">
            <div class="top-info"><a href="#">Orders history</a><small>purchases statistics</small></div>
            <a href="#"><i class="icon-cart2"></i></a><span class="bottom-info bg-primary">17 new orders</span></li>
        <li class="bg-primary">
            <div class="top-info"><a href="#">Invoices stats</a><small>invoices archive</small></div>
            <a href="#"><i class="icon-coin"></i></a><span class="bottom-info bg-danger">9 new invoices</span></li>
    </ul>
    <?php
}
?>
<!-- Task detailed -->
<div class="row">
    <div class="col-lg-8">
        <!-- Callout -->
        <div class="callout callout-info fade in">
            <h5>Bienvenido(a) al Sistema</h5>
            <p>El administrador le desea suerte en sus funciones!.</p>
        </div>
        <!-- /callout -->
        <div class="block">
            <ul class="statistics">
                <li>
                    <div class="statistics-info">
                        <a href="javascript:void(0);" title="" class="bg-info">
                            <i class="icon-cart-plus"></i>
                        </a>
                        <strong>$562</strong> 
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div>
                    </div>
                    <span>Egresos Compras</span>
                </li>
                <li>
                    <div class="statistics-info">
                        <a href="javascript:void(0);" title="" class="bg-success">
                            <i class="icon-coin"></i>
                        </a>
                        <strong>$45,360</strong> 
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div>
                    </div>
                    <span>Ingresos Ventas</span> 
                </li>
                <li>
                    <div class="statistics-info"> 
                        <a href="javascript:void(0);" title="" class="bg-primary">
                            <i class="icon-user-plus2"></i>
                        </a> 
                        <strong>1500</strong> 
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div>
                    </div>
                    <span>Total Usuarios</span> 
                </li>
                <li>
                    <div class="statistics-info"> 
                        <a href="javascript:void(0);" title="" class="bg-warning">
                            <i class="icon-people"></i>
                        </a> 
                        <strong>36,290</strong> 
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div>
                    </div>
                    <span>Total Clientes</span> 
                </li>
                <li>
                    <div class="statistics-info"> 
                        <a href="javascript:void(0);" title="" class="bg-primary">
                            <i class="icon-basket"></i>
                        </a> 
                        <strong>36,290</strong> 
                    </div>
                    <div class="progress progress-micro">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div>
                    </div>
                    <span>Total Articulos</span> 
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="last-activity">
                    <div class="block">
                        <h6 class="heading-hr"><i class="icon-file"></i> Actividad reciente</h6>
                        <ul class="media-list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Timer -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-clock"></i> Fecha y Hora</h6>
            </div>
            <div class="panel-body">
                <ul class="timer-weekdays">
                    <li <?php echo date('w') == '1' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '1' ? 'danger' : 'default' ?>">Lu</a>
                    </li>
                    <li>
                    <li <?php echo date('w') == '2' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '2' ? 'danger' : 'default' ?>">Ma</a>
                    </li>
                    <li>
                    <li <?php echo date('w') == '3' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '3' ? 'danger' : 'default' ?>">Mi</a>
                    </li>
                    <li>
                    <li <?php echo date('w') == '4' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '4' ? 'danger' : 'default' ?>">Ju</a>
                    </li>
                    <li>
                    <li <?php echo date('w') == '5' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '5' ? 'danger' : 'default' ?>">Vi</a>
                    </li>
                    <li>
                    <li <?php echo date('w') == '6' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '6' ? 'danger' : 'default' ?>">Sa</a>
                    </li>
                    <li <?php echo date('w') == 'Sat' ? 'class="active"' : '' ?>>
                        <a href="javascript:void(0);" class="label label-<?php echo date('w') == '0' ? 'danger' : 'default' ?>">Do</a>
                    </li>
                    <li>
                </ul>
                <ul class="timer">
                    <li> 
                        <div id="hours">00</div> 
                        <span>hours</span> 
                    </li>
                    <li class="dots">:</li>
                    <li> 
                        <div id="minutes">00</div> 
                        <span>minutes</span> 
                    </li>
                    <li class="dots">:</li>
                    <li> 
                        <div id="seconds">00</div> 
                        <span>seconds</span> 
                    </li>
                </ul>
            </div>
            <div class="panel-footer">
                <div class="pull-left">
                    <span>
                        <i class="icon-checkmark3"></i> <?php echo Helper_Fecha::setFomratDate(date('Y-m-d'), true); ?>
                    </span>
                </div>
            </div>
        </div>
        <!-- /timer -->

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-list"></i> Recomendaciones</h6>
            </div>
            <div class="panel-body">
                <div class="block"> <span class="subtitle">Antes</span>
                    <div class="well">
                        <ul class="square">
                            <li>Puntualidad.</li>
                            <li>Realiza un buen calentamiento.</li>
                            <li>Hidrátate!!</li>
                            <li>Come ligero, pero come algo.</li>
                            <li>Trae una toalla, sudarás.</li>
                        </ul>
                    </div>
                </div>
                <div class="block"> <span class="subtitle">Durante</span>
                    <div class="well">
                        <ul class="square">
                            <li>Escucha a tu entrenador, si habla, tu callas.</li>
                            <li>No tirar kettlebells, discos de 5 y barras.</li>
                            <li>Hidrátate!!</li>
                            <li>Conoce tus límites (RMs).</li>
                            <li>Si deterioras la técnica no pongas más peso.</li>
                        </ul>
                    </div>
                </div>
                <div class="block"> <span class="subtitle">Después</span>
                    <div class="well">
                        <ul class="square">
                            <li>Realiza un buen estiramiento.</li>
                            <li>Recoge el material usado.</li>
                            <li>Hidrátate!!</li>
                            <li>Realiza un buen estiramiento.</li>
                            <li>Recuperate!! come algo de fruta.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <!--    <div class="row">
            <div class="col-md-12">
                <ul class="info-blocks">
                    <li class="bg-success">
                        <div class="top-info">
                            <a href="#">Ir a Ventas</a>
                        </div>
                        <a href="<?php echo site_url('app/'); ?>">
                            <i class="icon-coin"></i>
                        </a>
                        
                        <span class="bottom-info bg-primary">Ingresos Ventas <strong>12,476</strong></span>
                         
                    </li>
                    <li class="bg-warning">
                        <div class="top-info"><a href="#">Ir a Compras</a></div>
                        <a href="<?php echo site_url('app/'); ?>">
                            <i class="icon-cart4"></i>
                        </a>
                        <span class="bottom-info bg-primary">Egresos Compras</span>
                    </li>
                    <li class="bg-info">
                        <div class="top-info">
                            <a href="#">Ir a Usuarios</a>
                        </div>
                        <a href="<?php echo site_url('app/'); ?>">
                            <i class="icon-user-plus"></i>
                        </a>
                        <span class="bottom-info bg-primary">Usuarios Registrados</span>
                    </li>
                </ul>
            </div>
        </div>-->


</div>

<!-- /task detailed -->
<div element="last-activity" class="hidden">
    <li class="media">
        <a class="pull-left" href="javascript:void(0);">
            <img class="media-object" src="" alt="">
        </a>
        <div class="media-body">
            <div class="clearfix">
                <a href="javascript:void(0);" class="media-heading"></a>
                <span class="media-notice"></span>
            </div>
            <p>QUI IP</p>
            <!--Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.-->
        </div>
    </li>
</div>

<script type="text/javascript">
    setInterval('digiClock_Controller.digiClock()', 1000);
    setInterval('lastActivity_Controller.eventLoadActivity()', 300000);
</script>
