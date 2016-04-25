<div id='title-bar'>
			<ul id='breadcrumbs'>
				<li><a href="<?php echo base_url() . 'users'; ?>" title='<? echo $modul; ?>'><span id='bc-home'></span></a></li>
				<li><a href="#"> <? echo $modul; ?></a></li>
                                <li><? echo $title; ?></li>
			</ul>
		</div>
		<div class="shadow-bottom shadow-titlebar">
		</div>
<div id='main-content'>
    <div class='container_12'>
        <div class='grid_12'>
            <h1><? echo $modul; ?></h1>
        </div>
        <div class='grid_12'>
            <div class='block-border'>
                <div class='block-header'>
                    <h1><? echo $title; ?></h1>
                    <span></span>
                </div>
                <form id='validate-form' class="block-content form" action="<?php echo base_url() . $act; ?>" method='post'>
                    <div class='_100'>
                        <p>
                            <label for='username'>Username</label><? echo $this->session->userdata("username"); ?>
                        </p>
                    </div>
                    <div class='_100'>
                        <p>
                            <label for='nama'>Nama</label><? echo $this->session->userdata("nama"); ?>
                        </p>
                    </div>
                    <div class='_100'>
					
                        <p>
                            <label for='email'>Email</label>
							<input id='email' name='email' class='required' type='text' value="<?php echo set_value('mail', isset($mail) ? $mail : ''); ?>"/>
                        </p>
                    </div>
					
					<div class='_100'>
					
                        <p>
                            <label for='ismailing'>Langganan Email (disposisi dan forward)</label>
							<select name="ismailing">                
											<option value="0" <?php echo set_value('mailing', isset($mailing) && $mailing == 0 ? 'selected' : ''); ?> >Tidak Aktif</option>
											<option value="1" <?php echo set_value('mailing', isset($mailing) && $mailing == 1 ? 'selected' : ''); ?> >Aktif</option>
                            </select>
					    </p>
                    </div>
                    
                    <div class='clear'>
                    </div>
                    <div class='block-actions'>
                        <ul class='actions-left'>
                            <li><input type='submit' name="submit" class='button' value="Submit"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
