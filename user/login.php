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
    $email = $_POST['email'];
    $email = trim($email);
    $password = $_POST['password'];
    $password = trim($password);

    // Kiểm tra người dùng
    $checkUser = $conn->prepare("SELECT id, email, password FROM user WHERE email = ?");
    if (!$checkUser) {
        die("Prepare failed: " . $conn->error);
    }
    $checkUser->bind_param("s", $email);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows === 0) {
        $message[] = "Tài khoản không tồn tại hoặc sai địa chỉ email";
    } else {
        $checkUser->bind_result($dbId, $dbEmail, $dbPassword);
        $checkUser->fetch();

        if (password_verify($password, $dbPassword)) {
            $_SESSION['user_id'] = $dbId;
            // Chuyển hướng đến trang index.html sau khi đăng nhập thành công
            header("Location: ../index.html");
            exit();
        } else {
            $message[] = "Mật khẩu không đúng";
        }
    }

    $checkUser->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/img/title.png">
    <style>
        body {
            background-color: #000000; /* Nền ngoài màu đen */
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #2d3748;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            margin-top: 5%;
            z-index: 2;
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
    <title>Đăng nhập</title>
</head>

<body class="flex justify-center items-center h-screen">

    <div class="container">
        <div class="header">
            <h2>Đăng nhập</h2>
            <p class="text-sm">Chưa có tài khoản? <a href="register.php" class="text-blue-500 hover:underline">Đăng ký</a></p>
        </div>

        <form action="" method="post">
            <input class="input-field" name="email" placeholder="Nhập địa chỉ email" type="email" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input class="input-field" name="password" placeholder="Nhập mật khẩu" type="password" required oninput="this.value = this.value.replace(/\s/g, '')">

            <?php
            if (!empty($message)) {
                foreach ($message as $msg) {
                    echo '<p class="error-message">' . $msg . '</p>';
                }
            }
            ?>

            <button type="submit" class="btn-submit" name="submit">Đăng nhập</button>
        </form>

        <div class="footer">
            <p>© 2025 Movie Website</p>
        </div>
    </div>

</body>

</html>
