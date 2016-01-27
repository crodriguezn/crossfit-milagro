<?php $resource_path = "resources/assets/app" . '/'; ?>
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
        <title><?php echo empty($eCompany->name) ? 'Sistema de Venta' : $eCompany->name ?></title>
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
        <script type="text/javascript" src="<?php echo site_url('app/login_advanced/mvcjs'); ?>"></script>
    </head>
    <body class="full-width page-condensed">
        <!-- Navbar -->
        <div class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><?php echo empty($eConfigurationSystem->name_system) ? 'Sistema de Venta' : $eConfigurationSystem->name_system ?></a>
            </div>

        </div>
        <!-- /navbar -->
        <!-- Login wrapper -->
        <div class="login-wrapper">
            <form action="javascript:;"  role="form">
                <input type="hidden" class="form-control" value="<?php echo $eUser->username; ?>" name="username">
                <div class="well">
                    <div class="thumbnail">
                        <div class="thumb">
                            <?php $img_user = (file_exists('resources/uploads/person/' . $ePerson->id . '/profile.png')) ? '' : 'resources/assets/app/images/demo/users/user2.jpg'; ?>
                            <img src="<?php echo $img_user; ?>">
                        </div>
                        <div class="caption text-center">
                            <h6><?php echo $ePerson->name . ' ' . $ePerson->surname; ?> <small><?php echo $eProfile->name; ?></small></h6>
                        </div>
                    </div>
                    <div class="form-group has-feedback has-feedback-no-label">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password">
                        <i class="icon-lock form-control-feedback"></i>
                    </div>
                    <div class="row form-actions">
                        <div class="col-xs-2">
                            <div class="loading"><img src="resources/img/loading.gif" /></div>
                        </div>
                        <div class="col-xs-5">
                            <button type="button" class="btn btn-success pull-right action-cancel"><i class="icon-cancel-circle"></i> Cancelar</button>
                        </div>
                        <div class="col-xs-5">
                            <button type="submit" class="btn btn-warning pull-right action-login"><i class="icon-checkmark3"></i> Entrar</button>
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