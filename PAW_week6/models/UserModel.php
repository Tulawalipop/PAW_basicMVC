<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = mysqli_connect("localhost", "root", "", "db_web");
    }

    public function checkLogin($email, $password) {
        $stmt = mysqli_prepare($this->conn, "SELECT id, email, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);   // jangan simpan hash di session
            return $user;
        }
        return false;
    }
}