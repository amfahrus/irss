<div class="mainholder ">
<?php
if(isset($examdetails))
{
	foreach ($examdetails as $exam) 
	{?>
	<h1 style="color:#06F;"><?=$exam['examname'];?></h1>
	<div class="usercontent ui-corner-all">
		<ul class="examdata">
                <li><span class="file"></span><strong><?=$exam['questions'];?></strong> multiple choice answers</li>
                <li><span class="time"></span><strong><?=$exam['duration'];?></strong> minutes exam time</li>
                <li><span class="passmark"></span><strong><?=$exam['passmark'];?>%</strong> mark is needed to pass</li>
                <li style="border-bottom:none">
                <ol class="instructions">
 				<li>Attempt all the questions.</li>
 				<li>Do not use the browser back button while doing this test.</li>
 				<li>The timer of the exam will not stop once the exam starts.</li>
 				<li><strong>IMPORTANT!</strong> Remember to click the 'Finish Exam' link at the bottom of the page once you complete the whole exam. Clicking this link before you finish the whole exam will end your exam session.</li>
                </ol>
                </li>
                <li style="border-bottom:none"><a class="ui-corner-all ui-state-active bttn-takeexam" href="<?=base_url();?>users/exam/<?=$exam['examid'];?>"> Start Exam </a></li>
        </ul>

	</div>
	<?php
}
}
?>
</div>

