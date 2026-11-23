<?php
function top($title){
 $u=$_SESSION['u'];$role=$u['role'];$cur=basename($_SERVER['PHP_SELF']);
 $GLOBALS['menu']=$role=='admin'
 ?[['dashboard.php','Dashboard','house-fill'],['warga.php','Data Warga','people-fill'],['jenis.php','Jenis Bantuan','box2-heart-fill'],['pengajuan.php','Pengajuan','file-earmark-text-fill'],['monitoring.php','Monitoring','speedometer2'],['laporan.php','Laporan','printer-fill']]
 :[['dashboard.php','Beranda','house-fill'],['ajukan.php','Ajukan','file-earmark-plus-fill'],['riwayat.php','Riwayat','clock-history'],['profil.php','Profil','person-circle']];
 $GLOBALS['cur']=$cur;$m=$GLOBALS['menu'];?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($title)?> - SIBANSOS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet"></head><body>
<aside class="side d-none d-lg-flex flex-column no-print">
 <div class="text-center py-4"><div class="logo-badge mx-auto mb-2">S</div><div class="fw-bold fs-4 text-white">SIBANSOS</div><small class="text-white-50">Sistem Informasi<br>Bantuan Sosial</small></div>
 <nav class="px-3 flex-grow-1"><?php foreach($m as $i):?><a href="<?=$i[0]?>" class="nv <?=$cur==$i[0]?'on':''?>"><i class="bi bi-<?=$i[2]?>"></i><?=$i[1]?></a><?php endforeach?>
 <hr class="border-secondary"><a href="../logout.php" class="nv"><i class="bi bi-box-arrow-left"></i>Keluar</a></nav></aside>
<div class="main"><header class="topbar no-print"><div class="fw-semibold">Pemerintah Desa <span class="d-block d-sm-inline">Suka Maju</span></div>
 <div class="dropdown"><a class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person-circle fs-5 text-g"></i> <?=e($u['nama'])?></a>
 <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="../logout.php">Keluar</a></li></ul></div></header>
<main class="p-3 p-lg-4">
<?php if(!empty($_SESSION['f'])){[$fm,$ft]=$_SESSION['f'];unset($_SESSION['f']);echo "<div class='alert alert-$ft alert-dismissible no-print'>".e($fm)."<button class='btn-close' data-bs-dismiss='alert'></button></div>";}
}
function hero($t='Selamat Datang di<br>Sistem Informasi Bantuan Sosial',$s='Bersama Mewujudkan Masyarakat Sejahtera',$lnk='',$lb=''){
 echo "<section class='hero mb-4 no-print'><h1>$t</h1><p>".e($s)."</p>".($lnk?"<a href='$lnk' class='btn btn-lime'>".e($lb)." <i class='bi bi-arrow-right'></i></a>":'')."</section>";}
function bottom(){$m=$GLOBALS['menu'];$cur=$GLOBALS['cur'];?>
</main><footer class="foot no-print">© 2026 SIBANSOS. Pemerintah Desa Suka Maju</footer></div>
<nav class="bnav d-lg-none no-print"><?php foreach($m as $i):?><a href="<?=$i[0]?>" class="<?=$cur==$i[0]?'on':''?>"><i class="bi bi-<?=$i[2]?>"></i><span><?=explode(' ',$i[1])[0]?></span></a><?php endforeach?></nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html><?php }
