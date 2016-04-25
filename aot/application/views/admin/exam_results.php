<script src="<?php echo base_url(); ?>assets/plugins/htmltoexcel/jquery.battatech.excelexport.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	$( "#availablefrom" ).datepicker({
      defaultDate: "+1w",
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#availableto" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#availableto" ).datepicker({
      defaultDate: "+1w",
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#availablefrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });	
	$("#btnExport").click(function () {
	$("#tblExport").btechco_excelexport({
	containerid: "tblExport"
	, datatype: $datatype.Table
	});
	});
	topdf = function(){
		$('#createexamform').attr("action", "<?php echo base_url(); ?>administrator/pdfresult/<?=$exam_id;?>");
		$('#createexamform').submit();
	}
});
function modalWin(examid, userid) {
	if (window.showModalDialog) {
	window.showModalDialog("<?php echo base_url(); ?>administrator/results_summary/?examid="+examid+"&userid"+userid,"name dialogWidth:500px;dialogHeight:250px");
	} else {
	window.open('<?php echo base_url(); ?>administrator/results_summary/?examid='+examid+'&userid'+userid,'name height=255,width=500,toolbar=no,directories=no,status=no,linemenubar=no,scrollbars=no,resizable=no,modal=yes');
	}
} 
function loadOtherPage(examid, userid) {

    $("<iframe>")                             // create a new iframe element
        .hide()                               // make it invisible
        .attr("src", "<?php echo base_url(); ?>administrator/results_summary/?examid="+examid+"&userid="+userid) // point the iframe to the page you want to print
        .appendTo("body");                    // add iframe to the DOM to cause it to load the page

}
</script>
<div class="mainholder ">
        <div class="content ui-corner-all">
		<form action="<?php echo base_url().'administrator/view_results/'.$exam_id; ?>" method="post" id="createexamform">
			<table>
			<tbody>
				<tr>
				<td><div class="label">Name</div></td>
				<td><div class="input">
					<input type="text" name="name" size="39" class="ui-corner-all input-text">
					</div>
				</td>
				</tr>
				<tr>
				<td><div class="label">From</div></td>
				<td><div class="input">
					<input type="text" name="start" id="availablefrom" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('availablefrom'); ?></div></td>
				</tr>
				<tr>
				<td><div class="label">To</div></td>
				<td><div class="input">
					<input type="text" name="end" id="availableto" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('availableto'); ?></div></td>
				</tr>
				<!--<tr>
				<td><div class="label">Min. Percentage</div></td>
				<td><div class="input">
					<input type="text" name="min_percent" size="39" class="ui-corner-all input-text validate[required]"></div></td>
				</tr>
				<tr>-->
				<td>&nbsp;</td>
				<td><input type="submit" value="Search" name="searchbttn" class="input-button ui-corner-all ui-state-default"></td>
				</tr>	
			</tbody>
			</table>
		</form>	
        <h1><a href="<?php echo base_url().'administrator/publish_results/'.$exam_id; ?>"><img src="<?php echo base_url(); ?>assets/admin/images/add.png"> Publish</a></h1>
        <h1><div><button onclick="topdf()">Export PDF</button></div></h1>
        <h1><div><button id="btnExport">Export XLS</button></div></h1>
        <h1 style="color:#06F;"><?=$exam_results['examname'];?></h1>
        <div id="tblExport">
        <table cellpadding="0" cellspacing="15" border="0" style="text-align:left;width:100%">
        <tbody><tr>
        <td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Exam Results Summary</h3></td>
        </tr>
        <tr><td colspan="2"><hr/></td></tr>
        <tr><td>Exam </td><td><?=$exam_results['examname'];?></td></tr>
        <tr><td>Max. Marks</td><td><?=$exam_results['totalmarks'];?></td></tr>
        <tr><td>Pass Mark</td><td><?=$exam_results['exampassmark'];?>%</td></tr>
        <tr><td colspan="2"><hr/></td></tr>
        <?php
        if(!empty($exam_results['users_results']))
        {?>
        <tr><td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Attempted Users</h3></td></tr><tr><td colspan="2"><hr/></td></tr>
        <table cellpadding="0" cellspacing="30" class="datatable">
        <tbody><tr><th></th><th>Name</th><th>Email</th><th>Marks Obtained</th><th>Percentage</th><th>Remarks</th></tr>
        <?php
        $count = 1;
        foreach ($exam_results['users_results'] as $userresults) 
        {?>
          <tr>
                <td><?=$count;?>.</td>
                <td><?=$userresults['user_names'];?></td>
                <td><?=$userresults['user_email'];?></td>
                <td style="text-align:center"><?=$userresults['marksobtained'];?></td>
                <td style="text-align:center"><?=$userresults['percentage'];?>%</td>
                <td><?php
                if($userresults['passed'])
                {
                        echo '<span class="passed"><a href="#" onclick="loadOtherPage('.$userresults['exam_id'].','.$userresults['user_id'].');return false;">Passed</a></span>';
                }
                else
                {
                        echo '<span class="failed"><a href="#" onclick="loadOtherPage('.$userresults['exam_id'].','.$userresults['user_id'].');return false;">Failed</a></span>';
                }
                ?>
                </td>
          </tr>
        <?php
        $count ++;
        }
        ?>

        </tbody></table>
        <?php
        }
        ?>
        </tbody></table>
</div>
        </div>
        <div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>
<style type="text/css">
.datatable {
border: 1px solid #D6DDE6;
border-collapse: collapse;
text-align: left;
width: 100%;
font-size: 1em;
}
table {
border: 0;
font-family: verdana,sans-serif;
font-size: 1.2em;
margin-left: auto;
margin-right: auto;
text-align: center;
}
.datatable th {
border: 1px solid #828282;
background-color: #FCC;
font-weight: bold;
text-align: left;
padding: 1em;
}
.datatable td {
border: 1px solid #D6DDE6;
padding: 1em;
}
</style>

