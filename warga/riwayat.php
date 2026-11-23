<?php require '../config.php';require '../layout.php';need('warga');
top('Riwayat Bantuan');?>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Tanggal</th><th>Bantuan</th><th>Status</th><th>Penyaluran</th><th>Catatan</th></tr></thead><tbody>
<?php $r=q("SELECT p.*,j.nama jn,s.status ss,s.tanggal st,s.nominal FROM pengajuan p JOIN jenis_bantuan j ON j.id=p.jenis_id LEFT JOIN penyaluran s ON s.pengajuan_id=p.id WHERE p.warga_id=? ORDER BY p.id DESC",[$_SESSION['u']['warga_id']])->fetchAll();
foreach($r as $x):?><tr><td><?=tgl($x['tanggal'])?></td><td><?=e($x['jn'])?></td><td><?=badge($x['status'])?></td>
<td><?=$x['ss']?badge($x['ss']).($x['ss']=='Tersalurkan'?' <small>'.tgl($x['st']).' · '.rp($x['nominal']).'</small>':''):'-'?></td><td><?=e($x['catatan'])?></td></tr><?php endforeach?>
<?php if(!$r):?><tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat bantuan.</td></tr><?php endif?></tbody></table></div></div>
<?php bottom();
