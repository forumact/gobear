/**
 * @file
 * Gobeaer behaviors.
 */

(function ($, window, Drupal) {

    'use strict';

    /**
   * Provide the basic function on job listing.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior for the jobs listing.
   */
    Drupal.behaviors.Gobeaer = {
        attach: function (context) {
            $('body').once('Gobeaer').each(
                function() {    
                    $('.toggle-desc').click(
                        function(e) {              
                            if($(this).find('.clicktext').text() == 'More Info') {
                                 $(this).find('.clicktext').text('Less Info');
                            }else{
                                $(this).find('.clicktext').text('More Info');     
                            }             
                            $(this).parents('.card-body').find('.long-desc').toggleClass('hide');    
                            $(this).parents('.card-body').find('.short-desc').toggleClass('hide');                           
                        }
                    );
                }
            );
        }
    };

})(jQuery, window, Drupal);
