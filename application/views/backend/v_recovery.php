<body class='special-page'>
    <section id='login-box'>
        <div id='container'>
            <div class='block-border'>
                <div class='block-header'>
                    <h1>Revocery Password</h1>
                    <span></span>
                </div>



                <form id='validate-form' class="block-content form" action="<?php echo base_url(); ?>beranda/recovery_password" method='post'>

                    <?php
                    
                    $pesan_sukses = $this->session->flashdata('pesan_sukses');

                    if (!empty($pesan_sukses)) {

                        echo "<div class=\"alert success\"><strong>Success</strong>  " . $pesan_sukses . "</div>";
                    } 
                    ?>



                    <div class='_100'>
                        <p><label for='textfield'>Email</label><input id='email' name='email' class='required' type='text' value=""/></p>
                        <?= form_error('email','<div class="error">', '</div>'); ?>
                    </div>

                    <div class='clear'>
                    </div>
                    <div class='block-actions'>
                        <ul class='actions-left'>
                            <li><a class="button red" id='reset-validate-form' href="<?php echo base_url(); ?>beranda/">Kembali</a></li>
                        </ul>
                        <ul class='actions-right'>
                            <li><input type='submit' class='button' value="Kirim"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
