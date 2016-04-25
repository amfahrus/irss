<table cellpadding="0" cellspacing="15" border="0" style="page-break-after: always;">
<tbody><tr>
<td colspan="2"><h3>Exam Results Summary</h3></td>
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
{
?>
<tr><td colspan="2"><h3>Exam Results Summary</h3></td></tr>
<tr><td colspan="2"><hr/></td></tr>
</tbody></table>

<table cellpadding="0" cellspacing="30" class="datatable">
<tbody>
	<tr>
		<th>Q. No</th>
		<th>Question</th>
	</tr>
<?php
$count = 1;
foreach ($results['userquestions'] as $question) 
{
?>
  <tr>
		<td><?=$count;?>.</td>
		<td><?=str_replace('<img src="../../','<img src="',$question['question']);?></td>
  </tr>
<?php
$count ++;
}
?>
</tbody></table>
<div style="page-break-before: always;"></div>
<table cellpadding="0" cellspacing="30" class="datatable">
<tbody>
	<tr>
		<th>Q. No</th>
		<th>Correct Answer</th>
		<th>Your Answer</th>
		<th>Status</th>
	</tr>
<?php
$count = 1;
foreach ($results['userquestions'] as $question) 
{
?>
  <tr>
		<td><?=$count;?>.</td>
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

