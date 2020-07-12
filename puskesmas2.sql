-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2020 pada 14.12
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puskesmas2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_bidang`
--

CREATE TABLE `tbl_bidang` (
  `id_bidang` int(3) NOT NULL,
  `nama_bidang` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_bidang`
--

INSERT INTO `tbl_bidang` (`id_bidang`, `nama_bidang`) VALUES
(1, 'Paramedis'),
(2, 'Apotek'),
(3, 'Administrasi'),
(5, 'Bendahara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_diagnosa_penyakit`
--

CREATE TABLE `tbl_diagnosa_penyakit` (
  `kode_diagnosa` varchar(6) NOT NULL,
  `nama_penyakit` varchar(50) NOT NULL,
  `ciri_ciri_penyakit` text NOT NULL,
  `keterangan` text NOT NULL,
  `ciri_ciri_umum` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_diagnosa_penyakit`
--

INSERT INTO `tbl_diagnosa_penyakit` (`kode_diagnosa`, `nama_penyakit`, `ciri_ciri_penyakit`, `keterangan`, `ciri_ciri_umum`) VALUES
('Db-37', 'Diabetes', 'Kebanyakan Gula Darah', 'Penyakit Tingkat Tinggi', 'Kebanyakan Gula Darah'),
('Gg-39', 'Gigi Berlubang', 'Mengalami Linu DI Gigi', 'Penyakit Bagian Mulut', 'Mengalami Linu DI Gigi'),
('HB-39', 'Hidung Bengkak', 'Alergi Obat', 'Penyakit Tingkat Menengah', 'Hidung Berwarna Kemerahan'),
('KR-292', 'Mata Rabun', 'Mata Mengalami Sedikit Pergeseran Di Bagian Retina', 'Penyakit Tingkat Tinggi', 'Mata Mengalami Penurunan Penglihatan'),
('Kt-18', 'Cacar', 'Gatal', 'Berbahaya', 'Gatal'),
('S-9956', 'Kirarawit', 'Kulit Berwarna Bercak Kemerahan', 'Penyakit Ini Berhubungan Dengan Saraf', 'Kulit Berwarna Bercak Kemerahan'),
('Tk-67', 'Tuberklosis', 'Mengalami Sesak Nafas', 'Disertai Panas dan Flu', 'Disertai Panas dan Flu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dokter`
--

CREATE TABLE `tbl_dokter` (
  `kode_dokter` varchar(4) NOT NULL,
  `nama_dokter` varchar(30) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `nomor_induk_dokter` varchar(20) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` varchar(10) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `id_poli` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_dokter`
--

INSERT INTO `tbl_dokter` (`kode_dokter`, `nama_dokter`, `jenis_kelamin`, `nomor_induk_dokter`, `tempat_lahir`, `tgl_lahir`, `alamat`, `id_poli`) VALUES
('IA-0', 'Fitri', 'Perempuan', '4929029033291', 'CIREBON', '26-08-1995', 'Kalimalang', '4'),
('K-02', 'Sunarya', 'Laki-Laki', '71816828738790', 'Majalengka', '12-07-1977', 'Sukaluyu', '2'),
('K-12', 'Karsa', 'Laki-Laki', '71816838738718', 'Sidoarjo', '15-06-1982', 'Adiarsa', '1'),
('S-23', 'Samsul', 'Laki-Laki', '48916838738757', 'CIimahi', '26-11-1993', 'Ciraos', '1'),
('S-24', 'Maryudi', 'Laki-Laki', '71816838888718', 'Cepu', '21-08-1993', 'Santiong', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hak_akses`
--

CREATE TABLE `tbl_hak_akses` (
  `id` int(2) NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_hak_akses`
--

INSERT INTO `tbl_hak_akses` (`id`, `id_user_level`, `id_menu`) VALUES
(19, 1, 3),
(30, 1, 2),
(31, 1, 10),
(32, 1, 11),
(33, 1, 12),
(34, 1, 13),
(35, 1, 14),
(36, 1, 15),
(37, 1, 16),
(38, 1, 17),
(39, 1, 18),
(40, 1, 19),
(41, 1, 20),
(42, 1, 21),
(43, 1, 1),
(44, 1, 22),
(45, 1, 23),
(46, 1, 24),
(47, 1, 9),
(48, 1, 25),
(49, 1, 26),
(50, 1, 27),
(51, 1, 28),
(52, 1, 29),
(53, 1, 30),
(54, 1, 31),
(55, 1, 32),
(56, 1, 33),
(57, 1, 34),
(58, 1, 35),
(59, 1, 36),
(60, 1, 40),
(61, 1, 37),
(62, 1, 38),
(63, 1, 39),
(64, 1, 41),
(65, 1, 42),
(66, 1, 43),
(67, 1, 44),
(68, 1, 46),
(72, 2, 21),
(74, 2, 23),
(76, 1, 47),
(77, 1, 48),
(78, 1, 49),
(79, 3, 33),
(80, 3, 36),
(81, 1, 50),
(82, 3, 50),
(84, 3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id_jabatan` int(2) NOT NULL,
  `nama_jabatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Staff Apotek'),
(2, 'Staff Administrasi'),
(3, 'Kepala Puskesmas'),
(4, 'Staff Paramedis');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jadwal_praktek_dokter`
--

CREATE TABLE `tbl_jadwal_praktek_dokter` (
  `id_jadwal` int(2) NOT NULL,
  `kode_dokter` varchar(4) NOT NULL,
  `hari` varchar(13) NOT NULL,
  `jam_mulai` varchar(13) NOT NULL,
  `jam_selesai` varchar(13) NOT NULL,
  `id_poli` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_jadwal_praktek_dokter`
--

INSERT INTO `tbl_jadwal_praktek_dokter` (`id_jadwal`, `kode_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `id_poli`) VALUES
(6, 'K-02', 'Rabu', '14.30', '16.30', 2),
(7, 'S-23', 'Senin', '07.30', '11.30', 1),
(8, 'S-24', 'Sabtu', '07.30', '11.00', 2),
(9, 'K-12', 'Kamis', '08.00', '11.00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_laboratorium`
--

CREATE TABLE `tbl_laboratorium` (
  `id_lab` int(3) NOT NULL,
  `nama_alat_lab` varchar(50) NOT NULL,
  `jenis_alat_lab` varchar(50) NOT NULL,
  `status_alat_lab` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(3) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `is_main_menu` int(3) NOT NULL,
  `is_aktif` enum('y','n') NOT NULL COMMENT 'y=yes,n=no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `title`, `url`, `icon`, `is_main_menu`, `is_aktif`) VALUES
(1, 'DATA DOKTER', 'kelolamenu', 'fa fa-server', 0, 'n'),
(2, 'KELOLA PENGGUNA', 'user', 'fa fa-user-o', 0, 'y'),
(3, 'level PENGGUNA', 'userlevel', 'fa fa-users', 0, 'y'),
(15, 'DATA PARAMEDIS', 'paramedis', 'fa fa-graduation-cap', 22, 'y'),
(19, 'DATA JABATAN', 'jabatan', 'fa fa-area-chart', 22, 'y'),
(20, 'DATA BIDANG', 'bidang', 'fa fa-user-circle', 22, 'y'),
(21, 'DATA PEGAWAI', 'pegawai', 'fa fa-user-circle', 0, 'y'),
(22, 'DATA MASTER', '#', 'fa fa-id-card', 0, 'y'),
(23, 'DATA POLI', 'poli', 'fa fa-bed', 22, 'y'),
(27, 'DATA DOKTER', 'dokter', 'fa fa-graduation-cap', 0, 'y'),
(29, 'JADWAL PRAKTEK DOKTER', 'jadwalpraktek', 'fa fa-calendar', 0, 'y'),
(31, 'DATA PASIEN', 'pasien', 'fa fa-user', 0, 'y'),
(33, 'DATA PENDAFTARAN', 'pendaftaran', 'fa fa-sign-in', 0, 'y'),
(34, 'DATA DIAGNOSA', 'diagnosa', 'fa fa-id-card', 0, 'y'),
(36, 'DATA TINDAKAN', 'tindakan', 'fa fa-flask', 0, 'y'),
(37, 'STOK OBAT', 'stokobat', 'fa fa-bed', 40, 'y'),
(38, 'PENGADAAN OBAT', 'pengadaanobat', 'fa fa-bed', 40, 'y'),
(39, 'PENGELUARAN OBAT', 'pengeluaranobat', 'fa fa-calendar', 40, 'y'),
(40, 'DATA OBAT', 'dataobat', 'fa fa-card', 0, 'y'),
(41, 'DATA SUPPLIER', 'supplier', 'fa fa-bed', 0, 'y'),
(46, 'DATA OBAT-OBATAN', 'dataobat', 'fa fa-user', 40, 'y'),
(50, 'DATA TINDAKAN BEROBAT', 'tindakanberobat', 'fa fa-graduation-cap', 0, 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `kode_obat` varchar(5) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `jenis_obat` varchar(50) NOT NULL,
  `dosis_aturan_obat` varchar(40) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_obat`
--

INSERT INTO `tbl_obat` (`kode_obat`, `nama_obat`, `jenis_obat`, `dosis_aturan_obat`, `satuan`) VALUES
('A-282', 'Anexsamol', 'Kapsul', '2x1 Sehari', 'Strip'),
('A-989', 'Salicyl', 'Bedak', '3 x 1 sehari', 'Buah'),
('D-118', 'Dextrane', 'Tablet', '3x1 Sehari', 'Strip'),
('MP-29', 'Sun', 'Makanan PG', '-', 'Buah'),
('P-332', 'PoliSaxechon', 'Cairan Alkohol', 'Setiap pakai 10 ml', 'Botol'),
('PG-58', 'Pil Vitamin A', 'Suplemen', '3 x 1 Sehari', 'Strip'),
('SD-65', 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 'Botol '),
('SN-11', 'Alpara', 'Kapsul', '3x1 Sehari', 'Strip');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_operasi`
--

CREATE TABLE `tbl_operasi` (
  `kode_operasi` varchar(6) NOT NULL,
  `nama_operasi` varchar(50) NOT NULL,
  `biaya` int(11) NOT NULL,
  `tindakan_oleh` enum('dokter','petugas','dokter dan petugas','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_operasi`
--

INSERT INTO `tbl_operasi` (`kode_operasi`, `nama_operasi`, `biaya`, `tindakan_oleh`) VALUES
('A-3494', 'Penanganan Luka Memar', 50000, 'dokter'),
('BJ-191', 'Pemeriksaan Katarak', 75000, 'dokter'),
('IA-282', 'Pemeriksaan Polio', 80000, 'dokter'),
('IA-383', 'Penanganan Persalinan', 180000, 'dokter dan petugas'),
('IA-878', 'Pemeriksaan Ibu Hamil', 75000, 'dokter'),
('L-4839', 'Luka Jahit', 95000, 'dokter');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_paramedis`
--

CREATE TABLE `tbl_paramedis` (
  `kode_paramedis` varchar(4) NOT NULL,
  `nama_paramedis` varchar(30) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `no_izin_paramedis` varchar(20) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` varchar(10) NOT NULL,
  `alamat_tinggal` text NOT NULL,
  `id_poli` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_paramedis`
--

INSERT INTO `tbl_paramedis` (`kode_paramedis`, `nama_paramedis`, `jenis_kelamin`, `no_izin_paramedis`, `tempat_lahir`, `tanggal_lahir`, `alamat_tinggal`, `id_poli`) VALUES
('A-12', 'Aulia Mustika Putri', 'Perempuan', '29829822291', 'Bandung', '24-07-1988', 'Klari', 2),
('P-35', 'Lucky Ardi Wijaya', 'Laki-Laki', '29829823991', 'Jogjakarta', '18-03-1991', 'Wadas', 1),
('P-49', 'Marcel Ali Wijaya', 'Laki-Laki', '29829829291', 'Karawang', '19-07-1988', 'Rengas Dengklok', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pasien`
--

CREATE TABLE `tbl_pasien` (
  `no_rekamedis` char(6) NOT NULL,
  `no_ktp` varchar(16) NOT NULL,
  `no_bpjs` varchar(20) NOT NULL,
  `nama_pasien` varchar(30) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `status_pasien` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pasien`
--

INSERT INTO `tbl_pasien` (`no_rekamedis`, `no_ktp`, `no_bpjs`, `nama_pasien`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `status_pasien`) VALUES
('000001', '3215021831771822', '28287188196112', 'Niko Rahmad', 'L', 'Bandung', '29-03-1992', 'Serang', 'BPJS'),
('000002', '3215021621771800', '28287188196128', 'Oman', 'L', 'Cirebon', '19-07-1989', 'OK', 'BPJS'),
('000003', '3335021831771822', '28287188196156', 'Muhammad Yogi', 'L', 'Surabaya', '09-02-1993', 'okkk', 'BPJS'),
('000004', '3215089831777722', '28287188196139', 'Yulia', 'P', 'Cicaheum', '06-07-1994', 'Serdang', 'BPJS'),
('000005', '3015021831271822', '28287188196145', 'Diana', 'P', 'See Do Are Jo', '09-07-1995', 'CKM', 'BPJS'),
('000006', '3015021899271822', '28287134996145', 'Maulida Fitria', 'P', 'Karawang', '26-12-1984', 'Jatirasa', 'BPJS'),
('000007', '3218291973381903', '28287188096166', 'Rian', 'L', 'Kuningan', '18-07-1978', 'Kosambi', 'BPJS'),
('000008', '3349021991771822', '-', 'Maulana', 'L', 'Lamongan', '19-03-1999', 'Pamelang', 'Umum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `id_pegawai` varchar(20) NOT NULL,
  `nama_pegawai` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `npwp` varchar(25) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` varchar(10) NOT NULL,
  `id_jabatan` int(2) NOT NULL,
  `id_bidang` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`id_pegawai`, `nama_pegawai`, `jenis_kelamin`, `npwp`, `tempat_lahir`, `tanggal_lahir`, `id_jabatan`, `id_bidang`) VALUES
('2838938338', 'Asop', 'Laki-Laki', '389389111834', 'Karawang', '14-07-1993', 2, 3),
('2838938393', 'Suhandi', 'Laki-Laki', '822872181136', 'Cipedesa', '12-03-1985', 1, 2),
('3838918917', 'Tati Herawati', 'Perempuan', '958593882899', 'Karawang', '13-03-1986', 2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penanganan_operasi`
--

CREATE TABLE `tbl_penanganan_operasi` (
  `id_penanganan` int(5) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `no_bpjs` varchar(20) NOT NULL,
  `status_pasien` varchar(10) NOT NULL,
  `nama_operasi` varchar(50) NOT NULL,
  `biaya` int(11) NOT NULL,
  `ditangani_oleh` enum('dokter','petugas','dokter dan petugas','') NOT NULL,
  `dibayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `keterangan` varchar(13) NOT NULL,
  `tgl_operasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_penanganan_operasi`
--

INSERT INTO `tbl_penanganan_operasi` (`id_penanganan`, `nama_pasien`, `no_bpjs`, `status_pasien`, `nama_operasi`, `biaya`, `ditangani_oleh`, `dibayar`, `kembalian`, `keterangan`, `tgl_operasi`) VALUES
(9, 'Fitri', 'Fitri', 'Umum', 'Pemeriksaan Polio', 80000, 'dokter', 100000, 20000, 'Berbayar', '24-07-2018'),
(10, 'Oman', 'Oman', 'Umum', 'Pemeriksaan Polio', 80000, 'dokter', 130000, 50000, 'Berbayar', '26-07-2018'),
(11, 'Niko Rahmad', 'Niko Rahmad', 'Umum', 'Pemeriksaan Katarak', 75000, 'dokter', 100000, 25000, 'Berbayar', '26-07-2018'),
(12, 'Diana', 'Diana', 'BPJS', 'Pemeriksaan Katarak', 0, 'dokter', 0, 0, 'Gratis', '26-07-2018'),
(13, 'Muhammad Yogi', 'Muhammad Yogi', 'Umum', 'Pemeriksaan Polio', 80000, 'dokter', 100000, 20000, 'Berbayar', '26-07-2018'),
(14, 'Mehmet', 'Mehmet', 'BPJS', 'Luka Jahit', 0, 'dokter', 0, 0, 'Gratis', '26-07-2018');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pendaftaran`
--

CREATE TABLE `tbl_pendaftaran` (
  `no_registrasi` varchar(4) NOT NULL,
  `no_rawat` varchar(18) NOT NULL,
  `no_rekamedis` varchar(6) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `kode_dokter_penanggung_jawab` varchar(4) NOT NULL,
  `id_poli` varchar(2) NOT NULL,
  `nama_penanggung_jawab` varchar(30) NOT NULL,
  `hubungan_dengan_penanggung_jawab` varchar(30) NOT NULL,
  `alamat_penanggung_jawab` text NOT NULL,
  `status_pasien` varchar(10) NOT NULL,
  `no_bpjs` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pendaftaran`
--

INSERT INTO `tbl_pendaftaran` (`no_registrasi`, `no_rawat`, `no_rekamedis`, `tanggal_daftar`, `kode_dokter_penanggung_jawab`, `id_poli`, `nama_penanggung_jawab`, `hubungan_dengan_penanggung_jawab`, `alamat_penanggung_jawab`, `status_pasien`, `no_bpjs`) VALUES
('0001', '2018-07-27-0001', '000002', '2018-07-27', 'S-23', '1', 'Suarez', 'Orang Tua', 'Barcelona', 'Umum', '-'),
('0002', '2018-07-27-0002', '000004', '2018-07-27', 'K-12', '2', 'Michelle', 'Saudara Kandung', 'Adiarsa', 'BPJS', '28287188196139'),
('0001', '2018-07-30-0001', '000005', '2018-07-30', 'K-12', '4', 'Arif', 'Saudara Kandung', 'Teljam', 'BPJS', '28287188196145'),
('0001', '2020-07-07-0001', '000008', '2020-07-07', 'K-12', '2', 'Joko', 'Orang Tua', 'Cengkareng', 'Umum', '-'),
('0001', '2020-07-08-0001', '000003', '2020-07-08', 'K-12', '2', 'Johannes', 'Orang Tua', 'Kalideres', 'Umum', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengadaan_obat`
--

CREATE TABLE `tbl_pengadaan_obat` (
  `id_pengadaan` varchar(6) NOT NULL,
  `no_trans` varchar(15) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `kode_obat` varchar(5) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `jenis_obat` varchar(50) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `satuan` varchar(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `tgl_transaksi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pengadaan_obat`
--

INSERT INTO `tbl_pengadaan_obat` (`id_pengadaan`, `no_trans`, `supplier`, `kode_obat`, `nama_obat`, `jenis_obat`, `harga_beli`, `jumlah`, `satuan`, `keterangan`, `total`, `tgl_transaksi`) VALUES
('0002', 'B-180621-0002', 'Bentoman', 'A-989', 'Salicyl', 'Bedak', 320000, 3, 'Buah', 'ok', 960000, '21-06-2018'),
('0001', 'B-180623-0001', 'Novita', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 679000, 5, 'Botol', 'ok', 3395000, '23-06-2018'),
('0001', 'B-180624-0001', 'Novita', 'SN-11', 'Alpara', 'Tablet', 565000, 20, 'Strip', 'ok', 11300000, '24-06-2018'),
('0004', 'B-180624-0004', 'Novita', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 1230000, 25, 'Botol', 'ok', 30750000, '24-06-2018'),
('0001', 'B-180706-0001', 'Novita', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 479000, 3, 'Botol', 'ok', 1437000, '06-07-2018'),
('0001', 'B-180710-0001', 'Saomanz', 'SN-11', 'Alpara', 'Tablet', 190000, 190, 'Botol', 'ok', 36100000, '10-07-2018'),
('0001', 'B-180717-0001', 'Novita', 'D-118', 'Dextrane', 'Tablet', 3450, 2000, 'Strip', 'Ok', 6900000, '17-07-2018'),
('0001', 'B-180726-0001', 'Bentoman', 'P-332', 'PoliSaxechon', 'Cairan Alkohol', 50000, 4, 'Botol', 'ok', 200000, '26-07-2018'),
('0001', 'B-200707-0001', 'Novita', '', 'Alpara', '', 5000, 3, 'Tablet', 'Obat Sakit Kepala', 15000, '07-07-2020');

--
-- Trigger `tbl_pengadaan_obat`
--
DELIMITER $$
CREATE TRIGGER `pengadaan_obat` AFTER INSERT ON `tbl_pengadaan_obat` FOR EACH ROW BEGIN
INSERT into tbl_stok_obat SET
kode_obat = NEW.kode_obat, jumlah = New.jumlah
ON DUPLICATE KEY UPDATE jumlah=jumlah+New.jumlah;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengeluaran_obat`
--

CREATE TABLE `tbl_pengeluaran_obat` (
  `id_pengeluaran` varchar(6) NOT NULL,
  `no_terima_obat` char(15) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `kode_obat` varchar(5) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `jenis_obat` varchar(50) NOT NULL,
  `dosis_aturan_obat` varchar(50) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `satuan` varchar(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `tgl_serah_obat` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pengeluaran_obat`
--

INSERT INTO `tbl_pengeluaran_obat` (`id_pengeluaran`, `no_terima_obat`, `nama_pasien`, `kode_obat`, `nama_obat`, `jenis_obat`, `dosis_aturan_obat`, `jumlah`, `satuan`, `keterangan`, `tgl_serah_obat`) VALUES
('0001', 'S-180620-0001', 'Oman', 'K-198', 'Paracetamol', 'Tablet', '3 x 1 Sehari Setelah Makan', 5, 'Strip', 'ok', '20-06-2018'),
('0002', 'S-180620-0002', 'Niko Rahmad', 'A-989', 'Salicyl', 'Bedak', '3 x 1 sehari', 1, 'Buah', 'ok', '20-06-2018'),
('0001', 'S-180621-0001', 'Niko Rahmad', 'A-989', 'Salicyl', 'Bedak', '3 x 1 sehari', 4, 'Buah', 'an', '21-06-2018'),
('0002', 'S-180621-0002', 'Oman', 'K-198', 'Paracetamol', 'Tablet', '3 x 1 Sehari Setelah Makan', 2, 'Strip', 'ad', '21-06-2018'),
('0001', 'S-180624-0001', 'Muhammad Yogi', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 3, 'Botol', 'ok', '24-06-2018'),
('0002', 'S-180624-0002', 'Oman', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 3, 'Botol', 'ok', '24-06-2018'),
('0001', 'S-180630-0001', 'Niko Rahmad', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 1, 'Botol', 'ok', '30-06-2018'),
('0001', 'S-180710-0001', 'Diana', 'SD-65', 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 2, 'Botol', 'ok', '10-07-2018'),
('0001', 'S-200707-0001', 'Maulana', 'SN-11', 'Alpara', 'Kapsul', '3x1 Sehari', 3, 'Strip', 'Obat Sakit Kepala', '07-07-2020');

--
-- Trigger `tbl_pengeluaran_obat`
--
DELIMITER $$
CREATE TRIGGER `pengeluaran_obat` AFTER INSERT ON `tbl_pengeluaran_obat` FOR EACH ROW BEGIN
UPDATE tbl_stok_obat
SET jumlah = jumlah - new.jumlah
WHERE kode_obat= new.kode_obat;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_poli`
--

CREATE TABLE `tbl_poli` (
  `id_poli` int(2) NOT NULL,
  `nama_poli` varchar(40) NOT NULL,
  `ruang_poli` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_poli`
--

INSERT INTO `tbl_poli` (`id_poli`, `nama_poli`, `ruang_poli`) VALUES
(1, 'POLI GIGI', 'RUANG POLI GIGI'),
(2, 'POLI UMUM', 'RUANG POLI UMUM'),
(4, 'POLI KIA', 'RUANG POLI KIA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_resep_obat`
--

CREATE TABLE `tbl_resep_obat` (
  `kode_resep` int(4) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `jenis_obat` varchar(50) NOT NULL,
  `dosis_aturan_obat` varchar(40) NOT NULL,
  `jumlah_obat` int(2) NOT NULL,
  `no_rawat` varchar(18) NOT NULL,
  `no_rekamedis` varchar(6) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_resep_obat`
--

INSERT INTO `tbl_resep_obat` (`kode_resep`, `nama_obat`, `jenis_obat`, `dosis_aturan_obat`, `jumlah_obat`, `no_rawat`, `no_rekamedis`, `tanggal`) VALUES
(1, 'Salicyl', 'Bedak', '3 x 1 sehari', 2, '2018/06/24/0001', '000002', '2018-06-24'),
(2, 'Salicyl', 'Bedak', '3 x 1 sehari', 4, '2018/06/24/0001', '000002', '2018-06-24'),
(3, 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 1, '2018/06/25/0001', '000002', '2018-06-25'),
(4, 'Alpara', 'Tablet', '3x1 Sehari', 1, '2018/06/30/0001', '000002', '2018-06-30'),
(5, 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 2, '2018/07/03/0001', '000003', '2018-07-03'),
(6, 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 1, '2018/07/04/0001', '000003', '2018-07-04'),
(7, 'Alpara', 'Tablet', '3x1 Sehari', 1, '2018/07/06/0002', '000003', '2018-07-06'),
(8, 'Polivanol', 'Obat Tetes Luka', 'Setiap pakai 50 ml', 1, '2018-07-14-0001', '000001', '2018-07-14'),
(9, 'Anexsamol', 'Kapsul', '2x1 Sehari', 1, '2018-07-17-0002', '000003', '2018-07-17'),
(10, 'Alpara', 'Cair', '1x24 jam', 3, '2020-07-07-0001', '000008', '2020-07-07'),
(11, 'Alpara', 'Kapsul', '3x1 Sehari', 3, '2020-07-07-0001', '000008', '2020-07-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_riwayat_tindakan`
--

CREATE TABLE `tbl_riwayat_tindakan` (
  `id_riwayat_tindakan` int(11) NOT NULL,
  `id_poli` varchar(2) NOT NULL,
  `kode_penyakit` varchar(6) NOT NULL,
  `kode_tindakan` varchar(6) NOT NULL,
  `no_rawat` varchar(18) NOT NULL,
  `hasil_periksa` varchar(100) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `no_rekamedis` varchar(6) NOT NULL,
  `tanggal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_riwayat_tindakan`
--

INSERT INTO `tbl_riwayat_tindakan` (`id_riwayat_tindakan`, `id_poli`, `kode_penyakit`, `kode_tindakan`, `no_rawat`, `hasil_periksa`, `nama_obat`, `no_rekamedis`, `tanggal`) VALUES
(31, '2', 'HB-39', 'K-9892', '2018-07-17-0001', 'Hidung Mimisan', 'Dextrane', '000005', '17-07-2018'),
(33, '2', 'S-9956', 'K-2882', '2018-07-17-0001', 'Pendarahan Di Area Kirarawit', 'Polivanol', '000005', '17-07-2018'),
(34, '1', 'Gg-39', 'P-1912', '2018-07-17-0002', 'Sedikit Gigi Berlubang', 'Anexsamol', '000003', '17-07-2018'),
(35, '2', 'Kt-18', 'K-2882', '2020-07-07-0001', 'Kulit', 'Bodrex', '000008', '07-07-2020');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_rujukan`
--

CREATE TABLE `tbl_rujukan` (
  `kode_rujukan` varchar(11) NOT NULL,
  `no_rujukan` varchar(18) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `nama_penyakit` varchar(30) NOT NULL,
  `diagnosa` varchar(50) NOT NULL,
  `nama_rumah_sakit` varchar(40) NOT NULL,
  `poli_tujuan` varchar(25) NOT NULL,
  `tgl_rujukan` varchar(10) NOT NULL,
  `no_rawat` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_rujukan`
--

INSERT INTO `tbl_rujukan` (`kode_rujukan`, `no_rujukan`, `nama_pasien`, `nama_penyakit`, `diagnosa`, `nama_rumah_sakit`, `poli_tujuan`, `tgl_rujukan`, `no_rawat`) VALUES
('0001', 'R-20180621-0001', 'Niko Rahmad', 'Cacar', 'cacar ganas', 'RSUD Palembang', 'Poli Kulit', '2018-06-21', '2018/06/21/0002'),
('0001', 'R-20180623-0001', 'Muhammad Yogi', 'Diabetes', 'Kencing Manis', 'RS.Bayukarta', 'Poli Dalam', '2018-06-23', '2018/06/23/0001'),
('0001', 'R-20180625-0001', 'Oman', 'Diabetes', 'Mengalami Sedikit Penghambatan', 'RSUD Tembilahan ', 'Poli Saraf', '2018-06-25', '2018/06/25/0001'),
('0001', 'R-20180630-0001', 'Oman', 'Cacar', 'Bintik-Bintik Merah', 'RS Bayukarta', 'Poli Kulit', '2018-06-30', '2018/06/30/0001'),
('0001', 'R-20180706-0001', 'Muhammad Yogi', 'Cacar', 'Sakit Berdarah', 'RSUD Karawang', 'Poli Kulit', '2018-07-06', '2018/07/06/0002'),
('0001', 'R-20180714-0001', 'Niko Rahmad', 'Hidung Bengkak', 'Hidung Berdarah', 'RSUD Semarang', 'Poli Saraf', '2018-07-14', '2018-07-14-0001'),
('0001', 'R-20180717-0001', 'Muhammad Yogi', 'Gigi Berlubang', 'Pendarahan Di Gigi', 'RSUD Bandung', 'Poli Gigi', '2018-07-17', '2018-07-17-0002'),
('0001', 'R-20200707-0001', 'Maulana', 'Panoan', 'Sakit Kepala', 'Hermina', 'POLI UMUM', '2020-07-07', '2020-07-07-0001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id_setting` int(11) NOT NULL,
  `nama_setting` varchar(50) NOT NULL,
  `value` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id_setting`, `nama_setting`, `value`) VALUES
(1, 'Tampil Menu', 'ya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_stok_obat`
--

CREATE TABLE `tbl_stok_obat` (
  `kode_obat` varchar(5) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_stok_obat`
--

INSERT INTO `tbl_stok_obat` (`kode_obat`, `jumlah`, `satuan`) VALUES
('A-989', 22, 'Buah'),
('D-118', 2000, 'Strip'),
('SD-65', 24, 'Botol'),
('SN-11', 210, 'Strip'),
('P-332', 4, ''),
('', 6, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `kode_supplier` varchar(6) NOT NULL,
  `nama_supplier` varchar(60) NOT NULL,
  `alamat` text NOT NULL,
  `no_telpon` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `no_telpon`) VALUES
('AW-189', 'Novita', 'Perum Pemda', '082872878219'),
('B-2827', 'Bentoman', 'Johar', '0828728726');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_tindakan`
--

CREATE TABLE `tbl_tindakan` (
  `kode_tindakan` varchar(6) NOT NULL,
  `nama_tindakan` varchar(30) NOT NULL,
  `tindakan_oleh` enum('dokter','petugas','dokter_dan_petugas','') NOT NULL,
  `id_poliklinik` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_tindakan`
--

INSERT INTO `tbl_tindakan` (`kode_tindakan`, `nama_tindakan`, `tindakan_oleh`, `id_poliklinik`) VALUES
('K-0016', 'Periksa Mata', 'dokter', 2),
('K-2882', 'Periksa Kulit', 'dokter', 2),
('K-9892', 'Periksa Hidung', 'dokter_dan_petugas', 2),
('P-1912', 'Pemeriksaan Gigi', 'dokter', 1),
('P-3831', 'Periksa Mulut', 'dokter', 2),
('P-8392', 'Periksa Suhu', 'dokter', 2),
('PG-39', 'Pemberian MP-ASI', 'petugas', 2),
('PG-48', 'Penanggulangan GAKY', 'dokter_dan_petugas', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_users` int(2) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `id_user_level` int(11) NOT NULL,
  `is_aktif` enum('y','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_users`, `full_name`, `email`, `password`, `images`, `id_user_level`, `is_aktif`) VALUES
(6, 'admin', 'admin.puskesmas@gmail.com', '$2y$04$IhTaAEVp51NVhMPeAiOeZOrT.6ViccXtycqDBY1sGb3hUBYG7itsS', 'diponegoro1.png', 1, 'y'),
(8, 'Karnadi', 'karnadi@gmail.com', '$2y$04$C4EzhzhS/wIouhHdOs58deBLlnrl9l3I7EIIqQDKE2Tb2y5kJBuUC', '', 4, 'y'),
(9, 'Maulida', 'maulida@gmail.com', '$2y$04$vnJs3xrgxSC3qCU7qJCJ4.xqJXw.ZpAr67I37wG1F8T1XGdOjfSse', '', 3, 'y'),
(10, 'Dendi', 'dendi@gmail.com', '$2y$04$FDFXrutFFaOjyaFvo30efu5CrUy0Ou3rci.E4f.cDUlNPrOWAGaGe', '', 5, 'y'),
(11, 'Popon', 'popon@gmail.com', '$2y$04$K8fYN.G3WhbHQ7FE5scfHuJXCFwt71Io74Iyj1gsspSv9LRdlJAai', 'Ki_Hajar_Dewantara1.png', 5, 'y'),
(12, 'Tatang', 'tatang@gmail.com', '$2y$04$HTUtgwJ6tXlzFA9o9TYL.erXzyaLg/Ow5xgY/Ze.GNzO27X07Fluu', '', 4, 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_level`
--

CREATE TABLE `tbl_user_level` (
  `id_user_level` int(2) NOT NULL,
  `nama_level` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user_level`
--

INSERT INTO `tbl_user_level` (`id_user_level`, `nama_level`) VALUES
(1, 'Admin'),
(3, 'Dokter'),
(4, 'Apotek'),
(5, 'Pendaftaran');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indeks untuk tabel `tbl_diagnosa_penyakit`
--
ALTER TABLE `tbl_diagnosa_penyakit`
  ADD PRIMARY KEY (`kode_diagnosa`);

--
-- Indeks untuk tabel `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  ADD PRIMARY KEY (`kode_dokter`);

--
-- Indeks untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `tbl_jadwal_praktek_dokter`
--
ALTER TABLE `tbl_jadwal_praktek_dokter`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `tbl_laboratorium`
--
ALTER TABLE `tbl_laboratorium`
  ADD PRIMARY KEY (`id_lab`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`kode_obat`);

--
-- Indeks untuk tabel `tbl_operasi`
--
ALTER TABLE `tbl_operasi`
  ADD PRIMARY KEY (`kode_operasi`);

--
-- Indeks untuk tabel `tbl_paramedis`
--
ALTER TABLE `tbl_paramedis`
  ADD PRIMARY KEY (`kode_paramedis`),
  ADD KEY `id_spesialis` (`id_poli`);

--
-- Indeks untuk tabel `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  ADD PRIMARY KEY (`no_rekamedis`);

--
-- Indeks untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_bidang` (`id_bidang`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `tbl_penanganan_operasi`
--
ALTER TABLE `tbl_penanganan_operasi`
  ADD PRIMARY KEY (`id_penanganan`);

--
-- Indeks untuk tabel `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD PRIMARY KEY (`no_rawat`);

--
-- Indeks untuk tabel `tbl_pengadaan_obat`
--
ALTER TABLE `tbl_pengadaan_obat`
  ADD PRIMARY KEY (`no_trans`);

--
-- Indeks untuk tabel `tbl_pengeluaran_obat`
--
ALTER TABLE `tbl_pengeluaran_obat`
  ADD PRIMARY KEY (`no_terima_obat`);

--
-- Indeks untuk tabel `tbl_poli`
--
ALTER TABLE `tbl_poli`
  ADD PRIMARY KEY (`id_poli`);

--
-- Indeks untuk tabel `tbl_resep_obat`
--
ALTER TABLE `tbl_resep_obat`
  ADD PRIMARY KEY (`kode_resep`);

--
-- Indeks untuk tabel `tbl_riwayat_tindakan`
--
ALTER TABLE `tbl_riwayat_tindakan`
  ADD PRIMARY KEY (`id_riwayat_tindakan`);

--
-- Indeks untuk tabel `tbl_rujukan`
--
ALTER TABLE `tbl_rujukan`
  ADD PRIMARY KEY (`no_rujukan`);

--
-- Indeks untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `tbl_stok_obat`
--
ALTER TABLE `tbl_stok_obat`
  ADD PRIMARY KEY (`kode_obat`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indeks untuk tabel `tbl_tindakan`
--
ALTER TABLE `tbl_tindakan`
  ADD PRIMARY KEY (`kode_tindakan`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_users`);

--
-- Indeks untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  ADD PRIMARY KEY (`id_user_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  MODIFY `id_bidang` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id_jabatan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_jadwal_praktek_dokter`
--
ALTER TABLE `tbl_jadwal_praktek_dokter`
  MODIFY `id_jadwal` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_laboratorium`
--
ALTER TABLE `tbl_laboratorium`
  MODIFY `id_lab` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `tbl_penanganan_operasi`
--
ALTER TABLE `tbl_penanganan_operasi`
  MODIFY `id_penanganan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_poli`
--
ALTER TABLE `tbl_poli`
  MODIFY `id_poli` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_resep_obat`
--
ALTER TABLE `tbl_resep_obat`
  MODIFY `kode_resep` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_riwayat_tindakan`
--
ALTER TABLE `tbl_riwayat_tindakan`
  MODIFY `id_riwayat_tindakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_users` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  MODIFY `id_user_level` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
