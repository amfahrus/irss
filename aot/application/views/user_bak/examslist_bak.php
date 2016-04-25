<div class="mainholder ">
	<h1 style="color:#06F;">Search Exams</h1>
	

	    <form id="live-search" action="" class="styled" method="post">
        <input type="text" class="text-input ui-corner-all" id="filter" placeholder="Search for an exam try typing PHP or HTML" />
        <span id="filter-count"></span>
        </form>

        <?php
		foreach ($examlist as $index => $category) 
		{
		if(count($category['exams']) > 0)
		{ 
		?>
		<div class="examlist_wrapper ui-corner-all">
    	<div class="submenu"><p class="category"><?=ucfirst($category['catname']);?></p></div>
    	<ul class="examlist">
    	<?php
    	foreach ($category['exams'] as $count => $exam) 
    	{
            ?>
    		<li>
    			<div class="examimg" ><img src="<?=base_url();?>assets/images/exam_thumb.jpg"></div>
    			<div class="examname" ><?=$exam['examname'];?></div> 
				<div class="examtake" >
                <?php
                /*if(isset($exam['passed']) && $exam['passed']=='Failed')
                {
					echo '<a class="ui-corner-all ui-state-default bttn-takeexam" href="javascript:void(0);">';
                    echo 'Failed';
                }
                else*/ 
				if(!isset($exam['passed']))
                {
					echo '<a class="ui-corner-all ui-state-active bttn-takeexam" href="'.base_url().'users/takeexam/'.$exam['examid'].'">';
                    echo 'Take Exam';
                }?>


                </a>
                <?php
                if(isset($exam['percentage']) && isset($exam['passed']))
                {?>
                <a <?=$exam['passed']=='Passed' ? 'class="ui-corner-all ui-state-active bttn-takeexam"': 'class="ui-corner-all ui-state-active bttn-takeexam"'; ?> href="javascript:void(0);" style="margin-left:<?=$exam['passed']=='Passed' ? '5px' : '30px';?>">Finish</a>
                <?
                }

                ?>

                </div>
    			</li>
    	<?php
    	}
    	?>
		</ul>
        </div>
		<?php
		}	
		}
        ?>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $("#filter").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the comment list
        $(".examlist li").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
 
        // Update the count
        var numberItems = count;
        //$("#filter-count").text("Number of Comments = "+count);
    });
});
</script>
