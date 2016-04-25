<div data-role="content" class="ui-body">
<?php
			if($berita->num_rows() > 0){
				if ($berita->num_rows() > 0) {
					foreach ($berita->result() as $rowss) {
						echo "<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"> 
									<li data-role=\"list-divider\">".$rowss->subject."</li>
							 </ul>
							 ".$rowss->contents;
						}
					}
			} else {
				echo "<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"> 
									<li data-role=\"list-divider\">Perhatian</li> 
									<li>Maaf untuk sementara belum ada informasi yang tersedia</li> 
									<li data-role=\"list-divider\"></li>
					  </ul>";
			}
		?>
</div>
