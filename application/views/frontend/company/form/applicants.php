<link href="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style type="text/css">
            @import "<?php echo base_url(); ?>assets/frontend/twbs/plugins/datatables/dataTables.bootstrap.css";
         
    #container {
        padding-top: 60px !important;
        width: 960px !important;
    }
    #dt_example .big {
        font-size: 1.3em;
        line-height: 1.45em;
        color: #111;
        margin-left: -10px;
        margin-right: -10px;
        font-weight: normal;
    }
    #dt_example {
        font: 95%/1.45em "Lucida Grande", Verdana, Arial, Helvetica, sans-serif;
        color: #111;
    }
    div.dataTables_wrapper, table {
        font: 13px/1.45em "Lucida Grande", Verdana, Arial, Helvetica, sans-serif;
    }
    #dt_example h1 {
        font-size: 16px !important;
        color: #111;
    }
    #footer {
        line-height: 1.45em;
    }
    div.examples {
        padding-top: 1em !important;
    }
    div.examples ul {
        padding-top: 1em !important;
        padding-left: 1em !important;
        color: #111;
    }
    .scroll-area {
		height: 500px;
		widht: 100%;
		position: relative;
		overflow: auto;
		padding-left: 1px;
		padding-right: 1px;
	}
    .row_selected {
		background-color: #B0BED9;
	}
</style>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/ajaxfileupload/jquery.form.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datatables/media/js/jquery.dataTables.js" charset="utf-8" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datatables/dataTables.bootstrap.js" charset="utf-8" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datetimepicker/js/bootstrap-datetimepicker.js" charset="utf-8" type="text/javascript" ></script>
<script>
	
