<?php require '../config.php';require '../layout.php';need('admin');
$c=fn($w='')=>q("SELECT COUNT(*) c FROM pengajuan $w")->fetch()['c'];
$tw=q("SELECT COUNT(*) c FROM warga")->fetch()['c'];
$th=date('Y');$a=array_fill(1,12,0);$b=$a;
foreach(q("SELECT MONTH(tanggal) m,COUNT(*) n,SUM(status='Disetujui') s FROM pengajuan WHERE YEAR(tanggal)=? GROUP BY m",[$th]) as $r){$a[$r['m']]=(int)$r['n'];$b[$r['m']]=(int)$r['s'];}
top('Dashboard');hero('Selamat Datang di<br>Sistem Informasi Bantuan Sosial','Bersama Mewujudkan Masyarakat Sejahtera','pengajuan.php','Lihat Detail');?>
<div class="row g-3 mb-4">
<?php foreach([['s1','people-fill','success','Total Warga',$tw],['s2','file-earmark-text-fill','primary','Pengajuan',$c()],['s3','check-circle-fill','success','Disetujui',$c("WHERE status='Disetujui'")],['s4','x-circle-fill','danger','Ditolak',$c("WHERE status='Ditolak'")]] as $s):?>
<div class="col-6 col-lg-3"><div class="stat <?=$s[0]?>"><div class="ic text-<?=$s[2]?>"><i class="bi bi-<?=$s[1]?>"></i></div><div><small><?=$s[3]?></small><b><?=number_format($s[4],0,',','.')?></b></div></div></div>
<?php endforeach?></div>
<div class="row g-3 mb-4"><div class="col-lg-8"><div class="card p-3"><h2 class="h6 fw-bold">Grafik Bantuan Sosial <?=$th?></h2><canvas id="ch" height="110"></canvas></div></div>
<div class="col-lg-4"><div class="card p-3 h-100"><h2 class="h6 fw-bold">Jenis Bantuan</h2>
<?php foreach(q("SELECT * FROM jenis_bantuan") as $j):?><div class="border-bottom py-2"><b><?=e($j['kode'])?></b> <small class="text-muted d-block"><?=e($j['nama'])?> · <?=rp($j['nominal'])?></small></div><?php endforeach?>
<a href="jenis.php" class="small mt-2 text-g">Lihat Semua</a></div></div></div>
<div class="card p-3"><h2 class="h6 fw-bold">Pengajuan Terbaru</h2><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Nama</th><th>Jenis</th><th>Tanggal</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach(q("SELECT p.*,w.nama,j.kode FROM pengajuan p JOIN warga w ON w.id=p.warga_id JOIN jenis_bantuan j ON j.id=p.jenis_id ORDER BY p.id DESC LIMIT 5") as $r):?>
<tr><td><?=e($r['nama'])?></td><td><?=e($r['kode'])?></td><td><?=tgl($r['tanggal'])?></td><td><?=badge($r['status'])?></td><td><a class="btn btn-sm btn-g" href="pengajuan.php">Lihat</a></td></tr><?php endforeach?></tbody></table></div></div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>new Chart(ch,{type:'line',data:{labels:['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],datasets:[{label:'Pengajuan',data:<?=json_encode(array_values($a))?>,borderColor:'#1f6bd6',backgroundColor:'#1f6bd622',fill:true,tension:.3},{label:'Penerima',data:<?=json_encode(array_values($b))?>,borderColor:'#1f8a30',backgroundColor:'#1f8a3022',fill:true,tension:.3}]},options:{scales:{y:{beginAtZero:true,ticks:{precision:0}}}}})</script>
<?php bottom();
