/**
 * @file
 * JavaScript behaviors for webform pages titles.
 */

(function ($, Drupal) {

  'use strict';
  Drupal.behaviors.amazee_wfwz = {
    attach: function (context, settings) {
     settings = drupalSettings;
     var get_page = settings.get_page;

     //var cur_page = $('form.webform-submission-form').attr('data-webform-wizard-current-page');
     $('form.webform-submission-form', context).each(function() {
       var cur_page = $(this).attr('data-webform-wizard-current-page');
       if ((typeof cur_page !== typeof undefined) && (cur_page !== false)) {
          if (cur_page != get_page) {
            var cur_title = $('.webform-progress [data-webform-page="'+ cur_page +'"] h3').text();
            $('h1[class *= "page-title"]').text(cur_title);
          }
         }
     });
    }
  };

})(jQuery, Drupal);

