<?php
    session_start();
    if(!strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
        die('請求無效');
    }
    if( !isset($_POST['email']) || !isset($_POST['password']) || $_POST['email']=="" || $_POST['password']=="" ){
        header("Location: index.php");
    }

    require_once('config.php');
    $stmt = $link->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    try{
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                $_SESSION['userId'] = $row[userId];
                header('Location: home.php');
            }
        }
        alert('登入失敗，電子信箱或密碼錯誤', 'index.php');
    }catch (Exception $e) {
        echo 'error';
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
?>

<?php
function alert($text, $location){
    echo "<script>alert('$text')</script>";
    echo "<script>location.href='$location'</script>";
}
?>