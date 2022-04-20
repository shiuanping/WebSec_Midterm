<?php session_start();
    if(!isset($_SESSION['userId'])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php")?>
<body class="inner-page">
    <?php include("navbar.php")?>
    <div class="container">
        <div class="row  justify-content-center py-5">
            <div class="col-8">
                <div class="mb-5">
                    <h2 class="fw-bold mb-4">新增留言</h2>
                    <form name="post_form" method="post" action="handle_post.php" enctype="multipart/form-data">
                        <div class="form-group mb-4">
                            <input name="title" type="text" class="form-control fs-4 py-2 shadow" placeholder="Title" required>
                        </div>
                        <div class="btn-group mb-2 shadow-sm" role="group" aria-label="Basic example">
                            <button type="button" class="edit-btn btn btn-dark fw-bold" data-type='b'>b</button>
                            <button type="button" class="edit-btn btn btn-dark fw-bold" data-type='i'>i</button>
                            <button type="button" class="edit-btn btn btn-dark fw-bold" data-type='u'>u</button>
                            <button type="button" class="edit-btn btn btn-dark fw-bold" data-type='img'>img</button>
                            <button type="button" class="edit-btn btn btn-dark fw-bold" data-type='color'>color</button>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="message" class="content-input form-control p-3 shadow" rows="8"  placeholder="Leave a comment here..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="post-file" class="form-label fw-bold">上傳檔案</label>
                            <input name="post-file" class="form-control shadow-sm" type="file" id="post-file">
                        </div>
                        <button class="btn btn-dark fw-bold d-block px-4 ms-auto" type="submit">發布</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

