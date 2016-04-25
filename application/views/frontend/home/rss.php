<?php header('Content-type: text/xml');?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
 <title><?php echo $title; ?></title>
 <description><?php echo $description; ?></description>
 <link><?php echo $link; ?></link>
 
 <?php foreach($item->result_array() as $row) { ?>
 <item>
  <title><?php echo str_replace('&', '&#x26;', $row['job_name']); ?></title>
  <description>
	  <![CDATA[
	  <?php 
		echo str_replace('&', '&#x26;', $row['company_name']).'<br>'; 
		echo lang('career_level').' : '.str_replace('&', '&#x26;', $row['category_name']).'<br>'; 
		//echo lang('education').' : '.str_replace('&', '&#x26;', $row['grade_name']).'<br>'; 
		echo lang('industry').' : '.str_replace('&', '&#x26;', $row['industry_name']).'<br>'; 
		echo lang('location').' : '.str_replace('&', '&#x26;', $row['city_name']).'<br>'; 
		//echo lang('employment_term').' : '.str_replace('&', '&#x26;', $row['term_name']).'<br>'; 
		echo lang('expire_date').' : '.$this->dokumen_lib->simple($row['job_due_date']); 
	  ?>]]>
  </description>
  <link><?php echo $link.'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?></link>
  <guid><?php echo $link.'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?></guid>
  <pubDate><?php echo date('r',strtotime($row['job_post_date'])); ?></pubDate>
 </item>
 <?php } ?>	
 
</channel>
</rss>
