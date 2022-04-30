<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: manage_login.php");
    if(!strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
        die('請求無效');
    }
    require_once('config.php');
    $title = mysqli_real_escape_string($link, $_POST['title']);
    if($stmt = $link->prepare("UPDATE `web` SET `title`=? WHERE 1")){
        try{
            $stmt->bind_param('s', $title);
            $stmt->execute();
            $row = $stmt->affected_rows;
            if($row > 0) {
                alert('更新成功', 'manage.php');
            }
        }catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), '<br>';
            echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
        }
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