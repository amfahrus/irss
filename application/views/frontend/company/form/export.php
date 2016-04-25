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
<script>
	
$(document).ready(function() {
	var tbl_aot = $('#tbl_aot').dataTable
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
							null,
							null
					],			
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : '<?php echo $listener_aot;?>',
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
							null,
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
							{ "bVisible":    false },
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
				
	$('#tbl_jobs').on('click', 'tr', function(event) {
		$('#tbl_jobs tr').css('background', '#fff');
		var id = tbl_jobs.fnGetData(this)[0];
		$(this).css('background', '#B0BED9');
		//alert(id);
		tbl_filter.fnReloadAjax('<?php echo base_url(); ?>company/filter_listener/'+id);
		tbl_steps.fnReloadAjax('<?php echo base_url(); ?>company/steps_listener/'+id);
	});
	
	$('#tbl_filter').on('click', 'tr', function(event) {
		$('#tbl_filter tr').css('background', '#fff');
		var id = tbl_filter.fnGetData(this)[0];
		var job_id = tbl_filter.fnGetData(this)[1];
		$(this).css('background', '#B0BED9');
		//alert(id);
	});
	
	$('#tbl_steps').on('click', 'tr', function(event) {
			$('#tbl_steps tr').css('background', '#fff');
			var job_id = tbl_steps.fnGetData(this)[0];
			var step_id = tbl_steps.fnGetData(this)[1];
			$(this).css('background', '#B0BED9');
			//alert(job_id+' '+step_id);
		});
		
	aottoexcel = function(examid){
		//alert(job_id);
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/aottoexcel");
		var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "examid").val(examid);
		$('#exportform').append($(input));
		$('#exportform').submit();
	}
	
	aottopdf = function(examid){
		//alert(job_id);
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/aottopdf");
		var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "examid").val(examid);
		$('#exportform').append($(input));
		$('#exportform').submit();
	}
	
	apptoexcel = function(job_id){
		//alert(job_id);
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/apptoexcel");
		var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		$('#exportform').append($(input));
		$('#exportform').submit();
	}
	
	apptopdf = function(job_id){
		//alert(job_id);
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/apptopdf");
		var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		$('#exportform').append($(input));
		$('#exportform').submit();
	}
	
	filtertoexcel = function(job_id,fid){
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/filtertoexcel");
		var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "fid").val(fid);
		$('#exportform').append($(input1));
		$('#exportform').append($(input2));
		$('#exportform').submit();
	}
	
	filtertopdf = function(job_id,fid){
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/filtertopdf");
		var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "fid").val(fid);
		$('#exportform').append($(input1));
		$('#exportform').append($(input2));
		$('#exportform').submit();
	}
	
	steptoexcel = function(job_id,step_id,step_name){
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/steptoexcel");
		var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "step_id").val(step_id);
		var input3 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "step_name").val(step_name);
		$('#exportform').append($(input1));
		$('#exportform').append($(input2));
		$('#exportform').append($(input3));
		$('#exportform').submit();
	}
	
	steptopdf = function(job_id,step_id,step_name){
		$('#exportform').attr("action", "<?php echo base_url(); ?>company/steptopdf");
		var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "job_id").val(job_id);
		var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "step_id").val(step_id);
		var input3 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "step_name").val(step_name);
		$('#exportform').append($(input1));
		$('#exportform').append($(input2));
		$('#exportform').append($(input3));
		$('#exportform').submit();
	}
	
});

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
		  <div class="col-md-12">

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
										<th colspan="2">Export</th>
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
										<th colspan="2">Export</th>
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
										<th colspan="3">Export</th>
									</tr>
								</thead>
							</table>
						  </div>
				</div>
			  </div>
			  <div class="panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#left" href="#aots">
						<h4 class="panel-title">
							<?php echo 'AOT'; ?>
						</h4>
					</a>
				</div>
				<div id="aots" class="panel-collapse collapse">

						  <div class="panel-body">
							<table class="table table-bordered table-responsive" id="tbl_aot" border="0" cellpadding="0" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Exam Id</th>
										<th>Exam Name</th>
										<th><?php echo lang('applicants'); ?></th>
										<th colspan="3">Export</th>
									</tr>
								</thead>
							</table>
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
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="exportform" role="form" accept-charset="utf-8" method="post" action="">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		</form>
      </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
