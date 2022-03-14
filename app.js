let previewsCheckboxes = document.getElementsByClassName("task-preview-input");
document.cookie = "check=null";
document.cookie = "uncheck=null";
for(let i=0; i<previewsCheckboxes.length; i++) {
    if (!previewsCheckboxes[i].checked) {
        previewsCheckboxes[i].addEventListener("click", function () {
            document.cookie = "check=" + previewsCheckboxes[i].parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
            location.reload();
        })
    } else {
        previewsCheckboxes[i].addEventListener("click", function () {
            document.cookie = "uncheck=" + previewsCheckboxes[i].parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
            location.reload();
        })
    }
}

document.cookie = "categorySearch=null";
let categoryHeaders = document.getElementsByClassName("category-container");
for(let i=0; i<categoryHeaders.length; i++){
    categoryHeaders[i].addEventListener("click", function(){
        document.cookie = "categorySearch=" + categoryHeaders[i].classList[1];
        location.reload();
    })
}

document.getElementsByClassName("quick-add-button")[0].addEventListener("click", function() {
    document.getElementsByClassName("compose-container")[0].classList.toggle("hidden");
})

let closeIcon = document.getElementsByClassName("close-icon");

if (closeIcon.length > 0){
    closeIcon[0].addEventListener("click", function() {
        location.reload();
    })
}