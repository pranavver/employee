<?php $version=time();

require_once "./fetch_dashboard.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/dashboard.css?v=<?=$version?>">
    <title>Dashboard</title>
</head>
<body>
    <h3>Employee Profile</h3>
    <div class="profile-header">
        <img src="<?= htmlspecialchars($profilePic) ?>" alt="Profile Picture" id="profile-pic" accept="image/*"/>
        <input type="file" name="profile_picture" id="profile_picture" style="display: none;">
        <i class="icon img">&#9998;</i>
        <h4 id="profile-name"><?= htmlspecialchars($profileName) ?></h4>
        <p id="user-email"><?= htmlspecialchars($userEmail) ?></p>
        <p id="dob">DOB - <?= date('d M Y', strtotime(htmlspecialchars($dob))); ?></p>
    </div>

    <div class="profile-details">

        <div class="details-section">
            <div class="qualifications">
                <h5>Qualifications</h5>
                <?php foreach ($qualifications as $index => $qualification): ?>
                    <div class="data">
                            <input type="text" name="qualification" value="<?= htmlspecialchars($qualification['qualification']) ?>" id="<?= $qualification['id'] ?>" readonly disabled>
                            <i class="icon pencil">&#9998;</i>
                    </div>
                <?php endforeach; ?>
                <label id="addQualification" class="addMore">Add Qualification</label>
            </div>
            <div class="experiences">
                <h5>Experiences</h5>
                <?php foreach ($experiences as $index => $experience): ?>
                    <div class="data">
                        <input type="text" name="experience" value="<?= htmlspecialchars($experience['experience']) ?>" id="<?=  $experience['id'] ?>" readonly disabled>
                        <i class="icon pencil">&#9998;</i>
                        <!-- <i class="fa fa-save"></i> -->
                    </div>
                <?php endforeach; ?>
                <label id="addExperience" class="addMore">Add Experience</label>
            </div>
        </div>
         <div class="details-section">
            <div class="address">
                <h5>Current Address</h5>
                <div class="data">
                    <input type="text" name="current_address_line1" value="<?= htmlspecialchars($currAddressLine1) ?>" id="currentAddressLine1" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="current_address_line2" value="<?= htmlspecialchars($currAddressLine2) ?>" id="currentAddressLine2" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="current_city" value="<?= htmlspecialchars($currCity) ?>" id="currentCity" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="current_state" value="<?= htmlspecialchars($currState) ?>" id="currentState" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
            </div>
            <div class="permanent-address">
                <h5>Permanent Address</h5>
                <div class="data">
                    <input type="text" name="permanent_address_line1" value="<?= htmlspecialchars($permAddressLine1) ?>" id="permanentAddressLine1" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="permanent_address_line2" value="<?= htmlspecialchars($permAddressLine2) ?>" id="permanentAddressLine2" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="permanent_city" value="<?= htmlspecialchars($permCity) ?>" id="permanentCity" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
                <div class="data">
                    <input type="text" name="permanent_state" value="<?= htmlspecialchars($permState) ?>" id="permanentState" readonly disabled>
                    <i class="icon pencil">&#9998;</i>
                </div>
            </div>
        </div>
    </div>
<script src="../js/dashboard.js?v=<?=$version?>"></script>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/dashboard.css?v=<=$version?>">
    <title>Dashboard</title>
</head>
<body>
    <h3>Employee Profile</h3>
    <div class="profile-header">

        <img src="../uploads/default-profile.png" alt="Profile Picture" id="profile-pic"/>
        <i class="icon">&#9998;</i>
        <h4 id="profile-name">John Doe</h4>
        <p id="user-email">john@doe.com</p>
        <p id="dob">DOB - 1 Jan 1990</p>
    </div>

    <div class="profile-details">
        <div class="details-section">
            <div class="qualifications">
                <h5>Qualifications</h5>
                <div class="data">
                <input type="text" name="qualification1" id="q1">
                <i class="icon">&#9998;</i>
                </div>
                <label id="addQualification" class="addMore">Add Qualification</label>
            </div>
            <div class="experiences">
                <h5>Experiences</h5>
                <div class="data">
                <input type="text" name="qualification1" id="q2">
                <i class="fa fa-save"></i>
                </div>
                <label id="addExperience" class="addMore">Add Experience</label>
            </div>
        </div>
         <div class="details-section">
            <div class="address">
                <h5>Current Address</h5>
                <div class="data">
                <input type="text" name="address" id="a1">
                <i class="icon">&#9998;</i>
                </div>
            </div>
            <div class="permanent-address">
                <h5>Permanent Address</h5>
                <div class="data">
                <input type="text" name="permanentAddress" id="a2">
                <i class="icon">&#9998;</i>
                </div>
            </div>
        </div>
    </div>
<script src="../js/dashboard.js?v=<=$version?>"></script>
</body>
</html> -->