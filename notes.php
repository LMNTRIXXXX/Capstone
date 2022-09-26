
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
        <div class="modal-body" >
        <input type="text" class="form-control" placeholder="Notes Name" value="<?php echo htmlentities($result->notesname); ?>" name="notesname" style="color:black; background-color:white;">
        <br>
        
        <div id="sample" style="background-color: #FFFFFF; color:black;">
  <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script> 
  <script type="text/javascript">
        bkLib.onDomLoaded(function() {
        nicEditors.allTextAreas() });
  </script>
  
  <textarea name="notescontent" style="width: 765px; height: 200px; padding: 20px;"> <?php echo htmlentities($result->notescontent); ?>
</textarea>
</div>
<input type="hidden" name="updateid" value="<?php echo htmlentities($result->notesid); ?>">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#shareModal<?php echo htmlentities($result->notesid); ?>">Share</button>
        <button type="submit" class="btn btn-primary" name="update">Edit</button>


        </div>
        </form>
    </div>
    </div>


  <div class="modal fade" id="shareModal<?php echo htmlentities($result->notesid); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color: #FFFFFF" id="exampleModalLongTitle">Share Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="user-container">
        <?php
        $id = $_SESSION['userid'];
                        $sql = "SELECT * FROM user
                        WHERE userid != $id && usertype = 'user'";
                        $query=$dbh->prepare($sql);
                        $query->execute();
                        $results=$query->fetchALL(PDO::FETCH_OBJ);
        
                        $cnt=1;
                        if ($query->rowCount()>0) {
                        foreach ($results as $result)
                        {
        ?>
        <div class="user-items">
          <h4>  <?php echo htmlentities($result->firstname); ?>  <?php echo htmlentities($result->lastname); ?> </h4>
          <button type="submit" class="btn btn-primary" name="update">Share</button>
        </div>
        
        <?php
              }
          }
        ?>

      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



