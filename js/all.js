import '../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js';

const changeProfileImage = () => {
    const profileImgPreview = document.querySelector('.profile-img-preview');
    const profileImg = document.querySelector('.profile-img-input');
    const profileUrl = document.querySelector('.profile-url-input');
    if(profileImg.value){
        const file = profileImg.files[0];
        const url = getInputValue('profile-img-input');
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            const url = reader.result;
            if((!url.includes('image/jpg'))&&(!url.includes('image/jpeg'))&&(!url.includes('image/png'))){
                profileImg.value = '';
                alert('檔案類型錯誤，圖片網址需為 jpg、jpeg、png 格式');
                return
            }
            profileImgPreview.style.background = `url(${url}) no-repeat center center / cover`;
        }
    }
    else if(profileUrl.value){
        const url = profileUrl.value;
        if((!url.includes('jpg'))&&(!url.includes('jpeg'))&&(!url.includes('png'))){
            profileUrl.value = '';
            alert('檔案類型錯誤，圖片網址需為 jpg、jpeg、png 格式');
            return
        }
        profileImgPreview.style.background = `url(${profileUrl.value}) no-repeat center center / cover`;
    }
    else{
        reloadDefaultImage();
    }
    
}

const reloadDefaultImage = () => {
    document.querySelector('.profile-img-preview').style.background = `url(tmp/profile/default.png) no-repeat center center / cover`;
}

const clearInput = (val) => {
    if(val === 0){
        document.querySelector('.profile-img-input').value = '';
    }else{
        document.querySelector('.profile-url-input').value = '';
    }
}

const signupPage = () => {
    eventListener('profile-img-check', 'click', changeProfileImage);
    eventListener('profile-img-input', 'change', () => clearInput(1));
    eventListener('profile-url-input', 'change', () => clearInput(0));
};

const postPage = () => {
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(item => item.addEventListener('click', addBBcode));
};

const addBBcode = (e) => {
    const tag = e.target.dataset.type;
    const contentInput = document.querySelector('.content-input');
    const startIdx = contentInput.selectionStart;
    const endIdx = contentInput.selectionEnd;
    const text = {
        before: contentInput.value.substring(0, startIdx),
        selected: contentInput.value.substring(startIdx, endIdx),
        after: contentInput.value.substring(endIdx)
    }
    const {before, selected, after} = text;
    if(tag === 'color'){
        contentInput.value = `${before}[color=red]${selected}[/color]${after}`;
    }else{
        contentInput.value = `${before}[${tag}]${selected}[/${tag}]${after}`;
    }
}

const eventListener = (className, eventName, method) => {
    document.querySelector('.'+className).addEventListener(eventName, method);
} 

const getInputValue = (className) => {
    return document.querySelector('.'+className).value;
}

window.addEventListener('load', () => {
    const pathname = location.pathname.replace('/','');
    switch (pathname) {
        case 'signup.php':
            signupPage();
            break;
        case 'post.php':
            postPage();
            break;
        default:
            break;
    }
});