<!--<link href="<?php echo base_url(); ?>assets/plugins/froala/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/froala/css/froala_editor.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/froala/css/froala_reset.min.css" rel="stylesheet" type="text/css">
 --> 
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
  $("#editquestionform").validationEngine();
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
		<p class="pagetittle">Edit Question</p>
	</div>
	<?php 
		if(isset($success))
			echo '<p id="success" class="msg done">'.$success.'</p>';
		if(isset($error))
			echo '<p id="error" class="msg error">'.$error.'</p>';
		?>
		
		<form action="" method="post" id="editquestionform">
		<table>
	    <tbody>
	    <tr>
	    <td><div class="label">Question</div></td>
	    <td><div class="input">
	    <input type="hidden" value='<?=(isset($question)) ? $question->questionid : '' ;?>' name='questionid'/>
	    <textarea id="ajaxfilemanager" cols="50" rows="5" name="question" class="ui-corner-all input-text validate[required]" style="resize:none"><?=(isset($question)) ? $question->question : '' ;?></textarea>
	    </div></td>
	    </tr>
	      <tr>
	    <td><div class="label">Option A</div></td>
	    <td><div class="input">
	    	<input type="text" name="optiona" value="<?=(isset($question)) ? $question->optiona : '' ;?>" class="ui-corner-all input-text validate[required]"><?=form_error('optiona'); ?></div></td>
	    </tr>
	      <tr>
	    <td><div class="label">Option B</div></td>
	    <td><div class="input">
	    	<input type="text" name="optionb" value="<?=(isset($question)) ? $question->optionb : '' ;?>" class="ui-corner-all input-text validate[required]"><?=form_error('optionb'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Option C</div></td>
	    <td><div class="input">
	    	<input type="text" name="optionc" value="<?=(isset($question)) ? $question->optionc : '' ;?>" class="ui-corner-all input-text validate[required]"><?=form_error('optionc'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Option D</div></td>
	    <td><div class="input">
	    	<input type="text" name="optiond" value="<?=(isset($question)) ? $question->optiond : '' ;?>" class="ui-corner-all input-text validate[required]"><?=form_error('optiond'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Correct Answer</div></td>
	    <td><div class="input">
	    	<select name="correctanswer" class="input-text validate[required]">
	    	<option value="">------- Select Option ------</option>
	    	<option value="A" <?=(isset($question) && $question->correctanswer == 'A') ? 'selected' : '' ;?>> Option A</option>
	    	<option value="B" <?=(isset($question) && $question->correctanswer == 'B') ? 'selected' : '' ;?>> Option B</option>
	    	<option value="C" <?=(isset($question) && $question->correctanswer == 'C') ? 'selected' : '' ;?>> Option C</option>
	    	<option value="D" <?=(isset($question) && $question->correctanswer == 'D') ? 'selected' : '' ;?>> Option D</option>
	    	</select>
	    </div>

	    </td>
	    </tr>
	    <tr>
	    <td><div class="label">Marks</div></td>
	    <td><div class="input">
	    	<input type="text" name="marks" value="<?=(isset($question)) ? $question->marks : 1 ;?>" class="ui-corner-all input-text validate[required] custom[integer]" value="1"><?=form_error('marks'); ?>
	    </div>

	    </td>
	    </tr>
	    
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Save Question" name="editquestionbttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>
<!--
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/libs/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/libs/beautify/beautify-html.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/froala_editor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/froala_editor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/tables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/colors.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/fonts/fonts.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/fonts/font_family.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/fonts/font_size.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/block_styles.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/froala/js/plugins/video.min.js"></script>

<script>
  $(function(){
	  $('#questions').editable({inlineMode: false})
  });
</script>
-->
