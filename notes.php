
						
						
<div class="modal fade" id="myModal1<?php echo htmlentities($result->notesid); ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Notes</h4>
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
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  </script>
  
  <textarea name="area3" style="width: 765px; height: 200px; padding: 20px;"> <?php echo htmlentities($result->notescontent); ?>
</textarea>
</div>


          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submits">Edit</button>
        </div>
        
    </div>
    </div>