-- Anamakine: localhost
-- Üretim Zamanı: 16 Ara 2018, 13:30:18
-- Sunucu sürümü: 5.5.52-MariaDB
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `language`
--

INSERT INTO `language` (`id`, `name`) VALUES
(3, 'de'),
(2, 'en'),
(1, 'tr');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `localization`
--

CREATE TABLE `localization` (
  `id` int(11) NOT NULL,
  `localizationvalueid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL,
  `localizationkeyid` int(11) NOT NULL,
  `projectid` int(11) NOT NULL,
  `versionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `localization`
--

INSERT INTO `localization` (`id`, `localizationvalueid`, `languageid`, `localizationkeyid`, `projectid`, `versionid`, `userid`) VALUES
(12, 14, 1, 21, 17, 8, 1),
(14, 16, 1, 21, 17, 9, 1),
(15, 17, 2, 21, 17, 8, 1),
(16, 18, 1, 25, 17, 9, 1),
(17, 19, 1, 21, 20, 8, 1),
(21, 18, 1, 21, 20, 9, 1),
(22, 18, 1, 25, 20, 12, 1),
(23, 21, 1, 25, 17, 10, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `localizationkey`
--

CREATE TABLE `localizationkey` (
  `id` int(11) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `localizationkey`
--

INSERT INTO `localizationkey` (`id`, `value`) VALUES
(25, 'fist'),
(21, 'title');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `localizationvalue`
--

CREATE TABLE `localizationvalue` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `localizationvalue`
--

INSERT INTO `localizationvalue` (`id`, `value`) VALUES
(17, 'hi'),
(14, 'merhaba'),
(16, 'Merhabalar!'),
(19, 'Selam'),
(18, 'yumruk'),
(21, 'Yumruk!!');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `project`
--

INSERT INTO `project` (`id`, `value`) VALUES
(17, 'Project1'),
(20, 'Project2');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'test4', '202cb962ac59075b964b07152d234b70', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `version`
--

CREATE TABLE `version` (
  `id` int(11) NOT NULL,
  `revision` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `version`
--

INSERT INTO `version` (`id`, `revision`) VALUES
(8, 1),
(9, 1.01),
(10, 1.02),
(12, 2);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Tablo için indeksler `localization`
--
ALTER TABLE `localization`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projectid_languageid_localizationkeyid_versionid_ck` (`languageid`,`localizationkeyid`,`versionid`,`projectid`) USING BTREE;

--
-- Tablo için indeksler `localizationkey`
--
ALTER TABLE `localizationkey`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`value`);

--
-- Tablo için indeksler `localizationvalue`
--
ALTER TABLE `localizationvalue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Tablo için indeksler `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Tablo için indeksler `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `revision` (`revision`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `localization`
--
ALTER TABLE `localization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Tablo için AUTO_INCREMENT değeri `localizationkey`
--
ALTER TABLE `localizationkey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Tablo için AUTO_INCREMENT değeri `localizationvalue`
--
ALTER TABLE `localizationvalue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Tablo için AUTO_INCREMENT değeri `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `version`
--
ALTER TABLE `version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
