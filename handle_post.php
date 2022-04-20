<?php
    session_start();
    if(!isset($_SESSION['userId'])) header("Location: index.php");
    $id = 'P'.md5(uniqid()); 
    $title = $_POST['title'];
    $content = $_POST['message'];
    $userId = $_SESSION['userId'];
    $fileName = NULL;
    $fileUrl = NULL;
    $random = md5(uniqid());
    
    if($_FILES['post-file']['error'] === UPLOAD_ERR_OK){
        $name = $_FILES['post-file']['name'];
        $extName  = substr( $name, strrpos( $name, '.' ) + 1);
        $fileName = str_replace('.'.$extName, "", $name).'.'.$extName;
        $url = 'tmp/postfile/'.$random.$id.'.'.$extName;
        move_uploaded_file($_FILES['post-file']['tmp_name'], $url);
        $fileUrl = $url;
    }

    require_once('config.php');
    $title = mysqli_real_escape_string($link, $title);
    $content = mysqli_real_escape_string($link, $content);
    $fileName = mysqli_real_escape_string($link, $fileName);
    $fileUrl = mysqli_real_escape_string($link, $fileUrl);
    if($stmt = $link->prepare("INSERT INTO posts (postId, title, content, date,fileName, fileUrl, userId) VALUES(?, ?, ?, DEFAULT, ?, ?, ?)")){
        try{
            $stmt->bind_param('ssssss', $id, $title, $content, $fileName, $fileUrl, $userId);
            $stmt->execute();
            $row = $stmt->affected_rows;
            if($row > 0) {
                header('Location: home.php');
            }else{
                alert('新增失敗，請再試一次', 'post.php');
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

<?php
    // if($_FILES['post-file']['error'] === UPLOAD_ERR_OK){
    //     $fileName = $_FILES['post-file']['name'];
    //     $extName = strrchr($fileName, ".");
    //     $name = str_replace($extName, "", $fileName);
    //     move_uploaded_file($_FILES['post-file']['tmp_name'],'tmp/postfile/'.$name.$id.$extName);
    //     $fileUrl = 'tmp/postfile/'.$name.$id.$extName;
    // }
    // require_once('config.php');
    // $sql = "INSERT INTO `posts` (`postId`, `title`, `content`, `date`, `file`, `userId`) VALUES ('$id','$title','$content', DEFAULT, '$fileUrl', '$userId')";
    // $result=mysqli_query($link,$sql);
    // try {
    //     if ($result) {
    //         header('Location: home.php');
    //     }
    // }
    // catch (Exception $e) {
    //     echo 'Caught exception: ', $e->getMessage(), '<br>';
    //     echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    // }
    // mysqli_close($link);
?>