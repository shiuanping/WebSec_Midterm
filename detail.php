<?php 
    session_start();
    if(!isset($_SESSION['userId'])) header("Location: index.php");
    if(!isset($_GET['id'])) header("Location: home.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<?php
    $postId = $_GET[id];
    $data = loadPosts($postId);
?>
<body class="inner-page">
    <?php include("navbar.php")?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9 p-5">
                <div class="post bg-white rounded-3 p-5 my-3 shadow">
                    <div class="w-100 d-flex justify-content-between align-items-center mb-3">
                        <p class="m-0"><?= $data -> month; ?>　<?= $data -> date; ?>, <?= $data -> year; ?></p>
                        <div class="d-flex align-items-center" >
                            <div class="profile rounded-circle" style="background: url('<?= $data -> profile; ?>') no-repeat center /cover;"></div>
                            <p class="mb-0 ms-2"><?= htmlspecialchars($data -> username); ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <h1 class='fw-bold me-3'>
                        <?= htmlspecialchars($data -> title); ?>
                        </h1>
                        <?= renderDelBtn($data -> userId,  $data -> postId) ?>
                    </div>
                    <pre class="fs-4 mb-5 m-0"><?= strToBBcode($data -> content) ?></pre>
                    <?= createFileLink($data -> postId, $data -> fileName) ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('" . $output . "' );</script>";
}


function timeFormat($timestamp){
    $date = explode (" ", $timestamp)[0];
    $date = explode ("-", $date);
    $month = array('JUN','FEB','MAR','APR','MAY','JUNE','JULY','AUG','SEPT','OCT','NOV','DEC');
    $result = array($date[0],$month[(int)($date[1]-1)],$date[2]);
    return $result;
}

function loadPosts($postId) {
    require_once('config.php');
    $data = new stdClass();
    if($stmt = $link->prepare("SELECT users.username, users.profile, posts.* FROM users INNER JOIN posts ON users.userId = posts.userId  WHERE posts.postId = ? ORDER BY posts.date DESC")){
        try{
            $stmt->bind_param('s', $postId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                if($row){
                    $data = (object)[
                        'postId' => $row[postId],
                        'username' => $row[username],
                        'profile' => $row[profile],
                        'title' => $row[title],
                        'content' => $row[content],
                        'year' => timeFormat($row[date])[0],
                        'month' => timeFormat($row[date])[1],
                        'date' => timeFormat($row[date])[2],
                        'fileName' => $row[fileName],
                        'fileUrl' => $row[fileUrl],
                        'userId' => $row[userId]
                    ];
                }
            }
            $tmp = (array) $data;
            if(empty($tmp)){
                alert('留言不存在或已被刪除', 'home.php');
            }
            return $data;
        }catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), '<br>';
            echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
        }
    }
}

function formatTitle($str){
    $str = htmlspecialchars($str);
    $str = str_replace('\r\n', '<br>', $str);
    echo $str;
}

function strToBBcode($str){
    $str = htmlspecialchars($str);
    $format_search =  array(
        '/\[b\](.*?)\[\/b\]/',
        '/\[i\](.*?)\[\/i\]/',
        '/\[u\](.*?)\[\/u\]/',
        '/\[img\](.*?)\[\/img\]/',
        '/\[color\=(.*?)\](.*?)\[\/color\]/'
    );

    $format_replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<u>$1</u>',
        '<img class=my-3 src=$1>',
        '<span style="color:$1">$2</span>'
    );

    for ($i =0;$i<count($format_search);$i++) {
        $str =  preg_replace($format_search[$i], $format_replace[$i], $str);
        $str =  str_replace(array(";"), '', $str);
    }
    $str = str_replace('\r\n', '<br>', $str);
    echo $str;
}

function renderDelBtn($postUserId, $postId){
    if($_SESSION['userId'] === $postUserId){
        echo "<a href='handle_delete.php?id=$postId' class='link-dark d-flex align-items-center text-decoration-none'><i class='fa-solid fa-trash fs-5'></i></a>";
    }
}

function createFileLink($id, $fileName){
    if($fileName){
        echo "<a class='btn btn-light border border-1' href='handle_download.php?id=$id'><i class='fa-solid fa-file-arrow-down me-2'></i>$fileName</a>";
    }
}

function alert($text, $location){
    echo "<script>alert('$text')</script>";
    echo "<script>location.href='$location'</script>";
}

?>
