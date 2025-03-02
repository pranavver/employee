<?php $version = time();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Registration Form</title>
  <link rel="stylesheet" href="../css/register.css?v=<?=$version?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h3 style="text-align:center">Employee Registration Form</h3>
  <div class="form-container">
    <form action="register_emp.php" id="registrationForm" method="POST" enctype="multipart/form-data">
        
    <div class="form-row grid">

      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" required>
      </div>
       <div class="form-group image">
            <img src="../uploads/default-profile.png" alt="Profile Picture" id="profilePreview" style="align-items:center;">
            <input type="file" id="profile_pic" name="profile_pic" accept="image/*" onchange="previewProfilePic()" style="display: none;">
            <label for="profile_pic" class="upload-btn">Upload Profile Pic</label>
        </div>
      <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" min="1900-01-01" max="2015-12-31" required>
      </div>  
         
    </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" aria-required="true" name="password" required>
          <label class="suggession">Use A-Z, a-z, 0-9, !@#$%^&* in password</label>
        </div>
        <div class="form-group">
          <label for="rePassword">Re-Password</label>
          <input type="password" id="rePassword" required>
        </div>
      </div>

      <div class="form-group">
        <label>Add your Qualifications</label>
        <label for="addQualification" class="suggession">Qualification 1</label>
        <input type="text" name="qualifications[]">
        <label id="addQualification" class="addMore">Add Qualification</label>
      </div>

      <div class="form-group">
        <label>Add your Experiences</label>
        <label for="addExperience" class="suggession">Experience 1</label>
        <input type="text" name="experiences[]">
        <label id="addExperience" class="addMore">Add Experience</label>
      </div>

      <div class="form-group">
        <label>Permanent Address</label>
        <input type="text" placeholder="Line 1" name="perm_address_line1" id="permAddr" required>
        <input type="text" placeholder="Line 2" name="perm_address_line2">
        <div class="form-row">
          <input type="text" placeholder="City" name="perm_city" id="perm_city" required>
          <select name="perm_state" required>
            <option value="">Select State</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
            <option value="Assam">Assam</option>
            <option value="Bihar">Bihar</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Goa">Goa</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Haryana">Haryana</option>
            <option value="Himachal Pradesh">Himachal Pradesh</option>
            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
            <option value="Jharkhand">Jharkhand</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Kerala">Kerala</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Manipur">Manipur</option>
            <option value="Meghalaya">Meghalaya</option>
            <option value="Mizoram">Mizoram</option>
            <option value="Nagaland">Nagaland</option>
            <option value="Odisha">Odisha</option>
            <option value="Punjab">Punjab</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Sikkim">Sikkim</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Tripura">Tripura</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
            <option value="Uttarakhand">Uttarakhand</option>
            <option value="West Bengal">West Bengal</option>
            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
            <option value="Daman and Diu">Daman and Diu</option>
            <option value="Delhi">Delhi</option>
            <option value="Lakshadweep">Lakshadweep</option>
            <option value="Puducherry">Puducherry</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Current Address</label>
        <input type="text" placeholder="Line 1" name="curr_address_line1" id="currAddr" required>
        <input type="text" placeholder="Line 2" name="curr_address_line2">
        <div class="form-row">
          <input type="text" placeholder="City" name="curr_city" id="curr_city" required>
          <select name="curr_state" required>
          <option value="">Select State</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
            <option value="Assam">Assam</option>
            <option value="Bihar">Bihar</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Goa">Goa</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Haryana">Haryana</option>
            <option value="Himachal Pradesh">Himachal Pradesh</option>
            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
            <option value="Jharkhand">Jharkhand</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Kerala">Kerala</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Manipur">Manipur</option>
            <option value="Meghalaya">Meghalaya</option>
            <option value="Mizoram">Mizoram</option>
            <option value="Nagaland">Nagaland</option>
            <option value="Odisha">Odisha</option>
            <option value="Punjab">Punjab</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Sikkim">Sikkim</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Tripura">Tripura</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
            <option value="Uttarakhand">Uttarakhand</option>
            <option value="West Bengal">West Bengal</option>
            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
            <option value="Daman and Diu">Daman and Diu</option>
            <option value="Delhi">Delhi</option>
            <option value="Lakshadweep">Lakshadweep</option>
            <option value="Puducherry">Puducherry</option>
          </select>
        </div>
      </div>

      <button type="submit" class="submit-button">Sign Up</button>
    </form>
  </div>
  <script src="../js/register.js?v=<?=$version?>"></script>
</body>
</html>