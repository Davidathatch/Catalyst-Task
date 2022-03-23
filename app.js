let previewsCheckboxes = document.getElementsByClassName("task-preview-input");
document.cookie = "check=null";
document.cookie = "uncheck=null";

//Adds functionality to checkbox: communicates with "ajax.php" when clicked, applies styles and rearranges task
function addCheckBehavior () {
    for (let i = 0; i < previewsCheckboxes.length; i++) {
        previewsCheckboxes[i].addEventListener("click", function (e) {
                let selectedTaskTitle = e.target.parentElement.parentElement.previousElementSibling.children[0].children[0].innerText;
                let selectedCheck = e.target;
                $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: {selectedTask: selectedTaskTitle, taskAction: selectedCheck.checked},
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

//Code to submit new task to "ajax.php" and creates new "task-preview" HTML element
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

        //When receive confirmation from "ajax.php", clear the form inputs and create new "task-preview" HTML element
        success: function (data) {
            taskName.value = "";
            taskCategory.value = "";
            taskNotes.value = "";
            let parsedData = JSON.parse(data);
            console.log(parsedData["postCategory"]);
            let previewContainer = document.getElementsByClassName("task-preview-container")[0];
            previewContainer.insertBefore(createTaskPreview(parsedData["postTitle"], parsedData["postCategory"], "0"), previewContainer.children[0]);
            addCheckBehavior();
        }
    })
})

//Filter tasks according to their assigned category
let categoryHeaders = document.getElementsByClassName("category-container");
for(let i=0; i<categoryHeaders.length; i++){
    categoryHeaders[i].addEventListener("click", function(e){
        let selectedCategory = categoryHeaders[i].children[0].children[0].children[0].innerText;
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {filterCategory: selectedCategory},
            success: function (response) {
                document.getElementsByTagName("header")[0].classList.add("filter-shrink");
                document.getElementsByClassName("task-previews")[0].classList.add("filter-grow");
                document.getElementsByClassName("task-preview-container")[0].style.height = "100%";
                document.getElementsByClassName("category-gradient")[0].style.display = "none";
                document.getElementsByClassName("close-icon")[0].classList.remove("hidden");

                for (let i=0; i<categoryHeaders.length; i++) {
                    if (categoryHeaders[i].children[0].children[0].children[0].innerText !== selectedCategory) {
                        categoryHeaders[i].remove();
                        i--;
                    }
                }

                let taskPreviews = document.getElementsByClassName("task-preview");
                for (let i=0; i<taskPreviews.length; i++) {
                    taskPreviews[i].remove();
                    i--;
                }

                let filteredTasks = JSON.parse(response);
                for (let i=0; i<filteredTasks.length; i++) {
                    document.getElementsByClassName("task-preview-container")[0].append(createTaskPreview(filteredTasks[i]["taskTitle"], filteredTasks[i]["taskCategory"], "0"));
                }
                addCheckBehavior();
            }
        })
    })
}

//Brings up task composition form when plus button is pressed
document.getElementsByClassName("quick-add-button")[0].addEventListener("click", function() {
    document.getElementsByClassName("compose-container")[0].classList.toggle("hidden");
})

//When exiting filtered results (clicking x in corner), render all tasks and categories in database
    let closeIcon = document.getElementsByClassName("close-icon")[0];
    let taskPreviews = document.getElementsByClassName("task-preview");
    closeIcon.addEventListener("click", function () {
        document.getElementsByTagName("header")[0].classList.remove("filter-shrink");
        document.getElementsByClassName("task-previews")[0].classList.remove("filter-grow");
        document.getElementsByClassName("task-preview-container")[0].style.height = "70%";
        document.getElementsByClassName("category-gradient")[0].style.display = "-webkit-sticky";
        document.getElementsByClassName("close-icon")[0].classList.add("hidden");

        //Get task list from databse and render on page, organizing and styling based on completion status
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {getTaskPreviews: true},
            success: function (response) {
                let filteredTasks = document.getElementsByClassName("task-preview");
                for (let i=0; i<filteredTasks.length; i++) {
                    filteredTasks[i].remove();
                }

                let tasksList = JSON.parse(response);

                for (let i=0; i<tasksList.length; i++){
                    let taskTitle = tasksList[i]["taskTitle"];
                    let taskCategory = tasksList[i]["taskCategory"];
                    let taskDate = tasksList[i]["taskDate"];
                    let isComplete = tasksList[i]["isComplete"];

                    let previewContainer = document.getElementsByClassName("task-preview-container")[0];
                    if (isComplete === "1") {
                        previewContainer.append(createTaskPreview(taskTitle, taskCategory, isComplete));
                    }else {
                        previewContainer.insertBefore(createTaskPreview(taskTitle, taskCategory, isComplete), previewContainer.children[0]);
                    }

                }
            }
        })
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {getCategories: true},
            success: function (response) {
                let categoryList = JSON.parse(response);
                console.log(categoryList);
            }
        })
    })



//Adds check behavior to all checkboxes on initial page load
addCheckBehavior();

//Creates "task-preview" and returns it
function createTaskPreview(taskTitle, taskCategory, isComplete) {
    let taskPreview = document.createElement("div");
        taskPreview.classList.add("task-preview");
        if (isComplete === "1") {
            taskPreview.classList.add("task-preview-complete");
        }

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
        if (isComplete === "1") {
            taskPreviewInput.checked = true;
        }

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

function createCategoryHeader(categoryTitle, categoryId) {
    
}