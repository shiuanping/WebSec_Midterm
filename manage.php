<html lang="en">
<?php include("head.php")?>
<?php $title = loadTitle(); ?>
<body class="inner-page">
<nav class="navbar navbar-light py-3">  
    <div class="container justify-content-end">
        <div class="row">
            <a href="handle_logout.php" class="btn btn-dark" type="submit">登出</a>
        </div>
    </div>
</nav>
<div class="container">
  <div class="row justify-content-center align-items-center py-5">
    <div class="col-4 bg-white p-5 d-flex flex-column justify-content-center rounded-3 shadow">
        <h2 class="fw-bold text-center mb-5">管理介面</h2>
        <form method="POST" action="handle_title_update.php" class="col-12">
            <div class="mb-4">
                <label class="form-label fw-bold">目前標題</label>
                <input class="form-control-plaintext p-2" type="text" value=<?= $title ?> readonly>
            </div>
            <div class="mb-5">
                <label for="title" class="form-label fw-bold">更新首頁標題</label>
                <input name="title" id="title" class="form-control p-2" type="text" placeholder="請輸入密碼" required>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-dark fw-bold rounded-pill px-5 py-2">確定</button>
            </div>
        </form>
    </div>
  </div>
  </div>
</div>
</body>
</html>

<?php
function loadTitle(){
    require_once('config.php');
    $stmt = $link->prepare("SELECT * FROM web WHERE 1");
    $title = "";
    try{
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if($row){
                return $row[title];
            }
        }
        return "Error";
    }catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), '<br>';
        echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>