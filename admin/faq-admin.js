(function($){

    var $optionsForm = $("#options-form");
    var $iframe = $("#rbd-faq-preview").find("iframe");
    var $submit = $('#submit');

    /**
     * Updates the preview 
     */ 
    function updatePreview(){
        checkColors($optionsForm);
        var options = $optionsForm.serialize();
        $iframe[0].contentWindow.postMessage(options, "*");
    }

    /**
     * Checks that the form fields are valid css colours
     * @param {Obj} form
     */
    function checkColors(form) {
        $inputs = form.find("input[type='text']");
        for (var i = 0; i < $inputs.length; i++){
            var $thisInput = $inputs.eq(i);
            if (!validColor($thisInput.val())){
                $thisInput.addClass('rbd-faq-invalid-color');
            } else {
                $thisInput.removeClass('rbd-faq-invalid-color');
            }
        }
        if ( $('.rbd-faq-invalid-color').length > 0 ){
            $submit.addClass('disabled');
        } else {
            $submit.removeClass('disabled');
        }
    }

    /**
     * Tests if a string is a valid css color
     * @param {String} color
     * @return {bool}
     */
    function validColor(color){
        var $div = $("<div>");
        $div.css("border", "1px solid "+color);
        return ($div.css("border-color")!="")
    }


    $optionsForm.on("focus", "input", function(e){
        $(this).removeClass('rbd-faq-invalid-color');
    });

    // Update the colours on iframe loading
    $iframe.on("load", updatePreview);

    $optionsForm.on("change", "input", updatePreview)

    $optionsForm.on("submit", function(e){
        checkColors($optionsForm);
        if ($('.rbd-faq-invalid-color').length > 0){
            e.preventDefault();
        }
    });
    
    
})(jQuery);
