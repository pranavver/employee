$(document).ready(function () {

    function validateField(selector, validator, errorMsg) {
        $(selector).on("input change", function () {
            const value = $(this).val().trim();
            const $error = $(this).next(".error-msg");
  
            // If no error message element exists, create it
            if (!$error.length) {
                $(this).after(
                    $("<div>")
                        .addClass("error-msg")
                        .css({
                            color: "red",
                            fontSize: "0.8em",
                            marginTop: "0px",
                        })
                );
            }
  
            // Apply validation
            if (validator(value)) {
                $(this).css("border", "1px solid green");
                $(this).next(".error-msg").text("");
            } else {
                $(this).css("border", "1px solid red");
                $(this).next(".error-msg").text(errorMsg);
            }
        });
    }
  
    // Validators
    const isNotLess = (value) => value.length >= 8;
    const isValidPass = (value) => /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/.test(value);
    const isValidEmail = (value) => /^[a-zA-Z0-9][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/.test(value);

     // Email Address
    validateField("#email", isValidEmail, "Invalid email address.");

    // Password
    // validateField("#password", isNotLess, "Password must be at least 8 characters long");
    // validateField("#password", isValidPass, "Use A-Z, a-z, 0-9, !@#$%^&* in password");

    // $("#password").on("input", function () {
    //     const value = $(this).val().trim();
    //     const $error = $(this).next(".error-msg");
    
    //     if (!$error.length) {
    //         $(this).after(
    //             $("<div>")
    //                 .addClass("error-msg")
    //                 .css({
    //                     color: "red",
    //                     fontSize: "0.8em",
    //                     marginTop: "0px",
    //                 })
    //         );
    //     }
    
    //     if (!isNotLess(value)) {
    //         $(this).css("outline", "1px solid red");
    //         $(this).next(".error-msg").text("Password must be at least 8 characters long.");
    //     } else if (!isValidPassword(value)) {
    //         $(this).css("outline", "1px solid red");
    //         $(this).next(".error-msg").text("Use A-Z, a-z, 0-9, !@#$%^&* in password.");
    //     } else {
    //         $(this).css("outline", "1px solid green");
    //         $(this).next(".error-msg").text("");
    //     }
    //     });
   
      $("#login-form").submit(function(e) {
            var email = $('#email').val();
            var password = $('#password').val();
            if (!isValidPass(password) && !isNotLess(password) && !isValidEmail(email))
            {
                e.preventDefault();
            }
        });
    
});
  