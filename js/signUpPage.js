$(document).ready(function () {
    app.websiteRoot = "";
    $("#signUpForm").ajaxForm({
        beforeSubmit: function (formData) {
			var isValid = false;
            for (var i = 0; i < formData.length; i++) {
                if (formData[i].required && formData[i].value.trim() === "") {
                    app.showNotificationFailure("Required fields are empty");
                    return false;
				}
				
                if (formData[i].name == "email") {
                    formData[i].value = formData[i].value.toLowerCase();
                    if (app.validateEmail(formData[i].value) === app.emailValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name == "password") {
                    if (app.validatePassword(formData[i].value) === app.passwordValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name == "confirm_password") {
                    if (app.validateConfirmPassword(formData[i - 1].value, formData[i].value) === app.confirmPasswordValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                } else if (formData[i].name == "first_name" || formData[i].name == "last_name") {
                    isValid = true;
                } else if (formData[i].name == "phone_number") {
                    if (app.validateNumber(formData[i].value) === app.numberValidationState.SUCCESS)
                        isValid = true;
                    else {
                        isValid = false;
                        break;
                    }
                }
            }
            if (!isValid) {
                app.showNotificationFailure("Validation Failed for some input field");
                return false;
            }
            $(".cover").fadeIn(100);
            $("#pageLoading").addClass("loader");
        },
        success: function (responseText, statusText, xhr, $form) {
            console.log(responseText);
            var response = JSON.parse(responseText);
            if (response.status == 0) {
                app.showNotificationFailure(response.message);
            }
            else {
                app.showNotificationSuccess(response.message);
                window.location.href = "login.php";
            }
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        },
        error: function () {
            app.showNotificationFailure("Our Server probably took a Nap!<br/>Try Again! :-)");
            $("#pageLoading").removeClass("loader");
            $(".cover").fadeOut(100);
        }
    });

    $("#email").on('input propertychange', function () {
        app.validate(this, 2);
    });

    $("#phoneNumber").on('input propertychange', function () {
        app.validate(this, 3);
    });

    $("#password").on('input propertychange', function () {
        app.validate(this, 4);
    });

    $("#confirmPassword").on('input propertychange', function () {
        app.validate(this, 5);
    });
});
