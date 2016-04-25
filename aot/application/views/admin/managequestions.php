
<div class="mainholder">
	<div class="content ui-corner-all">
	<div class="createnewdiv">
	<p class="pagetittle">Exam Name : <?=($examdata) ? $examdata->examname : '';?></p>
<!-- Hint section start-->
    <div class="hintsidebar ui-corner-all" style="float:left;font-size:12px;margin:10px 30px 5px 0;width:50%">
	<span class="icon-left ui-icon ui-icon-info"></span> 
	<?php
	$totalquestions = $examdata->questions;
	$addedquestions = $questions->num_rows();
	$remainingquestions = $totalquestions - $addedquestions;
	?>
	<?=$addedquestions;?> Questions added already.
	</div>
<!-- Hint section end -->
	<?php
	//if($remainingquestions > 0)
	//{?>
	<p class="pagetittle" style="float:right;text-align:center;margin-bottom:10px">
	<a href="<?=base_url();?>administrator/createquestion/<?=$examdata->examid; ?>"><img src="<?=base_url();?>assets/admin/images/add.png" ></a><br/> Add question </a>
    </p>
	<?php
	//}
	?>
	</div>
	<div class="clear"></div>
	<table width="670px" border='1' class="contenttable" id="contenttable">
	<thead>
	<tr>
	<th>Question</th>
	<th>Correct Answer</th>
	<th>Marks</th>
	<th></th>
	<th></th>
	</tr>
	</thead>

		<?php
		if(isset($questions))
		{
			foreach($questions->result_array() as $row)
			{
				echo '<tr>
				<td>'.ucfirst($row['question']).'</td>
				<td>'.$row['correctanswer'].'</td>
				<td>'.$row['marks'].'</td>
				<td style="line-height:5px;text-align:center"><a href='.base_url().'administrator/editquestion/'.$row['questionid'].'><img src='.base_url().'assets/admin/images/edit.png></a></td>
				<td style="line-height:5px;text-align:center"><a class="deletebttn" href="#" id='.$row['questionid'].'><img src='.base_url().'assets/admin/images/delete.png></a></td>
				</tr>';
			}
			
		}
		?>
		</table>
</div>
<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>

<script type="text/javascript">
	  $("a.deletebttn").live('click', function(e){
	  e.preventDefault();
	  var questionId = $(this).attr("id");

	  if(confirm('Are you sure you want to Delete this question?'))
	  {
	  $.ajax({
	  type: "POST",
	  url: "<?=base_url();?>administrator/deletequestion",
	  data: {"questionId": questionId },
	  success: function(test)
	  {
	  	alert('Question has been Deleted successfully !');
	  	location.reload();
	  }
	  });
	  }
	  });

</script>
