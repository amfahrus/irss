<script type="text/javascript" src="<?=base_url();?>assets/js/validationEngine/js/jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function () {
    window.print();
});
</script>
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
background: #F5F9F4;
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
<div class="mainholder " id="printableArea">
        <div class="usercontent ui-corner-all">

        <table cellpadding="0" cellspacing="15" border="0" style="text-align:left;width:100%">
        <tbody><tr>
        <td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">Exam Results Summary</h3></td>
        </tr>
        <tr><td colspan="2"><hr/></td></tr>
        <tr><td>Name </td><td><?=$results['user'];?></td></tr>
        <tr><td>Exam </td><td><?=$results['examname'];?></td></tr>
        <tr><td>Time Spent</td><td><?=$results['duration'];?></td></tr>
        <tr><td>Max. Marks</td><td><?=$results['totalmarks'];?></td></tr>
        <tr><td>Marks Obtained</td><td><?=$results['marksobtained'];?></td></tr>
        <tr><td>Percentage</td><td>
        <?php
        if($results['passed'])
        {
                echo $results['percentage'].'% <span class="passed">Passed</span>';
        }
        else
        {
                 echo $results['percentage'].'% <span class="failed">Failed</span>';
        }
        ?>

        </td></tr>
        <tr><td colspan="2"><hr/></td></tr>
        <?php
        if(!empty($results['userquestions']))
        {?>
        <tr><td colspan="2"><h3 style="color:#0000cc;text-align:center;margin:0px">You finished the following questions</h3></td></tr><tr><td colspan="2"><hr/></td></tr>
        <table cellpadding="0" cellspacing="30" class="datatable">
        <tbody><tr><th>Q. No</th><th>Correct Answer</th><th>Your Answer</th><th>Status</th></tr>
        <?php
        $count = 1;
        foreach ($results['userquestions'] as $question) 
        {?>
        <tr>
			<td rowspan="2"><?=$count;?>.</td>
			<td colspan="3"><?=$question['question'];?></td>
		</tr>	
		<tr>
			<td><?=$question['correctanswer'];?></td>
			<td><?=$question['youranswer'];?></td>
			<td><?=$question['status'];?></td>
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

