<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/htmltoexcel/jquery.battatech.excelexport.js"></script>
<script type="text/javascript">
$(document).ready(function () {
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
		<form action="<?php echo base_url().'administrator/compare_summary'; ?>" method="post" id="createexamform">
			<table>
			<tbody>
				<tr>
				<td><div class="label">Exam</div></td>
				<td><div class="input">
					<select name="exam1">
						<?php
							if(count($exams)>0){
								foreach($exams as $row){
									echo '<option value="'.$row['examid'].'">'.$row['examname'].'</option>';
								}
							}
						?>
					</select>
					</div>
				</td>
				</tr>
				<tr>
				<td><div class="label">Exam</div></td>
				<td><div class="input">
					<select name="exam2">
						<?php
							if(count($exams)>0){
								foreach($exams as $row){
									echo '<option value="'.$row['examid'].'">'.$row['examname'].'</option>';
								}
							}
						?>
					</select>
					</div>
				</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Search" name="searchbttn" class="input-button ui-corner-all ui-state-default"></td>
				</tr>	
			</tbody>
			</table>
		</form>		
        <h1><div><button id="btnExport">Export XLS</button></div></h1>
        <div id="tblExport">
        <table cellpadding="0" cellspacing="15" border="0" style="text-align:left;width:100%">
        <tbody><tr>
        <td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Compare Summary</h3></td>
        </tr>
        <tr><td colspan="2"><hr/></td></tr>
        <?php
        if(!empty($results))
        {?>
        <table cellpadding="0" cellspacing="30" id="datacompare" class="datatable">
        <tbody>
			<tr>
				<th></th>
				<th><?=$examname1;?></th>
				<th><?=$examname2;?></th>
			</tr>
        <?php
		//die(print_r($results));
        foreach ($results as $rows) 
        {?>
          <tr>
                <td><?=$rows['name'];?></td>
                <td><?=round($rows['tes1'],0);?></td>
                <td><?=round($rows['tes2'],0);?></td>
          </tr>
        <?php
        }
        ?>
        </tbody></table>
		
		
		  <script>
		  $(function () {
				$('#container').highcharts({
					data: {
						table: 'datacompare'
					},
					chart: {
						type: 'column'
					},
					title: {
						text: 'Perbandingan'
					},
					yAxis: {
						allowDecimals: false,
						title: {
							text: 'Persen'
						}
					},
					tooltip: {
						formatter: function () {
							return '<b>' + this.series.name + '</b><br/>' +
								this.point.y + '%';
						}
					}
				});
			});
		  </script>
		  <tr>
                <td colspan="2"><div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div></td>
          </tr>	
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
