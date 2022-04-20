<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="exampleModalLabel">上傳頭像</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link active w-100" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">本地上傳</button>
            </li>
            <li class="nav-item w-50" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">網址上傳</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <input type="file" name="profile-img" class="profile-img-input" accept="image/png, image/jpeg">
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <input type="text" name="profile-url" class="profile-url-input form-control"  placeholder="請輸入圖片網址">
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">取消</button>
        <button type="button" class="profile-img-check btn btn-primary"  data-bs-dismiss="modal">確定</button>
      </div>
    </div>
  </div>
</div>