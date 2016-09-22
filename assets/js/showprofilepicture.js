$(document).ready(function() {
    function readURL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            
            // onload is container event handler execute when the load event is fired
            reader.onload = function(e) {
                $(".pp-custom, .pp-custom2").attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#foto").change(function() {
        readURL(this);
    });
});                                             