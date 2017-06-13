// Show hide taken from reveal.js
(function ($) {
    $.fn.showHide = function (options) {
    //default vars for the plugin
        var defaults = {
            speed: 1000,
            easing: '',
            changeText: 0,
            showText: 'Show',
            hideText: 'Hide'
        };
        var options = $.extend(defaults, options);
        $(this).click(function () {
            $(this).toggleClass('open');
        });
        $(this).click(
            function () {
                // optionally add the class .toggle-div to each div you want to automatically close
                $('.toggle-div').slideUp(options.speed, options.easing);
                // this var stores which button you've clicked
                var toggleClick = $(this);
                // this reads the rel attribute of the button to determine which div id to toggle
                var toggleDiv = $(this).attr('rel');
                $(toggleDiv).trigger('faq:start');
                // here we toggle show/hide the correct div at the right speed and using which easing effect
                $(toggleDiv).slideToggle(options.speed, options.easing, function() {
                    // this only fires once the animation is completed
                    $(toggleDiv).trigger('faq:complete');
                    if(options.changeText==1){
                        $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
                    }
                });
                return false;
            }
        );

    };

    function getGETvariable(key){
        if ( window.location.search.length > 0) {
            var getArray = window.location.search.substr(1).split('&'),
                getObj = {};
            for (var i = 0; i < getArray.length; i++) {
                var indArray = getArray[i].split('=');
                getObj[indArray[0]] = indArray[1];
            }
            if (typeof key !== undefined && typeof getObj[key]!== 'undefined') {
                return getObj[key];
            } else {
                return getObj
            }
        }
        else {
            return false;
        }
    }

    $('.show-hide').showHide({
      speed: 250,       // speed you want the toggle to happen
      easing: '',       // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
      changeText: 0    // if you dont want the button text to change, set this to 0
    });
    // Custom event that can trigger other functions when the faq opens or closes:
    $('.rbd-faq-sliding-div').on('faq:start', function(event) {
        if ( $(this).prev().hasClass('open')) {
            // Triggered when the element is open
        }
        else {
            // Triggered when the element is closed
        }
    });

    $(window).on('load', function(){
        var targetQuestion = getGETvariable('targetQuestion');
        if (typeof targetQuestion === 'string') {
            var scrollTo = jQuery('#rbd-faq-question-'+targetQuestion).offset().top - ($(window).height()/10) ;
            setTimeout(function(){
                window.scrollTo( 0, scrollTo );
            }, 10)
        }
    });
})(jQuery);