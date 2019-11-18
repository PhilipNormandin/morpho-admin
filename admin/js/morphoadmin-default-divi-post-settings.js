/* Morpho Admin - Default Divi Post Settings JavaScript */

//call jQuery
jQuery( document ).ready( function( $ ) {
    // alert('test');
});

jQuery( document ).ready( function( $ ) {

    // var $j = jQuery.noConflict();

    function select_fullwidth() {
        // select fullwith
        $( "#et_pb_page_layout option[value='et_full_width_page']" ).attr( "selected", "selected" );
        $( "#et_single_title option[value='off']" ).attr( "selected", "selected" );
        $( "#et_pb_toggle_builder" ).off( "click", select_fullwidth );
        $( "#et_pb_toggle_builder" ).on( "click", return_standard_editor );
    }

    function return_standard_editor() {
        // re-select no sidebar
        $( "#et_pb_page_layout option[value='et_no_sidebar']" ).attr( "selected", "selected" );
        $( "#et_pb_toggle_builder" ).off( "click", return_standard_editor );
        $( "#et_pb_toggle_builder" ).on( "click", select_fullwidth );
    }

    // if using classic Divi Builder on backend
    // -------------------------------------------------------------------------------------

    if ( $( "body" ).hasClass( "post-new-php" ) ) {
        // if divi builder is not activated - of course because it's the default behavior
        if ( ! $( "#et_pb_toggle_builder" ).hasClass( "et_pb_builder_is_used" ) ) {
            // select no sidebar
            $( "#et_pb_page_layout option[value='et_no_sidebar']" ).attr( "selected", "selected" );
            $( "#et_pb_toggle_builder" ).on( "click", select_fullwidth );
        }
    }

    // if using new Divi Builder on backend
    // -------------------------------------------------------------------------------------

    // https://developer.mozilla.org/en-US/docs/Web/API/MutationObserver
    // https://gist.github.com/prof3ssorSt3v3/3146ce1a727861edd05dfc6523e969ea

    // Select the node that will be observed for mutations
    var targetNode = document.querySelector( 'body' );

    // Options for the observer (which mutations to observe)
    var config = { attributes: true, childList: false, subtree: false };

    // Create an observer instance linked to the mutated function
    var observer = new MutationObserver( mutated );

    // Start observing the target node for configured mutations
    observer.observe( targetNode, config );

    // mutated function to execute when mutations are observed
    function mutated( mutationList ) {
        // console.log( mutationList );
        for( let mutation of mutationList ) {
            if ( ( mutation.type == 'attributes' ) && ( mutation.attributeName == 'class' ) ) {
                // if specific class is added to body
                if ( $( "body" ).hasClass( "et-fb-global-preloader" ) ) {
                    console.log( 'et-fb-global-preloader class added to body' );
                    $( "#et_pb_page_layout option[value='et_full_width_page']" ).attr( "selected", "selected" );
                    $( "#et_single_title option[value='off']" ).attr( "selected", "selected" );
                    observer.disconnect();
                }
            }
        }
    }

});
