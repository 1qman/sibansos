<?php require '../config.php';require '../layout.php';need('admin');
if($_SERVER['REQUEST_METHOD']=='POST'){chk();q("UPDATE penyaluran SET status='Tersalurkan',tanggal=CURDATE() WHERE id=?",[$_POST['id']]);flash('Penyaluran dicatat');header('Location: monitoring.php');exit;}
top('Monitoring Penyaluran');?>
<div class="row g-3 mb-3"><?php foreach(q("SELECT j.kode,j.nama,COUNT(s.id) tot,COALESCE(SUM(s.status='Tersalurkan'),0) ok,COALESCE(SUM(CASE WHEN s.status='Tersalurkan' THEN s.nominal END),0) dana FROM jenis_bantuan j LEFT JOIN pengajuan p ON p.jenis_id=j.id LEFT JOIN penyaluran s ON s.pengajuan_id=p.id GROUP BY j.id") as $j):$pc=$j['tot']?round($j['ok']/$j['tot']*100):0;?>
<div class="col-md-4"><div class="card p-3"><b><?=e($j['kode'])?></b> <small class="text-muted"><?=e($j['nama'])?></small>
<div class="progress my-2" style="height:10px"><div class="progress-bar bg-success" style="width:<?=$pc?>%"></div></div>
<small><?=$j['ok']?> dari <?=$j['tot']?> tersalurkan (<?=$pc?>%) · <?=rp($j['dana'])?></small></div></div><?php endforeach?></div>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Penerima</th><th>Bantuan</th><th>Nominal</th><th>Status</th><th>Tanggal</th><th></th></tr></thead><tbody>
<?php foreach(q("SELECT s.*,w.nama,j.kode FROM penyaluran s JOIN pengajuan p ON p.id=s.pengajuan_id JOIN warga w ON w.id=p.warga_id JOIN jenis_bantuan j ON j.id=p.jenis_id ORDER BY s.status,s.id DESC") as $s):?>
<tr><td><?=e($s['nama'])?></td><td><?=e($s['kode'])?></td><td><?=rp($s['nominal'])?></td><td><?=badge($s['status'])?></td><td><?=tgl($s['tanggal'])?></td>
<td><?php if($s['status']=='Belum'):?><form method="post"><?=csrf()?><input type="hidden" name="id" value="<?=$s['id']?>"><button class="btn btn-sm btn-g">Tandai tersalurkan</button></form><?php endif?></td></tr><?php endforeach?></tbody></table></div></div>
<?php bottom();
