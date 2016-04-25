<script>
$(document).ready(function(){
  $("#editcategoryform").validationEngine();
}); 

</script>
<div class="mainholder">

	<div class="content ui-corner-all">
	<div class="createnewdiv">
		<p class="pagetittle">Edit category</p>
	</div>
	<?php 
		if(isset($success))
			echo '<p id="success" class="msg done">'.$success.'</p>'
		?>
		
		<form action="" method="post" id="editcategoryform">
		<table>
	    <tbody><tr>
	    <td><div class="label">Category Name</div></td>
	    <td><div class="input">
	    	<input type="hidden" name="catid" value="<?=(isset($categorydetails) ? $categorydetails->catid : '')?>"/>
	    	<input type="text" value="<?=(isset($categorydetails) ? $categorydetails->catname : '')?>" name="catname" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('catname'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Category Description</div></td>
	    <td><div class="input">
	    	<textarea cols="50" rows="5" name="catdesc" class="ui-corner-all input-text validate[required]" style="resize:none"><?=(isset($categorydetails) ? $categorydetails->catdesc : '')?></textarea>

	    	<!-- Hint section start-->
	    		    <div class="hintsidebar ui-corner-all" style="float:right;font-size:12px;margin-right:30px">
					<span class="icon-left ui-icon ui-icon-info"></span> 
					A short description of what the category covers.
					</div>
		    <!-- Hint section end -->
	    </div>
	    </tr>
	    
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Save Category" name="editcategorybttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>