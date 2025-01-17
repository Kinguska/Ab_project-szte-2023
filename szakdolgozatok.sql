-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Nov 25. 18:06
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozatok`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `adminisztrátor`
--

CREATE TABLE `adminisztrátor` (
  `egyetemi azonosító` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `adminisztrátor`
--

INSERT INTO `adminisztrátor` (`egyetemi azonosító`) VALUES
('ADD'),
('ADDM'),
('ADM'),
('ADM434'),
('ART');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hallgató`
--

CREATE TABLE `hallgató` (
  `egyetemi azonosító` varchar(10) NOT NULL,
  `jogviszony` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `hallgató`
--

INSERT INTO `hallgató` (`egyetemi azonosító`, `jogviszony`) VALUES
('ABC123', 'aktív'),
('ÁLTJ', 'passzív'),
('DBER23', 'passzív'),
('ÉLK6TF', 'passzív'),
('FE3RT', 'aktív'),
('GE34DE', 'aktív'),
('GRTE', 'passzív'),
('HEM567', 'passzív'),
('IZT6ZK', 'aktív'),
('KRT456', 'aktív'),
('KRT4ED', 'aktív'),
('PRTEWQ', 'aktív'),
('Z5TG8H', 'aktív'),
('ZT56RT', 'aktív');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kar`
--

CREATE TABLE `kar` (
  `kar azonosító` varchar(20) NOT NULL,
  `kar neve` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `kar`
--

INSERT INTO `kar` (`kar azonosító`, `kar neve`) VALUES
('BTK', 'Bölcsészet- és Társadalomtudományi Kar'),
('JGYPK', 'Juhász Gyula Pedagógusképző Kar'),
('TTIK', 'Természettudományi és Informatikai Kar');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `képzése`
--

CREATE TABLE `képzése` (
  `szak azonosítója` varchar(20) NOT NULL,
  `egyetemi azonosító` varchar(10) NOT NULL,
  `kezdés szemesztere` varchar(10) DEFAULT NULL,
  `végzés szemesztere` varchar(10) DEFAULT NULL,
  `diploma sorszáma` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `képzése`
--

INSERT INTO `képzése` (`szak azonosítója`, `egyetemi azonosító`, `kezdés szemesztere`, `végzés szemesztere`, `diploma sorszáma`) VALUES
('AnyM', 'ABC123', '2019', NULL, NULL),
('BIO', 'DBER23', '', '', ''),
('BIO', 'ÉLK6TF', '2019/21/1', '', ''),
('BIO', 'PRTEWQ', '2014/15/1', '2017/18/1', 'FR48'),
('GI', 'KRT456', '2018/19/1', '2021/22/2', 'LK78'),
('GYP', 'ÁLTJ', '2020/21/1', '2023/24/1', 'E23T'),
('GYP', 'Z5TG8H', '2016/17/1', '2020/21/1', 'HJ91'),
('MA', 'FE3RT', '', '', ''),
('MA', 'GE34DE', '2020/21/1', '2023/24/1', 'GT54'),
('MA', 'PRTEWQ', '2017/18/1', '2019/20/2', 'VG21'),
('MGY', 'KRT4ED', '2016/17/1', '2018/19/1', 'HG56'),
('ÓP', 'ZT56RT', '2023/24/1', '', ''),
('PSZ', 'GRTE', '2020/21/1', '2023/24/1', 'ER34'),
('PSZ', 'HEM567', '2018/19/1', '2021/22/2', 'GET6'),
('PTI', 'ABC123', '2020', '', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szak`
--

CREATE TABLE `szak` (
  `szak azonosítója` varchar(20) NOT NULL,
  `kar azonosító` varchar(20) DEFAULT NULL,
  `szak neve` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szak`
--

INSERT INTO `szak` (`szak azonosítója`, `kar azonosító`, `szak neve`) VALUES
('AnyM', 'TTIK', 'Anyagmérnöki'),
('BIO', 'TTIK', 'Biológia'),
('Ed', 'JGYPK', 'Edző'),
('GI', 'TTIK', 'Gazdaságinformatikus'),
('GYP', 'JGYPK', 'Gyógypedagógia'),
('INFK', 'BTK', 'Informatikus könyvtáros'),
('MA', 'TTIK', 'Matematika'),
('MGY', 'BTK', 'Magyar'),
('MI', 'TTIK', 'Mérnökinformatikus'),
('ÓP', 'JGYPK', 'Óvodapedagógus'),
('PE', 'BTK', 'Pedagógia'),
('PSZ', 'BTK', 'Pszichológia'),
('PTI', 'TTIK', 'Programtervező Informatikus'),
('TA', 'JGYPK', 'Tanító');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szakdolgozat`
--

CREATE TABLE `szakdolgozat` (
  `dolgozat azonosítója` varchar(20) NOT NULL,
  `dolgozat címe` varchar(100) NOT NULL,
  `tanszék` varchar(100) DEFAULT NULL,
  `beadás éve` int(4) DEFAULT NULL,
  `védés éve` int(4) DEFAULT NULL,
  `védés érdemjegye` int(1) DEFAULT NULL,
  `egyetemi azonosító` varchar(10) DEFAULT NULL,
  `szak azonosítója` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szakdolgozat`
--

INSERT INTO `szakdolgozat` (`dolgozat azonosítója`, `dolgozat címe`, `tanszék`, `beadás éve`, `védés éve`, `védés érdemjegye`, `egyetemi azonosító`, `szak azonosítója`) VALUES
('cfgr', 'Számoló számok', 'Algebra és Számelmélet Tanszék', 2023, NULL, NULL, 'KRT4ED', 'MA'),
('ebt', 'Az ebek eredete 2', 'Genetikai Tanszék', 2021, 2021, 4, 'ABC123', 'BIO'),
('ezt', 'A nyelvtani szabályok lázadása', 'Magyar Nyelvészeti Tanszék', 2012, 2013, 5, 'ABC123', 'MGY'),
('gaeve', 'Animált napok', 'Képfeldolgozás és Számítógépes Grafika Tanszék', 2020, 2020, 4, 'HEM567', 'MI'),
('gewq', 'Számolj optimálisan', 'Számítógépes Optimalizálás Tanszék', 2023, 2023, 3, 'ÁLTJ', 'MI'),
('grtuns', 'Optimális opkut', 'Számítógépes Optimalizálás Tanszék', 2023, 2023, 4, 'GRTE', 'PTI'),
('hdget', 'A kéz dinamikája', 'Gyógypedagógus-képző Tanszék', 2020, 2020, 4, 'Z5TG8H', 'GYP'),
('hdhd', 'Deutsch, DEUTSCH', 'Német és Német Nemzetiségi Tanszék', 2022, 2022, 5, 'HEM567', 'TA'),
('hsdgze', 'Élet az élet nélkül', 'Kognitív és Neuropszichológiai Tanszék', 2023, 2023, 2, 'GRTE', 'PSZ'),
('htre', 'Valami a valamiben', 'Magyar Nyelvészeti Tanszék', 2021, 2021, 3, 'IZT6ZK', 'MGY'),
('jtr23', 'Az analízis pszichológiája', 'Kognitív és Neuropszichológiai Tanszék', 2021, 2021, 3, 'ÁLTJ', 'PSZ'),
('retvg', 'Halmozott halmazok hatványa', 'Halmazelmélet és Matematikai Logika Tanszék', 2019, 2020, 4, 'PRTEWQ', 'MA'),
('rsacd', 'A korán kelés hatása', 'Embertani Tanszék', 2017, 2017, 5, 'PRTEWQ', 'BIO'),
('Scleroglucan', 'Sajtos medvesajt', 'Genetikai Tanszék', 2021, 2021, 2, 'FE3RT', 'MA'),
('szkt', 'Az elmélkedő számok', 'Algebra és Számelmélet Tanszék', 2022, 2023, 4, 'ABC123', 'MA'),
('tefds', 'Félelem nélküli mátrixok', 'Algebra és Számelmélet Tanszék', 2023, 2023, 5, 'GE34DE', 'MA'),
('terji', 'VGEB jsebfjzka', 'Képfeldolgozás és Számítógépes Grafika Tanszék', NULL, NULL, NULL, 'ABC123', 'Ed'),
('tersv', 'Kultúrák az unokatesókkal', 'Osztrák Irodalom és Kultúra Tanszék', 2018, 2018, 2, 'KRT4ED', 'MGY'),
('trsgd', 'Pici, aranyos képecskék', 'Képfeldolgozás és Számítógépes Grafika Tanszék', 2021, 2022, 3, 'KRT456', 'GI'),
('tzte', 'A tészta program', 'Szoftverfejlesztés Tanszék', 2018, 2020, 4, 'IZT6ZK', 'PTI');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `személy`
--

CREATE TABLE `személy` (
  `egyetemi azonosító` varchar(10) NOT NULL,
  `név` varchar(40) NOT NULL,
  `előtag` varchar(10) DEFAULT NULL,
  `jelszó` varchar(100) NOT NULL,
  `munkaköri beosztás` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `személy`
--

INSERT INTO `személy` (`egyetemi azonosító`, `név`, `előtag`, `jelszó`, `munkaköri beosztás`) VALUES
('ABC123', 'Kiss Dani', '', '$2y$10$DHvvUT3vZ/P9rhgsQTDSaOCReXeJVCilXSjq9rahzfpsN7wbSjsEe', 'hallgató'),
('ADD', 'Kiss Sanyi', 'Dr.', '$2y$10$7pZoP2H5XNTlqMGOQOqja.ykutZEalt1gHHjtk.eJE9IgVn83L6dy', 'adminisztrátor'),
('ADDM', 'Add Adél', '', '$2y$10$3qnq4SCB9PM1SuTRzGJ0Y.LxLGvKhmLJQUoLX6y7767vQZH0ONIYG', 'adminisztrátor'),
('ADM', 'Armani Amanda', 'Dr.', '$2y$10$EWbvhVT9LQHIbZ8MI6PEUuu.Pnlg7aRMMvNPzjz8U656x2k4.e1/q', 'adminisztrátor'),
('ADM434', 'Allokált Angéla', 'Dr.', '$2y$10$qzsBMuCm7LAt4nT8YPX48ObGa/wlYzKGiTe.oIqQQ8g5bxU.7l/7K', 'adminisztrátor'),
('ÁLTJ', 'Általános Álmos', '', '$2y$10$R8h1dHeaoPKanalfEqmnLeEjH8Xg1C9XEOLx5yYrJqzE34869XciG', 'hallgató'),
('ART', 'Admin Addi', 'Dr.', '$2y$10$/agzxX/ne2dJPUvVRdCEHuDa/X0/Mm1pZSeDqnX3qoqxzZW8lBoj6', 'adminisztrátor'),
('CDI954', 'Cseles Csenge', 'sr.', '$2y$10$8mK2s7vuk7Caj3cDwm2vCO12f6IzESvxMmxismHUtFeHUQFeK9dx.', 'témavezető'),
('DBER23', 'Hajnali Somina', '', '$2y$10$0xel8e6xF.DaCDVm.JKztOs3rak9Vx2tachkqznjA6wHlbD0GSQd.', 'hallgató'),
('ÉLK6TF', 'Élet Telen', '', '$2y$10$QnaJY8yuzgM1rkP5.AhpQezDkKcB2lT2QgjD5KXJfaQ/VSeEsVXgC', 'hallgató'),
('FE3RT', 'Zámbó Dzsimi', 'jr.', '$2y$10$ESaXu1km7tEghodnLM88..Ghr4.yXZVzHp4QkXWnoeMnuqIwMRsyK', 'hallgató'),
('FRENC', 'Kőbányai Béluska', 'Dr.', '$2y$10$JoFcJkYmD4ZL86XpGgKo3ujH4kDGQnHpdSFGT2J6Qmyc3FK/e0L46', 'témavezető'),
('GE34DE', 'Gondos Gerta', '', '$2y$10$Gt7lb94kKGQDBkTtqzT2BOEp1MUfCObW2Gs4g5G3kJ9sXnaeeGGaC', 'hallgató'),
('GRTE', 'Kiss Dani', '', '$2y$10$QhFQdaajlWt.X/Yc/5aezOqFwhJkHGvKA6q5LFbMGPFYmkXjx6PWO', 'hallgató'),
('HEM567', 'Herle Gerle', '', '$2y$10$04Aj6b5lsFGO422ORN9zFOE1/XA3qaGrwizCefreNNoX38oP7OVhi', 'hallgató'),
('IZT6ZK', 'V K', '', '$2y$10$SNrrgyZ5FvCVBeW6zM.OLO11qGwdSWDnVXEYzA97bkJnsMTC/a86O', 'hallgató'),
('KHGRTD', 'Kellemes Kendra', 'Dr.', '$2y$10$3t2FTqjakI5b/1M0nLt/1edfmBD3XHEoQPeG5cc/QqTDPFU3uP8x.', 'témavezető'),
('KRT456', 'Kárász Karcsi', '', '$2y$10$jD/MJyqcyAfwbXHfmMtnheiSbT3lMvuyX1gKcrQ4kh1I/9mlHrpie', 'hallgató'),
('KRT4ED', 'Kertész Kelemen', '', '$2y$10$UDMDPToV0VJitASIJTkA/ucE0hz6ha6eEK9EqPEJLwcIgh/C4HLiu', 'hallgató'),
('LJK510', 'Lajtos Lajos', 'jr.', '$2y$10$3j/E9MKYT44lfMp89BPKWeB2GH0bacFTzasvY8rLt9Rbzh/uiDKwq', 'témavezető'),
('LK9246', 'Lehel Lea', '', '$2y$10$JfIj7he8xP9ybqWQMNraXepuECQ36IZjK0L.yfgP2xaxk0aSiN14m', 'témavezető'),
('ŐPLJH6', 'Őr Mezőcske', '', '$2y$10$yBQlIc60zSDTaeIjuHmSUOhOgtiaOZ3JLbRiYXFE5iHrLdVEIaKfa', 'témavezető'),
('PRTEWQ', 'Perem Petra', '', '$2y$10$3p5i8dEAFAHtL8bUtoWlc.fKBC65lkdX7hEV1B8ueyzhFXeQZt8iW', 'hallgató'),
('TMVZT', 'Téma Tomi', '', '$2y$10$ERucZP.Jdwx9kXqNbDgOVOjfUYsmu1TDwf2vVKxINaNZb/LyX1YlK', 'témavezető'),
('TMZTG', 'Latin Lajos', '', '$2y$10$kcELZPOUmVc4fsJeH2cIPO.UXtB6edWkPHiI3BP/hJBe0MMF6wCya', 'témavezető'),
('UJ7G54', 'Uwu Ulrik', 'sr.', '$2y$10$PasW18xHLkC8v7SoOmDYAe03190gqvSPcVBW8lP5mOklwGIWK/tIe', 'témavezető'),
('VB4FT', 'Zámbó Dzsimi', 'Dr.', '$2y$10$TQnirCIXVQu0Se2Wbz6IAerdE1j0aB68kBsk0HnUXSMnbFSu4VE.W', 'témavezető'),
('Z5TG8H', 'Tégla Ház', 'jr.', '$2y$10$t7ipBb4q0sOhdWlgbGdQAOIsnnTqWyZXoXpr3bxZexD2gas1yTeqa', 'hallgató'),
('ZT56RT', 'Zápor Eső', 'jr.', '$2y$10$M/C5asYze6rscb4S2X.5pOVOn6aqE05Ybbd/HQHQ1RwMxAGKQ5nIq', 'hallgató');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tanszék`
--

CREATE TABLE `tanszék` (
  `tanszék` varchar(100) NOT NULL,
  `intézet` varchar(100) NOT NULL,
  `kar azonosító` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `tanszék`
--

INSERT INTO `tanszék` (`tanszék`, `intézet`, `kar azonosító`) VALUES
('Algebra és Számelmélet Tanszék', 'Bolyai Intézet', 'TTIK'),
('Embertani Tanszék', 'Biológia Intézet', 'TTIK'),
('Ének-zene Tanszék', 'Művészeti Intézet', 'JGYPK'),
('Genetikai Tanszék', 'Biológia Intézet', 'TTIK'),
('Gyógypedagógus-képző Tanszék', 'Alkalmazott Pedagógiai Intézet', 'JGYPK'),
('Halmazelmélet és Matematikai Logika Tanszék', 'Bolyai Intézet', 'TTIK'),
('Képfeldolgozás és Számítógépes Grafika Tanszék', 'Informatikai Intézet', 'TTIK'),
('Kognitív és Neuropszichológiai Tanszék', 'Pszichológiai Intézet', 'BTK'),
('Magyar Irodalmi Tanszék', 'Magyar Nyelvi és Irodalmi Intézet', 'BTK'),
('Magyar Nyelvészeti Tanszék', 'Magyar Nyelvi és Irodalmi Intézet', 'BTK'),
('Német és Német Nemzetiségi Tanszék', 'Nemzetiségi Intézet', 'JGYPK'),
('Osztrák Irodalom és Kultúra Tanszék', 'Germán Filológiai Intézet', 'BTK'),
('Számítógépes Optimalizálás Tanszék', 'Informatikai Intézet', 'TTIK'),
('Szoftverfejlesztés Tanszék', 'Informatikai Intézet', 'TTIK'),
('Tanítóképző Tanszék', 'Alkalmazott Pedagógiai Intézet', 'JGYPK');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `téma`
--

CREATE TABLE `téma` (
  `egyetemi azonosító` varchar(10) NOT NULL,
  `dolgozat azonosítója` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `téma`
--

INSERT INTO `téma` (`egyetemi azonosító`, `dolgozat azonosítója`) VALUES
('CDI954', 'rsacd'),
('FRENC', 'ebt'),
('FRENC', 'ezt'),
('FRENC', 'htre'),
('FRENC', 'szkt'),
('FRENC', 'terji'),
('KHGRTD', 'gaeve'),
('KHGRTD', 'htre'),
('KHGRTD', 'trsgd'),
('LJK510', 'gewq'),
('LJK510', 'jtr23'),
('ŐPLJH6', 'grtuns'),
('ŐPLJH6', 'tefds'),
('TMVZT', 'hdget'),
('TMVZT', 'terji'),
('TMVZT', 'tersv'),
('TMZTG', 'htre'),
('UJ7G54', 'hdhd'),
('UJ7G54', 'hsdgze'),
('VB4FT', 'retvg'),
('VB4FT', 'Scleroglucan'),
('VB4FT', 'tzte');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `témavezető`
--

CREATE TABLE `témavezető` (
  `egyetemi azonosító` varchar(10) NOT NULL,
  `szerepkör` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `témavezető`
--

INSERT INTO `témavezető` (`egyetemi azonosító`, `szerepkör`) VALUES
('CDI954', 'külső'),
('FRENC', 'külső'),
('KHGRTD', 'belső'),
('LJK510', 'belső'),
('LK9246', 'külső'),
('ŐPLJH6', 'belső'),
('TMVZT', 'belső'),
('TMZTG', 'belső'),
('UJ7G54', 'belső'),
('VB4FT', 'belső');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `adminisztrátor`
--
ALTER TABLE `adminisztrátor`
  ADD PRIMARY KEY (`egyetemi azonosító`),
  ADD KEY `admin egyetemi azonosító` (`egyetemi azonosító`);

--
-- A tábla indexei `hallgató`
--
ALTER TABLE `hallgató`
  ADD PRIMARY KEY (`egyetemi azonosító`),
  ADD KEY `hallgatói egyetemi azonosító` (`egyetemi azonosító`);

--
-- A tábla indexei `kar`
--
ALTER TABLE `kar`
  ADD PRIMARY KEY (`kar azonosító`);

--
-- A tábla indexei `képzése`
--
ALTER TABLE `képzése`
  ADD PRIMARY KEY (`szak azonosítója`,`egyetemi azonosító`),
  ADD KEY `szak azonosító` (`szak azonosítója`),
  ADD KEY `hallgatói egyetemi azonosító` (`egyetemi azonosító`);

--
-- A tábla indexei `szak`
--
ALTER TABLE `szak`
  ADD PRIMARY KEY (`szak azonosítója`),
  ADD KEY `kar azonosító` (`kar azonosító`);

--
-- A tábla indexei `szakdolgozat`
--
ALTER TABLE `szakdolgozat`
  ADD PRIMARY KEY (`dolgozat azonosítója`),
  ADD KEY `tanszék neve` (`tanszék`),
  ADD KEY `hallgató egyetemi azonosító` (`egyetemi azonosító`),
  ADD KEY `szak azonositoja` (`szak azonosítója`);

--
-- A tábla indexei `személy`
--
ALTER TABLE `személy`
  ADD PRIMARY KEY (`egyetemi azonosító`);

--
-- A tábla indexei `tanszék`
--
ALTER TABLE `tanszék`
  ADD PRIMARY KEY (`tanszék`),
  ADD KEY `kar azonosító` (`kar azonosító`);

--
-- A tábla indexei `téma`
--
ALTER TABLE `téma`
  ADD PRIMARY KEY (`egyetemi azonosító`,`dolgozat azonosítója`),
  ADD KEY `témavezetői egyetemi azonosító` (`egyetemi azonosító`),
  ADD KEY `dolgozat azonosítója` (`dolgozat azonosítója`);

--
-- A tábla indexei `témavezető`
--
ALTER TABLE `témavezető`
  ADD PRIMARY KEY (`egyetemi azonosító`),
  ADD KEY `témavezetői egyetemi azonosító` (`egyetemi azonosító`);

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `adminisztrátor`
--
ALTER TABLE `adminisztrátor`
  ADD CONSTRAINT `adminisztrátor_ibfk_1` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `személy` (`egyetemi azonosító`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `hallgató`
--
ALTER TABLE `hallgató`
  ADD CONSTRAINT `hallgató_ibfk_1` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `személy` (`egyetemi azonosító`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `képzése`
--
ALTER TABLE `képzése`
  ADD CONSTRAINT `képzése_ibfk_2` FOREIGN KEY (`szak azonosítója`) REFERENCES `szak` (`szak azonosítója`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `képzése_ibfk_3` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `hallgató` (`egyetemi azonosító`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `szak`
--
ALTER TABLE `szak`
  ADD CONSTRAINT `szak_ibfk_1` FOREIGN KEY (`kar azonosító`) REFERENCES `kar` (`kar azonosító`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `szakdolgozat`
--
ALTER TABLE `szakdolgozat`
  ADD CONSTRAINT `szakdolgozat_ibfk_3` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `hallgató` (`egyetemi azonosító`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `szakdolgozat_ibfk_4` FOREIGN KEY (`szak azonosítója`) REFERENCES `szak` (`szak azonosítója`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `szakdolgozat_ibfk_5` FOREIGN KEY (`tanszék`) REFERENCES `tanszék` (`tanszék`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `tanszék`
--
ALTER TABLE `tanszék`
  ADD CONSTRAINT `tanszék_ibfk_1` FOREIGN KEY (`kar azonosító`) REFERENCES `kar` (`kar azonosító`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `téma`
--
ALTER TABLE `téma`
  ADD CONSTRAINT `téma_ibfk_2` FOREIGN KEY (`dolgozat azonosítója`) REFERENCES `szakdolgozat` (`dolgozat azonosítója`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `téma_ibfk_3` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `témavezető` (`egyetemi azonosító`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `témavezető`
--
ALTER TABLE `témavezető`
  ADD CONSTRAINT `témavezető_ibfk_1` FOREIGN KEY (`egyetemi azonosító`) REFERENCES `személy` (`egyetemi azonosító`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
