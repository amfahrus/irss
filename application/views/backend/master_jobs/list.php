
<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/backend/js/jquery-1.7.2.min.js"></script>
<script>
jQuery(document).ready(function() {

function initDataTables(source){
   	$('#tbl_server').dataTable
			({
			  "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
			  "sPaginationType": "bootstrap",
			  "oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
				},
			  'bProcessing'    : true,
			  'bServerSide'    : true,
			  'sAjaxSource'    : source,
			  "aLengthMenu": [[10, 20, 30, 40, 50, 100], [10, 20, 30, 40, 50, 100]],
			  "bStateSave": true,
			  "bAutoWidth": false,
			  "bRetrieve": true, 
			  "bDestroy": true, 
			  'fnServerData': function(sSource, aoData, fnCallback)
			  {
			  //alert(aaData);
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

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
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
          
        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.fnDraw( false );
        }
        else
        {
            that.fnDraw();
        }
          
        that.oApi._fnProcessingDisplay( oSettings, false );
          
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback != null )
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

$(function(){
    initDataTables('<?php echo base_url().$listener;?>');
});

});
</script>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo $home; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><? echo $subtitle; ?></a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i><? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table id='tbl_server' class="table table-striped table-bordered bootstrap-datatable">
							<thead>
							  <tr>
								  <th>Job Name</th>
								  <th>Company Name</th>
								  <th>Post Date</th>
								  <th>End Date</th>
								  <th>Status</th>
								  <th>Action</th>
							  </tr>
							</thead>   
							<tbody>
									<tr>
										<td class='center'>
											
                                        </td>
                                        <td class='center'>
                                            
                                        </td>
                                        <td class='center'>
                                           
                                        </td>
                                        <td class='center'>
                                           
                                        </td>
                                        <td class='center'>
                                           
                                        </td>
                                        <td class='center'>
                                           
                                        </td>
									</tr>
                        </tbody>
                    </table>
                </div>
             </div><!--/span-->
		</div><!--/row-->
