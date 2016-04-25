<link href="<?php echo base_url(); ?>assets/jqueryMobile/css/themes/default/mobiscroll-2.0.custom.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/jqueryMobile/js/mobiscroll-2.0.custom.min.js" type="text/javascript"></script>

<script>
	
$(function(){
    $('#tgl_lhr').scroller({
        preset: 'date',
        theme: 'jqm',
        display: 'modal',
        mode: 'scroller',
        dateOrder: 'yymmdd',
        dateFormat: 'yy-mm-dd'
    });
});
    
/*
    Masked Input plugin for jQuery
    Copyright (c) 2007-@Year Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: @version
*/
(function($) {
    var pasteEventName = ($.browser.msie ? 'paste' : 'input') + ".mask";
    var iPhone = (window.orientation != undefined);

    $.mask = {
        //Predefined character definitions
        definitions: {
            '9': "[0-9]",
            'a': "[A-Za-z]",
            '*': "[A-Za-z0-9]"
        },
        dataName:"rawMaskFn"
    };

    $.fn.extend({
        //Helper Function for Caret positioning
        caret: function(begin, end) {
            if (this.length == 0) return;
            if (typeof begin == 'number') {
                end = (typeof end == 'number') ? end : begin;
                return this.each(function() {
                    if (this.setSelectionRange) {
                        this.setSelectionRange(begin, end);
                    } else if (this.createTextRange) {
                        var range = this.createTextRange();
                        range.collapse(true);
                        range.moveEnd('character', end);
                        range.moveStart('character', begin);
                        range.select();
                    }
                });
            } else {
                if (this[0].setSelectionRange) {
                    begin = this[0].selectionStart;
                    end = this[0].selectionEnd;
                } else if (document.selection && document.selection.createRange) {
                    var range = document.selection.createRange();
                    begin = 0 - range.duplicate().moveStart('character', -100000);
                    end = begin + range.text.length;
                }
                return { begin: begin, end: end };
            }
        },
        unmask: function() { return this.trigger("unmask"); },
        mask: function(mask, settings) {
            if (!mask && this.length > 0) {
                var input = $(this[0]);
                return input.data($.mask.dataName)();
            }
            settings = $.extend({
                placeholder: "_",
                completed: null
            }, settings);

            var defs = $.mask.definitions;
            var tests = [];
            var partialPosition = mask.length;
            var firstNonMaskPos = null;
            var len = mask.length;

            $.each(mask.split(""), function(i, c) {
                if (c == '?') {
                    len--;
                    partialPosition = i;
                } else if (defs[c]) {
                    tests.push(new RegExp(defs[c]));
                    if(firstNonMaskPos==null)
                        firstNonMaskPos =  tests.length - 1;
                } else {
                    tests.push(null);
                }
            });

            return this.trigger("unmask").each(function() {
                var input = $(this);
                var buffer = $.map(mask.split(""), function(c, i) { if (c != '?') return defs[c] ? settings.placeholder : c });
                var focusText = input.val();

                function seekNext(pos) {
                    while (++pos <= len && !tests[pos]);
                    return pos;
                };
                function seekPrev(pos) {
                    while (--pos >= 0 && !tests[pos]);
                    return pos;
                };

                function shiftL(begin,end) {
                    if(begin<0)
                       return;
                    for (var i = begin,j = seekNext(end); i < len; i++) {
                        if (tests[i]) {
                            if (j < len && tests[i].test(buffer[j])) {
                                buffer[i] = buffer[j];
                                buffer[j] = settings.placeholder;
                            } else
                                break;
                            j = seekNext(j);
                        }
                    }
                    writeBuffer();
                    input.caret(Math.max(firstNonMaskPos, begin));
                };

                function shiftR(pos) {
                    for (var i = pos, c = settings.placeholder; i < len; i++) {
                        if (tests[i]) {
                            var j = seekNext(i);
                            var t = buffer[i];
                            buffer[i] = c;
                            if (j < len && tests[j].test(t))
                                c = t;
                            else
                                break;
                        }
                    }
                };

                function keydownEvent(e) {
                    var k=e.which;

                    //backspace, delete, and escape get special treatment
                    if(k == 8 || k == 46 || (iPhone && k == 127)){
                        var pos = input.caret(),
                            begin = pos.begin,
                            end = pos.end;
                        
                        if(end-begin==0){
                            begin=k!=46?seekPrev(begin):(end=seekNext(begin-1));
                            end=k==46?seekNext(end):end;
                        }
                        clearBuffer(begin, end);
                        shiftL(begin,end-1);

                        return false;
                    } else if (k == 27) {//escape
                        input.val(focusText);
                        input.caret(0, checkVal());
                        return false;
                    }
                };

                function keypressEvent(e) {
                    var k = e.which,
                        pos = input.caret();
                    if (e.ctrlKey || e.altKey || e.metaKey || k<32) {//Ignore
                        return true;
                    } else if (k) {
                        if(pos.end-pos.begin!=0){
                            clearBuffer(pos.begin, pos.end);
                            shiftL(pos.begin, pos.end-1);
                        }

                        var p = seekNext(pos.begin - 1);
                        if (p < len) {
                            var c = String.fromCharCode(k);
                            if (tests[p].test(c)) {
                                shiftR(p);
                                buffer[p] = c;
                                writeBuffer();
                                var next = seekNext(p);
                                input.caret(next);
                                if (settings.completed && next >= len)
                                    settings.completed.call(input);
                            }
                        }
                        return false;
                    }
                };

                function clearBuffer(start, end) {
                    for (var i = start; i < end && i < len; i++) {
                        if (tests[i])
                            buffer[i] = settings.placeholder;
                    }
                };

                function writeBuffer() { return input.val(buffer.join('')).val(); };

                function checkVal(allow) {
                    //try to place characters where they belong
                    var test = input.val();
                    var lastMatch = -1;
                    for (var i = 0, pos = 0; i < len; i++) {
                        if (tests[i]) {
                            buffer[i] = settings.placeholder;
                            while (pos++ < test.length) {
                                var c = test.charAt(pos - 1);
                                if (tests[i].test(c)) {
                                    buffer[i] = c;
                                    lastMatch = i;
                                    break;
                                }
                            }
                            if (pos > test.length)
                                break;
                        } else if (buffer[i] == test.charAt(pos) && i!=partialPosition) {
                            pos++;
                            lastMatch = i;
                        }
                    }
                    if (!allow && lastMatch + 1 < partialPosition) {
                        input.val("");
                        clearBuffer(0, len);
                    } else if (allow || lastMatch + 1 >= partialPosition) {
                        writeBuffer();
                        if (!allow) input.val(input.val().substring(0, lastMatch + 1));
                    }
                    return (partialPosition ? i : firstNonMaskPos);
                };

                input.data($.mask.dataName,function(){
                    return $.map(buffer, function(c, i) {
                        return tests[i]&&c!=settings.placeholder ? c : null;
                    }).join('');
                })

                if (!input.attr("readonly"))
                    input
                    .one("unmask", function() {
                        input
                            .unbind(".mask")
                            .removeData($.mask.dataName);
                    })
                    .bind("focus.mask", function() {
                        focusText = input.val();
                        var pos = checkVal();
                        writeBuffer();
                        var moveCaret=function(){
                            if (pos == mask.length)
                                input.caret(0, pos);
                            else
                                input.caret(pos);
                        };
                        ($.browser.msie ? moveCaret:function(){setTimeout(moveCaret,0)})();
                    })
                    .bind("blur.mask", function() {
                        checkVal();
                        if (input.val() != focusText)
                            input.change();
                    })
                    .bind("keydown.mask", keydownEvent)
                    .bind("keypress.mask", keypressEvent)
                    .bind(pasteEventName, function() {
                        setTimeout(function() { input.caret(checkVal(true)); }, 0);
                    });

                checkVal(); //Perform initial check for existing values
            });
        }
    });
})(jQuery);



