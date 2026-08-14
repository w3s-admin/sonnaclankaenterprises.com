$(function() {
    if ($('div').hasClass('upload_c_logo')) {
        var fileUpload = $('#upload_c_logo');
        var status = $('#status_file');
        new AjaxUpload(fileUpload, {
            action: "temp_upload/index.php",
            name: 'file',
            onSubmit: function(file, ext) {
                if (!(ext && /^(jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))) {
                    // extension is not allowed 
                    return false;
                }
                status.html('<br/>Uploading...');
            },
            onComplete: function(file, response) {
                status.text('');

                if (response.indexOf("error") !== -1) {
                    $('#upload_c_logo').html('<span class="error">' + response + '</span>');
                } else {
                    $('#upload').html('<span><img src="js/ajx/mainUpload/' + response + '"  style="width:175;height:122px;" /><span>Click here to Replace</span></span>');
                    $('#dimg').val(response);
                }

            }
        });
    }




});
