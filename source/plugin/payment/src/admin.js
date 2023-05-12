function addnewrow(ele) {
    jQuery(ele).closest('tr').before(jQuery('#copytable tr').clone());
}

function rowup(ele) {
    var thisRow = jQuery(ele).closest('tr');
    if (thisRow.prev().hasClass('header')) return;
    thisRow.prev().before(thisRow.clone());
    thisRow.remove();
}

function rowdown(ele) {
    var thisRow = jQuery(ele).closest('tr');
    if (!thisRow.next().hasClass('hover')) return;
    thisRow.next().after(thisRow.clone());
    thisRow.remove();
}