<script>
	jQuery(document).ready(function() {
			 Jobs();
             Appl();
             Lolos();
	});			
				var auto_refresh = setInterval(
				function ()
				{
						Jobs();
						Appl();
						Lolos();
				}, 10000);
				
				
		function Jobs()
                {
                $.ajax({

                url: '<?php echo base_url();?>/home/sumjobs',
                success: function(data) {
                                $('#badge_1 ').html(data);
								if(data==0)
								{
								$('#badge_1 ').hide();
								}
								else
								{
								$('#badge_1 ').show();
								}
                }
                });


                }


                function Appl()
                {
                $.ajax({

                url: '<?php echo base_url();?>/home/sumappl',
                success: function(data) {
                                $('#badge_2').html(data);
								
								if(data==0)
								{
								$('#badge_2 ').hide();
								}
								else
								{
								$('#badge_2 ').show();
								}
							 
                }
                });


                }
                
                function Lolos()
                {
                $.ajax({

                url: '<?php echo base_url();?>/home/sumlolos',
                success: function(data) {
                                $('#badge_3 ').html(data);
								if(data==0)
								{
								$('#badge_3 ').hide();
								}
								else
								{
								$('#badge_3 ').show();
								}
                }
                });


                }
                </script>
<div data-role="content" class="ui-body">
   <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b"> 
			<li data-role="list-divider">Selamat Datang di Brantas Karir Center</li> 
			<li>Bila anda ingin mengetahui lebih banyak tentang Brantas Abipraya, memiliki perhatian yang tinggi terhadap kualitas sumber daya manusia.
			Di samping itu, penghargaan yang tinggi juga diberikan oleh perusahaan kepada setiap individu yang mampu menghadapi tantangan dan berprestasi
			dalam bidang masing-masing. Oleh karena itu, kami mengundang Anda yang memiliki kemampuan lebih untuk bergabung bersama kami.
			</li> 
			<li data-role="list-divider"></li>
	</ul>
	<br>
	<ul data-role="listview" data-theme="b">
		<li data-icon="gear">
		<a href="<?php echo base_url().'home/jobs'; ?>"> 
		<h3>Lowongan Terbaru <span class="ui-li-count ui-btn-up-c ui-btn-corner-all" id="badge_1">&nbsp;</span></h3>
		</a>
		</li>
		<li data-icon="alert">
		<a href="<?php echo base_url() ?>home/petunjuk" data-inline="true" data-rel="dialog" data-transition="pop"> 
		<h3>Petunjuk</h3>
		</a>
		</li>
		<li data-icon="plus">
		<a href="<?php echo base_url() ?>home/apl" data-inline="true" data-rel="dialog" data-transition="pop"> 
		<h3>Kirim Lamaran</h3>
		</a>
		</li>
		<li data-icon="check">
		<a href="<?php echo base_url().'home/applicants'; ?>"> 
		<h3>Daftar Pelamar <span class="ui-li-count ui-btn-up-c ui-btn-corner-all" id="badge_2">&nbsp;</span></h3>
		</a>
		</li>
		<li data-icon="refresh">
		<a href="<?php echo base_url().'home/lolos'; ?>"> 
		<h3>Pelamar Lulus <span class="ui-li-count ui-btn-up-c ui-btn-corner-all" id="badge_3">&nbsp;</span></h3>
		</a>
		</li>
		<li data-icon="info">
		<a href="<?php echo base_url().'home/news'; ?>"> 
		<h3>Informasi</h3>
		</a>
		</li>
	</ul>
	<br>
	<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b"> 
			<li data-role="list-divider">Informasi Pengunjung</li> 
			<li>Browser : <?php echo $this->agent->browser().' '.$this->agent->version(); ?></li> 
			<li>Platform OS : <?php echo $this->agent->platform(); ?></li>
			<li><a href = "http://disposisi.brantas-abipraya.co.id/android/e-recruitment.apk">Download e-Recruitment For Android</a></li>
			<li data-role="list-divider"></li>
	</ul>
</div>
