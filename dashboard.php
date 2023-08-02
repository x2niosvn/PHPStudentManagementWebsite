<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa, nếu chưa thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <? require_once 'header.php'; ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Students</h3>
                        <a href="add_student.php" class="btn btn-light mt-3">Add Student</a>
                        <a href="view_students.php" class="btn btn-light mt-3">View Students</a>
                        <!-- Add other actions for managing students -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Courses</h3>
                        <a href="add_course.php" class="btn btn-light mt-3">Add Course</a>
                        <a href="view_courses.php" class="btn btn-light mt-3">View Courses</a>
                        <!-- Add other actions for managing courses -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Grading Components</h3>
                        <a href="add_grading_component.php" class="btn btn-light mt-3">Add Grading Component</a>
                        <a href="view_grading_components.php" class="btn btn-light mt-3">View Grading Components</a>
                        <!-- Add other actions for managing grading components -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Enrollment</h3>
                        <a href="add_enrollment.php" class="btn btn-light mt-3">Add Enrollment</a>
                        <a href="view_enrollments.php" class="btn btn-light mt-3">View Enrollment</a>
                        <!-- Add other actions for managing grading components -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Manage Score</h3>
                        <a href="add_score.php" class="btn btn-light mt-3">Add Score</a>
                        <a href="view_scores.php" class="btn btn-light mt-3">View Score</a>
                        <!-- Add other actions for managing grading components -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Add other content and scripts as needed -->
</body>
</html>
