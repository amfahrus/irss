<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
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
		<form action="<?php echo base_url().'administrator/view_discresults'; ?>" method="post" id="createexamform">
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
        if(!empty($exam_results['guest_results']))
        {?>
        <tr><td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Attempted Users</h3></td></tr><tr><td colspan="2"><hr/></td></tr>
        <table cellpadding="0" cellspacing="30" class="datatable">
        <tbody>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Karakter</th>
			</tr>
        <?php
        $count = 1;
        foreach ($exam_results['guest_results'] as $userresults) 
        {?>
          <tr>
                <td><?=$count;?>.</td>
                <td><?=$userresults['user_name'];?></td>
                <td><?=$userresults['user_email'];?></td>
                <td><?=$userresults['guest_disc_type_desc'];?></td>
          </tr> <script>
			$(function () {
				$('#container_<?=$userresults['user_id'];?>').highcharts({
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: 'pie'
					},
					title: {
						text: 'Grafik Tes Karakter <?=$userresults['user_name'];?>'
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %',
								style: {
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
							}
						}
					},
					series: [{
						name: "Total",
						colorByPoint: true,
						data: [{
							name: "Dominan",
							y: <?=$userresults['avg_D'];?>,
							color:'#F7464A',
							highlight: '#FF5A5E'
						}, {
							name: "Intim",
							y: <?=$userresults['avg_I'];?>,
							color: '#FDB45C',
							highlight: '#FFC870'
						}, {
							name: "Stabil",
							y: <?=$userresults['avg_S'];?>,
							color: '#46BFBD',
							highlight: '#5AD3D1'
						}, {
							name: "Cermat",
							y: <?=$userresults['avg_C'];?>,
							color: '#5B81FD',
							highlight: '#7F9DFF'
						}]
					}]
				});
			});
		  </script>
		  <tr>
                <td colspan="4"><div id="container_<?=$userresults['user_id'];?>" style="min-width: 
310px; height: 400px; margin: 0 auto"></div></td>
          </tr>




		 <!-- <tr>
                <td style="text-align:center">C</td>
                <td style="text-align:center"><?=$userresults['user_disc_c_d'];?></td>
                <td style="text-align:center"><?=$userresults['user_disc_c_i'];?></td>
                <td style="text-align:center"><?=$userresults['user_disc_c_s'];?></td>
                <td style="text-align:center"><?=$userresults['user_disc_c_c'];?></td>
                <td style="text-align:center"></td>
                <td style="text-align:center"></td>
          </tr>-->
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

