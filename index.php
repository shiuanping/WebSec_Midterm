<?php $title=loadTitle();cleanSession(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<body class="bg-primary">
<nav class="navbar navbar-light position-absolute top-0 end-0 py-3">  
    <a href="manage_login.php" class="link-dark fw-bold text-decoration-none px-3">管理員登入</a>
</nav>
<div class="container">
  <div class="row">
    <div class="col-7 text-dark d-flex flex-column justify-content-center align-items-center">
        <i class="fa-solid fa-seedling text-secondary mb-5" style="font-size: 250px"></i>
        <p class='fs-1 fw-bolder'><?= $title ?></p>
    </div>
    <div class="col-5 p-5 vh-100 d-flex flex-column justify-content-center">
        <h2 class="fw-bold mb-5">登入</h2>
        <form method="POST" action="handle_login.php" class="col-10">
            <div class="mb-4">
                <label for="email" class="form-label fw-bold">帳號</label>
                <input name="email" id="email" class="form-control py-2" list="datalistOptions" type="email" placeholder="請輸入電子信箱" autofocus required>
            </div>
            <div class="mb-5">
                <label for="password" class="form-label fw-bold">密碼</label>
                <input name="password" id="password" class="form-control py-2" list="datalistOptions" type="password" placeholder="請輸入密碼" required>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <a href="signup.php" class="link-dark fw-bold text-decoration-none px-3">註冊新帳號</a>
                <button type="submit" class="btn btn-dark fw-bold rounded-pill px-5 py-2">登入</button>
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
function cleanSession(){
    session_start();
    session_destroy();
}
?>