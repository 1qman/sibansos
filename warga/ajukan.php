<?php require '../config.php';require '../layout.php';need('warga');$wid=$_SESSION['u']['warga_id'];
if($_SERVER['REQUEST_METHOD']=='POST'){chk();$jid=(int)$_POST['jenis_id'];$fn=null;$err='';
 if(q("SELECT 1 FROM pengajuan WHERE warga_id=? AND jenis_id=? AND status IN('Menunggu','Disetujui')",[$wid,$jid])->fetch())$err='Anda sudah punya pengajuan aktif untuk bantuan ini.';
 elseif(!empty($_FILES['berkas']['name'])){$f=$_FILES['berkas'];$ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
  if($f['error']||!in_array($ext,['jpg','jpeg','png','pdf'])||$f['size']>2*1024*1024)$err='Berkas harus JPG, PNG, atau PDF, maksimal 2 MB.';
  else{$fn=bin2hex(random_bytes(8)).".$ext";move_uploaded_file($f['tmp_name'],"../uploads/$fn");}}
 if($err)flash($err,'danger');else{q("INSERT INTO pengajuan(warga_id,jenis_id,alasan,berkas,tanggal) VALUES(?,?,?,?,CURDATE())",[$wid,$jid,$_POST['alasan'],$fn]);flash('Pengajuan terkirim. Petugas akan memeriksa berkas Anda.');header('Location: riwayat.php');exit;}}
top('Ajukan Bantuan');?>
<div class="card p-3 p-lg-4" style="max-width:640px"><h2 class="h5 fw-bold">Ajukan Bantuan</h2><form method="post" enctype="multipart/form-data"><?=csrf()?>
<label class="form-label">Jenis bantuan</label><select name="jenis_id" class="form-select mb-3" required><?php foreach(q("SELECT * FROM jenis_bantuan") as $j):?><option value="<?=$j['id']?>"><?=e($j['kode'].' – '.$j['nama'].' ('.rp($j['nominal']).')')?></option><?php endforeach?></select>
<label class="form-label">Alasan pengajuan</label><textarea name="alasan" class="form-control mb-3" rows="3" required></textarea>
<label class="form-label">Berkas pendukung (KK/KTP/surat keterangan)</label><input type="file" name="berkas" class="form-control mb-1" accept=".jpg,.jpeg,.png,.pdf"><div class="form-text mb-3">JPG, PNG, atau PDF. Maksimal 2 MB.</div>
<button class="btn btn-lime">Kirim pengajuan</button></form></div>
<?php bottom();
