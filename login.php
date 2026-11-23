<?php require 'config.php';$err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
 $u=q("SELECT * FROM users WHERE username=?",[trim($_POST['username'])])->fetch();
 if($u&&password_verify($_POST['password'],$u['password'])){session_regenerate_id(true);$_SESSION['u']=$u;header("Location: {$u['role']}/dashboard.php");exit;}
 $err='Username atau kata sandi salah.';}
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Masuk - SIBANSOS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/style.css" rel="stylesheet"></head>
<body class="login-bg d-flex align-items-center justify-content-center min-vh-100 p-3">
<div class="card login-card p-4 w-100" style="max-width:400px">
<div class="text-center mb-3"><div class="logo-badge mx-auto mb-2">S</div><h1 class="h3 fw-bold mb-0 text-g">SIBANSOS</h1><small class="text-muted">Sistem Informasi Bantuan Sosial<br>Pemerintah Desa Suka Maju</small></div>
<?php if($err):?><div class="alert alert-danger py-2"><?=e($err)?></div><?php endif?>
<form method="post"><label class="form-label">Username / NIK</label><input name="username" class="form-control mb-3" required autofocus>
<label class="form-label">Kata sandi</label><input type="password" name="password" class="form-control mb-3" required>
<button class="btn btn-lime w-100 py-2">Masuk</button></form>
<p class="small text-muted mt-3 mb-0 text-center">Warga masuk dengan NIK. Petugas masuk dengan username admin.</p></div></body></html>
