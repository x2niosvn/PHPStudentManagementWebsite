<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Custom CSS for the login form */
        body {
        }

        .login-form {
            max-width: 400px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            background-color: #1e1e1e;
            color: #fff;
            margin: 100px auto;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
            color: #fff;
        }

        .login-form .form-control {
            border: 1px solid #666;
            border-radius: 5px;
            box-shadow: none;
            background-color: #282828;
            color: #fff;
        }

        .login-form .form-control:focus {
            border-color: #999;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        .login-form .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }

        .login-form .btn-primary:hover {
            background-color: #0056b3;
        }


        .login-form .alert.alert-danger {
            display: block;
            background-color: #721c24;
            border-color: #f5c6cb;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <?php
            session_start();
            require_once 'db_connect.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Kiểm tra thông tin đăng nhập trong cơ sở dữ liệu
                $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Đăng nhập thành công
                    $_SESSION['username'] = $username;
                    header("Location: dashboard.php"); // Điều hướng đến trang dashboard sau khi đăng nhập thành công
                    exit();
                } else {
                    // Đăng nhập không thành công
                    echo '<div class="alert alert-danger mt-3 text-light" role="alert">Invalid username or password.</div>';
                }
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
