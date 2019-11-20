jQuery(document).ready(function($){
    $('.superwebshare-colorpicker').wpColorPicker();	// Color picker
});

function SuperWebShareRighTLeft() {
    var x = document.getElementById("superwebshare_settings[floating_position]").value;
    document.getElementById("rightleft").innerHTML = " " + x;
}
