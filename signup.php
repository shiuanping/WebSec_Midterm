<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<body class="bg-primary">
<div class="container">
  <div class="row">
    <div class="col-7 d-flex flex-column justify-content-center align-items-center">
        <i class="fa-solid fa-seedling text-secondary mb-5" style="font-size: 250px"></i>
        <h2 class='fs-1 fw-bolder'>註冊新帳號</h2>
    </div>
    <div class="col-5 p-5 vh-100 d-flex flex-column justify-content-center">
        <form method="POST" action="handle_singup.php" class="col-10" enctype="multipart/form-data">
            <div>
                <div class="profile-img-preview rounded-circle mb-3 mx-auto position-relative" style="width:150px;height: 150px;background: url('tmp/profile/default.png') no-repeat center center / cover">
                    <button type="button" class="btn btn-dark position-absolute bottom-0 end-0 px-2 py-1 rounded-circle" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label for="username" class="form-label fw-bold">用戶名稱</label>
                <input name="username" id="username" class="form-control py-2" list="datalistOptions" type="text" placeholder="請輸入用戶名稱" autofocus required>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label fw-bold">電子信箱</label>
                <input name="email" id="email" class="form-control py-2" list="datalistOptions" type="email" placeholder="請輸入信箱" autofocus required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-bold">密碼</label>
                <input name="password" id="password" class="form-control py-2" list="datalistOptions" type="password" placeholder="請輸入密碼" required>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <a href="index.php" class="fw-bold link-dark text-decoration-none px-3">登入帳號</a>
                <button type="submit" class="btn btn-dark rounded-pill px-5 py-2">註冊</button>
            </div>
            <?php include("signup_modal.php"); ?>
        </form>
    </div>
  </div>
  </div>
</div>
</body>
</html>