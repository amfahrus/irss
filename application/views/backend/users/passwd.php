<script>

function showpass()
{

if($("input[name='dokumen']:checked").val())
{
 $('#dok').hide();
 $("input[name='password']").each (function() {  this.type = 'text' });
}
else
{
 $('#dok').show();
 $("input[name='password']").each (function() {  this.type = 'password' });
 var pass=$("input[name='password']").val();
 $("input[name='conf_password']").val(pass);
}

}
function kirim()
{
if($("input[name='dokumen']:checked").val())
{


}
else
{
 var pass1=$("input[name='password']").val();
 var pass2=$("input[name='conf_password']").val();
 
 if(pass1!=pass2)
 {
	alert("password tidak sama");
	return false;
 }
}

}
</script>
<div>
	<ul class="breadcrumb">
		<li>
			<a href="<?php echo base_url(); ?>"><? echo $modul; ?></a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#"><? echo $title; ?></a>
		</li>
	</ul>
</div>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><? echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?php echo base_url() . $act; ?>" method='post'>
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Show Password</label>
									<div class="controls">
									  <input  type='checkbox' name='dokumen' onclick="return showpass();" value='1' />
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Password</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='password' id="focusedInput" type="password" value="">
									</div>
								</div>
								
								<div class="control-group" id="dok">
									<label class="control-label" for="focusedInput">Confirm Password</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='conf_password' id="focusedInput" type='password' value="">
									</div>
								</div>
								
								<div class="form-actions">
								<button type="submit" onclick="return kirim();" class="btn btn-primary">Submit</button>
								<button class="btn">Cancel</button>
							  </div>
								
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
</div><!--/row-->
