  <script>
  $(function() {
    $( "#availablefrom" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#availableto" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#availableto" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#availablefrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>

<script type="text/javascript">
$(document).ready(function(){
  $("#createexamform").validationEngine();
}); 

</script>
<div class="mainholder">

	<div class="content ui-corner-all">
	<div class="createnewdiv">
		<p class="pagetittle">Create exam</p>
	</div>
	<?php 
		if(isset($success))
			echo '<p id="success" class="msg done">'.$success.'</p>';
		if(isset($error))
			echo '<p id="error" class="msg error">'.$error.'</p>';
		?>
		
		<form action="" method="post" id="createexamform">
		<table>
	    <tbody>
	    <tr>
	    <td><div class="label">Select Category</div></td>
	    <td><div class="input">
	    <select name="category" class="input-text validate[required]">
	    <?=(isset($categories)) ? $categories : ''; ?>
	    </select>
	    	</div>
	    </td>
	    </tr>

	    <tr>
	    <td><div class="label">Exam Name</div></td>
	    <td><div class="input">
	    	<input type="text" name="examname" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('examname'); ?>

	    	<!-- Hint section start-->
	    		    <div class="hintsidebar ui-corner-all" style="float:right;font-size:12px;margin-right:30px">
					<span class="icon-left ui-icon ui-icon-info"></span> 
					Must be unique to differentiate exams in the same category.
					</div>
		    <!-- Hint section end -->

	    </div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Exam Description</div></td>
	    <td><div class="input">
	    	<textarea cols="50" rows="5" name="examdesc" class="ui-corner-all input-text validate[required]" style="resize:none"></textarea>

	    	<!-- Hint section start-->
	    		    <div class="hintsidebar ui-corner-all" style="float:right;font-size:12px;margin-right:30px">
					<span class="icon-left ui-icon ui-icon-info"></span> 
					A short description of what the exam covers.
					</div>
		    <!-- Hint section end -->
	    </div>
	    </tr>
	      <tr>
	    <td><div class="label">Total Questions</div></td>
	    <td><div class="input">
	    	<input type="text" name="noofques" size="39" class="ui-corner-all input-text validate[required] custom[integer]"><?=form_error('noofques'); ?></div></td>
	    </tr>
	      <tr>
	    <td><div class="label">Duration (Minutes)</div></td>
	    <td><div class="input">
	    	<input type="text" name="duration" size="39" class="ui-corner-all input-text validate[required] custom[integer]"><?=form_error('duration'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Available From</div></td>
	    <td><div class="input">
	    	<input type="text" name="availablefrom" id="availablefrom" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('availablefrom'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Available To</div></td>
	    <td><div class="input">
	    	<input type="text" name="availableto" id="availableto" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('availableto'); ?></div></td>
	    </tr>

	    <tr>
	    <td><div class="label">Pass Mark</div></td>
	    <td><div class="input">
	    	<input type="text" name="passmark" size="39" class="ui-corner-all input-text validate[required] custom[integer]"><?=form_error('passmark'); ?>

<!-- Hint section start-->
	    		    <div class="hintsidebar ui-corner-all" style="float:right;font-size:12px;margin-right:30px">
					<span class="icon-left ui-icon ui-icon-info"></span> 
					Candidates must enter this code to take the test.
					</div>
		    <!-- Hint section end -->
	    </div>

	    </td>
	    </tr>
	    
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Save Exam" name="saveexambttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>

