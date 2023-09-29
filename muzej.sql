-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 12:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `muzej`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AžurirajEksponateNakonIstekaVremena` ()   BEGIN
    DECLARE isteklo INT DEFAULT 0;
    DECLARE id_dogadjaja INT;

    -- Pronađi događaje koji su istekli
    DECLARE dogadjaj_cursor CURSOR FOR
        SELECT id_dogadjaja
        FROM dogadjaj
        WHERE TRAJANJE_DOGADJAJA < NOW();

    -- Uzmi prvi istekli događaj
    OPEN dogadjaj_cursor;
    FETCH dogadjaj_cursor INTO id_dogadjaja;

    -- Ako ima isteklih događaja, ažuriraj eksponate
    WHILE id_dogadjaja IS NOT NULL DO
        -- Ažuriraj eksponate koji su povezani sa isteklim događajem
        UPDATE eksponati
        SET id_dogadjaja = NULL
        WHERE id_dogadjaja = id_dogadjaja;

        -- Označi da je bar jedan događaj istekao
        SET isteklo = 1;

        -- Uzmi sledeći istekli događaj
        FETCH dogadjaj_cursor INTO id_dogadjaja;
    END WHILE;

    -- Zatvori kursor
    CLOSE dogadjaj_cursor;

    -- Ako je bar jedan događaj istekao, ispiši poruku
    IF isteklo = 1 THEN
        SELECT 'Ažuriranje uspešno.';
    ELSE
        SELECT 'Nema isteklih događaja za ažuriranje.';
        SELECT TRAJANJE_DOGADJAJA FROM dogadjaj;
SELECT NOW();
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PREDHODNO` ()   BEGIN
DELETE FROM predhodne_vrednosti where id_eksponata in (select id_eksponata from eksponati where id_izlozbe is not null);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UporediDvaDatuma` (IN `datum1` DATETIME, IN `datum2` DATETIME, OUT `rezultat` VARCHAR(100))   BEGIN
    IF datum1 < datum2 THEN
        SET rezultat = 'Prvi datum je manji od drugog datuma.';
    ELSEIF datum1 > datum2 THEN
        SET rezultat = 'Prvi datum je veći od drugog datuma.';
    ELSE
        SET rezultat = 'Prvi datum je jednak drugom datumu.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VratiEksponateNakonIstekaVremena` ()   BEGIN
    DECLARE v_trenutno_vreme DATETIME;
    SET v_trenutno_vreme = NOW();
    
    UPDATE eksponati e
    SET e.id_dogadjaja = NULL, e.id_izlozbe=(select id_izlozbe from predhodne_vrednosti where id_eksponata=e.id_eksponata)
    WHERE e.id_dogadjaja IN (SELECT ID_DOGADJAJA FROM DOGADJAJ WHERE TRAJANJE_DOGADJAJA < v_trenutno_vreme);
DELETE FROM predhodne_vrednosti where id_eksponata in (select id_eksponata from eksponati where id_izlozbe is not null);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VratiEksponateNakonIstekaVremena5` ()   BEGIN
    DECLARE v_trenutno_vreme INT;
    SET v_trenutno_vreme = UNIX_TIMESTAMP(NOW());
    UPDATE eksponati e
    JOIN dogadjaj d ON e.id_dogadjaja = d.id_dogadjaja
    SET e.id_dogadjaja = NULL
    WHERE d.TRAJANJE_DOGADJAJA < v_trenutno_vreme;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dogadjaj`
--

