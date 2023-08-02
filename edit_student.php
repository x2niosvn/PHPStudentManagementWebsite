<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
        <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Edit Student</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Check if studentID is provided in the URL
                        if (isset($_GET["studentID"])) {
                            $studentID = $_GET["studentID"];

                            // Include the database connection
                            include 'db_connect.php';

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("SELECT StudentID, FirstName, LastName, StudentCode, DateOfBirth, Gender, ContactNumber, Email, Address, EnrollmentStatus FROM Student WHERE StudentID = ?");
                            $stmt->bind_param("i", $studentID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="studentID" value="<?php echo $row["StudentID"]; ?>">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row["FirstName"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row["LastName"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="studentCode" class="form-label">Student Code</label>
                                        <input type="text" class="form-control" id="studentCode" name="studentCode" value="<?php echo $row["StudentCode"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="<?php echo $row["DateOfBirth"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" <?php echo $row["Gender"] === "Male" ? "checked" : ""; ?> required>
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female" <?php echo $row["Gender"] === "Female" ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="other" value="Other" <?php echo $row["Gender"] === "Other" ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="other">Other</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contactNumber" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?php echo $row["ContactNumber"]; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["Email"]; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo $row["Address"]; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Enrollment Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="enrollmentStatus" id="active" value="Active" <?php echo $row["EnrollmentStatus"] === "Active" ? "checked" : ""; ?> required>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="enrollmentStatus" id="inactive" value="Inactive" <?php echo $row["EnrollmentStatus"] === "Inactive" ? "checked" : ""; ?>>
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="view_students.php" class="btn btn-secondary">Cancel</a>
                                </form>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Student not found.</div>';
                            }

                            // Close statement and connection
                            $stmt->close();
                            $conn->close();
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Invalid request.</div>';
                        }

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php'; // Include the database connection

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("UPDATE Student SET FirstName = ?, LastName = ?, StudentCode = ?, DateOfBirth = ?, Gender = ?, ContactNumber = ?, Email = ?, Address = ?, EnrollmentStatus = ? WHERE StudentID = ?");
    $stmt->bind_param("sssssssssi", $firstName, $lastName, $StudentCode, $dateOfBirth, $gender, $contactNumber, $email, $address, $enrollmentStatus, $studentID);

    // Set parameters and execute
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $StudentCode = $_POST["studentCode"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $gender = $_POST["gender"];
    $contactNumber = $_POST["contactNumber"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $enrollmentStatus = $_POST["enrollmentStatus"];
    $studentID = $_POST["studentID"];

    if ($stmt->execute()) {
        echo '<div class="alert alert-success mt-3" role="alert">Student information updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Error updating student information. Please try again later.</div>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
