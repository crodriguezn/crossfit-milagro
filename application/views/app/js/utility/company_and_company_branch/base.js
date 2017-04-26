var Administration_Company_Base = {
    link: "<?php echo $link; ?>",
    linkx: "<?php echo $linkx; ?>",
    permissions: $.parseJSON('<?php echo json_encode($permissions); ?>'),
    data_company_default: $.parseJSON('<?php echo json_encode($data_company_default); ?>'),
    data_company_branch_default: $.parseJSON('<?php echo json_encode($data_company_branch_default); ?>')
};
