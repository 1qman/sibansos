<?php require '../config.php';require '../layout.php';need('admin');
if($_SERVER['REQUEST_METHOD']=='POST'){chk();
 if(isset($_POST['hapus'])){q("DELETE FROM warga WHERE id=?",[$_POST['hapus']]);flash('Data warga dihapus');}
 else{$p=$_POST;$d=[$p['nik'],$p['nama'],$p['alamat'],$p['rt_rw'],$p['no_hp'],$p['pekerjaan'],(int)$p['penghasilan']];
  try{if($p['id']){q("UPDATE warga SET nik=?,nama=?,alamat=?,rt_rw=?,no_hp=?,pekerjaan=?,penghasilan=? WHERE id=?",[...$d,$p['id']]);q("UPDATE users SET username=?,nama=? WHERE warga_id=?",[$p['nik'],$p['nama'],$p['id']]);}
  else{q("INSERT INTO warga(nik,nama,alamat,rt_rw,no_hp,pekerjaan,penghasilan) VALUES(?,?,?,?,?,?,?)",$d);q("INSERT INTO users(username,password,role,nama,warga_id) VALUES(?,?,'warga',?,?)",[$p['nik'],password_hash('warga123',PASSWORD_DEFAULT),$p['nama'],$pdo->lastInsertId()]);}
  flash('Data tersimpan. Kata sandi awal warga: warga123');}catch(PDOException $x){flash('Gagal menyimpan: NIK sudah terdaftar.','danger');}}
 header('Location: warga.php');exit;}
$ed=isset($_GET['edit'])?q("SELECT * FROM warga WHERE id=?",[$_GET['edit']])->fetch():null;$ed=$ed?:array_fill_keys(['id','nik','nama','alamat','rt_rw','no_hp','pekerjaan','penghasilan'],'');
$cari='%'.($_GET['q']??'').'%';
top('Data Warga');?>
<div class="card p-3 mb-3"><h2 class="h6 fw-bold"><?=$ed['id']?'Ubah':'Tambah'?> Warga</h2><form method="post" class="row g-2"><?=csrf()?><input type="hidden" name="id" value="<?=e($ed['id'])?>">
<div class="col-md-4"><input name="nik" class="form-control" placeholder="NIK (16 digit)" pattern="\d{16}" required value="<?=e($ed['nik'])?>"></div>
<div class="col-md-4"><input name="nama" class="form-control" placeholder="Nama lengkap" required value="<?=e($ed['nama'])?>"></div>
<div class="col-md-4"><input name="no_hp" class="form-control" placeholder="No. HP" value="<?=e($ed['no_hp'])?>"></div>
<div class="col-md-5"><input name="alamat" class="form-control" placeholder="Alamat" value="<?=e($ed['alamat'])?>"></div>
<div class="col-md-2"><input name="rt_rw" class="form-control" placeholder="RT/RW" value="<?=e($ed['rt_rw'])?>"></div>
<div class="col-md-3"><input name="pekerjaan" class="form-control" placeholder="Pekerjaan" value="<?=e($ed['pekerjaan'])?>"></div>
<div class="col-md-2"><input type="number" name="penghasilan" class="form-control" placeholder="Penghasilan" value="<?=e($ed['penghasilan'])?>"></div>
<div class="col-12"><button class="btn btn-lime">Simpan</button> <?php if($ed['id']):?><a href="warga.php" class="btn btn-light">Batal</a><?php endif?></div></form></div>
<div class="card p-3"><form class="mb-2"><input name="q" class="form-control" placeholder="Cari nama atau NIK…" value="<?=e($_GET['q']??'')?>"></form>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>NIK</th><th>Nama</th><th>Alamat</th><th>Pekerjaan</th><th>Penghasilan</th><th></th></tr></thead><tbody>
<?php foreach(q("SELECT * FROM warga WHERE nama LIKE ? OR nik LIKE ? ORDER BY nama",[$cari,$cari]) as $w):?>
<tr><td><?=e($w['nik'])?></td><td><?=e($w['nama'])?></td><td><?=e($w['alamat'].' RT/RW '.$w['rt_rw'])?></td><td><?=e($w['pekerjaan'])?></td><td><?=rp($w['penghasilan'])?></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-success" href="?edit=<?=$w['id']?>">Ubah</a>
<form method="post" class="d-inline" onsubmit="return confirm('Hapus warga ini beserta pengajuannya?')"><?=csrf()?><button name="hapus" value="<?=$w['id']?>" class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach?></tbody></table></div></div>
<?php bottom();
