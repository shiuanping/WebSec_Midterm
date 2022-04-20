<?php
    session_start();
    if( !isset($_POST['email']) || !isset($_POST['password']) || $_POST['email']=="" || $_POST['password']=="" ){
        header("Location: manage_login.php");
    }

    require_once('config.php');
    $stmt = $link->prepare("SELECT * FROM administrator WHERE email = ? AND password = ?");
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    try{
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                $_SESSION['admin'] = $row[adminId];
                header('Location: manage.php');
            }
        }
        alert('登入失敗，電子信箱或密碼錯誤', 'manage_login.php');
    }catch (Exception $e) {
        echo 'error';
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
?>