<?php $resource_path = "resources/assets/app" . '/'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>"/>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Londinium - premium responsive admin template by Eugene Kopyov</title>
        <link href="<?php echo $resource_path; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/londinium-theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/styles.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $resource_path; ?>css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="resources/js/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="resources/js/jqueryui/1.10.4/ui/minified/jquery-ui.min.js"></script>
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
        <script type="text/javascript" src="<?php echo site_url('app/js/mvc/login'); ?>"></script>
        <style type="text/css">
            /*.login-wrapper { margin-top:-250px; }*/
        </style>
    </head>
    <body class="full-width page-condensed">
        <!-- Navbar -->
        <div class="navbar navbar-inverse" role="navigation">
            <nav class="navbar navbar-static-top" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right"><span class="sr-only">Toggle navbar</span><i class="icon-grid3"></i></button>-->
                <a class="navbar-brand" href="javascript:;">Sistema Académico CAH</a>
        <!--        <a class="navbar-brand" href="#"><img src="<?php echo $resource_path; ?>images/logo.png" alt="Londinium"></a>-->
                <button data-target="#navbar-login-register" data-toggle="collapse" class="navbar-toggle collapsed" type="button"><span class="sr-only">Toggle navbar button</span><i class="icon-paragraph-justify2"></i></button>
            </div>
            <div id="navbar-login-register" class="nav navbar-nav navbar-left collapse" style="height: auto;">
                <button class="btn btn-default navbar-btn" type="button" id="login-register"><i class="icon-user3"></i> Registrate</button>
            </div>
            <!--<ul class="nav navbar-nav navbar-right collapse">
                <li><a href="<?php echo current_url(); ?>#"><i class="icon-screen2"></i></a></li>
                <li><a href="<?php echo current_url(); ?>#"><i class="icon-paragraph-justify2"></i></a></li>
                <li>
                    <a href="<?php echo current_url(); ?>#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                        <li><a href="<?php echo current_url(); ?>#"><i class="icon-cogs"></i> This is</a></li>
                        <li><a href="<?php echo current_url(); ?>#"><i class="icon-grid3"></i> Dropdown</a></li>
                        <li><a href="<?php echo current_url(); ?>#"><i class="icon-spinner7"></i> With right</a></li>
                        <li><a href="<?php echo current_url(); ?>#"><i class="icon-link"></i> Aligned icons</a></li>
                    </ul>
                </li>
            </ul>-->
        </div>
        <!-- /navbar -->
        <!-- Login wrapper -->
        <div class="login-wrapper">
            <form action="javascript:;"  role="form">
                <div class="popup-header">
        <!--            <a href="<?php //echo current_url();                                                                                      ?>#" class="pull-left"><i class="icon-user-plus"></i></a>-->
                    <span class="text-semibold">Iniciar Sesión</span>
                    <!--            <div class="btn-group pull-right">
                                    <a href="<?php echo current_url(); ?>#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
                                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                    <?php /* ?>
                      <li><a href="<?php echo current_url(); ?>#"><i class="icon-people"></i> Change user</a></li>
                      <?php */ ?>
                                        <li><a href="<?php //echo current_url();                                                                                      ?>#"><i class="icon-info"></i> Olvido contraseña?</a></li>
                    <?php /* ?>
                      <li><a href="<?php echo current_url(); ?>#"><i class="icon-support"></i> Contact admin</a></li>
                      <li><a href="<?php echo current_url(); ?>#"><i class="icon-wrench"></i> Settings</a></li>
                      <?php */ ?>
                                    </ul>
                                </div>-->
                </div>
                <div class="well">
                    <div class="alert alert-danger fade in block-inner">
                        <!--<button data-dismiss="alert" class="close" type="button">×</button>-->
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
                    <div class="form-group has-feedback">
                        <label>Código de Seguridad</label><br/>
                        <img class="img-captcha" src="resources/img/captcha.png" width="100%" />
                        <input type="text" class="form-control" placeholder="Seguridad" name="security">
                    </div>
                    <div class="row form-actions">
                        <div class="col-xs-3">
                            <?php /* ?>
                              <div class="checkbox checkbox-success">
                              <label><input type="checkbox" class="styled"> Remember me</label>
                              </div>
                              <?php */ ?>
                            <div class="loading"><img src="resources/img/loading.gif" /></div>
                        </div>
                        <div class="col-xs-9">
                            <button type="submit"  id="btnEntrar" class="btn btn-success pull-right"><i class="icon-checkmark3"></i> Entrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /login wrapper -->
        <!-- Footer -->
        <?php ?>
        <div class="footer clearfix">
            <div class="pull-left">&copy; 2015 - <?php echo date('Y') + 1; ?> . Desarrollado por <a href="http://it-corp.com">iT/Corp</a></div>
            <div class="pull-right icons-group">
                <!--<a href="#"><i class="icon-screen2"></i></a>
                <a href="#"><i class="icon-balance"></i></a>
                <a href="#"><i class="icon-cog3"></i></a>-->
            </div>
        </div>
        <?php ?>

        <!-- /footer -->


        <?php // =========================================================================== ?>
        <?php // =========================================================================== ?>

        <div id="modal-register" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="icon-user3"></i>Registro</h4>
                    </div>
                    <!-- Form inside modal -->
                    <form action="javascript:;"  role="form">
                        <div class="modal-body with-padding">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab1" data-toggle="tab">
                                            <i class="icon-users form-control-feedback"></i>
                                            Datos Personales
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab">
                                            <i class="icon-lock form-control-feedback"></i>
                                            Datos de Usuario
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1">
                                        <div class="block-inner text-danger">
                                            <h6 class="heading-hr"><small class="display-block">La informaci&oacute;n registrada en este formulario deber&aacute; ser del Representante Legal del alumno</small></h6>
                                        </div>
                                        <input type="hidden" name="id_register" value="0" />
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Apellidos:</label>
                                                    <input type="text" placeholder="Apellidos" name="surname" maxlength="80" class="form-control">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Nombres:</label>
                                                    <input type="text" placeholder="Nombres" name="name" maxlength="80" class="form-control">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Cédula</label>
                                                    <input type="text" placeholder="0999999999" maxlength="10" name="document" class="form-control" />
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Fecha de Nacimiento:</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" name="birthday" class="form-control"  data-mask="99/99/9999" placeholder="mm/dd/aaaa"/>
                                                        <div class="input-group-addon">
                                                            <i class="icon-calendar"></i>
                                                        </div>
                                                    </div><!-- /.input group -->
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Género:</label>
                                                    <select  class="select-full" name="gender" tabindex="0">
                                                        <option value="GENDER_FEMALE">Femenino</option>
                                                        <option value="GENDER_MALE">Masculino</option>
                                                    </select>
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> T&eacute;lefono:</label>
                                                    <input type="text" placeholder="0999999999" name="phone" maxlength="50" class="form-control">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Domicilio:</label>
                                                    <textarea rows="5" cols="5" style="resize:none; height: 50px" maxlength="220" class="form-control" name="address" placeholder="Direcci&oacute;n..."></textarea>
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane body fade" id="tab2">
                                        <div class="block-inner text-danger">
                                            <h6 class="heading-hr"><small class="display-block">La informaci&oacute;n registrada en este formulario deber&aacute; ser del Representante Legal del alumno</small></h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Usuario:</label>
                                                    <input type="text" placeholder="Usuario" name="username"maxlength="40" class="form-control">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Contraseña:</label>
                                                    <input type="password" class="form-control" placeholder="Contraseña" maxlength="12" name="password">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Verificar Contraseña:</label>
                                                    <input type="password" class="form-control" placeholder="Verificar Contraseña" maxlength="12" name="verifypassword">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Email:</label>
                                                    <input type="text" class="form-control" placeholder="Email" maxlength="80" name="email">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group has-feedback">
                                                    <label><i class="icon-spell-check"></i> Verificar Email:</label>
                                                    <input type="text" class="form-control" placeholder="Verificar Email" maxlength="80" name="verifyemail">
                                                    <span class="label label-block label-danger text-left">Centered label</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-xs-3">
                                <div class="loading"><img src="resources/img/loading.gif" /></div>
                            </div>
                            <div class="col-xs-9">

                                <button type="submit" id="btnRegistar" class="btn btn-success"><i class="icon-checkmark3"></i> Registrar</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="icon-close"></i> Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php // =========================================================================== ?>
        <?php // =========================================================================== ?>

        <script type="text/javascript">
            Core.init();
        </script>

    </body>
</html>