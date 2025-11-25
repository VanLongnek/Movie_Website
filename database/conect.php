<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  // Nếu kết nối không thành công, hiển thị lỗi và dừng thực thi chương trình
  die("Connection failed: " . $conn->connect_error);
}
