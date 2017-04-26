var Calendar_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    calendar_form_default: $.parseJSON('<?php echo json_encode($calendar_form_default); ?>'),
    data: $.parseJSON('<?php echo json_encode($data); ?>')
};
