<?php $resource_path = "resources/assets/app" . '/'; ?>

<html lang="en" class="">
    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>Sistema Academico CAH</title>
        <link type="text/css" rel="stylesheet" href="<?php echo $resource_path; ?>css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="<?php echo $resource_path; ?>css/londinium-theme.min.css">
        <link type="text/css" rel="stylesheet" href="<?php echo $resource_path; ?>css/styles.min.css">
        <link type="text/css" rel="stylesheet" href="<?php echo $resource_path; ?>css/icons.min.css">
        <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext">
        <link type="text/css" rel="stylesheet" href="resources/css/custom.css">
        <script type="text/javascript" src="resources/js/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="resources/js/jqueryui/1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/charts/sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/inputmask.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/autosize.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/inputlimit.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/listbox.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/multiselect.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/validate.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/tags.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/switch.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/uploader/plupload.full.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/uploader/plupload.queue.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/wysihtml5/wysihtml5.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/forms/wysihtml5/toolbar.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/daterangepicker.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/fancybox.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/moment.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/jgrowl.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/colorpicker.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/timepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/plugins/interface/collapsible.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $resource_path; ?>js/application.js" type="text/javascript"></script>
        <script type="text/javascript" src="resources/js/jquery.numeric.min.js"></script>
        <style type="text/css">
            .page-condensed .error-wrapper { padding-top:110px; }
            @media (min-width: 630px) {
                .error-content{ width:600px; }
            }
        </style>
    </head>

    <body class="full-width page-condensed cah-bg">
        <?php if ($navegador['isSuccess']) { ?>
            <div class="alert alert-warning fade in block-inner">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <i class="icon-cancel-circle"></i> <?php echo $navegador['message']; ?>
            </div>
        <?php } ?>

        <!-- Navbar -->
        <div role="navigation" class="navbar navbar-inverse cah-bg-red">
            <div class="navbar-header"><a href="javascript:;" class="navbar-brand">Sistema Académico</a></div>
        </div>
        <!-- /navbar -->
        <!-- Error wrapper -->
        <div class="error-wrapper offline text-center">
            <div class="error-content">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="info-blocks">
                            <li class="bg-info">
                                <div class="top-info"><a href="#">Administrativos</a></div>
                                <a href="<?php echo site_url('app/login/administrativo'); ?>"><i class="icon-user4"></i></a><span class="bottom-info bg-primary">Personal Administrativo</span>
                            </li>
                            <li class="bg-primary">
                                <div class="top-info"><a href="#">Docentes</a></div>
                                <a href="<?php echo site_url('app/login/docente'); ?>"><i class="icon-user"></i></a><span class="bottom-info bg-danger">Profesores</span>
                            </li>
                            <li class="bg-success">
                                <div class="top-info"><a href="#">Representantes</a></div>
                                <a href="<?php echo site_url('app/login/representante_legal'); ?>"><i class="icon-users"></i></a><span class="bottom-info bg-primary">Representante Legal</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /error content -->
        </div>
        <!-- /error wrapper -->
        <!-- Footer -->
        <div class="footer clearfix">
            <div class="pull-left">&copy; 2015 - <?php echo date('Y') + 1; ?> . Desarrollado por <a href="http://it-corp.com">iT/Corp</a></div>
            <div class="pull-right icons-group"> <a href="#"><i class="icon-screen2"></i></a> <a href="#"><i class="icon-balance"></i></a> <a href="#"><i class="icon-cog3"></i></a> </div>
        </div>
        <!-- /footer -->

    </body></html>