$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var admin_url = "http://localhost/phealthbd/admin";
    //var admin_url = window.location.origin + '/admin';

    // Slug Generate
    $("#title").keyup(function(){
        var str = $(this).val();
        var txt = str.replace(/ /g,"-");
        $("#slug").val(txt.toLowerCase());
    })
    
    // Multiple Image Picker
    $("#multiple-image-picker").spartanMultiImagePicker({
        fieldName: "gallery[]",
        allowedExt: "png|jpg|jpeg|gif|svg",
        maxFileSize: "2048",
        groupClassName: "col-12 col-md-3 col-lg-2",
    });
    
// Image Change With Preview
function preview_image(input, image_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(image_id).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#icon_file").change(function () {
    preview_image(this, "#icon_image");
});

$("#desktop_hero_image_file").change(function () {
    preview_image(this, "#desktop_hero_image");
});

$("#mobile_hero_image_file").change(function () {
    preview_image(this, "#mobile_hero_image");
});

$("#billboard_image_file").change(function () {
    preview_image(this, "#billboard_image");
});

$("#highlight_image_file").change(function () {
    preview_image(this, "#highlight_image");
});


});
