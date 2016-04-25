<div class="mainholder">
<div class="content ui-corner-all">
<table width="700px" class="dashboard">
<tbody><tr>
<td><a href="<?=base_url();?>administrator/exams"><img src="<?=base_url();?>assets/admin/images/editexams.png"></a><br/>Manage Exams</td>
<td><a href="<?=base_url();?>administrator/categories"><img src="<?=base_url();?>assets/admin/images/categories.png" ></a><br/>Manage Categories</td>
</tr>
<tr>
<td><a href="<?=base_url();?>administrator/results"><img src="<?=base_url();?>assets/admin/images/icon_reports.png" ></a><br/>View Results</td>
<td><a href="<?=base_url();?>administrator/createexam"><img src="<?=base_url();?>assets/admin/images/new_exam.png"></a><br/>Create Exam</td>
</tr>
</tbody></table>
</div>
<div class="sidebarmenu">
<?php $this->load->view('admin/sidebarmenu');?>
</div>
</div>
