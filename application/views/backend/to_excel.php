
                        <thead>
                           <tr>
                                 <th>
                                    Disposisi
                                </th>
                                <th>
                                    Baca
                                </th>
                                <th>
                                    Tanggal-Nomor
                                </th>
                                <th>
                                    Subyek Surat
                                </th>
                                <th>
                                    Intern-Extern
                                </th>
                                <th>
                                     Pengirim / Tujuan
                                </th>
                                <!--<th width="10%">
                                    Dokumen
                                </th>-->
                                <th>
                                    Tipe
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            if ($sql->num_rows() > 0) {
                                foreach ($sql->result() as $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <? echo $row->status_disp == 1 ? '<center>Sudah</center>' : '<center>Belum</center>'; ?>
                                        </td>
                                        <td>
                                            <? echo $row->baca > 0 ? '<center>Sudah</center>' : '<center>Belum</center>'; ?>
                                        </td>
                                        <td>
                                            <? echo $this->dokumen_lib->convert2($row->tgl_surat) . "<br/>" . $row->no_surat; ?>
                                        </td>
                                        <td>
                                            <? echo "<strong>" . $row->subjek . "</strong>"; ?>
                                        </td>
                                        <td>
                                            <? echo $row->intern == 1 ? 'Intern' : 'Extern'; ?>
                                        </td>
                                        <td>
                                            <? echo $row->arah_surat == 1 ? $row->penerima : $row->pengirim; ?>
                                        </td>
                                        <td>
                                            <? echo $row->jenisdokumen . " - " . $row->kategori; ?>
                                        </td>
                                        <!--<td class='center'>
                                            <? echo $row->jenis; ?>
                                        </td>-->
                                    </tr>
                                    <?
                                }
                            }
                            ?>
                        </tbody>
                    