$(document).ready(function() {
	$('.datetimepicker').datetimepicker({
         format: "yyyy-mm-dd hh:ii:ss",
		 autoclose: true,
		 pickerPosition: "bottom-left"
    });
    var tbl_jobs = $('#tbl_jobs').dataTable
			({
			  "sDom": '<"top">rt<"bottom"p><"clear">',
			  "iDisplayLength": 5,
			  "bSort": false,
			  "oLanguage": {
							"sProcessing": "Processing... <img src='<?php echo base_url(); ?>images/ajax-loader.gif'>"
							},
			  "aoColumns": [ 
							{ "bVisible":    false },
							null,
							null,
							null
					],			
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : '<?php echo $listener_job;?>',
			  "bStateSave": true,
			  "bAutoWidth": false,
			  "bRetrieve": true, 
			  "bDestroy": true, 
			  'fnServerData': function(sSource, aoData, fnCallback)
			  {
			  //alert(aaData);
				aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>" } );
				$.ajax
				({
				  'dataType': 'json',
				  'type'    : 'POST',
				  'url'     : sSource,
				  'data'    : aoData,
				  'success' : fnCallback
				});
			  }
			});
			
	var tbl_filter = $('#tbl_filter').dataTable
			({
			  "sDom": '<"top">rt<"clear">',
			  "iDisplayLength": 5,
			  "bSort": false,
			  "oLanguage": {
							"sProcessing": "Processing... <img src='<?php echo base_url(); ?>images/ajax-loader.gif'>"
							},
			  "aoColumns": [ 
							{ "bVisible":    false },
							{ "bVisible":    false },
							null,
							null
					],			
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : '<?php echo $listener_filter;?>',
			  "bStateSave": true,
			  "bAutoWidth": false,
			  "bRetrieve": true, 
			  "bDestroy": true, 
			  'fnServerData': function(sSource, aoData, fnCallback)
			  {
			  //alert(aaData);
				aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>" } );
				$.ajax
				({
				  'dataType': 'json',
				  'type'    : 'POST',
				  'url'     : sSource,
				  'data'    : aoData,
				  'success' : fnCallback
				});
			  }
			});			
			
			
	var tbl_steps = $('#tbl_steps').dataTable
			({
			  "sDom": '<"top">rt<"clear">',
			  "iDisplayLength": 10,
			  "bSort": false,
			  "oLanguage": {
							"sProcessing": "Processing... <img src='<?php echo base_url(); ?>images/ajax-loader.gif'>"
							},
			  "aoColumns": [ 
							{ "bVisible":    false },
							{ "bVisible":    false },
							null,
							null,
							null
					],			
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : '<?php echo $listener_step;?>',
			  "bStateSave": true,
			  "bAutoWidth": false,
			  "bRetrieve": true, 
			  "bDestroy": true, 
			  'fnServerData': function(sSource, aoData, fnCallback)
			  {
			  //alert(aaData);
				aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>" } );
				$.ajax
				({
				  'dataType': 'json',
				  'type'    : 'POST',
				  'url'     : sSource,
				  'data'    : aoData,
				  'success' : fnCallback
				});
			  }
			});

	var tbl_appls = $('#tbl_applicants').dataTable
			({
			  "sDom": '<"top">frt<"bottom"p><"clear">',
			  "iDisplayLength": 5,
			  "bSort": false,
			  "oLanguage": {
							"sProcessing": "Processing... <img src='<?php echo base_url(); ?>images/ajax-loader.gif'>"
							},
			  "aoColumns": [ 
							{ "bVisible":    false },
							null,
							null,
							{ "bVisible":    false },
							null,
							{ "bVisible":    false },
							null,
							null
					],			
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : '<?php echo $listener_appl;?>',
			  "bStateSave": true,
			  "bAutoWidth": false,
			  "bRetrieve": true, 
			  "bDestroy": true, 
			  'fnServerData': function(sSource, aoData, fnCallback)
			  {
			  //alert(aaData);
				aoData.push( { "name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>" } );
				$.ajax
				({
				  'dataType': 'json',
				  'type'    : 'POST',
				  'url'     : sSource,
				  'data'    : aoData,
				  'success' : fnCallback
				});
			  }
			});
	
	$('#tbl_applicants_filter input').attr("placeholder", "search name or email");
				
	$('#tbl_jobs').on('click', 'tr', function(event) {
		$('#tbl_jobs tr').css('background', '#fff');
		var id = tbl_jobs.fnGetData(this)[0];
		$(this).css('background', '#B0BED9');
		//alert(id);
		tbl_filter.fnReloadAjax('<?php echo base_url(); ?>company/filter_listener/'+id);
		tbl_steps.fnReloadAjax('<?php echo base_url(); ?>company/steps_listener/'+id);
		tbl_appls.fnReloadAjax('<?php echo base_url(); ?>company/jobappl_listener/'+id);
	});
	
	$('#tbl_filter').on('click', 'tr', function(event) {
		$('#tbl_filter tr').css('background', '#fff');
		var id = tbl_filter.fnGetData(this)[0];
		var job_id = tbl_filter.fnGetData(this)[1];
		$(this).css('background', '#B0BED9');
		//alert(id);
		tbl_appls.fnReloadAjax('<?php echo base_url(); ?>company/filterappl_listener/'+id+'/'+job_id);
	});
	
	$('#tbl_steps').on('click', 'tr', function(event) {
			$('#tbl_steps tr').css('background', '#fff');
			var job_id = tbl_steps.fnGetData(this)[0];
			var step_id = tbl_steps.fnGetData(this)[1];
			$(this).css('background', '#B0BED9');
			//alert(job_id+' '+step_id);
			tbl_appls.fnReloadAjax('<?php echo base_url(); ?>company/stepappl_listener/'+job_id+'/'+step_id);
		});

	$('#tbl_applicants').on('click', 'tr', function(event) {
		$('#tbl_applicants tr').css('background', '#fff');
		var id = tbl_appls.fnGetData(this)[0];
		//var jb_id = tbl_steps.fnGetData(this)[0];
		//var sp_id = tbl_steps.fnGetData(this)[1];
		$(this).css('background', '#B0BED9');
		//alert(jb_id);
		$.ajax({
            url: '<?php echo base_url(); ?>company/cv/'+id,
            success: function(data) {
                $('#preview_resume').html(data);
            }
        });
		//initDataTablesSteps('<?php echo base_url(); ?>company/steps_listener/'+id);
	});
	
	addStep = function(job_id,step_id,user_id){
		//alert(job_id+' '+step_id+' '+user_id);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>company/add_jobstepperson",
			data: { job_id: job_id, step_id: step_id, user_id: user_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'}
		})
		.done(function() {
			//tbl_steps.fnReloadAjax();
			tbl_steps.fnStandingRedraw();
			//tbl_appls.fnReloadAjax();
			tbl_appls.fnStandingRedraw();
		});
	}
	
	deleteStep = function(job_id,step_id,user_id){
		//alert(job_id+' '+step_id+' '+user_id);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>company/delete_jobstepperson",
			data: { job_id: job_id, step_id: step_id, user_id: user_id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' }
		})
		.done(function() {
			//tbl_steps.fnReloadAjax();
			tbl_steps.fnStandingRedraw();
			//tbl_appls.fnReloadAjax();
			tbl_appls.fnStandingRedraw();
		});
	}
	
	sendPersonalEmail = function(user_id){
		$("#send_email").attr("action", "<?php echo base_url(); ?>company/send_personal_email/" + user_id);
		$('#SendEmail').modal('show');
	}
	
	sendStepEmail = function(job_id,step_id){
		$("#send_email").attr("action", "<?php echo base_url(); ?>company/send_email/" + job_id + '/' + step_id);
		$('#SendEmail').modal('show');
	}
	
	sendPersonalAOT = function(job_id,user_id){
		//alert(job_id);
		$("#send_aot").attr("action", "<?php echo base_url(); ?>company/send_personal_aot/" + job_id + '/' + user_id);
		$('#SendAOT').modal('show');
	}
	
	sendStepAOT = function(job_id,step_id){
		$("#send_aot").attr("action", "<?php echo base_url(); ?>company/send_aot/" + job_id + '/' + step_id);
		$('#SendAOT').modal('show');
	}
	
	sendPersonalAOI = function(job_id,user_id){
		//alert(job_id);
		$("#send_aoi").attr("action", "<?php echo base_url(); ?>company/send_personal_aoi/" + job_id + '/' + user_id);
		$('#SendAOI').modal('show');
	}
	
	sendStepAOI = function(job_id,step_id){
		$("#send_aoi").attr("action", "<?php echo base_url(); ?>company/send_aoi/" + job_id + '/' + step_id);
		$('#SendAOI').modal('show');
	}
	
	$("#send_email").ajaxForm({
		complete: function(response) { // on complete
			alert(response.responseText);
			$('#SendEmail').modal('hide');
		}
	});
	
	$('#SendEmail').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
			$('#cc').val('');
			$('#subject').val('');
			$('#attach').val('');
			$('#message').html('');
			var wysihtml5Editor = $('#message').data("wysihtml5").editor;
			wysihtml5Editor.setValue("", true);
	});
	
	$("#send_aot").ajaxForm({
		complete: function(response) { // on complete
			alert(response.responseText);
			$('#SendAOT').modal('hide');
		}
	});
	
	$('#SendAOT').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
			$('#description').html('');
			var wysihtml5Editor = $('#description').data("wysihtml5").editor;
			wysihtml5Editor.setValue("", true);
	});
	
	$("#send_aoi").ajaxForm({
		complete: function(response) { // on complete
			alert(response.responseText);
			$('#SendAOI').modal('hide');
		}
	});
	
	$('#SendAOI').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
			$('#description').html('');
			var wysihtml5Editor = $('#description').data("wysihtml5").editor;
			wysihtml5Editor.setValue("", true);
	});
	
	$('#message').wysihtml5();
	$('#description').wysihtml5();
	
} );

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    // DataTables 1.10 compatibility - if 1.10 then versionCheck exists.
    // 1.10s API has ajax reloading built in, so we use those abilities
    // directly.
    if ( $.fn.dataTable.versionCheck ) {
        var api = new $.fn.dataTable.Api( oSettings );
 
        if ( sNewSource ) {
            api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
        }
        else {
            api.ajax.reload( fnCallback, !bStandingRedraw );
        }
        return;
    }
 
    if ( sNewSource !== undefined && sNewSource !== null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
 
    this.oApi._fnServerParams( oSettings, aData );
 
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
 
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
 
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
         
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
 
        that.fnDraw();
 
        if ( bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd( oSettings );
            that.fnDraw( false );
        }
 
        that.oApi._fnProcessingDisplay( oSettings, false );
 
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback !== null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};

