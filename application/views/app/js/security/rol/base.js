var Rol_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    rol_form_default: $.parseJSON('<?php echo json_encode($rol_form_default); ?>')
};
