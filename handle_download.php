<?php
    session_start();
    if(!isset($_SESSION['userId'])) header("Location: index.php");  
    $id = $_GET['id'];
    $fileUrl = '';
    $fileName = '';
    require_once('config.php');
    $stmt = $link->prepare("SELECT * FROM posts WHERE postId = ? ");
    try{
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                $fileUrl = $row[fileUrl];
                $fileName = $row[fileName];
            }
        }
    }catch (Exception $e) {
        echo 'error';
    }

    if(!file_exists($fileUrl)){
        alert('檔案不存在或是已損毀', 'home.php');
    }else{
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        readfile($fileUrl);
    }
?>

<?php
function alert($text, $location){
    echo "<script>alert('$text')</script>";
    echo "<script>location.href='$location'</script>";
}
?>