var SettingParam_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    data_setting_param_default: $.parseJSON('<?php echo json_encode($data_setting_param_default); ?>')
};
