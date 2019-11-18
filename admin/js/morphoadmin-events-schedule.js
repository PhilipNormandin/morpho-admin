/* Morpho Admin - Events Schedule JavaScript */

//call jQuery
jQuery( document ).ready( function( $ ) {
    // alert('test');
});

jQuery( document ).ready( function( $ ) {

    // var $j = jQuery.noConflict();

    if ( $( "body" ).hasClass( "post-type-class" ) ) {
        if ( $( "body" ).hasClass( "locale-fr-fr" ) || $( "body" ).hasClass( "locale-fr-ca" ) ) {
            $( "#content_class_image_tab #wrapper__wcs_image > label.name" ).text( "URL de l'image" );
            $( "#content_action_tab #wrapper__wcs_action_email > label.name" ).text( "Adresse courriel" );
        }
        else {
            $( "#content_class_image_tab #wrapper__wcs_image > label.name" ).text( "Image URL" );
            $( "#content_action_tab #wrapper__wcs_action_email > label.name" ).text( "Email Address" );
        }
    }

    if ( $( "body" ).hasClass( "post-type-class" ) ) {
        $( "#switch_show_post_translations" ).parent().hide();
        $( "#switch_show_filter_post_translations" ).parent().hide();
        $( "#switch_modal_post_translations" ).parent().hide();
    }
});

// jQuery( document ).ready( function( $ ) {

    // if ( $( "body" ).hasClass( "post-php" ) ) {
    //     var previewbtn =  document.getElementById( "post-preview" );
    //     if ( ( previewbtn.textContent.includes( 'Prévisualiser les modifications' ) )  ||
    //          ( previewbtn.textContent.includes( 'Preview Changes') ) ) {
    //         $( "#preview-action" ).width( "100%" );
    //         $( "#preview-action" ).css( 'display', 'flex' );
    //         $( "#preview-action" ).css( 'flex-direction', 'column' );
    //     }
    // }
// });
