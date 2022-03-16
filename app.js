let previewsCheckboxes = document.getElementsByClassName("task-preview-input");
document.cookie = "check=null";
document.cookie = "uncheck=null";

function addCheckBehavior () {
    for (let i = 0; i < previewsCheckboxes.length; i++) {
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
        success: function (data) {
            taskName.value = "";
            taskCategory.value = "";
            taskNotes.value = "";
            let parsedData = JSON.parse(data);
            console.log(parsedData["postCategory"]);
            let previewContainer = document.getElementsByClassName("task-preview-container")[0];
            previewContainer.insertBefore(createTaskPreview(parsedData["postTitle"], parsedData["postCategory"]), previewContainer.children[0]);
            addCheckBehavior();
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

addCheckBehavior();

function createTaskPreview(taskTitle, taskCategory) {
    let taskPreview = document.createElement("div");
        taskPreview.classList.add("task-preview");

    let taskPreviewBody = document.createElement("div");
        taskPreviewBody.classList.add("task-preview-body");

    let previewHeadingContainer = document.createElement("div");
        previewHeadingContainer.classList.add("preview-heading-container");

    let taskPreviewHeading = document.createElement("h3");
        taskPreviewHeading.classList.add("task-preview-heading");
        taskPreviewHeading.innerHTML = "<strong>" + taskTitle + "</strong>";

    let taskPreviewDate = document.createElement("h4");
        taskPreviewDate.classList.add("task-preview-date");
        taskPreviewDate.innerHTML = "<i>00-00-0000</i>";

    let taskPreviewCategory = document.createElement("h5");
        taskPreviewCategory.classList.add("task-preview-category");
        taskPreviewCategory.innerHTML = "<i>" + taskCategory +"</i>";

    previewHeadingContainer.append(taskPreviewHeading);
    previewHeadingContainer.append(taskPreviewDate);
    previewHeadingContainer.append(taskPreviewCategory);

    let taskPreviewDesc = document.createElement("p");
        taskPreviewDesc.classList.add("task-preview-desc");
        taskPreviewDesc.innerHTML = "Lorem ipsum blah blah stuff stuff... see more->";

    let taskPreviewForm = document.createElement("form");
        taskPreviewForm.action = "../home.php";
        taskPreviewForm.method = "post";

    let taskPreviewCheckbox = document.createElement("div");
        taskPreviewCheckbox.classList.add("task-preview-checkbox");

    let taskPreviewInput = document.createElement("input");
        taskPreviewInput.type = "checkbox";
        taskPreviewInput.name = "task-preview-input";
        taskPreviewInput.setAttribute("class", "task-preview-input");

    let customCheckbox = document.createElement("div");
        customCheckbox.classList.add("custom-checkbox");

    taskPreviewCheckbox.append(taskPreviewInput);
    taskPreviewCheckbox.append(customCheckbox);
    taskPreviewForm.append(taskPreviewCheckbox);

    previewHeadingContainer.append(taskPreviewHeading);
    previewHeadingContainer.append(taskPreviewDate);
    previewHeadingContainer.append(taskPreviewCategory);

    taskPreviewBody.append(previewHeadingContainer);
    taskPreviewBody.append(taskPreviewDesc);

    taskPreview.append(taskPreviewBody);
    taskPreview.append(taskPreviewForm);

    return taskPreview;
}