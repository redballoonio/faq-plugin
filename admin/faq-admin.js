(function($){

    var $optionsForm = $("#options-form");
    var $iframe = $("#rbd-faq-preview").find("iframe");

    $optionsForm.on("change", "input", function(e){
        var options = $optionsForm.serialize();
        $iframe[0].contentWindow.postMessage(options, "*");
    });
})(jQuery);
