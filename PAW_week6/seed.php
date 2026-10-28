<?php
$conn = mysqli_connect("localhost", "root", "", "db_web");
$email = "admin@mail.com";
$hash  = password_hash("admin123", PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "INSERT INTO users (email, password) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $email, $hash);
mysqli_stmt_execute($stmt);
echo "User dibuat: $email / admin123";