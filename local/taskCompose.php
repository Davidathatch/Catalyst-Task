 <div class="compose-container hidden">
        <form action="home.php" method="post">
            <div class="pair-container">
                <label for="newTaskTitle">Title</label>
                <input type="text" name="newTaskTitle" id="newTaskTitle" required>
            </div>

            <div class="pair-container">
                <label for="newTaskCategory">Category</label>
                <select name="newTaskCategory" id="newTaskCategory" class="categorySelect" required>
                    <?php foreach($completeCateList as $row) { ?>
                    <option value="<?php echo $row ?>"><?php echo $row ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="pair-container">
                <label for="newTaskNotes">Notes</label>
                <textarea name="newTaskNotes" id="newTaskNotes" cols="30" rows="10"></textarea>
            </div>

            <button type="submit">Save</button>
        </form>
    </div>

