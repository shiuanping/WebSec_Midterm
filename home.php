<?php 
    session_start();
    if(!isset($_SESSION['userId'])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php")?>
<?php
    $data = loadPosts($data);
    timeFormat($data[0] -> date);
?>
<body class="inner-page">
    <?php include("navbar.php")?>
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-8">
                <?php if(count($data) === 0){ ?>
                    <div class="d-flex flex-column justify-content-center align-items-center py-5">
                        <i class="fa-regular fa-comment-dots mb-4" style="font-size: 250px"></i>
                        <p class="fs-5 fw-bolder">目前尚無留言</p>
                    </div>
                <?php } ?>
                <ul class="list-unstyled">
                    <?php foreach($data as $item): ?>
                    <li class="post bg-white d-flex border-bottom rounded-3 p-4 mb-4 shadow">
                        <div class="post__date fw-bold px-1 me-5">
                            <div class="post__date__month"><?= $item -> month; ?></div>
                            <div class="post__date__day fs-2"><?= $item -> date; ?></div>
                        </div>
                        <div class="post__img" style="background-image: url(https://uwillx.com/demo/img/p24.png);"></div>
                        <div class="post__detail w-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="d-flex">
                                    <a href="detail.php?id=<?= $item -> postId; ?>" class="post__title text-dark fs-3 d-block fw-bold text-decoration-none me-3">
                                        <?= htmlspecialchars($item -> title); ?>
                                    </a>
                                    <?= renderDelBtn($item -> userId,  $item -> postId) ?>
                                </h2>
                                
                                <div class="d-flex align-items-center" >
                                    <div class="profile rounded-circle" style="background: url('<?= $item -> profile; ?>') no-repeat center /cover;"></div>
                                    <p class="mb-0 ms-2"><?= htmlspecialchars($item -> username); ?><span>,　<?= $item -> year; ?></span></p>
                                </div>
                            </div>
                            <div class="post__summary mb-3">
                                <p class="fs-5"><?= strToBBcode($item -> content) ?></p>
                                <?= createFileLink($item -> postId, $item -> fileName) ?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>

<?php
function timeFormat($timestamp){
    $date = explode (" ", $timestamp)[0];
    $date = explode ("-", $date);
    $month = array('JUN','FEB','MAR','APR','MAY','JUNE','JULY','AUG','SEPT','OCT','NOV','DEC');
    $result = array($date[0],$month[(int)($date[1]-1)],$date[2]);
    return $result;
}

function loadPosts() {
    require_once('config.php');
    $stmt = $link->prepare("SELECT users.username, users.profile, posts.* FROM users INNER JOIN posts ON users.userId = posts.userId ORDER BY posts.date DESC");
    $data = array();
    try{
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                array_push($data, (object)[
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
                ]);
            }
        }
        return $data;
    }catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}

function renderDelBtn($postUserId, $postId){
    if($_SESSION['userId'] === $postUserId){
        echo "<a href='handle_delete.php?id=$postId' class='link-dark d-flex align-items-center text-decoration-none'><i class='fa-solid fa-trash fs-5'></i></a>";
    }
}

function strToBBcode($str){
    $str = htmlspecialchars($str);
    $format_search =  array(
        '/\[b\](.*?)\[\/b\]/',
        '/\[i\](.*?)\[\/i\]/',
        '/\[u\](.*?)\[\/u\]/',
        '/\[img\](.*?)\?(.*?)\[\/img\]/',
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

function createFileLink($id, $fileName){
    if($fileName){
        $filename = htmlspecialchars($fileName);
        echo "<a class='btn btn-light border border-1' href='handle_download.php?id=$id'><i class='fa-solid fa-file-arrow-down me-2'></i>$fileName</a>";
    }
}

?>
