<?php

    if(!strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
        die('請求無效');
    }else{
        die('ok');
    }
    
    if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
        header("Location: index.php");
        alert('資料未輸入完全', 'index.php');
        $valid = false;
    }

    if( !isset($_POST['email']) || $_POST['email']=="" ){
        alert('資料未輸入完全', 'index.php');
        $valid = false;
    }

    require_once('config.php');
    $stmt = $link->prepare("SELECT * FROM users WHERE email = ? ");
    $id = mysqli_real_escape_string($link, 'U'.md5(uniqid())); 
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $profile = 'tmp/profile/default.png';
    $valid = true;
    try{
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                alert('註冊失敗，此信箱已被使用', 'signup.php');
                $valid = false;
            }
        }
    }catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }

    if($_FILES['profile-img']['error'] === UPLOAD_ERR_OK){
        $fileName = $_FILES['profile-img']['name'];
        $tmpName = $_FILES['profile-img']['tmp_name'];
        $type = $_FILES['profile-img']['type'];
        $extName  = substr( $fileName, strrpos( $fileName, '.' ) + 1);
        if (!in_array($extName, ['png', 'jpeg', 'jpg']) !== false) {
            die("檔案類型錯誤，只接受 jpg、jpeg、png");
        }
        if (in_array($type, ["image/png", "image/jpeg", "image/jpg"]) === false) {
            die("檔案類型錯誤，只接受 jpg、jpeg、png");
        }
        if(validContent($tmpName) !== 0){
            die("檔案類型錯誤，只接受 jpg、jpeg、png");
        }
        move_uploaded_file($_FILES['profile-img']['tmp_name'],'tmp/profile/'.$id.'.'.$extName);
        $profile = 'tmp/profile/'.$id.'.'.$extName;
    }

    if((isset($_POST['profile-url']))&&($_POST['profile-url'] != "")){
        $url = $_POST['profile-url'];
        $profile = download($url, $id);
    }

    if($stmt = $link->prepare("INSERT INTO users (userId, username, email, password, profile) VALUES(?, ?, ?, ?, ?)")){
        try{
            $stmt->bind_param('sssss', $id, $username, $email, $password, $profile);
            $stmt->execute();
            $row = $stmt->affected_rows;
            if($row > 0) {
                alert('註冊成功', 'index.php');
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
function download($url, $id){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    $mime = getUrlMimeType($url);
    if(($mime != 'image/jpeg')&&($mime != 'image/jpg')&&($mime != 'image/png')){
        die("檔案類型錯誤，圖片網址需為 jpg、jpeg、png 格式");
    }
    $fileName = pathinfo($url, PATHINFO_BASENAME);
    $fileExt  = substr( $fileName, strrpos( $fileName, '.' ) + 1);
    if (!in_array($fileExt, ['png', 'jpeg', 'jpg']) !== false) {
        die("檔案類型錯誤，圖片網址需為 jpg、jpeg、png 格式");
    }
    $resource = fopen('tmp/profile/'.$id.'.'.$fileExt, 'a');
    fwrite($resource, $file);
    fclose($resource);
    return 'tmp/profile/'.$id.'.'.$fileExt;
}

function getUrlMimeType($url)
{
    $buffer = file_get_contents($url);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->buffer($buffer);
}

function alert($text, $location){
    echo "<script>alert('$text')</script>";
    echo "<script>location.href='$location'</script>";
}

function handlePermission($mode){
    system('chmod '.$mode.' /tmp');
    system('cd tmp');
    system('chmod '.$mode.' profile');
}

function validContent($tmp){
    $result = preg_match("/<\?php/i", file_get_contents($tmp));
    return 0;
}
?>
