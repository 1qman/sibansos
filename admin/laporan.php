<?php require '../config.php';require '../layout.php';need('admin');
$d1=$_GET['dari']??date('Y-01-01');$d2=$_GET['sampai']??date('Y-m-d');$st=$_GET['status']??'';
$rows=q("SELECT p.*,w.nama,w.nik,j.kode,s.status ss,s.nominal FROM pengajuan p JOIN warga w ON w.id=p.warga_id JOIN jenis_bantuan j ON j.id=p.jenis_id LEFT JOIN penyaluran s ON s.pengajuan_id=p.id WHERE p.tanggal BETWEEN ? AND ?".($st?" AND p.status=?":"")." ORDER BY p.tanggal",$st?[$d1,$d2,$st]:[$d1,$d2])->fetchAll();
top('Laporan');?>
<form class="card p-3 mb-3 no-print row g-2 flex-row"><div class="col-6 col-md-3"><input type="date" name="dari" class="form-control" value="<?=e($d1)?>"></div><div class="col-6 col-md-3"><input type="date" name="sampai" class="form-control" value="<?=e($d2)?>"></div>
<div class="col-6 col-md-3"><select name="status" class="form-select"><option value="">Semua status</option><?php foreach(['Menunggu','Disetujui','Ditolak'] as $s):?><option <?=$st==$s?'selected':''?>><?=$s?></option><?php endforeach?></select></div>
<div class="col-6 col-md-3"><button class="btn btn-g">Tampilkan</button> <button type="button" class="btn btn-lime" onclick="print()">Cetak</button></div></form>
<div class="card p-3"><h2 class="h5 text-center mb-0">Laporan Bantuan Sosial</h2><p class="text-center text-muted">Pemerintah Desa Suka Maju · <?=tgl($d1)?> s/d <?=tgl($d2)?></p>
<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>No</th><th>Tanggal</th><th>Nama</th><th>NIK</th><th>Bantuan</th><th>Status</th><th>Penyaluran</th><th>Nominal</th></tr></thead><tbody>
<?php $tot=0;foreach($rows as $i=>$r):if($r['ss']=='Tersalurkan')$tot+=$r['nominal'];?><tr><td><?=$i+1?></td><td><?=tgl($r['tanggal'])?></td><td><?=e($r['nama'])?></td><td><?=e($r['nik'])?></td><td><?=e($r['kode'])?></td><td><?=e($r['status'])?></td><td><?=e($r['ss']??'-')?></td><td><?=$r['nominal']?rp($r['nominal']):'-'?></td></tr><?php endforeach?></tbody>
<tfoot><tr><th colspan="7" class="text-end">Total tersalurkan</th><th><?=rp($tot)?></th></tr></tfoot></table></div></div>
<?php bottom();
