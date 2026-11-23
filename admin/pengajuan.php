<?php require '../config.php';require '../layout.php';need('admin');
if($_SERVER['REQUEST_METHOD']=='POST'){chk();$id=(int)$_POST['id'];
 if($_POST['aksi']=='setuju'){q("UPDATE pengajuan SET status='Disetujui',catatan=? WHERE id=? AND status='Menunggu'",[$_POST['catatan'],$id]);
  q("INSERT INTO penyaluran(pengajuan_id,nominal) SELECT p.id,j.nominal FROM pengajuan p JOIN jenis_bantuan j ON j.id=p.jenis_id WHERE p.id=? AND p.status='Disetujui' AND NOT EXISTS(SELECT 1 FROM penyaluran WHERE pengajuan_id=p.id)",[$id]);flash('Pengajuan disetujui dan masuk daftar penyaluran');}
 else{q("UPDATE pengajuan SET status='Ditolak',catatan=? WHERE id=? AND status='Menunggu'",[$_POST['catatan'],$id]);flash('Pengajuan ditolak');}
 header('Location: pengajuan.php');exit;}
$st=$_GET['status']??'';
$rows=q("SELECT p.*,w.nama,w.nik,w.penghasilan,w.pekerjaan,j.kode,j.nama jn FROM pengajuan p JOIN warga w ON w.id=p.warga_id JOIN jenis_bantuan j ON j.id=p.jenis_id ".($st?"WHERE p.status=?":"")." ORDER BY p.id DESC",$st?[$st]:[])->fetchAll();
top('Verifikasi Pengajuan');?>
<div class="mb-3"><?php foreach(['','Menunggu','Disetujui','Ditolak'] as $s):?><a href="?status=<?=$s?>" class="btn btn-sm <?=$st==$s?'btn-g':'btn-light'?> me-1"><?=$s?:'Semua'?></a><?php endforeach?></div>
<div class="card p-3"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Nama</th><th>Jenis</th><th>Tanggal</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r):?><tr><td><?=e($r['nama'])?></td><td><?=e($r['kode'])?></td><td><?=tgl($r['tanggal'])?></td><td><?=badge($r['status'])?></td>
<td><button class="btn btn-sm btn-g" data-bs-toggle="modal" data-bs-target="#m" data-r='<?=e(json_encode($r))?>'>Periksa</button></td></tr><?php endforeach?>
<?php if(!$rows):?><tr><td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan.</td></tr><?php endif?></tbody></table></div></div>
<div class="modal fade" id="m"><div class="modal-dialog modal-dialog-centered"><form method="post" class="modal-content"><?=csrf()?><input type="hidden" name="id" id="mid">
<div class="modal-header"><h5 class="modal-title">Verifikasi pengajuan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body"><div id="mb" class="mb-3 small"></div><label class="form-label">Catatan petugas</label><textarea name="catatan" id="mc" class="form-control" rows="2"></textarea></div>
<div class="modal-footer" id="mf"><button name="aksi" value="tolak" class="btn btn-outline-danger">Tolak</button><button name="aksi" value="setuju" class="btn btn-lime">Setujui</button></div></form></div></div>
<script>document.getElementById('m').addEventListener('show.bs.modal',ev=>{const r=JSON.parse(ev.relatedTarget.dataset.r),t=s=>{const d=document.createElement('div');d.textContent=s;return d.innerHTML};
mid.value=r.id;mc.value=r.catatan||'';mf.style.display=r.status=='Menunggu'?'':'none';
mb.innerHTML=`<b>${t(r.nama)}</b> (NIK ${t(r.nik)})<br>Pekerjaan: ${t(r.pekerjaan||'-')} · Penghasilan: Rp ${Number(r.penghasilan).toLocaleString('id-ID')}<br>Bantuan: ${t(r.jn)}<br>Alasan: ${t(r.alasan||'-')}<br>`+(r.berkas?`<a href="../uploads/${encodeURIComponent(r.berkas)}" target="_blank">Lihat berkas</a>`:'<i>Tidak ada berkas</i>')})</script>
<?php bottom();
