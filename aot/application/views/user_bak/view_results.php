<div class="mainholder ">

        <div class="usercontent ui-corner-all">
            <h1 style="color:#06F;">Exams Attempted</h1><br/>
            <br/>
        <table cellpadding="0" cellspacing="30" class="datatable">
        <tbody><tr><th></th><th>Exam name</th><th>Your Score</th><th>Exam Pass Mark</th><th>Completion status</th><th>Remarks</th><th>View Details</th></tr>
        <?php
        $count = 1;
        foreach ($exams_attempted as $exam) 
        {?>
          <tr>
                <td><?=$count;?>.</td>
                <td><?=$exam['examname'];?></td>
                <td style="text-align:center"><?=$exam['percentage'];?>%</td>
                <td style="text-align:center"><?=$exam['exampassmark'];?>%</td>
                <td style="text-align:center"><?=$exam['status'];?></td>
                <td>
                <?php
                if($exam['passed'])
                {
                        echo '<span class="passed">Passed</span>';
                }
                else
                {
                        echo '<span class="failed">Failed</span>';
                }
                ?>
                </td>
                <td style="text-align:center"><a href="<?=base_url();?>users/results_summary/<?=$exam['examid'];?>"><img src="<?=base_url();?>assets/images/view-icon.png"></a></td>
          </tr>
        <?php
        $count ++;
        }
        ?>

        </tbody></table>

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

