jQuery(document).ready(function($){
    $('.superwebshare-colorpicker').wpColorPicker();	// Color picker
});

function SuperWebShareRighTLeft() {
    var x = document.getElementById("superwebshare_settings[floating_position]").value;
    document.getElementById("rightleft").innerHTML = " " + x;
}

jQuery(document).ready(function($){
    if(typeof navigator.share==='undefined' || !navigator.share){
         var share = "yes";
}});
