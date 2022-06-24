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
    }

    const buttonNames = [ 'floating', 'inline' ];
    for( i in buttonNames ){
        let floatingPostTypes = jQuery( `[name="superwebshare_${buttonNames[i]}_settings[${buttonNames[i]}_display_pages][]"]` );
        let manFloatingActive = jQuery( `[name="superwebshare_${buttonNames[i]}_settings[superwebshare_${buttonNames[i]}_enable]"]` );
        floatingPostTypes.change( function(){
            let anyOneActive = false;
            
            floatingPostTypes.each( function(input){
                if( $( this ).is( ":checked" ) ){
                    anyOneActive = true;
                }
            } );
            if( anyOneActive != true ){
                manFloatingActive.prop( 'checked', false );
            }else{
                manFloatingActive.prop( 'checked', true );
            }

        } );
        manFloatingActive.change( function(){
            let anyOneActive = false;
            
            floatingPostTypes.each( function(input){
                if( $( this ).is( ":checked" ) ){
                    anyOneActive = true;
                }
            } );
            if( anyOneActive != true ){
                floatingPostTypes.prop( 'checked', true );
            }
        } )
    }
});

