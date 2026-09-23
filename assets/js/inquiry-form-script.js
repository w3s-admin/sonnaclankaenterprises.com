/*==============================================================*/
// Vehicle Enquiry Form JS (used-japanese-vehicle-details.php)
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict

    var $form = $("#inquiryForm");
    if (!$form.length) {
        return;
    }

    $form.validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Did you fill in the form properly?");
        }
        else {
            event.preventDefault();
            submitForm();
        }
    });

    function submitForm() {
        var name = $("#inquiryName").val();
        var email = $("#inquiryEmail").val();
        var phone = $("#inquiryPhone").val();
        var message = $("#inquiryMessage").val();
        var vid = $form.find("input[name='vid']").val();
        var gridCheck = $("#inquiryGridCheck").val();

        $.ajax({
            type: "POST",
            url: "assets/php/inquiry-process.php",
            data: "name=" + encodeURIComponent(name) + "&email=" + encodeURIComponent(email) + "&phone=" + encodeURIComponent(phone) + "&message=" + encodeURIComponent(message) + "&vid=" + encodeURIComponent(vid) + "&gridCheck=" + encodeURIComponent(gridCheck),
            success: function (statustxt) {
                if (statustxt == "success") {
                    formSuccess();
                }
                else {
                    formError();
                    submitMSG(false, statustxt);
                }
            }
        });
    }
    function formSuccess() {
        $form[0].reset();
        submitMSG(true, "Enquiry Sent! We'll be in touch shortly.");
    }
    function formError() {
        $form.removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(this).removeClass();
        });
    }
    function submitMSG(valid, msg) {
        if (valid) {
            var msgClasses = "h4 tada animated text-success";
        }
        else {
            var msgClasses = "h4 text-danger";
        }
        $("#inquiryMsgSubmit").removeClass().addClass(msgClasses).text(msg);
    }

}(jQuery)); // End of use strict
