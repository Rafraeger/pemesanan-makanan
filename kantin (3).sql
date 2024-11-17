-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Okt 2023 pada 15.18
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_produk`
--

CREATE TABLE `menu_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `gambar_produk` varchar(255) NOT NULL,
  `deskripsi_produk` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menu_produk`
--

INSERT INTO `menu_produk` (`id_produk`, `nama_produk`, `harga_produk`, `gambar_produk`, `deskripsi_produk`) VALUES
(2, 'ayam', 10000, 'ayam.jpg', 'ayam guling'),
(3, 'pizza', 25000, 'pizza.jpg', 'pizza harga murah meriah muntah '),
(4, 'teh olong', 5000, 'teh.jpg', 'teh olong rasanya seperti ingin\r\nterbang'),
(5, 'ayam penyek', 15000, '1696846561.jpg', 'cabe 1 boleh\r\ncabe 2 boleh'),
(6, 'kebab burtok', 25000, '1696865043.jpg', 'kebaba alami berasal dari \r\narab '),
(7, 'kentang goreng', 12000, '1696921863.jpeg', 'enak kok'),
(8, 'ayam goreng', 12000, '1697001009.jpg', 'Ayam ogreng ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `status` enum('Belum Selesai','Selesai') NOT NULL DEFAULT 'Belum Selesai',
  `barang_dipesan` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `waktu_pemesanan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `nama_barang`, `total_harga`, `bukti_pembayaran`, `status`, `barang_dipesan`, `catatan`, `username`, `waktu_pemesanan`) VALUES