$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
    if(oSettings.oFeatures.bServerSide === false){
        var before = oSettings._iDisplayStart;
 
        oSettings.oApi._fnReDraw(oSettings);
 
        // iDisplayStart has been reset to zero - so lets change it back
        oSettings._iDisplayStart = before;
        oSettings.oApi._fnCalculateEnd(oSettings);
    }
      
    // draw the 'current' page
    oSettings.oApi._fnDraw(oSettings);
};

</script>

<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

		<div class="row">
		  <div class="col-md-4">

	      <div class="panel-group" id="left">
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#left" href="#jobs">
					  <h4 class="panel-title">
						  <?php echo lang('jobs'); ?>
					  </h4>
					</a>
				</div>
				<div id="jobs" class="panel-collapse collapse in">
				  
						  <div class="panel-body">
							<table class="table table-bordered table-responsive" id="tbl_jobs" border="0" cellpadding="0" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Job Id</th>
										<th><?php echo lang('company'); ?></th>
										<th><?php echo lang('job_name'); ?></th>
										<th><?php echo lang('applicants'); ?></th>
									</tr>
								</thead>
							</table>
						  </div>
				  
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#left" href="#filter_by_system">
						<h4 class="panel-title">
							<?php echo lang('filter_by_system'); ?>
						</h4>
					</a>
				</div>
				<div id="filter_by_system" class="panel-collapse collapse">
				 
					<div class="panel-body">
							<table class="table table-bordered table-responsive" id="tbl_filter" border="0" cellpadding="0" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Fid</th>
										<th>Job Id</th>
										<th>Filter</th>
										<th><?php echo lang('applicants'); ?></th>
									</tr>
								</thead>
							</table>
						  </div>
				 
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#left" href="#steps">
						<h4 class="panel-title">
							<?php echo lang('steps'); ?>
						</h4>
					</a>
				</div>
				<div id="steps" class="panel-collapse collapse">

						  <div class="panel-body">
							<table class="table table-bordered table-responsive" id="tbl_steps" border="0" cellpadding="0" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Job Id</th>
										<th>Step Id</th>
										<th><?php echo lang('step_name'); ?></th>
										<th><?php echo lang('applicants'); ?></th>
										<th><?php echo lang('action'); ?></th>
									</tr>
								</thead>
							</table>
						  </div>
				</div>
			  </div>
			</div>

		  </div>
		  
		  <div class="col-md-8">
			  
			  <div class="panel-group" id="right">
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#right" href="#applicants">
					  <h4 class="panel-title">
						  <?php echo lang('applicants'); ?>
					  </h4>
					</a>
				</div>
				<div id="applicants" class="panel-collapse collapse in">
				  
						  <div class="panel-body">
							<table class="table table-bordered table-responsive" id="tbl_applicants" border="0" cellpadding="0" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Applicant Id</th>
										<th><?php echo lang('applicant_name'); ?></th>
										<th><?php echo lang('applicant_email'); ?></th>
										<th>Current Step Id</th>
										<th><?php echo lang('current_step'); ?></th>
										<th>Next Step Id</th>
										<th><?php echo lang('next_step'); ?></th>
										<th><?php echo lang('action'); ?></th>
									</tr>
								</thead>
							</table>
						  </div>
				  
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#right" href="#resume">
						<h4 class="panel-title">
							<?php echo lang('resume'); ?>
						</h4>
					</a>
				</div>
				<div id="resume" class="panel-collapse collapse">
				  <div class="panel-body">
				  
						<div id="preview_resume"></div>
				  
				  </div>
				</div>
			  </div>
			</div>
		  
		   </div>  
	
	</div>  
