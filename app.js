console.log(document.cookie);

let previewsCheckboxes = document.getElementsByClassName("task-preview-input");
for(let i=0; i<previewsCheckboxes.length; i++){
    if(!previewsCheckboxes[i].checked){
        previewsCheckboxes[i].addEventListener("click", function() {
        document.cookie = "check=" + previewsCheckboxes[i].parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
        location.reload();
    })
    }else {
        previewsCheckboxes[i].addEventListener("click", function() {
            document.cookie = "uncheck=" + previewsCheckboxes[i].parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
            location.reload();
        })
    }
}