var Listing_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    profile_form_default: $.parseJSON('<?php echo json_encode($profile_form_default); ?>')
};
