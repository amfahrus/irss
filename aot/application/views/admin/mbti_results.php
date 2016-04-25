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
});
</script>
<div class="mainholder ">
        <div class="content ui-corner-all">
		<form action="<?php echo base_url().'administrator/view_mbtiresults'; ?>" method="post" id="createexamform">
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
				<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Search" name="searchbttn" class="input-button ui-corner-all ui-state-default"></td>
				</tr>	
			</tbody>
			</table>
		</form>		
        <h1><div><button id="btnExport">Export XLS</button></div></h1>
        <h1 style="color:#06F;"><?=$exam_results['examname'];?></h1>
        <div id="tblExport">
        <table cellpadding="0" cellspacing="15" border="0" style="text-align:left;width:100%">
        <tbody><tr>
        <td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Exam Results Summary</h3></td>
        </tr>
        <tr><td colspan="2"><hr/></td></tr>
        <tr><td>Exam </td><td><?=$exam_results['examname'];?></td></tr>
        <tr><td colspan="2"><hr/></td></tr>
        <?php
        if(!empty($exam_results['users_results']))
        {?>
        <tr><td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Attempted Users</h3></td></tr><tr><td colspan="2"><hr/></td></tr>
        <table cellpadding="0" cellspacing="30" class="datatable">
        <tbody>
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">Name</th>
				<th rowspan="2">Email</th>
				<th colspan="2">Energy</th>
				<th colspan="2">Information</th>
				<th colspan="2">Decisions</th>
				<th colspan="2">Lifestyle</th>
				<th rowspan="2">Result</th>
			</tr>
			<tr>
				<th>E</th>
				<th>I</th>
				<th>S</th>
				<th>N</th>
				<th>T</th>
				<th>F</th>
				<th>J</th>
				<th>P</th>
			</tr>
        <?php
        $count = 1;
        foreach ($exam_results['users_results'] as $userresults) 
        {?>
          <tr>
                <td rowspan="2"><?=$count;?>.</td>
                <td rowspan="2"><?=$userresults['user_names'];?></td>
                <td rowspan="2"><?=$userresults['user_email'];?></td>
                <td style="text-align:center"><?=$userresults['E'];?></td>
                <td style="text-align:center"><?=$userresults['I'];?></td>
                <td style="text-align:center"><?=$userresults['S'];?></td>
                <td style="text-align:center"><?=$userresults['N'];?></td>
                <td style="text-align:center"><?=$userresults['T'];?></td>
                <td style="text-align:center"><?=$userresults['F'];?></td>
                <td style="text-align:center"><?=$userresults['J'];?></td>
                <td style="text-align:center"><?=$userresults['P'];?></td>
                <td style="text-align:center"><?=$userresults['user_mbti'];?></td>
          </tr>
		  <tr>
                <td colspan="9" style="text-align:center"><?=$userresults['user_mbti_type'];?></td>
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
