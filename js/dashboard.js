$(document).ready(function() {
    $(document).on('focus', 'input[type="text"]', function() {
        $(this).closest('.data').css('outline', '1px solid #a1a1a1');
    }).on('blur', 'input[type="text"]', function() {
        $(this).closest('.data').css('outline', 'none');
    });
    // $('input[type="text"]').focus(function() {
    //     $(this).closest('.data').css('outline', '1px solid #a1a1a1');
    // }).blur(function() {
    //     $(this).closest('.data').css('outline', 'none');
    // });

    $("#addQualification").click(function () {
        // $(this).before(`<div class='data new-field'>
        //         <input type='text' name='qualification1'>
        //         <i class='fa fa-save' style="font-size:20px;"></i>
        //         </div>`);
        $(this).before(
            $('<div>')
            .addClass('data new-field')
            .append(
                $('<input>')
                .attr('type', 'text')
                .attr('name', "qualification")
                .attr('data-new', 'true') // Mark as a new record
            )
            .append(
                $('<i>')
                .addClass('fa fa-save save-icon')
            ));
        });
    
        
        // Add Experience
        //   $("#addExperience").click(function () {
            //     $(this).before(`<div class='data new-field'>
            //             <input type='text' name='qualification1'>
            //             <i class='fa fa-save' style="font-size:20px;"></i>
            //             </div>`);
    $("#addExperience").click(function () {
        $(this).before(
            $('<div>')
            .addClass('data new-field')
            .append(
                $('<input>')
                .attr('type', 'text')
                .attr('name', "experience")
                .attr('data-new', 'true') // Mark as a new record
            )
            .append(
                $('<i>')
                .addClass('fa fa-save save-icon')
                // .css('font-size', '20px')
            ));
        });


      
            // Enable editing on pencil icon click
        // $('.icon.pencil').click(function() {
        //     var inputField = $(this).siblings('input');
        //     inputField.prop('readonly', false).prop('disabled', false).focus();
        // });

         // Enable editing on pencil icon click and change to save icon
        $(document).on('click', '.icon.pencil', function () {
            var inputField = $(this).siblings('input');
            inputField.prop('readonly', false).prop('disabled', false).focus();

            var saveIcon = $('<i>').addClass('fa fa-save save-icon').css({"font-size":"20px",});
            $(this).replaceWith(saveIcon);
        });
    


         //Save changes on save icon click
    $(document).on('click', '.save-icon', function () {
        var inputField = $(this).siblings('input');
        var fieldName = inputField.attr('name');
        var fieldValue = inputField.val().trim();
        var recordId = inputField.attr('id'); // Existing record ID
        var isNew = inputField.data('new'); // Check if it's a new record

        if (!fieldValue || !fieldName) {
            alert('Field value cannot be empty.');
            return;
        }

        // Define the URL for new or existing records
        var url = isNew ? 'save_new_record.php' : 'update_record.php';
        var data = { fieldName: fieldName, fieldValue: fieldValue };

        // Add record ID for existing entries
        if (!isNew) {
            data.id = recordId;
        }

        // AJAX call to save the updated or new value
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    alert('Invalid server response.');
                    return;
                }

                if (response.status === 'success') {
                    alert('Field saved successfully.');
                    inputField.prop('readonly', true).prop('disabled', true);
                    // Change back to pencil icon
                    $(this).removeClass('fa-save save-icon').addClass('icon pencil').html('&#9998;');
                    // Remove new flag for new entries after saving
                    if (isNew) {
                        inputField.removeAttr('data-new').attr('id', response.id);
                    }

                } else {
                    alert(response.message || 'Failed to save the field.');
                }
            }.bind(this),
            // error: function () {
            //     alert('An error occurred while saving the field.');
            // }
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Server Response:', xhr.responseText);
                alert('An error occurred while saving the field. Check console for details.');
            }
        });
    });



    // Handle profile picture selection and preview
    $(".icon.img").on("click", function () {
        $("#profile_picture").click(); // Trigger the file input dialog
    });

    // Handle image preview and change the icon to save
    $("#profile_picture").on("change", function () {
        const preview = $("#profile-pic"); // Profile picture for preview
        if ($("#profile_picture")[0].files && $("#profile_picture")[0].files[0]) {
            $(".icon.img").replaceWith('<i class="fa fa-save save-img"></i>'); // Replace pencil with save icon

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.attr("src", e.target.result); // Set the preview image
            };
            reader.readAsDataURL($("#profile_picture")[0].files[0]);
        }
    });


    // Handle file selection and upload via AJAX
    // Save profile picture on save icon click
    $(document).on("click", ".save-img", function () {
        var file = $("#profile_picture")[0].files[0]; // Get the selected file
        var formData = new FormData();
        formData.append("profile_picture", file);

        // AJAX to upload the profile picture
        $.ajax({
            url: 'update_profile_picture.php', // Server-side script for image upload
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    $(".save-img").replaceWith('<i class="icon img">&#9998;</i>'); // Switch back to the pencil icon
                    alert('Profile picture updated successfully!');
                } else {
                    alert('Failed to update profile picture.');
                }
            },
            error: function () {
                alert('An error occurred while uploading the profile picture.');
            }
        });
    });

    
    
        // Save changes on blur or Enter key press
        // $('input').on('blur', function() {
        //         var inputField = $(this);
        //         var fieldName = inputField.attr('name');
        //         var fieldValue = inputField.val();
        //         var recordId = inputField.attr('id');

        //         // Validate fieldName and fieldValue
        //         if (!fieldName.trim() || !fieldValue.trim() || !recordId) {
        //             alert('Invalid input. Please try again.');
        //             return;
        //         }
    
        //         // AJAX call to save the updated value
        //         $.ajax({
        //             url: 'update_field.php',
        //             type: 'POST',
        //             data: {
        //                 fieldName: fieldName,
        //                 fieldValue: fieldValue,
        //                 id: recordId
        //             },
        //             success: function(response) {
        //                 // Parse the response if it's JSON
        //                 try {
        //                     response = JSON.parse(response);
        //                 } catch (e) {
        //                     alert('Invalid server response.');
        //                     return;
        //                 }

        //                 // Check the server response
        //                 if (response.status === 'success') {
        //                     alert('Field updated successfully.');
        //                     inputField.prop('readonly', true).prop('disabled', true);
        //                 } else {
        //                     alert(response.message || 'Failed to update the field.');
        //                 }
        //             },
        //             error: function() {
        //                 alert('An error occurred while updating the field.');
        //             }
        //         });
        // });
        
            

});
