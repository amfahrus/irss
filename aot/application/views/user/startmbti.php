<div class="mainholder ">
<?php
if(isset($details))
{
	?>
	<h1 style="color:#06F;">MBTI</h1>
	<div class="usercontent ui-corner-all">
		<ul class="examdata">
                <li><span class="file"></span><strong><?=$details->num_rows();?></strong> multiple choice answers</li>
                <li><span class="time"></span><strong>45</strong> minutes exam time</li>
                <li style="border-bottom:none">
                <ol class="instructions">
 				<li>Attempt all the questions.</li>
 				<li>Do not use the browser back button while doing this test.</li>
 				<li><strong>IMPORTANT!</strong> Remember to click the 'Finish Exam' link at the bottom of the page once you complete the whole exam. Clicking this link before you finish the whole exam will end your exam session.</li>
                </ol>
                </li>
                <li style="border-bottom:none"><a class="ui-corner-all ui-state-active bttn-takeexam" href="<?=base_url();?>users/mbti"> Start Exam </a></li>
        </ul>

	</div>
	<?php
}
?>
</div>

