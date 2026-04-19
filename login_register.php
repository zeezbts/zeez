<?php
 session_start();
 require_once 'config.php';

 if (isset($_POST['register'])) {
    $name =$_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkemail = $conn->query("SELECT email FROM user WHERE email = '$email'");
    if ($checkemail->run_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
         
    } else {
        $conn->query("INSERT INTO user (name, email, passwoard, role) VALUES ('$name', '$email', '$password', 'role')");
    }

    header("Location: index.php");
    exit();
 }

 if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FORM user WHERE email = '$email'");
    if ($result->num_rows > 0) {
      $user = $result->num_rows->fetch_assoc();
      if(password_verify($password, $useer['password'])) {
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        if ($user['role'] === 'admin') {
            header("Location: admin_page.php");
        } else {
            header("Location: user_page.php");
        }
       exit();
      }
    }
    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header('Location: index.php');
    exit();
 }
