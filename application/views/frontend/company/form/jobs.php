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
</style>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datatables/media/js/jquery.dataTables.js" charset="utf-8" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datatables/dataTables.bootstrap.js" charset="utf-8" type="text/javascript" ></script>
<script>
$(document).ready(function() {
 
     initDataTables('<?php echo $listener;?>');
     
} );
function initDataTables(source){
   	$('#tbl_server').dataTable
			({
			  "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
			  "oLanguage": {
							"sProcessing": "Processing... <img src='<?php echo base_url(); ?>images/ajax-loader.gif'>"
							},
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : source,
			  "bStateSave": false,
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
}

function showAppl(job_id){
	window.location.replace("<?php echo base_url().'company/applicants/'; ?>"+job_id);
}
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

		
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo lang('jobs_management'); ?> <span class="pull-right"><a class="btn btn-primary" href="<?php echo base_url().'company/post/'; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo lang('post'); ?></a></span></h4></p>
              </div>
			  <div class="panel-body">
				<table class="table table-striped table-bordered table-hover table-responsive" id="tbl_server" border="0" cellpadding="0" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width="20%"><?php echo lang('job_name'); ?></th>
							<th width="10%">Status</th>
							<th width="20%"><?php echo lang('company'); ?></th>
							<th width="15%"><?php echo lang('post_date'); ?></th>
							<th width="15%"><?php echo lang('expire_date'); ?></th>
							<th width="5%"><?php echo lang('show'); ?></th>
							<th width="5%"><?php echo lang('applicants'); ?></th>
							<th width="10%"><?php echo lang('tools'); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php echo lang('job_name'); ?></th>
							<th>Status</th>
							<th><?php echo lang('company'); ?></th>
							<th><?php echo lang('post_date'); ?></th>
							<th><?php echo lang('expire_date'); ?></th>
							<th><?php echo lang('show'); ?></th>
							<th><?php echo lang('applicants'); ?></th>
							<th><?php echo lang('tools'); ?></th>
						</tr>
					</tfoot>
				</table>
			  </div>
	      </div>
	      
		 
    </div>
        

</div><!-- /.container -->
