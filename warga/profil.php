<?php require '../config.php';require '../layout.php';need('warga');
$w=q("SELECT * FROM warga WHERE id=?",[$_SESSION['u']['warga_id']])->fetch();
if($_SERVER['REQUEST_METHOD']=='POST'){chk();
 if(strlen($_POST['baru'])<6)flash('Kata sandi baru minimal 6 karakter.','danger');
 elseif(!password_verify($_POST['lama'],q("SELECT password FROM users WHERE id=?",[$_SESSION['u']['id']])->fetch()['password']))flash('Kata sandi lama salah.','danger');
 else{q("UPDATE users SET password=? WHERE id=?",[password_hash($_POST['baru'],PASSWORD_DEFAULT),$_SESSION['u']['id']]);flash('Kata sandi diganti.');}
 header('Location: profil.php');exit;}
top('Profil');?>
<div class="row g-3"><div class="col-lg-6"><div class="card p-3"><h2 class="h6 fw-bold">Profil Saya</h2><dl class="row mb-0">
<?php foreach(['NIK'=>'nik','Nama'=>'nama','Alamat'=>'alamat','RT/RW'=>'rt_rw','No. HP'=>'no_hp','Pekerjaan'=>'pekerjaan'] as $l=>$k):?><dt class="col-4"><?=$l?></dt><dd class="col-8"><?=e($w[$k])?></dd><?php endforeach?>
<dt class="col-4">Penghasilan</dt><dd class="col-8"><?=rp($w['penghasilan'])?></dd></dl></div></div>
<div class="col-lg-6"><div class="card p-3"><h2 class="h6 fw-bold">Ganti Kata Sandi</h2><form method="post"><?=csrf()?>
<input type="password" name="lama" class="form-control mb-2" placeholder="Kata sandi lama" required><input type="password" name="baru" class="form-control mb-2" placeholder="Kata sandi baru" required><button class="btn btn-g">Simpan</button></form></div></div></div>
<?php bottom();
