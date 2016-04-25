
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
        
        <?php
			if($step->num_rows() > 0){
				$desc = $step->row_array();
        ?>
        <div class="panel panel-default">
			<div class="panel-body">
				<?php echo !empty($desc['js_desc']) ? $desc['js_desc'] : 'There is no information available'; ?>
			</div>
				<?php 
					if(!empty($desc['js_attach'])){
				?>
			<div class="panel-footer">
				<a href="<?php echo $desc['js_attach']; ?>" class="btn btn-primary">Download File</a>
			</div>
				<?php 
					}
				?>
		  </div>
		<?php
			} else {
				echo lang('there_is_no_information_available');
			}
		?>
		
      </div>
    </div><!-- /.modal-content -->
