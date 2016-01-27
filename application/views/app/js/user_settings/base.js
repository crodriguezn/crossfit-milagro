var UserSettings_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    user_settings_form_default: $.parseJSON('<?php echo json_encode($user_settings_form_default); ?>'),
    data_company_branch: []
};
