/**
 * Behavior definition to display reusable quotes from clients 
 * @description
 * Depending on a container width reusable quote should arrange its content
 * all stuff will be done by a css, but special class is needed
 * this behavior is responsible of adding classes to the quotes
 *
 * @param {Object} $ jQuery instance
 * @param {Object} Drupal Drupal instance
 */
!function($, Drupal) {
    /**
     * Smallest container width to display all 
     * content as a single column
     */
    var BREAKPOINT = 640;
    /**
     * Default behavior attachment
     */
    Drupal.behaviors.reusableQuotes = {
        attach: attachModificatiors
    };
    /**
     * Update classes on resize
     */
    $(window).resize(function onWindowResize() {
        attachModificatiors(document.body);
    });
    /**
     * Beavior definition
     * @param {HTMLElement} context
     */
    function attachModificatiors(context) {
        $('.quote-wrapper', context).each(function adjustSingleQuote(index, element) {
            var container = $(element).parent();
            if(container.width() > BREAKPOINT) {
                $(element).addClass('quote-wrapper--horisontal');
            } else {
                $(element).removeClass('quote-wrapper--horisontal');
            }
        });
    };        
}(jQuery, Drupal);