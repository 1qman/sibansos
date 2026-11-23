<?php // Jalankan sekali di browser, lalu HAPUS file ini.
require 'config.php';
if(q("SELECT COUNT(*) c FROM users")->fetch()['c']==0){
 q("INSERT INTO users(username,password,role,nama) VALUES('admin',?,'admin','Petugas Desa')",[password_hash('admin123',PASSWORD_DEFAULT)]);
 q("INSERT INTO warga(nik,nama,alamat,rt_rw,no_hp,pekerjaan,penghasilan) VALUES('3327010101900001','Ahmad Fauzi','Dusun I','01/02','081234567890','Buruh Tani',900000)");
 q("INSERT INTO users(username,password,role,nama,warga_id) VALUES('3327010101900001',?,'warga','Ahmad Fauzi',?)",[password_hash('warga123',PASSWORD_DEFAULT),$pdo->lastInsertId()]);
 echo 'Selesai. Admin: admin / admin123. Warga: 3327010101900001 / warga123. Hapus setup.php sekarang.';
}else echo 'Sudah dipasang. Hapus file ini.';
