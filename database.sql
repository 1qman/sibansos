CREATE DATABASE IF NOT EXISTS sibansos CHARACTER SET utf8mb4;
USE sibansos;
CREATE TABLE warga(id INT AUTO_INCREMENT PRIMARY KEY,nik CHAR(16) UNIQUE NOT NULL,nama VARCHAR(100) NOT NULL,alamat VARCHAR(255),rt_rw VARCHAR(10),no_hp VARCHAR(20),pekerjaan VARCHAR(60),penghasilan INT DEFAULT 0);
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,username VARCHAR(30) UNIQUE NOT NULL,password VARCHAR(255) NOT NULL,role ENUM('admin','warga') NOT NULL,nama VARCHAR(100),warga_id INT NULL,FOREIGN KEY(warga_id) REFERENCES warga(id) ON DELETE CASCADE);
CREATE TABLE jenis_bantuan(id INT AUTO_INCREMENT PRIMARY KEY,kode VARCHAR(10) NOT NULL,nama VARCHAR(80) NOT NULL,deskripsi VARCHAR(255),nominal INT DEFAULT 0);
CREATE TABLE pengajuan(id INT AUTO_INCREMENT PRIMARY KEY,warga_id INT NOT NULL,jenis_id INT NOT NULL,alasan TEXT,berkas VARCHAR(120),tanggal DATE NOT NULL,status ENUM('Menunggu','Disetujui','Ditolak') DEFAULT 'Menunggu',catatan VARCHAR(255),FOREIGN KEY(warga_id) REFERENCES warga(id) ON DELETE CASCADE,FOREIGN KEY(jenis_id) REFERENCES jenis_bantuan(id));
CREATE TABLE penyaluran(id INT AUTO_INCREMENT PRIMARY KEY,pengajuan_id INT NOT NULL,nominal INT DEFAULT 0,status ENUM('Belum','Tersalurkan') DEFAULT 'Belum',tanggal DATE NULL,FOREIGN KEY(pengajuan_id) REFERENCES pengajuan(id) ON DELETE CASCADE);
INSERT INTO jenis_bantuan(kode,nama,deskripsi,nominal) VALUES('PKH','Program Keluarga Harapan','Keluarga Sejahtera',750000),('BPNT','Bantuan Pangan Non Tunai','Bantuan Pangan',200000),('BLT','Bantuan Langsung Tunai','Bantuan Langsung Tunai',300000);
