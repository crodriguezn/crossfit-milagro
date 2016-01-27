<?php
/* @var $eCompany eCompany */
/* @var $eCompanyBranch eCompanyBranch */
/* @var $eUser eUser */
/* @var $ePerson ePerson */
/* @var $eProfile eProfile */
/* @var $eAppVersion eAppVersion */
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $eCompany->name ?></title>
        <link rel="icon" href="<?php echo base_url("resources/img/favicon.ico"); ?>" type="image/x-icon"/>
        <link href="<?php echo $resources_path; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/londinium-theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/styles.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resources_path; ?>/css/jqueryFileTree.css" rel="stylesheet" type="text/css">
        <!--<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->
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
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/FileTree/jqueryFileTree.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/plugins/FileTree/jquery.easing.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $resources_path; ?>/js/application.js"></script>
        <script type="text/javascript" src="<?php echo site_url('app/js/core'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('app/js/mvc/layout'); ?>"></script>
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
    <body class="navbar-fixed sidebar-wide">
        <!-- Navbar -->
        <?php if (!$useIframe) { ?>
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo site_url('app/dashboard'); ?>">
                        <?php echo $eCompany->name_key; ?>
                    </a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar"><span class="sr-only">Toggle navigation</span><i class="icon-paragraph-justify2"></i></button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
                        <span class="sr-only">Toggle navigation</span><i class="icon-user"></i>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-roles">
                        <span class="sr-only">Toggle navigation</span><i class="icon-cabinet"></i>
                    </button>
                    <button type="button" class="navbar-toggle collapsed" data-target="#navbar-sedes" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span><i class="icon-direction"></i>
                    </button>
                </div>

                <form id="navbar-perfiles" role="form" class="navbar-form navbar-left collapse">
                    <div class="form-group">
                        <select class="select select2-offscreen cmb-roles">
                            <?php foreach ($combo_perfiles as $var) { ?>
                                <option <?php if ($var['selected']) { ?> selected="selected" <?php } ?> value="<?php echo $var['value']; ?>"><?php echo $var['text']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
                <form id="navbar-sedes" role="search" class="navbar-form navbar-left collapse">
                    <div class="form-group">
                        <select class="select select2-offscreen cmb-sedes">
                            <?php foreach ($combo_sedes as $var) { ?>
                                <option <?php if ($var['selected']) { ?> selected="selected" <?php } ?> value="<?php echo $var['value']; ?>"><?php echo $var['text']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
                    <li class="dropdown">
                        <a href="<?php echo site_url('app/block'); ?>" >
                            <i class="icon-user-block"></i>
                        </a>
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="resources/assets/app/images/demo/users/user.png" alt="">
                            <span>
                                <?php echo $eUser->username ?>
                            </span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right icons-right">
                            <li><a href="<?php echo site_url('app/user_profile'); ?>"><i class="icon-user"></i> Perfil</a></li>
                            <li><a href="javascript:;" action="action-layout-password"><i class="icon-key"></i> Contraseña</a></li>
                            <li><a href="<?php echo site_url('app/logout'); ?>"><i class="icon-exit"></i> Cerrar Sesión</a></li>
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
                        <div class="user-menu dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $resources_path; ?>/images/demo/users/user.png" alt="">
                                <div class="user-info">
                                    <?php echo $eUser->username ?> 
                                    <span><?php echo $eProfile->name ?></span></div>
                            </a>
                            <div class="popup dropdown-menu dropdown-menu-right">
                                <div class="thumbnail">
                                    <div class="thumb">
                                        <img src="<?php echo $resources_path; ?>/images/demo/users/user2.jpg" alt="">
                                        <div class="thumb-options">
                                            <span>
                                                <a href="javascript:;" class="btn btn-icon btn-success">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-icon btn-success">
                                                    <i class="icon-remove"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="caption text-center">
                                        <h6><?php echo $ePerson->surname . ' ' . $ePerson->name ?> <small><?php echo $eProfile->name ?></small></h6>
                                    </div>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item"><i class="icon-pencil3 text-muted"></i> My posts <span class="label label-success">289</span></li>
                                    <li class="list-group-item"><i class="icon-people text-muted"></i> Users online <span class="label label-danger">892</span></li>
                                    <li class="list-group-item"><i class="icon-stats2 text-muted"></i> Reports <span class="label label-primary">92</span></li>
                                    <li class="list-group-item"><i class="icon-stack text-muted"></i> Balance
                                        <h5 class="pull-right text-danger">$45.389</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /user dropdown -->

                        <ul class="navigation navigation-icons-left">
                            <?php $isActiveMenu = ( $controller_current == 'dashboard' ); ?>

                            <li class="<?php if ($isActiveMenu) { ?>active<?php } ?>">
                                <a href="<?php //echo current_url();           ?>#" class="expand" <?php if ($isActiveMenu) { ?>id="second-level"<?php } ?>>
                                    <span>INICIO</span> 
                                    <i class="icon-screen2"></i>
                                </a>
                                <ul>
                                    <li class="<?php if ($isActiveMenu) { ?>active<?php } ?>">
                                        <a href="<?php echo site_url('app/dashboard'); ?>">Dashboard</a>
                                    </li>
                                </ul>
                            </li>

                            <?php //=================================================================== ?>
                            <?php //=================================================================== ?>
                            <?php
                            //print_r($arrMenu); 
                            if (!empty($arrMenu)) {
                                foreach ($arrMenu as $menu) {

                                    $isActiveMenu = FALSE;
                                    if (!empty($menu->_submodules)) {
                                        foreach ($menu->_submodules as $submenu) {
                                            if ($controller_current == $submenu->name_key) {
                                                $isActiveMenu = TRUE;
                                                break;
                                            }
                                        }
                                    }
                                    ?>

                                    <li class="<?php if ($isActiveMenu) { ?>active<?php } ?>">
                                        <a href="<?php //echo current_url();           ?>#" class="expand" <?php if ($isActiveMenu) { ?>id="second-level"<?php } ?>>
                                            <span><?php echo $menu->name; ?></span> 
                                            <i class="<?php echo is_null($menu->name_icon) ? 'icon-stack' : $menu->name_icon ?>"></i>
                                        </a>
                                        <?php if (!empty($menu->_submodules)) { ?>
                                            <ul>
                                                <?php
                                                foreach ($menu->_submodules as $submenu) {
                                                    $isActiveSubmenu = ( $controller_current == $submenu->name_key );
                                                    ?>
                                                    <li class="<?php if ($isActiveSubmenu) { ?>active<?php } ?>">
                                                        <a href="<?php echo site_url('app/' . $submenu->name_key); ?>"><?php echo $submenu->name; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <?php //===================================================================  ?>
                            <?php //===================================================================    ?>
                        </ul>
                    </div>

                </div>
            <?php } ?>
            <div class="page-content" >
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
                    <!-- Footer -->
                    <div class="footer clearfix">
                        <div class="pull-left">
                            <span>&copy; 2015 - <?php echo date('Y') + 1; ?> . Developer by Luis Rodriguez, &numsp; </span>
                            <span>
                                <?php echo ENVIRONMENT == 'development' ? 'Ambiente de Desarrollo' : 'Ambiente de Producción' ?>
                            </span>
                        </div>
                        <div class="pull-right icons-group"> 
                            <a href="https://twitter.com/TRodriguezN" target="_blank" title="Twitter" class="tip">
                                <i class="icon-twitter"></i>
                            </a> 
                            <a href="https://www.facebook.com/Luch1t0" target="_blank" title="Facebook" class="tip">
                                <i class="icon-facebook"></i>
                            </a> <a href="https://www.instagram.com/crodriguezn90/" target="_blank" title="Istragram" class="tip">
                                <i class="icon-cog3"></i>
                            </a> 
                            <a href="http://depwebrodriguez.honor.es/" target="_blank" title="Luis Rodriguez" class="tip">
                                <i class="icon-link"></i>
                            </a>
                            <a title="Aplicación" class="tip"> <?php echo '<i class="icon-screen"></i> ' . $eAppVersion->name ?></a>
                        </div>
                    </div>
                    <!-- /footer -->
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
        <?php if (!$useIframe) { ?>
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
        <?php } ?>
        <script type="text/javascript">
            Core.init();
        </script>

    </body>
</html>