<div class="modal fade" id="myModal1<?php echo htmlentities($result->notesid); ?>">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" style="color: #FFFFFF">Edit Note</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->

      <form method="POST">
        <div class="modal-body">
          <br>
          <div id="sample" style="background-color: #FFFFFF; color:black;">
            <textarea class="summernote" name="notescontent"><?php echo htmlentities($result->notescontent); ?></textarea>
          </div>
          <input type="hidden" name="updateid" value="<?php echo htmlentities($result->notesid); ?>">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update">Edit</button>
        </div>
      </form>
    </div>
  </div>