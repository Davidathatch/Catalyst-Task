let previewsCheckboxes = document.getElementsByClassName("task-preview-input");
document.cookie = "check=null";
document.cookie = "uncheck=null";

for(let i=0; i<previewsCheckboxes.length; i++) {
    previewsCheckboxes[i].addEventListener("click", function (e) {
        let selectedTaskTitle = previewsCheckboxes[i].parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {selectedTask: selectedTaskTitle, taskAction: previewsCheckboxes[i].checked},
            success: function (response) {
                e.target.parentElement.parentElement.parentElement.classList.toggle("task-preview-complete");
                var selectedTask = e.target.parentElement.parentElement.parentElement;
                var taskPreviews = document.getElementsByClassName("task-preview-container")[0];
                if (e.target.checked) {
                    taskPreviews.append(selectedTask);
                } else {
                    taskPreviews.insertBefore(selectedTask, taskPreviews.children[0]);
                }
            }
        })
    }
)

}

let taskComposeSubmit = document.getElementsByClassName("task-compose-submit")[0];
taskComposeSubmit.addEventListener("click", function (e) {
    document.getElementsByClassName("compose-container")[0].classList.add("hidden");
     let taskName = document.getElementById("newTaskTitle");
    let taskCategory = document.getElementById("newTaskCategory");
    let taskNotes = document.getElementById("newTaskNotes");
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {taskNameAdd: taskName.value, taskCategoryAdd: taskCategory.value, taskNotesAdd: taskNotes.value},
        success: function (response) {
            taskName.value = "";
            taskCategory.value = "";
            taskNotes.value = "";
            console.log(response);
        }
    })
})
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