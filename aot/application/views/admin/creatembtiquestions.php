<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/afm/jscripts/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/afm/jscripts/general.js"></script>
	<script language="javascript" type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			elements : "ajaxfilemanager",
			theme : "advanced",
			plugins : "advimage,advlink,media,contextmenu",
			theme_advanced_buttons1_add_before : "newdocument,separator",
			theme_advanced_buttons1_add : "",
			theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
			theme_advanced_buttons2_add_before: "cut,copy,separator,",
			theme_advanced_buttons3_add_before : "fontselect,fontsizeselect",
			theme_advanced_buttons3_add : "media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			extended_valid_elements : "hr[class|width|size|noshade]",
			file_browser_callback : "ajaxfilemanager",
			paste_use_dialog : false,
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			apply_source_formatting : true,
			force_br_newlines : true,
			force_p_newlines : false,	
			relative_urls : true
		});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../../../jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
			var view = 'detail';
			switch (type) {
				case "image":
				view = 'thumbnail';
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "../../../../jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
                width: 782,
                height: 440,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
/*            return false;			
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;*/
		}
	</script>
<script type="text/javascript">
$(document).ready(function(){
  $("#createquestionform").validationEngine();
}); 

</script>
<script>
$(function () {
	var cstate = 1;
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
        
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Option #' + newNum);

        newElem.find('.option_label').val([1]);
        
        newElem.find('.option_desc').html('');
        
        newElem.find('.option_marks').val(1);
        
        newElem.find('.option_type').val([1]);

    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_reference').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel').attr('disabled', false);
		
	// Form validation
		$('form').on('submit', function() {
		// do validation here
		if($('.clonedInput').length > cstate){
			if( 
			!newElem.find('.option_desc').val('')
			){
				$('#jvalid').attr('class','alert alert-danger').html('Please Complete All Field');
				return false;
			}
		} 
		});
	
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 5)
        $('#btnAdd').attr('disabled', true).prop('value', "Limit Exceed"); // value here updates the text in the 'add' button when the limit is reached 
    });

    $('#btnDel').click(function () {
		// Confirmation dialog box. Works on all desktop browsers and iPhone.
        if (confirm("Are you sure you wish to remove this section? This cannot be undone"))
            {
				var num = $('.clonedInput').length;
				// how many "duplicatable" input fields we currently have
				$('#entry' + num).slideUp('slow', function () {$(this).remove();
				// if only one element remains, disable the "remove" button
				if (num -1 === 1){
					$('#btnDel').attr('disabled', true);
				}
				// enable the "add" button
				$('#btnAdd').attr('disabled', false).prop('value', "<span class=\"glyphicon glyphicon-plus-sign\"></span> add option");});
			}
		return false; // Removes the last section you added
    });
    // Enable the "add" button
    $('#btnAdd').attr('disabled', false);
    // Disable the "remove" button
    $('#btnDel').attr('disabled', true);
    
	
	
});
</script>
<style type="text/css">
.input-text {
width: 30em;
}
</style>
<div class="mainholder">

	<div class="content ui-corner-all">
	<div class="createnewdiv">
		<p class="pagetittle">Create Question</p>
	</div>
	<?php 
		if(isset($success))
			echo '<p id="success" class="msg done">'.$success.'</p>';
		if(isset($error))
			echo '<p id="error" class="msg error">'.$error.'</p>';
		?>
		
		<form action="<?php echo base_url().'administrator/addmbtiquestion'; ?>" method="post" id="createquestionform">
		<table>
	    <tbody>
	    <tr>
	    <td><div class="label">Question</div></td>
	    <td><div class="input">
	    	<textarea id="ajaxfilemanager" cols="50" rows="5" name="question" class="ui-corner-all input-text validate[required]" style="resize:none"></textarea>
	    </div></td>
	    </tr>
	    </tbody></table>
		<div id="entry1" class="clonedInput">
		<h2 id="reference" name="reference" class="heading-reference">Option #1</h2>
	    <table>
	    <tbody>
		<tr>
	    <td><div class="label">Option Label</div></td>
	    <td><div class="input">
	    	<select name="option_label[]" class="option_label input-text validate[required]">
	    	<option value="A"> Option A</option>
	    	<option value="B"> Option B</option>
	    	<option value="C"> Option C</option>
	    	<option value="D"> Option D</option>
	    	</select>
	    </div>

	    </td>
	    </tr>
	    <tr>
	    <td><div class="label">Option Description</div></td>
	    <td><div class="input">
	    	<textarea cols="50" rows="5" name="option_desc[]" class="ui-corner-all input-text validate[required]" style="resize:none"></textarea></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Option Marks</div></td>
	    <td><div class="input">
	    	<input type="text" name="option_marks[]" class="option_marks ui-corner-all input-text validate[required] custom[integer]" value="1">
	    </div>
		
	    </td>
	    </tr>
		<tr>
	    <td><div class="label">Option Type</div></td>
	    <td><div class="input">
	    	<select name="option_type[]" class="option_type input-text validate[required]">
	    	<option value="E"> Extraversion</option>
	    	<option value="I"> Introversion</option>
	    	<option value="S"> Sensing</option>
	    	<option value="N"> iNtuition</option>
	    	<option value="T"> Thinking</option>
	    	<option value="F"> Feeling</option>
	    	<option value="J"> Judging</option>
	    	<option value="P"> Perceiving</option>
	    	</select>
	    </div>

	    </td>
	    </tr>
	    </tbody></table>
	    </div>
		<div id="jvalid"></div>
		<table>
	    <tbody>
		<tr>
		<td><button type="button" id="btnAdd" name="btnAdd">add option</button></td>
		<td><button type="button" id="btnDel" name="btnDel">remove option</button></td>
		</tr>
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Save Question" name="addmbtiquestionbttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>

