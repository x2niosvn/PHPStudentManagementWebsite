<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add Student</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                            <div class="mb-3">
                                <label for="studentCode" class="form-label">Student Code</label>
                                <input type="text" class="form-control" id="studentCode" name="studentCode" required>
                            </div>
                            <div class="mb-3">
                                <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Enrollment Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="enrollmentStatus" id="active" value="Active" required>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="enrollmentStatus" id="inactive" value="Inactive">
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>

                        <?php
                        // Process form data when the form is submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            include 'db_connect.php'; // Include the database connection

                            // Prepare and bind SQL statement
                            $stmt = $conn->prepare("INSERT INTO Student (FirstName, LastName, StudentCode, DateOfBirth, Gender, ContactNumber, Email, Address, EnrollmentStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssssssss", $firstName, $lastName, $studentCode, $dateOfBirth, $gender, $contactNumber, $email, $address, $enrollmentStatus);

                            // Set parameters and execute
                            $firstName = $_POST["firstName"];
                            $lastName = $_POST["lastName"];
                            $studentCode = $_POST["studentCode"];
                            $dateOfBirth = $_POST["dateOfBirth"];
                            $gender = $_POST["gender"];
                            $contactNumber = $_POST["contactNumber"];
                            $email = $_POST["email"];
                            $address = $_POST["address"];
                            $enrollmentStatus = $_POST["enrollmentStatus"];

                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success mt-3" role="alert">Student added successfully!</div>';
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">Error adding student. Please try again later.</div>';
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
