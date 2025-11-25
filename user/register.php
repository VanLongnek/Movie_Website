<?php

include "../database/conect.php";

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

$message = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $username = trim($username);
    $email = $_POST['email'];
    $email = trim($email);
    $password = $_POST['password'];
    $password = trim($password);
    $cpassword = $_POST['cpassword'];
    $cpassword = trim($cpassword);

    // Kiểm tra email đã tồn tại hay chưa
    $checkEmailStmt = $conn->prepare("SELECT email FROM user WHERE email = ?");
    if (!$checkEmailStmt) {
        die("Prepare failed: " . $conn->error);
    }
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        $message[] = "Email đã tồn tại";
    } else {
        // Kiểm tra mật khẩu và xác nhận mật khẩu
        if ($password !== $cpassword) {
            $message[] = "Mật khẩu không khớp";
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $message[] = "Đăng ký tài khoản thành công";
            } else {
                $message[] = "Lỗi: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    $checkEmailStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/img/title.png">
    <style>
        /* Cải thiện giao diện */
        body {
            background-color: #000000; /* Màu nền ngoài đen */
            font-family: 'Arial', sans-serif;
        }

        .container {
            background: #2d3748;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            margin-top: 5%;
        }

        .header {
            text-align: center;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .input-field {
            padding: 0.75rem;
            margin-bottom: 1rem;
            width: 100%;
            background-color: #edf2f7;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
        }

        .input-field:focus {
            background-color: #e2e8f0;
            border: 2px solid #3182ce;
        }

        .btn-submit {
            background-color: #3182ce;
            color: white;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-submit:hover {
            background-color: #2b6cb0;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.875rem;
        }

        .success-message {
            background-color: #38a169;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .footer {
            text-align: center;
            color: #fff;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .footer a {
            color: #3182ce;
            text-decoration: underline;
        }
    </style>
    <title>Đăng ký</title>
</head>

<body class="flex justify-center items-center h-screen background-image fade-in relative">

    <div class="container">
        <div class="header">
            <h2>Đăng ký tài khoản</h2>
            <p class="text-sm">Đã có tài khoản? <a href="login.php" class="text-blue-500 hover:underline">Đăng nhập</a></p>
        </div>

        <form action="" method="post">
            <input class="input-field" name="username" placeholder="Nhập tên người dùng" type="text" required maxlength="50">
            <input class="input-field" name="email" placeholder="Nhập địa chỉ email" type="email" required oninput="this.value = this.value.replace(/\s/g, '')">
            <?php
            if (!empty($message)) {
                foreach ($message as $msg) {
                    if ($msg === "Email đã tồn tại") {
                        echo '<p class="error-message">' . $msg . '</p>';
                    }
                }
            }
            ?>

            <input class="input-field" name="password" placeholder="Nhập mật khẩu" type="password" required minlength="6">
            <input class="input-field" name="cpassword" placeholder="Xác nhận mật khẩu" type="password" required>

            <?php
            if (!empty($message)) {
                foreach ($message as $msg) {
                    if ($msg === "Mật khẩu không khớp") {
                        echo '<p class="error-message">' . $msg . '</p>';
                    }
                }
            }
            ?>

            <button type="submit" class="btn-submit" name="submit">Đăng ký</button>
        </form>

        <?php
        if (!empty($message)) {
            foreach ($message as $msg) {
                if ($msg === "Đăng ký tài khoản thành công") {
                    echo '<div class="success-message">' . $msg . '</div>';
                }
            }
        }
        ?>

        <div class="footer">
            <p>© 2025 Movie Website</p>
        </div>
    </div>

</body>

</html>
