<div class="mainholder">
	<div class="content ui-corner-all">
	<div class="createnewdiv">
		<a href="<?=base_url();?>administrator/createcategory"><img src="<?=base_url();?>assets/admin/images/add.png" ></a>
	</div>
	<table width="670px" border='1' class="contenttable" id="contenttable">
	<thead>
	<tr>
	<th>Category Name</th>
	<th>Category Description</th>
	<th></th>
	<th></th>
	</tr>
	</thead>

		<?php
		if(isset($categoriesdata))
		{
			foreach($categoriesdata as $row)
			{
				echo '<tr>
				<td>'.ucfirst($row['catname']).'</td>
				<td>'.ucfirst($row['catdesc']).'</td>
				<td style="line-height:5px;text-align:center"><a href='.base_url().'administrator/editcategory/'.$row['catid'].'><img src='.base_url().'assets/admin/images/edit.png></a></td>
				<td style="line-height:5px;text-align:center"><a class="deletebttn" href="#" id='.$row['catid'].'><img src='.base_url().'assets/admin/images/delete.png></a></td>
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
	  var catId = $(this).attr("id");

	  if(confirm('Are you sure you want to Delete this category?'))
	  {
	  $.ajax({
	  type: "POST",
	  url: "<?=base_url();?>administrator/deletecategory",
	  data: {"catId": catId },
	  success: function(test)
	  {
	  	alert('Category has been Deleted successfully !');
	  	location.reload();
	  }
	  });
	  }

	  });

</script>