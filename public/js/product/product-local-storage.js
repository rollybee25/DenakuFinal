$(document).ready(function() {

    function forViewButon(view) {
        var view_button = view;
        window.localStorage.setItem('view_button', view_button);
    }

    $(document).on('click','.view-button', function(){
        var id = $(this).attr("id");
        forViewButon(id);
    });

});