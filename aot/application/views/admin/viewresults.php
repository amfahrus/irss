<div class="mainholder">
	<div class="content ui-corner-all">
	<div class="createnewdiv">
		<p class="pagetittle">Exam Results</p>
	</div>
	<table width="670px" border='1' class="contenttable" id="contenttable">
	<thead>
	<tr>
	<th>Exam Name</th>
	<th>Validity</th>
	<th style="line-height:5px;text-align:center">questions</th>
	<th style="line-height:5px;text-align:center">Attempted Students</th>
	<th></th>
	</tr>
	</thead>
	<tr>
		<td>Compare Summary</td>
		<td></td>
		<td></td>
		<td></td>
		<td style="line-height:5px;text-align:center"><a href='<?php echo base_url().'administrator/compare_summary'; ?>'>View Results</td>
	</tr>
	<tr>
		<td>Tes Karakter</td>
		<td></td>
		<td></td>
		<td></td>
		<td style="line-height:5px;text-align:center"><a href='<?php echo base_url().'administrator/view_discresults'; ?>'>View Results</td>
	</tr>
	<!--<tr>
		<td>MBTI</td>
		<td></td>
		<td></td>
		<td></td>
		<td style="line-height:5px;text-align:center"><a href='<?php echo base_url().'administrator/view_mbtiresults'; ?>'>View Results</td>
	</tr>-->
		<?php
		if(isset($exams))
		{
			foreach($exams->result_array() as $row)
			{ ?>
				<tr>
				<td><?=ucfirst($row['examname']);?></td>
				<td><?=date('d F Y', strtotime($row['availablefrom'])).' to '.date('d F Y', strtotime($row['availableto']));?></td>
				<td style="line-height:5px;text-align:center"><?=$row['questions'];?></td>
				<td style="line-height:5px;text-align:center"><?=$row['attempted_students'];?></td>
				<td style="line-height:5px;text-align:center"><a href='<?=base_url();?>administrator/view_results/<?=$row['examid'];?>'>
				<?php
				if($row['attempted_students'] != 0) echo 'View Results';

				?>
				</a></td>
				</tr>
			<?php 
			}
		}
		?>
		</table>
</div>
<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>
