<?php $resource_path = "resources/assets/app" . '/'; ?>

<?php
/* @var $eCompany eCompany */
/* @var $eConfigurationSystem eConfigurationSystem */
/* @var $eAppVersion eAppVersion */
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo empty($eCompany->name) ? 'Sistema de Control del WOD (Workout Of the Day)' : $eCompany->name ?></title>
        <link rel="icon" href="<?php echo base_url("resources/img/favicon.ico"); ?>" type="image/x-icon"/>
        <link href="<?php echo $resource_path; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/londinium-theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/styles.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="resources/css/custom.css">
        <script type="text/javascript" src="resources/js/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="resources/js/jqueryui/1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script type="text/javascript" src="resources/js/canvasloader/heartcode-canvasloader-min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/charts/sparkline.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/inputmask.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/autosize.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/inputlimit.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/listbox.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/multiselect.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/validate.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/tags.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/switch.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/form.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/uploader/plupload.full.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/uploader/plupload.queue.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/forms/wysihtml5/toolbar.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/fancybox.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/moment.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/jgrowl.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/plugins/interface/collapsible.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $resource_path; ?>js/application.js"></script>
        <script type="text/javascript" src="<?php echo site_url('app/js/core'); ?>"></script>
        <script type="text/javascript" src="resources/js/jquery.numeric.min.js"></script>
        <script type="text/javascript" src="<?php echo site_url('app/login/mvcjs'); ?>"></script>
    </head>
    <body class="full-width page-condensed">
        <!-- Navbar -->
        <div class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><?php echo empty($eConfigurationSystem->name_system) ? 'Sistema de Control del WOD (Workout Of the Day)' : $eConfigurationSystem->name_system ?></a>
            </div>

        </div>
        <!-- /navbar -->
        <!-- Login wrapper -->
        <div class="login-wrapper">
            <form action="javascript:;"  role="form">
                <div class="popup-header">
                    <span class="text-semibold">
                        <?php echo $login_title; ?>
                    </span>
                    <div class="btn-group pull-right"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
                        <ul class="dropdown-menu icons-right dropdown-menu-right">
                            <!--<li><a href="#"><i class="icon-people"></i> Change user</a></li>-->
                            <!--<li><a href="#"><i class="icon-info"></i> ¿Olvidó Contraseña?</a></li>-->
                            <li><a href=""><i class="icon-support"></i> En Contacto</a></li>
<!--                            <li><a href="#"><i class="icon-wrench"></i> Settings</a></li>-->
                        </ul>
                    </div>
                </div>
                <div class="well">
                    <div class="alert alert-danger fade in block-inner">
                        <i class="icon-cancel-circle"></i> <span>Error alert</span>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Usuario</label>
                        <input type="text" class="form-control" placeholder="Usuario" name="username">
                        <i class="icon-users form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" placeholder="Contraseña" name="password">
                        <i class="icon-lock form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback <?php //echo (ENVIRONMENT=='development') ? 'hidden':''; ?>">
                        <label>Código de Seguridad</label><br/>
                        <img class="img-captcha" src="resources/img/captcha.png" width="100%" />
                        <input type="text" class="form-control" placeholder="Seguridad" name="security">
                    </div>
                    <div class="row form-actions">
                        <div class="col-xs-3">
                            <div class="loading"><img src="resources/img/loading.gif" /></div>
                        </div>
                        <div class="col-xs-9">
                            <button type="submit" id="btnEntrar" class="btn btn-warning pull-right action-login"><i class="icon-checkmark3"></i> Entrar</button>
                        </div>
                        <div class="col-xs-12" style="text-align: center">
                            <br/>
                            <a href="javascript:void(0);" id="login-recovery-password">¿Olvidó Contraseña?</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /login wrapper -->
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

        <?php // =========================================================================== ?>
        <?php // =========================================================================== ?>

        <script type="text/javascript">
            Core.init();
        </script>
    </body>
</html>