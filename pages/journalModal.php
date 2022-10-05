<div class="modal fade" id="journalModal<?php echo htmlentities($result->journalid); ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" style="color: #FFFFFF"><?php echo htmlentities(date("F j, Y", strtotime($result->date))); ?> Journal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->


            <div class="modal-body">


                <div id="sample" style="color: white;">

                    <p style="letter-spacing: 0.8px;font-size:20px;"><?php echo htmlentities($result->content); ?></p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>