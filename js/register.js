$(document).ready(function () {
    let isEmailAvailable = true;
    
  // Function to validate fields
  function validateField(selector, validator, errorMsg) {
    $(selector).on("input", function () {
        const value = $(this).val().trim();
        let $error = $(this).next(".error-msg");

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
            $error = $(this).next(".error-msg");
        }

        if (validator(value)) {
            $(this).css("outline", "1px solid green").attr("data-error", "false");
            $error.text("");
        } else {
            $(this).css("outline", "1px solid red").attr("data-error", "true");
            $error.text(errorMsg);
        }
    });
}

// Validators
const isNotEmpty = (value) => value.length > 0;
const isNotLess = (value) => value.length >= 8;
const isValidEmail = (value) => /^[a-zA-Z0-9][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/.test(value);
const isValidPassword = (value) => /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/.test(value);
const isValidName = (value) => /^[A-Za-z\s]+$/.test(value);
const isMatchingPassword = () => $("#password").val() === $("#rePassword").val();

// Combined Name Validation
validateField("#fullName", (value) => isNotEmpty(value) && isValidName(value), "Full Name is required and must contain only letters and spaces.");
validateField("#dob", isNotEmpty, "Date of Birth is required.");
validateField("#permAddr", isNotEmpty, "Address is required.");
validateField("#currAddr", isNotEmpty, "Address is required.");
validateField("#perm_city", isNotEmpty, "City is required.");
validateField("#curr_city", isNotEmpty, "City is required.");
validateField("#email", isValidEmail, "Invalid email address.");

// Password Validation
$("#password").on("input", function () {
    const value = $(this).val().trim();
    let $error = $(this).next(".error-msg");

    if (!$error.length) {
        $(this).after(
            $("<div>")
                .addClass("error-msg")
                .css({
                    color: "red",
                    fontSize: "0.8em",
                    marginTop: "4px",
                })
        );
        $error = $(this).next(".error-msg");
    }

    if (!isNotLess(value)) {
        $(this).css("outline", "1px solid red").attr("data-error", "true");
        $error.text("Password must be at least 8 characters long.");
    } else if (!isValidPassword(value)) {
        $(this).css("outline", "1px solid red").attr("data-error", "true");
        $error.text("Use A-Z, a-z, 0-9, !@#$%^&* in password.");
    } else {
        $(this).css("outline", "1px solid green").attr("data-error", "false");
        $error.text("");
    }
});

$("#rePassword").on("input", function () {
    let $error = $(this).next(".error-msg");

    if (!$error.length) {
        $(this).after(
            $("<div>")
                .addClass("error-msg")
                .css({
                    color: "red",
                    fontSize: "0.8em",
                    marginTop: "4px",
                })
        );
        $error = $(this).next(".error-msg");
    }

    if (isMatchingPassword()) {
        $(this).css("outline", "1px solid green").attr("data-error", "false");
        $error.text("");
    } else {
        $(this).css("outline", "1px solid red").attr("data-error", "true");
        $error.text("Passwords do not match.");
    }
});

// Form Submission Validation
$("#registrationForm").on("submit", function (e) {
    let isValid = true;
    const fields = ['#fullName', '#dob', '#permAddr', '#currAddr', '#perm_city', '#curr_city', '#email', '#password'];

    fields.forEach(function (selector) {
        if ($(selector).attr("data-error") === "true" || !$(selector).val().trim()) {
            isValid = false;
        }
    });

    if (!isMatchingPassword()) {
        $("#rePassword").css("outline", "1px solid red").next(".error-msg").text("Passwords do not match.");
        isValid = false;
    }

    if (!isEmailAvailable) {
        // $("#email").next(".error-msg").text("Email already exists. Please use a different email.");
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
        console.log("Form submission cancelled due to validation errors.");
        const firstErrorField = $("[data-error='true']").first();
        if (firstErrorField.length) {
            $('html, body').animate({ scrollTop: firstErrorField.offset().top - 50 }, 400);
            firstErrorField.focus();
        }
    }
});



    $("#addQualification").on("click", function () {
        const count = $("input[name='qualifications[]']").length + 1;
        $(this).before(`<label class="suggession" style="margin-top: 10px;margin-bottom:5px;">Qualification ${count}</label>`);
        $("<input>")
            .attr("type", "text")
            .attr("name", "qualifications[]")
            .attr("placeholder", `Qualification ${count}`)
            .insertBefore($(this));
    });
  
    $("#addExperience").on("click", function () {
        const count = $("input[name='experiences[]']").length + 1;
        $(this).before(`<label class="suggession" style="margin-top: 10px;margin-bottom:5px;">Experience ${count}</label>`);
        $("<input>")
            .attr("type", "text")
            .attr("name", "experiences[]")
            .attr("placeholder", `Experience ${count}`)
            .insertBefore($(this));
    });

    
       
        
        
    let debounceTimer;

    // Function to live check if email exists
    function checkEmailExists(email) {
        clearTimeout(debounceTimer); // Clear any existing timer

        debounceTimer = setTimeout(function () {
            $.ajax({
                url: "check_email.php", // PHP file to handle the email check
                type: "POST",
                data: { email: email },
                dataType: "json", // Expect JSON response
                success: function (response) {

                    const $emailField = $("#email");
                    const $errorMsg = $emailField.next(".error-msg");
    
                    if (response.status === "exists") {
                        isEmailAvailable = false;
                        // Remove existing error message if any
                        if ($errorMsg.length) {
                            $errorMsg.remove();
                        }
    
                        // Create and append dynamic error message
                        $emailField.after(
                            $("<div>")
                                .addClass("error-msg")
                                .css({
                                    color: "red",
                                    fontSize: "0.8em",
                                    marginTop: "0px",
                                })
                                .text("Email already exists. Please use a different email.")
                        );
                        $emailField.css("outline", "1px solid red");
                    } else if (response.status === "available") {
                        isEmailAvailable = true;
                        // Remove error message if email is available
                        if ($errorMsg.length) {
                            $errorMsg.remove();
                        }
                        $emailField.after(
                            $("<div>")
                                .addClass("error-msg")
                                .css({
                                    color: "green",
                                    fontSize: "0.8em",
                                    marginTop: "0px",
                                })
                                .text("Email is available")
                        );
                        $emailField.css("outline", "1px solid green");
                    }
                    else if (response.status === "error") {
                        $emailField.after(
                            $("<div>")
                                .addClass("error-msg")
                                .css({
                                    color: "red",
                                    fontSize: "0.8em",
                                    marginTop: "0px",
                                })
                                .text(response.message)
                        );
                        $emailField.css("outline", "1px solid red");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                    isEmailAvailable = false;
                    const $emailField = $("#email");
                    const $errorMsg = $emailField.next(".error-msg");

                    if ($errorMsg.length) {
                        $errorMsg.remove();
                    }
                    $emailField.after(
                        $("<div>")
                            .addClass("error-msg")
                            .css({
                                color: "red",
                                fontSize: "0.8em",
                                marginTop: "4px",
                            })
                            .text("An error occurred while checking the email.")
                    );
                    $("#email").css("outline", "1px solid red");
                }
            });
        }, 500); // Wait 500ms before making the AJAX request
    }

    // Trigger email check on focusout
    $("#email").on("input", function () {
        const email = $(this).val().trim();
        console.log(email);
        const $emailField = $("#email");
        const $existingMsg = $emailField.next(".error-msg");

        // Remove any existing messages
        if ($existingMsg.length) {
            $existingMsg.remove();
        }

        if (email.length === 0) {
            $emailField.css("outline", "1px solid gray"); // Reset outline
            return; // Exit without showing any messages
        }

        if (isValidEmail(email)) {
            checkEmailExists(email);// Call the function to check email availability
        } 
        else {
            // Show invalid email error message
            $emailField.css("outline", "1px solid red");
            $emailField.after(
                $("<div>")
                    .addClass("error-msg")
                    .css({
                        color: "red",
                        fontSize: "0.8em",
                        marginTop: "0px",
                    })
                    .text("Invalid email address.")
            );
        }
    });
        
    
    

  
});

function previewProfilePic() {
    const file = document.getElementById("profile_pic").files[0];
    const preview = document.getElementById("profilePreview");
  
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
  }


//   $.ajax({
//     url: "../pages/check_email.php", // Adjust the path if needed
//     type: "POST",
//     data: { email: email },
//     success: function (response) {
//         const result = JSON.parse(response);
//         if (result.exists) {
//             $("#email").css("outline", "1px solid red");
//             $error.text(result.message);
//         } else {
//             $("#email").css("outline", "1px solid green");
//             $error.text("");
//         }
//     },
//     error: function () {
//         $("#email").css("outline", "1px solid red");
//         $error.text("Error checking email. Please try again.");
//     },
// });

//  $("#email").on("input", function () {
//         const email = $(this).val().trim();
//         const $errorMsg = $(this).next(".error-msg");

//         // If no error message element exists, create it
//         if (!$errorMsg.length) {
//             $(this).after(
//                 $("<div>")
//                     .addClass("error-msg")
//                     .css({
//                         color: "red",
//                         fontSize: "0.8em",
//                         marginTop: "4px",
//                     })
//             );
//         }

//         // AJAX request to check email
//         if (email !== "") {
//             $.ajax({
//                 url: "../path-to/check_email.php", // Update the path to your script
//                 type: "POST",
//                 data: { email: email },
//                 dataType: "json",
//                 success: function (response) {
//                     if (response.exists) {
//                         $("#email").css("outline", "1px solid red");
//                         $errorMsg.text(response.message).css("color", "red");
//                     } else {
//                         $("#email").css("outline", "1px solid green");
//                         $errorMsg.text(response.message).css("color", "green");
//                     }
//                 },
//                 error: function () {
//                     console.error("Error checking email.");
//                 },
//             });
//         } else {
//             $("#email").css("outline", "1px solid gray");
//             $errorMsg.text("");
//         }
//     });

