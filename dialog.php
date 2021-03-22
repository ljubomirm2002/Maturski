<div class="modal fade" id="modal<?php echo $_SESSION['a']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modal-header<?php echo $_SESSION['a']; ?>">
                    <h5 class="modal-title" id="modal-title<?php echo $_SESSION['a']; ?>"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='content<?php echo $_SESSION['a']; ?>'>
                </div>
                <div class="modal-footer" id='modal-footer<?php echo $_SESSION['a']; ?>'>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id='modal-submit<?php echo $_SESSION['a']; ?>'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['a']);