CREATE TABLE `dogadjaj` (
  `ID_DOGADJAJA` int(11) NOT NULL,
  `NAZIV_DOGADJAJA` varchar(50) NOT NULL,
  `VREME_DOGADJAJA` datetime NOT NULL,
  `TRAJANJE_DOGADJAJA` datetime NOT NULL,
  `LOKACIJA_DOGADJAJA` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dogadjaj`
--

INSERT INTO `dogadjaj` (`ID_DOGADJAJA`, `NAZIV_DOGADJAJA`, `VREME_DOGADJAJA`, `TRAJANJE_DOGADJAJA`, `LOKACIJA_DOGADJAJA`) VALUES
(73, 'DD', '2023-09-03 00:06:00', '2023-09-21 17:07:00', 'DD'),
(81, 'Dogadjaj Srpske istoruje', '2023-09-09 12:36:00', '2023-09-09 16:34:00', 'Beograd'),
(82, 'provera', '2023-09-09 19:31:00', '2023-09-09 19:36:00', 'Beograd'),
(83, 'provera', '2023-09-09 20:42:00', '2023-09-09 20:44:00', 'Beograd'),
(84, 'Istorija Srbije', '2023-09-20 22:38:00', '2023-09-29 14:46:00', 'Vinča'),
(85, 'Aleksandar', '2023-09-22 00:51:00', '2023-09-27 03:48:00', 'apatin');

-- --------------------------------------------------------

--
-- Table structure for table `eksponati`
--

CREATE TABLE `eksponati` (
  `ID_EKSPONATA` int(11) NOT NULL,
  `ID_LOKACIJE` int(11) NOT NULL,
  `NAZIV_EKSPONATA` varchar(50) NOT NULL,
  `IMG_EKSPONATA` varchar(50) NOT NULL,
  `ID_IZLOZBE` int(11) DEFAULT NULL,
  `OPIS_EKSPONATA` varchar(500) NOT NULL,
  `id_dogadjaja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eksponati`
--

INSERT INTO `eksponati` (`ID_EKSPONATA`, `ID_LOKACIJE`, `NAZIV_EKSPONATA`, `IMG_EKSPONATA`, `ID_IZLOZBE`, `OPIS_EKSPONATA`, `id_dogadjaja`) VALUES
(22, 3, 'Bronzana statua', 'img/eksponati/bronzanastatua.jpg', NULL, '', 84),
(23, 2, 'Srednjovekovni mač', 'img/eksponati/srednjovekovnimarymac.jpg', NULL, '', 84),
(24, 3, 'Kameni reljef', 'img/eksponati/kamenireljef.jpg', 17, 'Kamene reljefe možemo smatrati jednim od najlepših i najintrigantnijih oblika umetničkog izraza koji se koristi već hiljadama godina. Reljef je skulptorska tehnika koja se koristi za izražavanje slika i priča na ravnoj površini, obično na kamenu, drvetu ili drugim materijalima. Statua kameni reljef može biti posebno impresivna i značajna jer kombinuje elemente skulpture i slikarstva.', NULL),
(25, 3, 'Antički amfora', 'img/eksponati/antickiamfora.jpg', NULL, '', 84),
(26, 2, 'Grčki vazan', 'img/eksponati/grckivazan.jpg', 11, '', NULL),
(27, 4, 'Rimska figura', 'img/eksponati/rimskafigura.jpg', NULL, '', 84),
(28, 2, 'Mramorna skulptura', 'img/eksponati/mramornaskulptura.jpg', 9, '', NULL),
(29, 5, 'Slikarsko platno', 'img/eksponati/slikarskoplatno.jpg', 8, '', NULL),
(30, 2, 'Moderna umetnost', 'img/eksponati/modernaumetnost.jpg', NULL, '', 85),
(34, 4, 'crvenokosa boginja', 'img/eksponati/cb.jpg', NULL, 'dfasd', 73),
(48, 3, 'Seoba Srba', 'img/eksponati/Seoba_Srba.jpg', NULL, 'Prva Velika seoba Srba se odigrala pod pećkim patrijarhom Arsenijem III Čarnojevićem početkom 1690. godine, tokom Velikog bečkog rata, koji je trajao od 1683. do 1699. godine. Druga Velika seoba Srba se odigrala pod pećkim patrijarhom Arsenijem IV Jovanovićem 1740. godine, nakon Rusko-austro-turskog rata, koji je trajao od 1735. do 1739. godine.', 85),
(49, 2, 'dd', 'img/eksponati/cb.jpg', 9, 'dd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `izlozba`
--

CREATE TABLE `izlozba` (
  `ID_IZLOZBE` int(11) NOT NULL,
  `ID_LOKACIJE` int(11) NOT NULL,
  `NAZIV_IZLOZBE` varchar(50) NOT NULL,
  `DATUM_IZLOZBE` datetime NOT NULL,
  `OPIS_IZLOZBE` varchar(300) NOT NULL,
  `IMG_IZLOZBE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izlozba`
--

INSERT INTO `izlozba` (`ID_IZLOZBE`, `ID_LOKACIJE`, `NAZIV_IZLOZBE`, `DATUM_IZLOZBE`, `OPIS_IZLOZBE`, `IMG_IZLOZBE`) VALUES
(8, 3, 'Arheološka prošlost', '2023-08-15 10:00:00', 'Upoznajte bogatu arheološku prošlost kroz otkrivanje antičkih artefakata.', 'img/izlozbe/arheoloskaprostlost.jpg'),
(9, 2, 'Slikarski biseri', '2023-08-20 11:30:00', 'Otkrijte remek-dela slikarstva iz XIX veka i divite se lepoti umetničkog stvaralaštva.', 'img/izlozbe/slikarskibiseri.jpg'),
(10, 3, 'Kulturno nasleđe', '2023-09-05 09:00:00', 'Putovanje kroz kulturno nasleđe Balkana i upoznavanje sa tradicionalnom nošnjom.', 'img/izlozbe/kulturnonasledje.jpg'),
(11, 4, 'Kraljevska riznica', '2023-09-12 10:30:00', 'Otkrijte bogatstvo kraljevskih artefakata i blaga koja su obeležila istoriju.', 'img/izlozbe/kraljevskariznica.jpg'),
(12, 5, 'Arheološke zagonetke', '2023-09-25 14:00:00', 'Istražite tajne i zagonetke antičkih civilizacija i njihovog nasleđa.', 'img/izlozbe/arheoloskezagonetke.jpg'),
(17, 4, 'd', '2023-08-04 00:00:00', 'd', 'd'),
(20, 3, 'krv', '2023-08-10 00:00:00', 'dfasd', 'img/izlozba/nesto'),
(21, 2, 'dd', '2023-09-22 00:00:00', 'dd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID_KORISNIKA` int(11) NOT NULL,
  `IME` varchar(40) NOT NULL,
  `PREZIME` varchar(40) NOT NULL,
  `BROJ_TELEFONA` varchar(12) NOT NULL,
  `EMAIL` varchar(45) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID_KORISNIKA`, `IME`, `PREZIME`, `BROJ_TELEFONA`, `EMAIL`, `PASSWORD`, `status`) VALUES
(1, 'Danilo', 'Milanovic', '0645798169', 'danilo@gmail.com', 'danlo', 'korisnik'),
(2, 'Milan', 'Rodic', '064 579 816 ', 'milan@gmail.com', 'milan', 'admin'),
(3, 'Predrag', 'Tomic', '064 533 5433', 'test@gmail.com', 'pedja', 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `lokacija`
--

CREATE TABLE `lokacija` (
  `ID_LOKACIJE` int(11) NOT NULL,
  `NAZIV_LOKACIJE` varchar(50) NOT NULL,
  `ADRESA_LOKACIJE` varchar(50) NOT NULL,
  `OPIS` varchar(300) NOT NULL,
  `IMG_LOKACIJE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokacija`
--

INSERT INTO `lokacija` (`ID_LOKACIJE`, `NAZIV_LOKACIJE`, `ADRESA_LOKACIJE`, `OPIS`, `IMG_LOKACIJE`) VALUES
(2, 'Beograd', 'Knez Mihailova 2, Beograd, Srbija', 'Upoznajte istoriju Beograda kroz bogatu kolekciju artefakata i umetničkih dela. Otkrijte tajne grada na dve reke i istražite njegov kulturni i istorijski značaj.', 'img/lokacija/beograd.jpg'),
(3, 'Novi Sad', 'Dunavska 29, Novi Sad, Srbija', 'Neka vas Novi Sad očara svojom raznolikom baštinom. Naš muzej vam nudi uvid u bogatu istoriju ovog grada i njegovu umetničku scenu.', 'img/lokacija/novisad.jpg'),
(4, 'Kragujevac', 'Kralja Petra I 23, Kragujevac, Srbija', 'Kragujevac je grad sa dugačkom i zanimljivom istorijom. Posetite naš muzej i otkrijte priče o Kragujevcu kroz vreme.', 'img/lokacija/kragujevac.jpeg'),
(5, 'Niš', 'Nikole Pašića 4, Niš, Srbija', 'Niš je grad bogate kulture i istorije. Naš muzej nudi uvid u važne događaje i ličnosti koje su oblikovale ovaj grad.', 'img/lokacija/nis.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `predhodne_vrednosti`
--

CREATE TABLE `predhodne_vrednosti` (
  `ID` int(11) NOT NULL,
  `ID_EKSPONATA` int(11) NOT NULL,
  `ID_IZLOZBE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `predhodne_vrednosti`
--

INSERT INTO `predhodne_vrednosti` (`ID`, `ID_EKSPONATA`, `ID_IZLOZBE`) VALUES
(92, 34, 12),
(112, 22, 17),
(113, 23, 10),
(114, 25, 12),
(115, 27, 10),
(116, 30, 9),
(117, 48, 10);

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `ID_REZERVACIJE` int(11) NOT NULL,
  `ID_IZLOZBE` int(11) NOT NULL,
  `ID_KORISNIKA` int(11) DEFAULT NULL,
  `DATUM_REZERVACIJE` datetime NOT NULL,
  `IME` varchar(50) NOT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `broj_mesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`ID_REZERVACIJE`, `ID_IZLOZBE`, `ID_KORISNIKA`, `DATUM_REZERVACIJE`, `IME`, `EMAIL`, `broj_mesta`) VALUES
(1, 9, NULL, '2023-08-17 12:55:43', 'Danilo', 'predragbiorac8@gmail.com', 0),
(12, 9, NULL, '2023-08-17 13:23:50', 'Danilo', 'predragbiorac8@gmail.com', 0),
(13, 8, NULL, '2023-08-22 18:43:04', 'Predrag', 'srdjantomic22@gmail.com', 0),
(14, 10, NULL, '2023-08-22 18:43:17', 'sir', 'test@gmail.com', 0),
(15, 8, 0, '2023-09-17 15:55:00', '', '', 0),
(21, 9, 2, '2023-09-17 22:20:00', 'Milan', 'milan@gmail.com', 1),
(23, 11, 1, '2023-09-20 12:53:00', 'Danilo', 'danilo@gmail.com', 1),
(24, 9, 1, '2023-09-20 12:53:00', 'Danilo', 'danilo@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_statusa` int(11) NOT NULL,
  `naziv_statusa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dogadjaj`
--
ALTER TABLE `dogadjaj`
  ADD PRIMARY KEY (`ID_DOGADJAJA`);

--
-- Indexes for table `eksponati`
--
ALTER TABLE `eksponati`
  ADD PRIMARY KEY (`ID_EKSPONATA`),
  ADD KEY `ID_LOKACIJE` (`ID_LOKACIJE`),
  ADD KEY `ID_IZLOZBE` (`ID_IZLOZBE`),
  ADD KEY `FK_RELATIONSHIP_9` (`id_dogadjaja`);

--
-- Indexes for table `izlozba`
--
ALTER TABLE `izlozba`
  ADD PRIMARY KEY (`ID_IZLOZBE`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID_KORISNIKA`);

--
-- Indexes for table `lokacija`
--
ALTER TABLE `lokacija`
  ADD PRIMARY KEY (`ID_LOKACIJE`);

--
-- Indexes for table `predhodne_vrednosti`
--
ALTER TABLE `predhodne_vrednosti`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`ID_REZERVACIJE`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_statusa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dogadjaj`
--
ALTER TABLE `dogadjaj`
  MODIFY `ID_DOGADJAJA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `eksponati`
--
ALTER TABLE `eksponati`
  MODIFY `ID_EKSPONATA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `izlozba`
--
ALTER TABLE `izlozba`
  MODIFY `ID_IZLOZBE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID_KORISNIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lokacija`
--
ALTER TABLE `lokacija`
  MODIFY `ID_LOKACIJE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `predhodne_vrednosti`
--
ALTER TABLE `predhodne_vrednosti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `ID_REZERVACIJE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id_statusa` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eksponati`
--
ALTER TABLE `eksponati`
  ADD CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`id_dogadjaja`) REFERENCES `dogadjaj` (`ID_DOGADJAJA`),
  ADD CONSTRAINT `eksponati_ibfk_1` FOREIGN KEY (`ID_LOKACIJE`) REFERENCES `lokacija` (`ID_LOKACIJE`),
  ADD CONSTRAINT `eksponati_ibfk_2` FOREIGN KEY (`ID_IZLOZBE`) REFERENCES `izlozba` (`ID_IZLOZBE`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `pozivanje_procedure_na1h` ON SCHEDULE EVERY 1 HOUR STARTS '2023-09-09 19:35:05' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    CALL VratiEksponateNakonIstekaVremena();
  END$$

CREATE DEFINER=`root`@`localhost` EVENT `pozivanje_procedure_na1hh` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-09-09 20:38:55' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    CALL VratiEksponateNakonIstekaVremena();
end$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
