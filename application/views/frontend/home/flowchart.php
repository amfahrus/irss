<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
	      
        <div class="col-md-8">
		  <?php
			echo $panel;
		  ?>
		 
		  <div class="panel panel-default">
			<div class="panel-body">
				Gambar Flowchart
			</div>
		  </div>
        </div>

		<div class="col-md-4">
        
		  <div class="panel panel-default">
			<div class="panel-heading">
				Career Center
			</div>
			<div class="panel-body">
				<p>Bila anda ingin mengetahui lebih banyak tentang IRSS, memiliki perhatian yang tinggi terhadap kualitas sumber daya manusia.
				Di samping itu, penghargaan yang tinggi juga diberikan oleh perusahaan kepada setiap individu yang mampu menghadapi tantangan dan berprestasi
				dalam bidang masing-masing. Oleh karena itu, kami mengundang Anda yang memiliki kemampuan lebih untuk bergabung bersama kami.</p>
			</div>
		  </div>
		  <?php 
			if($count->num_rows() > 0){	
		  ?> 
		  <div class="panel panel-default">
			<div class="panel-heading">
				<?php echo lang('companies'); ?>
			</div>
			<div class="panel-body">
			<?php 
				foreach($count->result_array() as $rows){	
			?>
				<a title="<?php echo $rows['total']; ?> opening jobs." class="well top-block" href="<?php echo base_url().'home/company/'.$rows['company_id'].'/'.url_title($rows['company_name']); ?>">
					<img src="<?php echo $rows['company_logo']; ?>" width="50px" height="50px">
					<div><?php echo $rows['company_name']; ?></div>
					<span class="notification red"><?php echo $rows['total']; ?></span>
				</a>
			<?php 
				}
			?>
			</div>
			<?php
			}
			?>
		  </div>

        </div>
       
    </div>
        

</div><!-- /.container -->
