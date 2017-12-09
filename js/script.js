/**
 * @file
 * Attaches behaviors for the openadstream.
 */
var oas_tag = {};
(function ($) {
  /**
   * Adding function for openadstream on mobile.
   */
  // @TODTO  pass these variable from form setting.
  var mobile = 350;
  var tablet = 740;
  var scrn = 'desktop';
  var lastWindowWidth = $(window).width();
  Drupal.behaviors.openadstream = {
    attach: function (context, settings) {
      var width = window.outerWidth;
      if (lastWindowWidth < mobile || lastWindowWidth < tablet) {
        scrn = 'phone';
      }
      else if (lastWindowWidth >= tablet && lastWindowWidth <= 868) {
        scrn = 'tablet';
      }

      oas_tag.url = settings.openadstream.url;
      oas_tag.sizes = function () {
        $.each(settings.openadstream.position, function (key, value) {
          oas_tag.definePos(key, [value.width, value.height]);
        });
      };
      oas_tag.site_page = settings.openadstream.oas_client;
      oas_tag.query = 'screen=' + scrn;
      (function() {
        oas_tag.version ='1';
        var oas = document.createElement('script'),
          protocol = 'https:' == document.location.protocol?'https://':'http://',
          node = document.getElementsByTagName('script')[0];
        oas.type = 'text/javascript';
        oas.async = true;
        oas.src = protocol + oas_tag.url + '/om/' + oas_tag.version + '.js';
        node.parentNode.insertBefore(oas, node);
      })();

    } //end of attach function
  }; // end fo drupal behaviors

})(jQuery, drupalSettings);