// Begin code...
$(function() {
    $('#nilai').mask('9.99');
});

function cekFile() {
	var resume = $('#resume')[0].files[0].size;
	var ijazah = $('#ijazah')[0].files[0].size;
	var transkrip = $('#transkrip')[0].files[0].size;
	if (resume > 600000)
	{
		alert('File Resume Terlalu Besar! Ukuran Resume Anda = '+resume+' Max Size = 500 Kb!');
		return false;
	} else if (ijazah > 600000)
	{
		alert('File Ijazah Terlalu Besar! Ukuran Ijazah Anda = '+ijazah+' Max Size = 500 Kb!');
		return false;
	} else if (transkrip > 600000)
	{
		alert('File Transkrip Terlalu Besar! Ukuran Transkrip Anda = '+transkrip+' Max Size = 500 Kb!');
		return false;
	} else if ($('#resume').val().lastIndexOf(".xlsx")==-1)
	{
		alert("Upload resume hanya .xlsx extention file");
		return false;
	} else if ($('#ijazah').val().lastIndexOf(".pdf")==-1 || $('#transkrip').val().lastIndexOf(".pdf")==-1)
	{
		alert("Upload ijazah dan transkrip hanya .pdf extention file");
		return false;
	} else {
		return true;
	};
};

</script>

<div data-role="content">
   <p>Selamat datang di situs rekrutmen PT Brantas Abipraya<span>Kami mengundang putra putri terbaik bangsa Indonesia untuk bergabung</span></p>

