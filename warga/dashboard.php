<?php require '../config.php';require '../layout.php';need('warga');$wid=$_SESSION['u']['warga_id'];
$n=fn($s)=>q("SELECT COUNT(*) c FROM pengajuan WHERE warga_id=?".($s?" AND status='$s'":""),[$wid])->fetch()['c'];
top('Beranda');hero('Halo, '.e($_SESSION['u']['nama']).'!','Ajukan bantuan sosial dan pantau statusnya di sini.','ajukan.php','Ajukan Bantuan');?>
<div class="row g-3 mb-4"><?php foreach([['s2','file-earmark-text-fill','primary','Pengajuan',$n('')],['s3','check-circle-fill','success','Disetujui',$n('Disetujui')],['s4','x-circle-fill','danger','Ditolak',$n('Ditolak')]] as $s):?>
<div class="col-4"><div class="stat <?=$s[0]?>"><div class="ic text-<?=$s[2]?> d-none d-sm-grid"><i class="bi bi-<?=$s[1]?>"></i></div><div><small><?=$s[3]?></small><b><?=$s[4]?></b></div></div></div><?php endforeach?></div>
<div class="card p-3"><h2 class="h6 fw-bold">Status Pengajuan Terbaru</h2>
<?php $r=q("SELECT p.*,j.nama jn FROM pengajuan p JOIN jenis_bantuan j ON j.id=p.jenis_id WHERE warga_id=? ORDER BY p.id DESC LIMIT 5",[$wid])->fetchAll();
foreach($r as $x):?><div class="d-flex justify-content-between border-bottom py-2"><div><b><?=e($x['jn'])?></b><small class="d-block text-muted"><?=tgl($x['tanggal'])?><?=$x['catatan']?' · '.e($x['catatan']):''?></small></div><div><?=badge($x['status'])?></div></div><?php endforeach?>
<?php if(!$r):?><p class="text-muted mb-0">Belum ada pengajuan. Tekan “Ajukan Bantuan” untuk memulai.</p><?php endif?></div>
<?php bottom();
