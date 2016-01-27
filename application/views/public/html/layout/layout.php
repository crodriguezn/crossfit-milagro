<?php
/* @var $eCompany eCompany */
/* @var $eCompanyBranch eCompanyBranch */
/* @var $eProfile eProfile */
/* @var $eUser eUser */
/* @var $ePerson ePerson */
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fundación Terminal Terrestre</title>
        <link rel="icon" href="<?php echo base_url("resources/img/favicon.ico"); ?>" type="image/x-icon"/>
        <link href="<?php echo $resources_path; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/londinium-theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/styles.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <!--<link type="text/css" rel="stylesheet" href="resources/css/custom.css">-->
        <script type="text/javascript" src="resources/js/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="resources/js/jqueryui/1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script type="text/javascript" src="resources/js/canvasloader/heartcode-canvasloader-min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/charts/sparkline.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/inputmask.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/autosize.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/inputlimit.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/listbox.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/multiselect.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/validate.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/tags.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/switch.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/form.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/uploader/plupload.full.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/uploader/plupload.queue.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/forms/wysihtml5/toolbar.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/fancybox.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/prettify.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/moment.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/jgrowl.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/interface/collapsible.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/application.js"></script>
        <script type="text/javascript" src="<?php echo site_url('public/js/core'); ?>"></script>
    <!--    <script type="text/javascript" src="<?php echo site_url('public/js/mvc/layout'); ?>"></script>-->
        <!-- NUMERIC -->
        <script type="text/javascript" src="resources/js/jquery.numeric.min.js"></script>
        <script type="text/javascript" src="resources/js/jquery.isloading.min.js"></script>
    <!--    <script type="text/javascript" src="app/js/load/login"></script>-->
        <style type="text/css">
            .isloading-wrapper.isloading-right{margin-left:10px;}
            .isloading-overlay{position:relative;text-align:center;}.isloading-overlay .isloading-wrapper{background:#FFFFFF;-webkit-border-radius:7px;-webkit-background-clip:padding-box;-moz-border-radius:7px;-moz-background-clip:padding;border-radius:7px;background-clip:padding-box;display:inline-block;margin:0 auto;padding:10px 20px;top:10%;z-index:9000;}
            .btn-group, .btn-group-vertical { width:100%; }
        </style>
        <?php if ($useIframe) { ?>
            <style type="text/css">
                .page-content { margin:0 !important; }
                .navbar-fixed { padding-top:0; }
                .panel { margin-bottom:0; }
            </style>
        <?php } ?>
    </head>
    <body class="navbar-fixed sidebar-wide cah-bg">

        <!-- Navbar -->
        <?php if (!$useIframe) { ?>
            <div class="navbar navbar-inverse navbar-fixed-top cah-bg-red" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo site_url('public/dashboard'); ?>"><?php echo 'Fundación Terminal Terrestre'//$eCompany->name;     ?></a>

                <!--        <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>-->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
                    <!--<button data-target="#navbar-sedes" data-toggle="collapse" class="navbar-toggle collapsed" type="button"><span class="sr-only">Toggle navigation</span><i class="icon-tree2"></i></button>-->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-sedes"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
                </div>

                <?php /* ?>
                  <ul class="nav navbar-nav collapse" id="navbar-menu">
                  <?php //=================================================================== ?>
                  <?php //=================================================================== ?>
                  <?php //print_r($arrMenu);
                  if( !empty($arrMenu) ) { foreach( $arrMenu as $menu ) {

                  ?>

                  <li class="dropdown"><a href="<?php echo current_url(); ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-screen2"></i> <span><?php echo $menu->name; ?></span> <b class="caret"></b></a>

                  <?php if( !empty($menu->_submodules) ) { ?>
                  <ul class="dropdown-menu dropdown-menu-right">
                  <?php
                  foreach( $menu->_submodules as $submenu )
                  {
                  $isActiveSubmenu = ( $controller_current == $submenu->name_key );
                  ?>
                  <li class="<?php if( $isActiveSubmenu ) { ?>active<?php } ?>"><a href="<?php echo site_url('app/'.$submenu->name_key); ?>"><?php echo $submenu->name; ?></a></li>
                  <?php   } ?>
                  </ul>
                  <?php } ?>
                  </li>
                  <?php } } ?>
                  <?php //=================================================================== ?>
                  <?php //=================================================================== ?>
                  </ul>
                  <?php */ ?>
                <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown"><img src="resources/assets/app/images/demo/users/user.png" alt=""><span><?php echo 'Administrador' ?></span><i class="caret"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right icons-right">
                            <li><a href="#" action="action-layout-password"><i class="icon-user"></i> Contraseña</a></li>
                            <li><a href="<?php //echo site_url('app/logout');     ?>"><i class="icon-exit"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php } ?>

        <!-- /navbar -->
        <!-- Page container -->
        <div class="page-container">
            <!-- Sidebar -->
            <?php if (!$useIframe) { ?>
                <div class="sidebar collapse">
                    <div class="sidebar-content">
                        <!-- User dropdown -->

                        <div class="user-menu dropdown cah-bg-yellow cah-color-black">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $resources_path; ?>/images/demo/users/user.png" alt="">
                                <div class="user-info"><?php echo 'Administrador'//$ePerson->name.' '.$ePerson->surname;     ?> <span><?php echo 'Administrador'//$eProfile->name;     ?></span></div>
                            </a>
                        </div>
                        <ul class="navigation">
                            <li class="<?php echo $controller_current == 'dashboard' ? 'active' : '' ?>">
                                <a href="<?php echo site_url('public/dashboard'); ?>">
                                    <span>INICIO</span> <i class="icon-screen2"></i>
                                </a>
                            </li>
                            <li class="<?php echo $controller_current == 'reporte_general' || $controller_current == 'reporte_resumen' || $controller_current == 'panel_control' ? 'active' : '' ?>">
                                <a href="#" class="expand" <?php if ($controller_current == 'reporte_general' || $controller_current == 'reporte_resumen' || $controller_current == 'panel_control') { ?>id="second-level"<?php } ?> >
                                    <span>Reportes</span> <i class="icon-grid"></i>
                                </a>
                                <ul>
                                    <li class="<?php echo $controller_current == 'reporte_general' ? 'active' : '' ?>">
                                        <a href="<?php echo site_url('public/reporte_general'); ?>">
                                            <span>General</span>
                                        </a>
                                    </li>
                                    <li class="<?php echo $controller_current == 'reporte_resumen' ? 'active' : '' ?>">
                                        <a href="<?php echo site_url('public/reporte_resumen'); ?>">
                                            <span>Resumen</span>
                                        </a>
                                    </li>
                                    <li class="<?php echo $controller_current == 'panel_control' ? 'active' : '' ?>">
                                        <a href="<?php echo site_url('public/panel_control'); ?>">
                                            <span>Panel de Control</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <div class="page-content">
                <?php if ($navegador['isSuccess']) { ?>
                    <div class="alert alert-warning fade in block-inner">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <i class="icon-cancel-circle"></i> <?php echo $navegador['message']; ?>
                    </div>
                <?php } ?>
                <?php if (!$useIframe) { ?>

                <?php } ?>
                <?php echo $content; ?>
                <?php if (!$useIframe) { ?>
                    <div class="footer clearfix">
                        <div class="pull-center">&copy; 2015 - <?php echo date('Y') + 1; ?> . Desarrollado por <a href="http://www.it-corp.com" target="_blank">It/Corp</a> </div>
            <!--            <div class="pull-right icons-group"> <a href="#"><i class="icon-screen2"></i></a> <a href="#"><i class="icon-balance"></i></a> <a href="#"><i class="icon-cog3"></i></a> </div>-->
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="modal fade" id="alert-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmacion</h4>
                    </div>
                    <div class="modal-body with-padding">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-success">Si</a>
                        <a href="javascript:;" class="btn btn-danger">No</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="layout-password-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Contraseña</h4>
                    </div>
                    <form action="javascript:;" role="form">
                        <input type="hidden" name="id_module" value="0" />
                        <div class="modal-body with-padding">
                            <div class="form-group has-feedback">
                                <label>Contraseña actual</label>
                                <input type="password" placeholder="Contraseña actual" class="form-control" name="password_current">
                                <i class="icon icon-checkmark3 form-control-feedback"></i>
                                <span class="label label-block label-danger text-left">Centered label</span>
                            </div>
                            <hr/>
                            <div class="form-group has-feedback">
                                <label>Nueva Contraseña</label>
                                <input type="password" placeholder="Nueva Contraseña" class="form-control" name="password_new">
                                <i class="icon icon-checkmark3 form-control-feedback"></i>
                                <span class="label label-block label-danger text-left">Centered label</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Repetir Contraseña</label>
                                <input type="password" placeholder="Repetir Contraseña" class="form-control" name="password_new_repeat">
                                <i class="icon icon-checkmark3 form-control-feedback"></i>
                                <span class="label label-block label-danger text-left">Centered label</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success action-save"><i class="icon-disk"></i>Guardar</button>
                            <button type="button" class="btn btn btn-warning action-close" data-dismiss="modal"><i class="icon-cancel-circle2"></i>Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            Core.init();
        </script>

    </body>
</html>