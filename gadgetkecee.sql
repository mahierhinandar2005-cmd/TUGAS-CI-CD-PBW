

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `imei` varchar(50) DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `imei`, `harga`) VALUES
(1, 'Redmi Note 4/64', '9888', '900000.00'),
(2, 'Samsung A14 4/128', '7766', '2100000.00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_nota`
--

CREATE TABLE `detail_nota` (
  `id_detail` int(11) NOT NULL,
  `no_nota` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_nota`
--

INSERT INTO `detail_nota` (`id_detail`, `no_nota`, `id_barang`, `harga`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, '900000.00', 1, '900000.00'),
(2, 2, 2, '2100000.00', 1, '2100000.00');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `no_nota` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `total` decimal(15,2) DEFAULT 0.00,
  `id_petugas` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`no_nota`, `tanggal`, `total`, `id_petugas`, `id_pelanggan`) VALUES
(1, '2026-02-18', '900000.00', 1, 1),
(2, '2026-02-18', '2100000.00', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_telepon`, `alamat`) VALUES
(1, 'Budi', '08987654321', 'Surabaya'),
(2, 'Rina', '08771234567', 'Yogyakarta');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `hp_petugas` varchar(20) DEFAULT NULL,
  `alamat_petugas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `hp_petugas`, `alamat_petugas`) VALUES
(1, 'Andi', '08123456789', 'Jakarta'),
(2, 'Siti', '08234567890', 'Bandung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `detail_nota`
--
ALTER TABLE `detail_nota`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `no_nota` (`no_nota`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`no_nota`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_nota`
--
ALTER TABLE `detail_nota`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `no_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_nota`
--
ALTER TABLE `detail_nota`
  ADD CONSTRAINT `detail_nota_ibfk_1` FOREIGN KEY (`no_nota`) REFERENCES `nota` (`no_nota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_nota_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON UPDATE CASCADE;

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

