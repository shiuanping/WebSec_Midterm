<?php
session_start();
if(!isset($_SESSION['userId'])) header("Location: index.php");
$userId = $_SESSION['userId'];
$valid = false;

require_once('config.php');
if($stmt = $link->prepare("SELECT * FROM `posts` WHERE postId = ?")){
    $postId = mysqli_real_escape_string($link, $_GET['id']);
    try{
        $stmt->bind_param('s', $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                if($userId != $row[userId]){
                    header('Location: home.php');
                }else{
                    $valid = true;
                }
                if(($valid == true)&&(file_exists($row[fileUrl]))){
                    unlink($row[fileUrl]);
                }
            }
        }
    }catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }
}

if($valid){
    if($stmt = $link->prepare("DELETE FROM posts WHERE postId = ?")){
        try{
            $stmt->bind_param('s', $postId);
            $stmt->execute();
            header('Location: home.php');
        }catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), '<br>';
            echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
        }
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
