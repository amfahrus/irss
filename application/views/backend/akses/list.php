<div id='title-bar'>
			<ul id='breadcrumbs'>
				<li><a href="<?php echo $home; ?>" title='<? echo $modul; ?>'><span id='bc-home'></span></a></li>
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
            <p><a href="<?php echo base_url() . $link_add; ?>" class="button blue">Add Akses Menu</a></p>
        </div>
        <div class='grid_12'>
            <div class='block-border'>
                <div class='block-header'>
                    <h1><? echo $title; ?></h1>
                    <span></span>
                </div>
                <div class='block-content'>
                    <table id='table-example' class='table'>
                        <thead>
                            <tr>
                                <th>
                                    Group
                                </th>
                                <th>
                                    Menu
                                </th>
								<th>
                                    Akses
                                </th>
                                <th>
                                    Tools
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            if ($sql->num_rows() > 0) {
                                foreach ($sql->result() as $row) {
                                    ?>
                                    <tr class='gradeA'>
                                        <td class='center'>
                                            <? echo $row->role2name; ?>
                                        </td>
                                        <td class='center'>
                                            <? echo $row->label; ?>
                                        </td>
										<td class='center'>
                                            <center><? echo $row->enable == 1 ? '<img src="'.base_url().'assets/images/checkbox_checked.png" >' : '<img src="'.base_url().'assets/images/checkbox_unchecked.png" >'; ?></center>
                                        </td>
                                        <td class='center'>
                                            <a href="<?php echo base_url() . $link_edit . $row->id; ?>" class="button blue">Edit</a> <a href="<?php echo base_url() . $link_delete . $row->id; ?>" class="button red">Delete</a>
                                        </td>
                                    </tr>
                                    <?
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clear height-fix">
        </div>
    </div>
</div>