(4, 'andi', 40000, 'ayam.jpg', 'Selesai', '2 Ayam Goreng, 2 Teh', '', '', '2023-10-10 12:32:01'),
(5, 'yudha', 30000, 'ice.jpg', 'Selesai', '2 Ayam Goreng', '', '', '2023-10-10 12:32:01'),
(6, 'andi', 12000, 'ice.jpg', 'Selesai', '1 Bakso', '', '', '2023-10-10 12:32:01'),
(7, 'Rafif', 12000, 'ice.jpg', 'Selesai', '1 Bakso', 'saya di kantin', '', '2023-10-10 12:32:01'),
(8, 'Zidane', 20000, 'ayam.jpg', 'Selesai', '2 Ice Cream', 'kaga usah pake saus', '', '2023-10-10 12:32:01'),
(9, 'andi', 0, 'ayam.jpg', 'Selesai', '3 , 2', 'dadsdad', '', '2023-10-10 12:32:01'),
(10, 'yudha', 32000, 'bakso.jpg', 'Selesai', '1 kebab, 2 ayam', 'saya di kantin', '', '2023-10-10 12:32:01'),
(11, 'damar', 60000, 'bakso.jpg', 'Selesai', '2 pizza, 1 ayam', 'kaga usah pake saus', '', '2023-10-10 12:32:01'),
(12, 'Rafif', 40000, '1696843507_bakso.jpg', 'Selesai', '4 ayam', 'saya di kantin', '', '2023-10-10 12:32:01'),
(13, 'adi', 75000, '1696844359_ayam.jpg', 'Belum Selesai', '1 ayam, 2 pizza, 3 teh olong', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(14, 'melisa', 45000, '1696854307_pizza.jpg', 'Belum Selesai', '1 ayam, 1 pizza, 2 teh olong', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(15, 'andi', 25000, '1696854391_kebab.jpg', 'Belum Selesai', '1 pizza', '', '', '2023-10-10 12:32:01'),
(16, 'yudha', 5000, '1696854457_ayam.jpg', 'Belum Selesai', '1 teh olong', '', '', '2023-10-10 12:32:01'),
(17, 'andi', 10000, '1696854489_1696846561.jpg', 'Belum Selesai', '1 ayam', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(18, 'andi', 60000, '1696864381_mercubuana.jpg', 'Belum Selesai', '6 ayam', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(19, 'Rafif', 60000, '1696865341_ice.jpg', 'Belum Selesai', '1 ayam, 2 pizza', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(20, 'yudha', 50000, '1696865868_ice.jpg', 'Belum Selesai', '5 ayam', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(21, 'andi', 40000, '1696865967_ice.jpg', 'Belum Selesai', '4 ayam', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(22, 'andi', 10000, '1696866400_bakso.jpg', 'Belum Selesai', '1 ayam', 'kaga usah pake saus', '', '2023-10-10 12:32:01'),
(27, 'andi', 0, '1696869125_1696846561.jpg', 'Belum Selesai', '', 'Boleh ngutang ngga wkwkwk', '', '2023-10-10 12:32:01'),
(28, 'andi', 0, '1696869390_1696865043.jpg', 'Belum Selesai', '', '', '', '2023-10-10 12:32:01'),
(29, 'yudha', 0, '1696869785_ice.jpg', 'Belum Selesai', '', 'saya di kantin', '', '2023-10-10 12:32:01'),
(30, 'andi', 0, '1696870092_1696846561.jpg', 'Belum Selesai', '', '', '', '2023-10-10 12:32:01'),
(31, 'andi', 0, '1696870423_ice.jpg', 'Belum Selesai', '', '', '', '2023-10-10 12:32:01'),
(32, 'andi', 0, '1696870445_1696865043.jpg', 'Belum Selesai', '', '', '', '2023-10-10 12:32:01'),
(33, 'andi', 0, '1696870474_kebab.jpg', 'Belum Selesai', '', 'saya di kantin', '', '2023-10-10 12:32:01'),
(34, 'andi', 0, '1696870697_1696846561.jpg', 'Belum Selesai', '', '', '', '2023-10-10 12:32:01'),
(35, 'andi', 35000, '1696871712_ice.jpg', 'Belum Selesai', '1 ayam, 1 kebab farhan', '', '', '2023-10-10 12:32:01'),
(36, 'andi', 50000, '1696871760_1696865043.jpg', 'Belum Selesai', '2 kebab farhan', '', '', '2023-10-10 12:32:01'),
(37, 'andi', 50000, '1696871839_umb.jpg', 'Belum Selesai', '2 kebab farhan', '', '', '2023-10-10 12:32:01'),
(38, 'yudha', 100000, '1696872003_ice.jpg', 'Belum Selesai', '4 kebab farhan', '', '', '2023-10-10 12:32:01'),
(39, 'andi', 125000, '1696873995_ice.jpg', 'Belum Selesai', '5 kebab farhan', '', '', '2023-10-10 12:32:01'),
(40, '', 35000, '1696875061_kebab.jpg', 'Belum Selesai', '1 kebab farhan, 1 ayam', '', '', '2023-10-10 12:32:01'),
(41, 'budi', 25000, '1696875335_1696865043.jpg', 'Belum Selesai', '1 kebab farhan', 'awsdfg', '', '2023-10-10 12:32:01'),
(42, 'budi', 25000, '1696875594_ice.jpg', 'Belum Selesai', '1 kebab farhan', 'sa', '', '2023-10-10 12:32:01'),
(43, 'budi', 25000, '1696875793_ice.jpg', 'Belum Selesai', '1 kebab farhan', '', '', '2023-10-10 12:32:01'),
(44, 'budi', 25000, '1696875996_teh.jpg', 'Belum Selesai', '1 kebab farhan', '', '', '2023-10-10 12:32:01'),
(45, 'budi', 125000, '1696876206_mercubuana.jpg', 'Belum Selesai', '5 kebab farhan', '', '', '2023-10-10 12:32:01'),
(46, 'budi', 5000, '1696876437_kebab.jpg', 'Belum Selesai', '1 teh olong', 'asasa', '', '2023-10-10 12:32:01'),
(47, 'Rafif', 20000, '1696876674_mercubuana.jpg', 'Belum Selesai', '1 teh olong, 1 ayam penyek', 'yang pedes', '', '2023-10-10 12:32:01'),
(48, 'budi', 10000, '1696876893_kebab.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(49, 'budi', 10000, '1696877035_kebab.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(50, '12', 10000, '1696877230_ice.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(51, 'as', 10000, '1696877299_ice.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(52, 'Rafif', 10000, '1696877469_kebab.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(53, 'budi', 10000, '1696877542_kebab.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(54, 'agiler', 75000, '1696878635_batik_hijau.jpg', 'Belum Selesai', '3 kebab farhan', 'kaga usah pake keju', '', '2023-10-10 12:32:01'),
(55, 'agiler', 15000, '1696910394_batik_kuning.jpg', 'Belum Selesai', '3 teh olong', 'no', '', '2023-10-10 12:32:01'),
(56, 'agiler', 10000, '1696915395_batik_hijau.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(57, 'Rafif', 75000, '1696915551_1696865043.jpg', 'Selesai', '3 kebab farhan', 'pppppppp', '', '2023-10-10 12:32:01'),
(59, 'raeger', 45000, '1696917728_1696865043.jpg', 'Belum Selesai', '3 teh olong, 3 ayam', '', '', '2023-10-10 12:32:01'),
(60, 'as', 50000, '1696917770_ice.jpg', 'Belum Selesai', '5 ayam', '', '', '2023-10-10 12:32:01'),
(61, 'raeger', 10000, '1696917928_ice.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(62, 'Rafif', 10000, '1696918065_ice.jpg', 'Belum Selesai', '1 ayam', '', '', '2023-10-10 12:32:01'),
(63, 'budi', 35000, '1696918367_ice.jpg', 'Selesai', '1 teh olong, 3 ayam', 'aasasasa', '', '2023-10-10 12:32:01'),
(64, 'Rafif', 63000, '1696921980_history id.png', 'Selesai', '3 teh olong, 4 kentang goreng', 'saya ada di kuersi sebelah kanan', '', '2023-10-10 12:32:01'),
(65, 'Rafif', 39000, '1696926474_history id.png', 'Selesai', '1 ayam, 2 kentang goreng, 1 teh olong', 'saya ada di meja 2', '', '2023-10-10 12:32:01'),
(66, 'budi', 10000, '1696930288_history id.png', 'Belum Selesai', '1 ayam', 'swadesfdf', '', '2023-10-10 12:32:01'),
(67, 'Rafif', 75000, '1696930668_history id.png', 'Belum Selesai', '3 kebab burtok', 'adsffgn', '', '2023-10-10 12:32:01'),
(68, 'budi', 100000, '1696931349_history id.png', 'Belum Selesai', '4 kebab burtok', 'no saus', '', '2023-10-10 12:32:01'),
(69, 'budi', 100000, '1696931543_history id.png', 'Belum Selesai', '4 kebab burtok', 'no saus', '', '2023-10-10 12:32:01'),
(70, 'sda', 100000, '1696931561_kentang goreng.jpeg', 'Belum Selesai', '4 kebab burtok', '', '', '2023-10-10 12:32:01'),
(71, 'Rafif', 75000, '1696931917_history id.png', 'Belum Selesai', '3 kebab burtok', 'test', '', '2023-10-10 12:32:01'),
(72, 'budi', 75000, '1696932120_history id.png', 'Belum Selesai', '3 kebab burtok', '', '', '2023-10-10 12:32:01'),
(73, 'ida', 35000, '1696937461_history id.png', 'Belum Selesai', '1 kebab burtok, 1 ayam', '', 'ida', '2023-10-10 12:32:01'),
(74, 'Rafif', 10000, '1696937754_history id.png', 'Belum Selesai', '1 ayam', 'ssadsad', 'ida', '2023-10-10 12:32:01'),
(75, 'Rafif', 25000, '1696941356_history id.png', 'Belum Selesai', '1 kebab burtok', 'sadasdad', 'raeger', '2023-10-10 07:35:56'),
(76, 'Rafif', 25000, '1696941423_history id.png', 'Belum Selesai', '1 kebab burtok', 'fsfsfsf', 'raeger', '2023-10-10 07:37:03'),
(77, 'Rafif', 5000, '1696941785_history id.png', 'Selesai', '1 teh olong', 'AFSD', 'ida', '2023-10-10 12:43:05'),
(78, 'Rafif', 50000, '1696944072_history id.png', 'Selesai', '2 kebab burtok', 'ah crott', 'pia', '2023-10-10 13:21:12'),
(79, 'pakde', 25000, '1696953033_shopee.png', 'Belum Selesai', '1 kebab burtok', 'tidak usah pake saus', 'ida', '2023-10-10 15:50:33'),
(80, 'raeger', 55000, '1696954798_dana.png', 'Belum Selesai', '2 kebab burtok, 1 teh olong', 'rudian', 'ida', '2023-10-10 16:19:58'),
(81, 'agiler', 25000, '1696956897_bca.png', 'Belum Selesai', '1 kebab burtok', 'qwsdfghnk,', 'ida', '2023-10-10 16:54:57'),
(82, 'agiler', 25000, '1696959105_bca.png', 'Selesai', '1 kebab burtok', 'QADFJN', 'raeger', '2023-10-10 17:31:45'),
(83, 'agiler', 25000, '1696960994_1696846561.jpg', 'Belum Selesai', '1 kebab burtok', 'SDADADD', 'raeger', '2023-10-10 18:03:14'),
(84, 'agiler', 10000, '1696961248_id_15809831282.jpg', 'Selesai', '1 ayam', 'fwff', 'raeger', '2023-10-10 18:07:28'),
(85, 'mamat', 30000, '1696989711_E8_KgtsVgAA5HeL.jpg', 'Selesai', '2 ayam, 2 teh olong', 'kokoh bagi duit', 'botol', '2023-10-11 02:01:51'),
(86, 'zsdfghj', 25000, '1696997926_kentang goreng.jpeg', 'Belum Selesai', '1 kebab burtok', 'zdfghj', 'ida', '2023-10-11 04:18:46'),
(87, 'medula', 60000, '1697000888_E8_KgtsVgAA5HeL.jpg', 'Selesai', '3 ayam, 1 kebab burtok, 1 teh olong', 'bang baoleh cash gk ?', 'user1', '2023-10-11 05:08:08'),
(88, 'damar', 22000, '1697001246_bca.png', 'Selesai', '1 ayam, 1 ayam goreng', 'lewat bca ', 'user1', '2023-10-11 05:14:06'),
(89, 'pakde', 24000, '1697030165_E8_KgtsVgAA5HeL.jpg', 'Belum Selesai', '2 ayam goreng', 'tidak usah pake saus', 'raeger', '2023-10-11 13:16:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sellers`
--

INSERT INTO `sellers` (`id`, `username`, `password`) VALUES
(1, 'ida', '$2y$10$H97QC.2UYl1UntTeurpRQuACBsd3ZX7ORVK08jJ.VoOwyvRslwDvm'),
(2, 'salim', '$2y$10$4YOEDYcDktYTknEdAgFGt.7UFjLUjWndsWc/azbFM.bSd2mJOe70W'),
(3, 'yudha', '$2y$10$0rZyHdTo7K//ELxQ07NgUe5WZumPpcrEufFNx21NQ7zjHxSE.myuu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'ida', '$2y$10$c9/d73T13t..FCA8TsEfMeTCo2JSCb2xojacRkDY0DsQ1tFdDOH/.'),
(2, 'admin', '$2y$10$9CgfmBqQAuYbfMevMeK2FeLBWgo/VxPfavCnaBSNTTgcFwlmcyngy'),
(3, 'admin1', '$2y$10$3rPGbZ6A/mw1Y9./zpEmd./htVL1Re0MFINDp./FhERsY0EtQzfFS'),
(4, '', '$2y$10$af7Sm9/P9pkHIGm1gV0G/OcrOXuzU4Q0e9Z6HncYvf7ebgbssAi6S'),
(5, 'rika', '$2y$10$bUOaRIdPMb1ZFwEQ1bu8i.QD5jvGhN4JYl6tAPy4QMg8pGm0ff4Dq'),
(6, 'ghu', '$2y$10$XWQ0/2yd27kUlddhWw6tXeGUzvn5zGW/spWXEWRFOWfJvuetNchuG'),
(7, 'yudha', '$2y$10$6LJACGIRvA4VUhTTgAFLyukCDLvx6i7u.iKEINvtrHXaFdsHPg38e'),
(8, 'sai', '$2y$10$8czAFpbJypF0HoAVuFh37e9mgiRL7UkC57HIFeQJjFrOJzPPLuFH2'),
(9, 'jui', '$2y$10$7oOGeT/wZ6.D8f/CnbY23.DDd0UN5cikeRh/ssPVzTlmqn479DObi'),
(11, 'kita', '$2y$10$oXRPPxxjdj1oQU8PCnpcguzogyOwwkuHNxLLHI2GJWFWBVqMBF.aK'),
(12, 'juha', '$2y$10$jvYNui5KTsW6MQE9/4LOqexxgcrpunQcUdK.dtQsXIZJXZpIhhBcC'),
(17, 'raeger', '$2y$10$gdD8Wn/clc873DDWovbQVujQWG7yVe3YXumxquYSU.2VEj6aotYvK'),
(19, 'rui', '$2y$10$zuYC9v95pJ4YuGyVsgKJ.OxpXQH.HNWpiVlPkNe1XZpqt6mC1IJ62'),
(20, 'pia', '$2y$10$2ZggRw9hqq1dNQ6ly9Jql.0ui./nlUeUeyJOzVkcNFByHrO08JsCW'),
(21, 'botol', '$2y$10$X99i0nkxR9oHlhv.wG2b1eSdRtrb8ubqIw4CSC2GlbRr.SiGsJ7v6'),
(22, 'user1', '$2y$10$NhXj4jXDz0ScwlfA9LL8xuEHlHmCfbWOn68RDjCpyzbwU8Ql/r2Xa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu_produk`
--
ALTER TABLE `menu_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indeks untuk tabel `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu_produk`
--
ALTER TABLE `menu_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