</div><!-- /.container -->

<div class="modal fade" id="SendEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('send_email'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="send_email" role="form" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div id="jvalid"></div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">CC Email</label>
			<div class="col-sm-10">
			  <input type="text" name="cc" class="form-control" id="cc" placeholder="CC Email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('subject'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="subject" class="form-control" id="subject" placeholder="<?php echo lang('subject'); ?> Email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('messages'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="message" id="message" placeholder="<?php echo lang('messages'); ?> Email"></textarea>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('attach'); ?></label>
			<div class="col-sm-10">
			  <input type="file" name="attach" id="attach">
			  <div class="help-block"><?php echo lang('max_3mb_with_only_zip_extension'); ?></div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary"><?php echo lang('send'); ?></button>
			  <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><?php echo lang('cancel'); ?></button>
			</div>
		  </div>
		</form>
      </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="SendAOT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> Online Test</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="send_aot" role="form" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div id="jvalid"></div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Test Name <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="examid" class="form-control examid">
				<?php 
					if($aot->num_rows() > 0){
						foreach($aot->result_array() as $test){
				?>
					 <option value="<?php echo $test['examid']; ?>"><?php echo $test['examname'].' : '.$test['availablefrom'].' - '.$test['availableto']; ?></option>
				<?php 
						}
					}
				?>
				<option value="disc">DISC</option>
				<option value="mbti">MBTI</option>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Description <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"></textarea>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Start <span class="important">*</span></label>
			<div class="col-sm-10">
				<input class="datetimepicker" name="startdate" data-format="MM/dd/yyyy HH:mm:ss PP" type="text"></input>
			</div>
		  </div>
  
		  <div class="form-group">
			<label class="col-sm-2 control-label">End <span class="important">*</span></label>
			<div class="col-sm-10">
				<input class="datetimepicker" name="enddate" data-format="MM/dd/yyyy HH:mm:ss PP" type="text"></input>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary"><?php echo lang('send'); ?></button>
			  <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><?php echo lang('cancel'); ?></button>
			</div>
		  </div>
		</form>
      </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="SendAOI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> Online Interview</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="send_aoi" role="form" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div id="jvalid"></div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Description <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"></textarea>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Start <span class="important">*</span></label>
			<div class="col-sm-10">
				<input class="datetimepicker" name="startdate" data-format="MM/dd/yyyy HH:mm:ss PP" type="text"></input>
			</div>
		  </div>
  
		  <div class="form-group">
			<label class="col-sm-2 control-label">End <span class="important">*</span></label>
			<div class="col-sm-10">
				<input class="datetimepicker" name="enddate" data-format="MM/dd/yyyy HH:mm:ss PP" type="text"></input>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary"><?php echo lang('send'); ?></button>
			  <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><?php echo lang('cancel'); ?></button>
			</div>
		  </div>
		</form>
      </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
