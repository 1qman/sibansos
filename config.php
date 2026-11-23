<?php
session_start();
$pdo=new PDO('mysql:host=localhost;dbname=sibansos;charset=utf8mb4','root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
function q($s,$p=[]){global $pdo;$st=$pdo->prepare($s);$st->execute($p);return $st;}
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function rp($n){return 'Rp '.number_format((float)$n,0,',','.');}
function tgl($d){return $d?date('d M Y',strtotime($d)):'-';}
function need($r){if(($_SESSION['u']['role']??'')!==$r){header('Location: ../login.php');exit;}}
function flash($m,$t='success'){$_SESSION['f']=[$m,$t];}
function csrf(){$_SESSION['t']=$_SESSION['t']??bin2hex(random_bytes(16));return "<input type='hidden' name='_t' value='{$_SESSION['t']}'>";}
function chk(){if(!hash_equals($_SESSION['t']??'',$_POST['_t']??'')){http_response_code(400);exit('Token tidak valid');}}
function badge($s){$c=['Menunggu'=>'warning','Disetujui'=>'success','Ditolak'=>'danger','Belum'=>'warning','Tersalurkan'=>'success'][$s]??'secondary';return "<span class='badge rounded-pill text-bg-$c'>".e($s)."</span>";}
