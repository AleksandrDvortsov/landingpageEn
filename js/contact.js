//
// Contact Form Js
//

var lng = window.localStorage.getItem('lng');
var errorName = "";
var errorEmail = "";
var errorComment = "";
var formValid = "";

var parent = $("#error-msg");
var contactForm = $("#contactForm");

if (lng == "ua") {
    errorName = "Имя еррор";
    errorEmail = "Емайл еррор";
    errorComment = "Коммент еррор";
    formValid = "сообщение отправленно. Спасибо!";
} else {
    errorName = "Please enter a name*";
    errorEmail = "Please enter a email*";
    errorComment = "Please enter a comments*";
    formValid = "En сообщение отправленно. Спасибо!";
}

contactForm.validate({
    rules: {
        email: {
            required: true,
            maxlength: 50
        },
        name: {
            required: true,
            maxlength: 50
        },
        comments: {
            required: true,
            maxlength: 250
        }

    },
    messages: {
        name: errorName,
        email: errorEmail,
        comments: errorComment,
    },
    submitHandler: function() {
        $.ajax({
            type: "POST",
            url: "php/contact.php",
            data: contactForm.serialize(),
            success: function(data) {
                console.log('Submission was successful.');
                console.log(data);
                parent.html("<div class='alert alert-success error_message'><i class='mdi mdi-alert'></i>" + formValid + "</div>");
                showMessage();
            },
            error: function(data) {
                console.log('An error occurred.');
                console.log(data);
                parent.html("<div class='alert alert-success error_message'><i class='mdi mdi-alert'></i>" + formValid + "</div>");
                showMessage();
            },
        });
    }
});

function showMessage() {
    parent.show();
}