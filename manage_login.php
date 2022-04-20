<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<body class="bg-primary">
<nav class="navbar navbar-light position-absolute top-0 end-0 py-3">  
    <a href="index.php" class="link-dark fw-bold text-decoration-none px-3">一般登入</a>
</nav>
<div class="container">
  <div class="row vh-100 justify-content-center align-items-center">
    <div class="col-4 bg-white p-5 d-flex flex-column justify-content-center rounded-3 shadow">
        <h2 class="fw-bold text-center mb-5">管理員登入</h2>
        <form method="POST" action="handle_manage_login.php" class="col-12">
            <div class="mb-4">
                <label for="email" class="form-label fw-bold">帳號</label>
                <input name="email" id="email" class="form-control py-2" list="datalistOptions" type="text" placeholder="請輸入電子信箱" autofocus required>
            </div>
            <div class="mb-5">
                <label for="password" class="form-label fw-bold">密碼</label>
                <input name="password" id="password" class="form-control py-2" list="datalistOptions" type="password" placeholder="請輸入密碼" required>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-dark fw-bold rounded-pill px-5 py-2">登入</button>
            </div>
        </form>
    </div>
  </div>
  </div>
</div>
</body>
</html>