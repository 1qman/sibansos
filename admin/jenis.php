<?php require '../config.php';require '../layout.php';need('admin');
if($_SERVER['REQUEST_METHOD']=='POST'){chk();$p=$_POST;
 if(isset($p['hapus'])){try{q("DELETE FROM jenis_bantuan WHERE id=?",[$p['hapus']]);flash('Jenis bantuan dihapus');}catch(PDOException $x){flash('Tidak bisa dihapus: sudah dipakai pengajuan.','danger');}}
 elseif($p['id']){q("UPDATE jenis_bantuan SET kode=?,nama=?,deskripsi=?,nominal=? WHERE id=?",[$p['kode'],$p['nama'],$p['deskripsi'],(int)$p['nominal'],$p['id']]);flash('Data diperbarui');}
 else{q("INSERT INTO jenis_bantuan(kode,nama,deskripsi,nominal) VALUES(?,?,?,?)",[$p['kode'],$p['nama'],$p['deskripsi'],(int)$p['nominal']]);flash('Jenis bantuan ditambahkan');}
 header('Location: jenis.php');exit;}
$ed=isset($_GET['edit'])?q("SELECT * FROM jenis_bantuan WHERE id=?",[$_GET['edit']])->fetch():null;$ed=$ed?:array_fill_keys(['id','kode','nama','deskripsi','nominal'],'');
top('Jenis Bantuan');?>
<div class="card p-3 mb-3"><h2 class="h6 fw-bold"><?=$ed['id']?'Ubah':'Tambah'?> Jenis Bantuan</h2><form method="post" class="row g-2"><?=csrf()?><input type="hidden" name="id" value="<?=e($ed['id'])?>">
<div class="col-4 col-md-2"><input name="kode" class="form-control" placeholder="Kode" required value="<?=e($ed['kode'])?>"></div>
<div class="col-8 col-md-4"><input name="nama" class="form-control" placeholder="Nama bantuan" required value="<?=e($ed['nama'])?>"></div>
<div class="col-md-4"><input name="deskripsi" class="form-control" placeholder="Deskripsi" value="<?=e($ed['deskripsi'])?>"></div>
<div class="col-md-2"><input type="number" name="nominal" class="form-control" placeholder="Nominal" value="<?=e($ed['nominal'])?>"></div>
<div class="col-12"><button class="btn btn-lime">Simpan</button></div></form></div>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Kode</th><th>Nama</th><th>Deskripsi</th><th>Nominal</th><th></th></tr></thead><tbody>
<?php foreach(q("SELECT * FROM jenis_bantuan") as $j):?><tr><td><b><?=e($j['kode'])?></b></td><td><?=e($j['nama'])?></td><td><?=e($j['deskripsi'])?></td><td><?=rp($j['nominal'])?></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-success" href="?edit=<?=$j['id']?>">Ubah</a>
<form method="post" class="d-inline" onsubmit="return confirm('Hapus jenis bantuan ini?')"><?=csrf()?><button name="hapus" value="<?=$j['id']?>" class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach?></tbody></table></div></div>
<?php bottom();