<?php
			if($sql->num_rows() > 0 && isset($jobs_id)){
				?> <p>Anda melamar posisi <?php echo $jobs_name; ?></p>
					<p>Silahkan isi form dibawah ini dengan lengkap</p><br>
					<form action="<?php echo base_url(); ?>form/submit" id="register_form" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="form" data-ajax="false">
					<input type="hidden" name="jobs" value="<?php echo $jobs_id; ?>" />
						
						<fieldset>
						<div data-role="fieldcontain">
						 <label for="nama">Nama Lengkap</label>
						 <input type="text" name="nama" value="" id="nama" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
							<label for="select-choice-1">Gender</label>
							<select name="gender" id="select-choice-1">
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
						</div>
						
						<div data-role="fieldcontain">
							<label for="select-choice-2">Agama</label>
							<select name="agama" id="select-choice-2">
								<option value="Islam">Islam</option>
								<option value="Kristen Katolik">Kristen Katolik</option>
								<option value="Kristen Protestan">Kristen Protestan</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Budha</option>
							</select>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="email">Email</label>
						 <input type="text" name="email" value="" id="email" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="tmp_lhr">Tempat Lahir</label>
						 <input type="text" name="tmp_lhr" value="" id="tmp_lhr" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="tgl_lhr">Tanggal Lahir</label>
						 <input type="text" name="tgl_lhr" value="" id="tgl_lhr" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="alamat">Alamat</label>
						 <textarea cols="55" rows="10" name="alamat" id="alamat"></textarea>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="tlp_sel">Telp. Selular</label>
						 <input type="text" name="tlp_sel" value="" id="tlp_sel" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="kota">Kota</label>
						 <input type="text" name="kota" value="" id="kota" title="isi tidak boleh kosong"  />
						</div>
						</fieldset>
						
						<fieldset>
						<div data-role="fieldcontain">
						 <label for="universitas">Universitas</label>
						 <input type="text" name="universitas" value="" id="universitas" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
							<label for="select-choice-3">Pendidikan Terakhir</label>
							<select name="pendidikan" id="select-choice-3">
								<option value="S2">S2</option>
								<option value="S1">S1</option>
								<option value="D3">D3</option>
							</select>
						</div>
						
						<div data-role="fieldcontain">
							<label for="select-choice-4">Jurusan</label>
							<select name="jurusan" id="select-choice-4">
								<?
									if ($jurusan->num_rows() > 0) {
										foreach ($jurusan->result() as $rows) {
												?>
												<option value="<? echo $rows->jurusan; ?>"><? echo $rows->jurusan; ?></option>
												<?php
											}
										}
									?>
							</select>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nilai">Nilai / IPK</label>
						 <input type="text" name="nilai" value="" id="nilai" title="isi tidak boleh kosong"  />
						</div>
						</fieldset>
						
						<fieldset>
						<div data-role="fieldcontain">
						 <label for="resume">Resume (.xls) Max. 500kb <a href="<?php echo base_url(); ?>form_daftar_pegawai_new.xlsx">Download untuk diisi kemudian upload </a></label>
						 <input type="file" name="resume" value="" id="resume" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="ijazah">Ijazah (.pdf) Max. 500kb</label>
						 <input type="file" name="ijazah" value="" id="ijazah" title="isi tidak boleh kosong"  />
						</div>
						
						<div data-role="fieldcontain">
						 <label for="transkrip">Transkip Nilai (.pdf) Max. 500kb</label>
						 <input type="file" name="transkrip" value="" id="transkrip" title="isi tidak boleh kosong"  />
						</div>
						</fieldset>
						
						<div class="ui-body ui-body-b">
						<fieldset class="ui-grid-a">
								<div class="ui-block-a"><input type="reset" name="batal" value="Batal"/></div>
								<div class="ui-block-b"><input type="Submit" name="simpan" value="Daftar" onclick="return check_extension();"/></div>
						</fieldset>
						</div>
					
						<fieldset>
										<?php 
						if(! empty($error)) {
							echo "<div>";
							echo $error;
							echo "<div>";
						}
						else {
							echo "";
						}
						?>
						<p>Catatan: Semua field wajib diisi</p>
						</fieldset>
					 </form>
			<? } else {
				echo "<h1>Maaf untuk sementara belum ada lowongan pekerjaan yang tersedia</h1>";
			}
		?>
</div>
<script>

function check_extension() {

	if((document.form.resume.value.lastIndexOf(".xlsx")==-1)) {
		alert("Please upload only .xlsx extention file");
		return false;
	}
	else if((document.form.ijazah.value.lastIndexOf(".pdf")==-1)) {
		alert("Please upload only .pdf extention file");
		return false;
	}
	else if((document.form.transkrip.value.lastIndexOf(".pdf")==-1)) {
		alert("Please upload only .pdf extention file");
		return false;
	}
	else {
		return true;
	}
  
}
</script>
