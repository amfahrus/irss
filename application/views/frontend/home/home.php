<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
        <div class="col-md-8">
		  <?php
			echo $panel;
		  ?>
		  
		  <?php if($sql->num_rows() > 0){
		  ?>
		  <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo $total; ?></b> <?php echo lang('jobs'); ?></h4></p>
              </div>
			  <div class="panel-body">
		  <table class="table table-hover">
		  <tbody>
		  <?php
					foreach($sql->result_array() as $row){
		  ?>
		  <tr>
			<td><a href="<?php echo base_url().'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?>"><img src="<?php echo $row['company_logo']; ?>" width="50px" height="50px"></a></td>
			<td><a href="<?php echo base_url().'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?>"><b><?php echo $row['job_name']; ?></b></a><br><p class="smooth"><?php echo $row['company_name']; ?></p></td>
			<td><span class="label <?php echo url_title($row['category_name']); ?>"><?php echo $row['category_name']; ?></span></td>
			<td class="smooth"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $row['city_name']; ?></td>
		  </tr>	
			<?php } ?>
		  </tbody>
		  </table>
		  </div>
		  </div>
		  <?php
				}
			?>
			
		<?php echo $this->pagination->create_links(); ?>

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
