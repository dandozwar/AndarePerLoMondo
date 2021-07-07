-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Lug 07, 2021 alle 18:51
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplm`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Biografia`
--

CREATE TABLE `Biografia` (
  `id` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL,
  `presentazione` varchar(256) COLLATE latin1_general_cs NOT NULL,
  `descrizione` blob NOT NULL,
  `viaggio1` smallint(6) DEFAULT NULL,
  `viaggio2` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Biografia`
--

INSERT INTO `Biografia` (`id`, `persona`, `presentazione`, `descrizione`, `viaggio1`, `viaggio2`) VALUES
(1, 1, 'Bonaccorso Pitti (1354-1432) fu un mercante, un giocatore d’azzardo e un politico fiorentino.', 0x426f6e6163636f72736f206469204e6572692050697474692028466972656e7a652c20323520617072696c652031333534202d20466972656e7a6520342061676f73746f20313433322920667520756e206d657263616e74652c20756e2067696f6361746f72652064e28099617a7a6172646f206520756e20706f6c697469636f2066696f72656e74696e6f206469207061727465206775656c66612e20446f706f206c61207269766f6c7461206465692043696f6d70692c20766961676769c3b2207072696e636970616c6d656e746520667261204672616e6369612065204669616e6472652c2070657220706f6920746f726e617265206120466972656e7a6520652073667275747461726520692070726f70726920636f6e74617474692070657220696c2062656e652064656c20436f6d756e652c206f7474656e656e646f20636f73c3ac20696c2072616e676f206e6f62696c696172652064616c6c27696d70657261746f726520526f626572746f20646920426176696572612e2041207365677569746f20646920756e612070657269636f6c6f736120636f6e7465736120636f6e206c612066616d69676c696120726976616c65206465692052696361736f6c692c2073637269766572c3a0206c652070726f70726965206d656d6f726965206e6569205269636f7264692e0a, 2, 8),
(2, 15, 'Sigerico di Canterbury († 994) fu un arcivescovo anglosassone.', 0x536967657269636f2064692043616e746572627572792028e280a0203239206f74746f6272652039393429206675206ce2809961726369766573636f766f2064692043616e746572627572792064616c203939302066696e6f20616c6c61206d6f7274652e204f6c747265206368652070657220696c2073756f20636f696e766f6c67696d656e746f206e656c6c6520747261747461746976652066726120616e676c6f736173736f6e69206520696e7661736f72692064616e6573692c20c3a8207269636f726461746f20696e207175616e746f207072696d6f2074657374696d6f6e652064656c20706572636f72736f2064656c6c6120566961204672616e636967656e612c2064692063756920617070756e74c3b2206c6520746170706520646120526f6d612066696e6f20612043616e746572627572792e, 6, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Commento_Biografia`
--

CREATE TABLE `Commento_Biografia` (
  `id` smallint(6) NOT NULL,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `biografia` smallint(6) NOT NULL,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Commento_Biografia`
--

INSERT INTO `Commento_Biografia` (`id`, `autore`, `biografia`, `commento`) VALUES
(1, 'acignoni', 1, 0x426f6e6163636f72736f2050697474692065726120696c207061647265206469204c7563612050697474692c20636f6c756920636865206665636520636f7374727569726520696c2066616d6f73697373696d6f2070616c617a7a6f2050697474692c20706f692072657175697369746f20646169204d656469636920646f706f20636865206c612066616d69676c696120636164646520696e206469736772617a69612e),
(2, 'acignoni', 1, 0x492052696361736f6c6920c3a820756e612066696f72656e74652066616d69676c69612066696f72656e74696e61206469206f726967696e652066657564616c6520636865206573697374652074757474e280996f6767693b20696c207365636f6e646f20707265736964656e74652064656c20636f6e7369676c696f2064656c207265676e6f2064e280994974616c69612c20646f706f204361766f75722c20667520756e2052696361736f6c692e);

-- --------------------------------------------------------

--
-- Struttura della tabella `Commento_Viaggio`
--

CREATE TABLE `Commento_Viaggio` (
  `id` smallint(6) NOT NULL,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `viaggio` smallint(6) NOT NULL,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Commento_Viaggio`
--

INSERT INTO `Commento_Viaggio` (`id`, `autore`, `viaggio`, `commento`) VALUES
(1, 'acignoni', 1, 0x446f706f206c61207269766f6c7461206465692043696f6d706920692066756f7269757363697469206775656c6669206f6c69676172636869636920646920466972656e7a65207369206163636f6461726f6e6f20616c6ce28099657365726369746f206469204361726c6f2064656c6c6120506163652073706572616e646f20636865206c69207265696e7365646961737365206e656c6c612063697474c3a02064656c206769676c696f3b2070757274726f70706f2066726120692066696e616e7a6961746f72692064656c20726520616e67696f696e6f2063e2809965726120616e63686520696c20726567696d6520706f706f6c6172652066696f72656e74696e6f2065207175696e6469206c27657365726369746f206e6f6e20617373616c74c3b2206d6169206c612063697474c3a02e);

-- --------------------------------------------------------

--
-- Struttura della tabella `destinatario`
--

CREATE TABLE `destinatario` (
  `scopo` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `destinatario`
--

INSERT INTO `destinatario` (`scopo`, `persona`) VALUES
(1, 2),
(2, 2),
(4, 5),
(5, 6),
(5, 7),
(6, 9),
(7, 10),
(9, 12),
(10, 14),
(11, 12),
(17, 12),
(19, 20),
(20, 21),
(21, 21),
(22, 21),
(24, 21),
(25, 21),
(27, 21),
(28, 21),
(28, 20),
(29, 21),
(30, 21),
(30, 20),
(31, 24),
(33, 27),
(34, 28),
(36, 29),
(32, 25);

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

CREATE TABLE `Evento` (
  `id` smallint(6) NOT NULL,
  `biografia` smallint(6) NOT NULL,
  `immagine` smallint(6) DEFAULT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date DEFAULT NULL,
  `titolo` varchar(128) COLLATE latin1_general_cs NOT NULL,
  `didascalia` blob NOT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Evento`
--

INSERT INTO `Evento` (`id`, `biografia`, `immagine`, `data_inizio`, `data_fine`, `titolo`, `didascalia`, `uri`) VALUES
(1, 1, 1, '1354-04-25', NULL, 'Nascita', 0x3c703e426f6e6163636f72736f206469204e657269205069747469206e61736365206120466972656e7a65206e656c207175617274696572652064692053616e746f205370697269746f20696c20323520617072696c65203133353420646120756e612072696363612066616d69676c696120646920636f6d6d65726369616e74692065206c616e61696f6c692e3c2f703e0a, 'https://www.treccani.it/enciclopedia/buonaccorso-di-neri-pitti_%28Dizionario-Biografico%29/'),
(2, 1, 2, '1378-07-21', NULL, 'Il tumulto dei Ciompi', 0x3c703e492043696f6d70692c20692073616c6172696174692064656c6ce28099417274652064656c6c61206c616e6120646920466972656e7a652c20696e736f72676f6e6f206520726976656e646963616e6f206d616767696f7265207065736f20706f6c697469636f2061207363617069746f2064656c6c61207061727465206f6c696761726368696361206775656c66612e2053656262656e65206e6f6e20636f6d706c6574616d656e74652c206c61207269766f6c746120686120737563636573736f2065206120466972656e7a6520736920696e73746175726120756e20726567696d65207069c3b920706f706f6c6172652e3c2f703e0a, 'https://www.treccani.it/enciclopedia/tumulto-dei-ciompi_%28Dizionario-di-Storia%29/'),
(3, 1, NULL, '1378-08-00', '1391-00-00', 'Autoesilio', 0x3c703e41207365677569746f2064656c6c61207269766f6c7461206465692043696f6d706920652064656c6ce28099696e7374617275617a696f6e6520646920756e20726567696d6520706f706f6c6172652c20426f6e6163636f72736f2c20666965726f206d656d62726f2064656c6c61207061727465206f6c696761726368696361206775656c66612c20696e697a696120616420c2ab616e6461726520706572206c6f206d6f6e646fc2bb2e20496e207061727469636f6c617265207369206d6574746520616c2073657276697a696f206469204265726e6172646f2042656e76656e757469206465e28099204e6f62696c6920652067696f63612064e28099617a7a6172646f20696e204669616e64726120636f6e2069206e6f62696c69206c6f63616c693b2070617274656369706572c3a020616e63686520612076617269652073706564697a696f6e69206d696c697461726920616c2073657276697a696f2064656c207265206469204672616e636961204361726c6f2056492e205269746f726e6572c3a0206120466972656e7a6520736f6c6f20646f706f20616e6e692063686520696c20726567696d65206f6c69676172636869636f20c3a820737461746f207265737461757261746f207065722073706f736172736920656420656e7472617265206e656c6c6120706f6c697469636120636f6d756e616c652e3c2f703e0a, NULL),
(4, 1, 3, '1401-00-00', NULL, 'Nobiltà', 0x3c703e426f6e6163636f72736f206520692073756f692066726174656c6c692076656e676f6e6f20656c657661746920616c2072616e676f206469206e6f62696c652064616c6ce28099696d70657261746f726520526f626572746f2064692057697474656c736261636820696e2063616d62696f206465692073756f692073657276696769206469706c6f6d61746963692e3c2f703e, 'https://www.treccani.it/enciclopedia/roberto-elettore-del-palatinato-e-re-di-germania/'),
(5, 1, 4, '1404-00-00', '1414-00-00', 'La contesa con i Ricasoli', 0x3c703e49205069747469206520692052696361736f6c692c20616c74726120706f74656e74652066616d69676c69612066696f72656e74696e612c20656e7472616e6f20696e20636f6e74726173746f2070657220696c20636f6e74726f6c6c6f2064656c6ce28099616262617a69612064692053616e2050696574726f20612052756f746920696e2056616c64616d6272612e204e656c203134313320426f6e6163636f72736f206520696c2066726174656c6c6f204c756967692076656e676f6e6f20617272657374617469206520696c206669676c696f204c756361206573696c6961746f2c206d61206c612066616d69676c6961207269657363652070726573746f20612072697072656e64657273692e3c2f703e0a, NULL),
(6, 1, 5, '1412-12-00', '1430-00-00', 'I Ricordi', 0x3c703e49205269636f72646920736f6e6f207175656c6c6f20636865207669656e6520646566696e69746f20756e206c6962726f2064692066616d69676c69612e20426f6e6163636f72736f20696e697a69c3b2206120736372697665726c6920696e20756e206d6f6d656e746f206372697469636f20706572206c612066616d69676c696120286c6120636f6e7465736120636f6e20692052696361736f6c692920636f6d6520736f727461206469206d616e75616c65206469206d65726361747572612070657220692070726f7072692064697363656e64656e74692e3c2f703e, NULL),
(7, 1, 1, '1432-08-04', NULL, 'Morte', 0x3c703e426f6e6163636f72736f206d756f7265206120466972656e7a65206e656c6c612070726f70726961206361736120616c6ce280996574c3a020646920373820616e6e692e204772617a696520616c2073756f206f70657261746f2069205069747469207369206572616e6f2061666665726d61746920636f6d6520756e612064656c6c652066616d69676c6965207069c3b920706f74656e74692064656c20636f6d756e65206520636f6e74726962756972616e6e6f20616c6ce2809961736365736120646569204d65646963692e3c2f703e0a, 'https://www.treccani.it/enciclopedia/buonaccorso-di-neri-pitti_%28Dizionario-Biografico%29/'),
(8, 2, 6, '0975-00-00', NULL, 'Elezione ad abate', 0x3c703e4c61207072696d61206e6f74697a6961206461746174612073756c6c61207669746120646920536967657269636f20c3a8206c612073756120656c657a696f6e652061642061626174652064656c6ce28099616262617a69612062656e6564657474696e612064692053616e74e2809941676f7374696e6f20612043616e746572627572792e3c2f703e, NULL),
(9, 2, 7, '0985-00-00', NULL, 'Consacarazione a vescovo', 0x3c703e4ce2809961726369766573636f766f2064692043616e746572627572792053616e2044756e7374616e6f20636f6e736163726120536967657269636f20766573636f766f2064692052616d73627572792e3c2f703e, NULL),
(10, 2, 8, '0990-00-00', NULL, 'Scrittura dell’itinerario', 0x3c703e536967657269636f20736372697665206f206661207363726976657265206120756e2073756f20736f74746f706f73746f206c652037392074617070652063686520686120636f6d706975746f2070657220746f726e6172652064616c2073756f207669616767696f206120526f6d61207065722072696365766520696c2070616c6c696f2e2051756573746f20646f63756d656e746f20c3a820646920666f6e64616d656e74616c6520696d706f7274616e7a6120706572206964656e746966696361726520696c207072696d6f2074726163636961746f2064656c6c6120766961204672616e636967656e612e3c2f703e, 'https://it.wikipedia.org/wiki/Itinerario_di_Sigerico'),
(11, 2, 9, '0991-00-00', NULL, 'Consigli al re', 0x3c703e536967657269636f20636f6e7369676c696120696c2072652064e28099496e6768696c7465727261204574656c7265646f2049492064692070616761726520756e207472696275746f20616c2072652064616e65736520537765796e204920696e206d616e6965726120636865206e6f6e2072617a7a69206c6520746572726520616e676c6f736173736f6e692e3c2f703e, NULL),
(12, 2, 10, '0994-00-00', NULL, 'Un tributo per la cattedrale', 0x3c703e536967657269636f207061676120756e207472696275746f2061692064616e6573692070657220696d70656469726520636865207175657374692062727563696e6f206c612063617474656472616c652064692043616e746572627572793c2f703e, NULL),
(13, 2, 10, '0994-10-28', NULL, 'Morte', 0x3c703e536967657269636f206d756f726520696c203238206f74746f627265203939342c20696c2073756f20636f72706f207669656e652073657070656c6c69746f206e656c6c612063617474656472616c652064692043616e746572627572792e3c2f703e, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Fonte`
--

CREATE TABLE `Fonte` (
  `id` smallint(6) NOT NULL,
  `cit_biblio` varchar(256) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Fonte`
--

INSERT INTO `Fonte` (`id`, `cit_biblio`) VALUES
(1, 'Bonaccorso Pitti, Ricordi, in: Mercanti scrittori. Ricordi nella Firenze tra Medioevo e Rinascimento, Vittore Branca (a cura di), Rusconi, Milano, 1986'),
(2, '<a href=\"https://www.viefrancigene.org/it/resource/blog/Webmaster/litinerario-di-sigerico\" target=\"_blank\">Sito ufficiale Via Francigena</a>');

-- --------------------------------------------------------

--
-- Struttura della tabella `Immagine`
--

CREATE TABLE `Immagine` (
  `id` smallint(6) NOT NULL,
  `locazione` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `didascalia` varchar(256) COLLATE latin1_general_cs NOT NULL,
  `provenienza` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Immagine`
--

INSERT INTO `Immagine` (`id`, `locazione`, `didascalia`, `provenienza`) VALUES
(1, './img/StemmaPitti.jpg', 'Lo stemma della famiglia Pitti', 'Archivio di Stato di Firenze, Raccolta Caramelli Papiani'),
(2, './img/RivoltaCiompi.jpg', 'G. L. Gatteri, Il tumulto dei Ciompi, 1877', 'Civici Musei di Storia ed Arte di Trieste'),
(3, './img/ImperatoreRoberto.jpg', 'L’imperatore Roberto di Wittelsbach', 'Chiesa Collegiata di Neustadt an der Weinstrasse, Germania'),
(4, './img/StemmaRicasoli.jpg', 'Lo stemma della famiglia Ricasoli', 'Luigi Passerini, Genealogia e storia della famiglia Ricasoli, Firenze, 1864'),
(5, './img/ManoscrittoPitti.png', 'Il manoscritto autografo dei Ricordi', 'Manoscritto II, III, 245, Biblioteca Nazionale Centrale di Firenze'),
(6, './img/AbbaziaSAgostino.jpg', 'L’ex-monastero benedettino di Sant’Agostino', 'L’entrata privata dell’attuale King’s School'),
(7, './img/Dunstan.jpg', 'Possibile autoritratto dell’arcivescovo di Canterbury Dunstano', 'St Dunstan’s Classbook, MS. Auct. F. 4. 32, Biblioteche di Oxford'),
(8, './img/ItinerarioSigerico.jpg', 'Trascrizione dell’XI secolo', 'British Library, Cotton MS. Tiberius B.V, f.23v'),
(9, './img/ReEthelred.jpg', 'Re Etelredo II d’Inghilterra detto lo Sconsigliato', 'Copia del XIII secolo del Historia Ecclesie Abbendonensis'),
(10, './img/CattedraleCanterbury.jpg', 'La cattedrale di Canterbury', 'Vista dall’entrata');

-- --------------------------------------------------------

--
-- Struttura della tabella `lavora_come`
--

CREATE TABLE `lavora_come` (
  `persona` smallint(6) NOT NULL,
  `occupazione` smallint(6) NOT NULL,
  `data_fine` date DEFAULT NULL,
  `data_inizio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `lavora_come`
--

INSERT INTO `lavora_come` (`persona`, `occupazione`, `data_fine`, `data_inizio`) VALUES
(1, 1, '1432-08-05', '1374-04-25'),
(1, 2, '1398-00-00', '1376-00-00'),
(1, 3, '1426-02-26', '1396-07-20'),
(1, 4, '1427-06-27', '1399-09-22'),
(2, 5, '1386-02-24', '1382-05-12'),
(2, 6, '1386-02-24', '1385-12-31'),
(3, 7, '1382-00-00', '1378-00-00'),
(4, 7, '1382-00-00', '1378-00-00'),
(6, 3, '1381-00-00', '1372-00-00'),
(6, 4, '1391-00-00', '1382-00-00'),
(8, 8, NULL, NULL),
(8, 4, '1404-00-00', '1392-00-00'),
(9, 9, '1383-12-07', '1346-08-26'),
(9, 10, '1383-12-07', '1355-12-05'),
(10, 11, '1399-02-03', '1362-11-13'),
(10, 12, '1388-07-08', '1372-02-26'),
(10, 13, '1399-02-03', '1390-03-02'),
(11, 14, '1404-01-16', '1364-09-29'),
(12, 15, '1422-10-21', '1380-09-16'),
(12, 16, '1413-03-21', '1396-11-27'),
(13, 2, NULL, NULL),
(14, 17, '1404-12-13', '1347-10-11'),
(14, 18, '1404-12-13', '1354-00-00'),
(14, 19, '1404-12-13', '1356-06-23'),
(15, 20, '0990-00-00', '0975-00-00'),
(15, 21, '0990-00-00', '0985-00-00'),
(15, 22, '0994-10-28', '0990-00-00'),
(16, 23, '1363-00-00', '1360-00-00'),
(16, 24, '1404-04-27', '1363-00-00'),
(17, 3, '1402-02-17', '1368-00-00'),
(17, 25, '1381-00-00', '1372-00-00'),
(17, 4, '1417-10-02', '1381-00-00'),
(18, 3, NULL, NULL),
(19, 3, NULL, NULL),
(20, 26, '1405-11-17', '1388-06-29'),
(21, 27, '1410-05-18', '1398-01-06'),
(21, 28, '1410-05-18', '1400-08-21'),
(22, 4, '1409-00-00', '1382-00-00'),
(22, 3, NULL, NULL),
(23, 4, '1429-02-20', '1401-00-00'),
(23, 3, '1424-00-00', '1402-00-00'),
(23, 29, '1429-02-20', '1385-00-00'),
(24, 30, '1413-12-26', '1400-12-01'),
(25, 31, '1417-04-29', '1384-09-20'),
(26, 3, NULL, NULL),
(26, 4, NULL, NULL),
(27, 32, '1424-01-24', '1383-05-00'),
(27, 33, '1424-01-24', '1411-00-00'),
(28, 32, '1416-08-05', NULL),
(28, 34, '1416-08-05', NULL),
(29, 35, '1415-05-29', '1410-05-17');

-- --------------------------------------------------------

--
-- Struttura della tabella `Luogo`
--

CREATE TABLE `Luogo` (
  `id` smallint(6) NOT NULL,
  `nome` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `latitudine` decimal(8,5) NOT NULL,
  `longitudine` decimal(8,5) NOT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Luogo`
--

INSERT INTO `Luogo` (`id`, `nome`, `latitudine`, `longitudine`, `uri`) VALUES
(1, 'Firenze', '43.77139', '11.25417', 'https://it.wikipedia.org/wiki/Firenze'),
(2, 'Napoli', '40.83000', '14.25000', 'https://it.wikipedia.org/wiki/Napoli'),
(3, 'Visegrád', '47.78578', '18.97024', 'https://it.wikipedia.org/wiki/Visegr%C3%A1d'),
(4, 'Genova', '44.40719', '8.93390', 'https://it.wikipedia.org/wiki/Genova'),
(5, 'Mutrone', '43.92642', '10.19675', 'https://it.wikipedia.org/wiki/Porto_di_Motrone'),
(6, 'Lucca', '43.85000', '10.51600', 'https://it.wikipedia.org/wiki/Lucca'),
(7, 'Sarzana', '44.11361', '9.96000', 'https://it.wikipedia.org/wiki/Sarzana'),
(8, 'Pontremoli', '44.37610', '9.87990', 'https://it.wikipedia.org/wiki/Pontremoli'),
(9, 'Berceto', '44.50899', '9.99104', 'https://it.wikipedia.org/wiki/Berceto'),
(10, 'Montefiorino', '44.35000', '10.61600', 'https://it.wikipedia.org/wiki/Montefiorino'),
(11, 'Fornovo del Taro', '44.68300', '10.10000', 'https://it.wikipedia.org/wiki/Fornovo_di_Taro'),
(12, 'Modena', '44.64582', '10.92572', 'https://it.wikipedia.org/wiki/Modena'),
(13, 'Mirandola', '44.88727', '11.06603', 'https://it.wikipedia.org/wiki/Mirandola'),
(14, 'Ostiglia', '45.07039', '11.13641', 'https://it.wikipedia.org/wiki/Ostiglia'),
(15, 'Verona', '45.43861', '10.99280', 'https://it.wikipedia.org/wiki/Verona'),
(16, 'Stellata', '44.94567', '11.42079', 'https://it.wikipedia.org/wiki/Stellata'),
(17, 'Bondeno', '44.88944', '11.41542', 'https://it.wikipedia.org/wiki/Bondeno'),
(18, 'San Pietro Terme', '44.39700', '11.58940', 'https://it.wikipedia.org/wiki/Castel_San_Pietro_Terme'),
(19, 'Massa Lombarda', '44.45000', '11.81600', 'https://it.wikipedia.org/wiki/Massa_Lombarda'),
(20, 'Lugo', '44.41600', '11.91600', 'https://it.wikipedia.org/wiki/Lugo_(Italia)'),
(21, 'Imola', '44.35306', '11.71472', 'https://it.wikipedia.org/wiki/Imola'),
(22, 'Faenza', '44.28500', '11.88300', 'https://it.wikipedia.org/wiki/Faenza'),
(23, 'Forlì', '44.22250', '12.04083', 'https://it.wikipedia.org/wiki/Forl%C3%AC'),
(24, 'Cesena', '44.13000', '12.23000', 'https://it.wikipedia.org/wiki/Cesena'),
(25, 'Rimini', '44.05940', '12.56830', 'https://it.wikipedia.org/wiki/Rimini'),
(26, 'Urbino', '43.72523', '12.63720', 'https://it.wikipedia.org/wiki/Urbino'),
(27, 'Cagli', '43.54700', '12.64730', 'https://it.wikipedia.org/wiki/Cagli'),
(28, 'Gubbio', '43.35179', '12.57727', 'https://it.wikipedia.org/wiki/Gubbio'),
(29, 'Fratta Todina', '42.85000', '12.36000', 'https://it.wikipedia.org/wiki/Fratta_Todina'),
(30, 'Sansepolcro', '43.57500', '12.14380', 'https://it.wikipedia.org/wiki/Sansepolcro'),
(31, 'Anghiari', '43.54160', '12.05500', 'https://it.wikipedia.org/wiki/Anghiari'),
(32, 'Arezzo', '43.46306', '11.87806', 'https://it.wikipedia.org/wiki/Arezzo'),
(33, 'Stia', '43.80380', '11.70940', 'https://it.wikipedia.org/wiki/Stia'),
(34, 'Abbadia a Isola', '43.38917', '11.19500', 'https://it.wikipedia.org/wiki/Abbadia_a_Isola'),
(35, 'Castiglion Fiorentino', '43.34380', '11.91800', 'https://it.wikipedia.org/wiki/Castiglion_Fiorentino'),
(36, 'Cortona', '43.27500', '11.98806', 'https://it.wikipedia.org/wiki/Cortona'),
(37, 'Città di Castello', '43.45742', '12.24031', 'https://it.wikipedia.org/wiki/Citt%C3%A0_di_Castello'),
(38, 'Bologna', '44.49380', '11.34270', 'https://it.wikipedia.org/wiki/Bologna'),
(39, 'Reggio Emilia', '44.70000', '10.63000', 'https://it.wikipedia.org/wiki/Reggio_Emilia'),
(40, 'Parma', '44.80147', '10.32800', 'https://it.wikipedia.org/wiki/Parma'),
(41, 'Fidenza', '44.86000', '10.06000', 'https://it.wikipedia.org/wiki/Fidenza'),
(42, 'Firenzuola d\'Arda', '44.93000', '9.90000', 'https://it.wikipedia.org/wiki/Fiorenzuola_d%27Arda'),
(43, 'Piacenza', '45.05000', '9.70000', 'https://it.wikipedia.org/wiki/Piacenza'),
(44, 'Lodi', '45.31600', '9.50000', 'https://it.wikipedia.org/wiki/Lodi'),
(45, 'Malegnano', '45.36000', '9.31600', 'https://it.wikipedia.org/wiki/Melegnano'),
(46, 'Milano', '45.46694', '9.19000', 'https://it.wikipedia.org/wiki/Milano'),
(47, 'Novara', '45.45000', '8.61600', 'https://it.wikipedia.org/wiki/Novara'),
(48, 'Vercelli', '45.31600', '8.41600', 'https://it.wikipedia.org/wiki/Vercelli'),
(49, 'Chiavasso', '45.18300', '7.88300', 'https://it.wikipedia.org/wiki/Chivasso'),
(50, 'Torino', '45.06000', '7.70000', 'https://it.wikipedia.org/wiki/Torino'),
(51, 'Susa', '45.13000', '7.05000', 'https://it.wikipedia.org/wiki/Susa_(Italia)'),
(52, 'Colle del Monginevro', '44.93097', '6.72335', 'https://it.wikipedia.org/wiki/Colle_del_Monginevro'),
(53, 'Brianzone', '44.90000', '6.65000', 'https://it.wikipedia.org/wiki/Brian%C3%A7on'),
(54, 'Embrun', '44.56000', '6.50000', 'https://it.wikipedia.org/wiki/Embrun'),
(55, 'Gap', '44.56000', '6.08300', 'https://it.wikipedia.org/wiki/Gap_(Francia)'),
(56, 'Sisteron', '44.20000', '5.93000', 'https://it.wikipedia.org/wiki/Sisteron'),
(57, 'Avignone', '43.95000', '4.81600', 'https://it.wikipedia.org/wiki/Avignone'),
(58, 'Tarascona', '43.80000', '4.66000', 'https://it.wikipedia.org/wiki/Tarascona'),
(59, 'Orange', '44.13000', '4.80000', 'https://it.wikipedia.org/wiki/Orange_(Francia)'),
(60, 'Mondragon', '44.23000', '4.71600', 'https://it.wikipedia.org/wiki/Mondragon_(Francia)'),
(61, 'Montélimar', '44.56000', '4.75000', 'https://it.wikipedia.org/wiki/Mont%C3%A9limar'),
(62, 'Valenza', '44.93000', '4.90000', 'https://it.wikipedia.org/wiki/Valence_(Alvernia-Rodano-Alpi)'),
(63, 'Tain-l’Hermitage', '45.06000', '4.85000', 'https://it.wikipedia.org/wiki/Tain-l%27Hermitage'),
(64, 'Vienne', '45.51600', '4.86000', 'https://it.wikipedia.org/wiki/Vienne_(Francia)'),
(65, 'Lione', '45.76694', '4.81417', 'https://it.wikipedia.org/wiki/Lione'),
(66, 'Villefranche-sur-Saône', '45.98300', '4.71600', 'https://it.wikipedia.org/wiki/Villefranche-sur-Sa%C3%B4ne'),
(67, 'Mâcon', '46.30000', '4.83000', 'https://it.wikipedia.org/wiki/M%C3%A2con'),
(68, 'Tournus', '46.56000', '4.90000', 'https://it.wikipedia.org/wiki/Tournus'),
(69, 'Chalon-sur-Saône', '46.78300', '4.85000', 'https://it.wikipedia.org/wiki/Chalon-sur-Sa%C3%B4ne'),
(70, 'Beaune', '47.03000', '4.83000', 'https://it.wikipedia.org/wiki/Beaune'),
(71, 'Fleurey-sur-Ouche', '47.31600', '4.85000', 'https://it.wikipedia.org/wiki/Fleurey-sur-Ouche'),
(72, 'Chanceaux', '47.51600', '4.70000', 'https://it.wikipedia.org/wiki/Chanceaux'),
(73, 'Magny-Lambert', '47.68300', '4.58300', 'https://it.wikipedia.org/wiki/Magny-Lambert'),
(74, 'Châtillon-sur-Seine', '47.85000', '4.55000', 'https://it.wikipedia.org/wiki/Ch%C3%A2tillon-sur-Seine'),
(75, 'Mussy-sur-Seine', '47.96000', '4.50000', 'https://it.wikipedia.org/wiki/Mussy-sur-Seine'),
(76, 'Bar-sur-Seine', '48.11600', '4.36000', 'https://it.wikipedia.org/wiki/Bar-sur-Seine'),
(77, 'Troyes', '48.30000', '4.08300', 'https://it.wikipedia.org/wiki/Troyes'),
(78, 'Traînel', '48.41600', '3.45000', 'https://it.wikipedia.org/wiki/Tra%C3%AEnel'),
(79, 'Bray-sur-Seine', '48.41600', '3.23000', 'https://it.wikipedia.org/wiki/Bray-sur-Seine'),
(80, 'Rampillon', '48.55000', '3.06000', 'https://it.wikipedia.org/wiki/Rampillon'),
(81, 'Donnemarie-Dontilly', '48.47580', '3.12720', 'https://it.wikipedia.org/wiki/Donnemarie-Dontilly'),
(82, 'Grandpuits-Bailly-Carrois', '48.58400', '2.96000', 'https://it.wikipedia.org/wiki/Grandpuits-Bailly-Carrois'),
(83, 'Brie-Comte-Robert', '48.68300', '2.61600', 'https://it.wikipedia.org/wiki/Brie-Comte-Robert'),
(84, 'Parigi', '48.85600', '2.35194', 'https://it.wikipedia.org/wiki/Parigi'),
(85, 'Senlis', '49.20000', '2.58300', 'https://it.wikipedia.org/wiki/Senlis_(Oise)'),
(86, 'Verberie', '49.31600', '2.73000', 'https://it.wikipedia.org/wiki/Verberie'),
(87, 'Compiègne', '49.41600', '2.83000', 'https://it.wikipedia.org/wiki/Compi%C3%A8gne'),
(88, 'Noyon', '49.58300', '3.00000', 'https://it.wikipedia.org/wiki/Noyon'),
(89, 'Ham', '49.75000', '3.06000', 'https://it.wikipedia.org/wiki/Ham_(Somme)'),
(90, 'San Quintino', '49.85000', '3.28300', 'https://it.wikipedia.org/wiki/San_Quintino_(Francia)'),
(91, 'Le Cateau-Cambrésis', '50.10610', '3.54194', 'https://it.wikipedia.org/wiki/Le_Cateau-Cambr%C3%A9sis'),
(92, 'Le Quesnoy', '50.25000', '3.63000', 'https://it.wikipedia.org/wiki/Le_Quesnoy'),
(93, 'Mons', '50.45470', '3.95200', 'https://it.wikipedia.org/wiki/Mons'),
(94, 'Braine-le-Comte', '50.60000', '4.13000', 'https://it.wikipedia.org/wiki/Braine-le-Comte'),
(95, 'Halle', '50.73610', '4.23720', 'https://it.wikipedia.org/wiki/Halle_(Belgio)'),
(96, 'Bruxelles', '50.84600', '4.35160', 'https://it.wikipedia.org/wiki/Bruxelles'),
(97, 'Vilvoorde', '50.91600', '4.41600', 'https://it.wikipedia.org/wiki/Vilvoorde'),
(98, 'Malines', '51.02805', '4.48028', 'https://it.wikipedia.org/wiki/Malines'),
(99, 'Enghien', '50.68300', '4.03000', 'https://it.wikipedia.org/wiki/Enghien'),
(100, 'Roeselare', '50.93000', '3.11600', 'https://it.wikipedia.org/wiki/Roeselare'),
(101, 'Warneton', '50.75000', '2.95000', NULL),
(102, 'Dunkerque', '51.05000', '2.36000', 'https://it.wikipedia.org/wiki/Dunkerque'),
(103, 'Gravelines', '50.98300', '2.13000', 'https://it.wikipedia.org/wiki/Gravelines'),
(104, 'Calais', '50.95000', '1.83000', 'https://it.wikipedia.org/wiki/Calais'),
(105, 'Dover', '51.11600', '1.30000', 'https://it.wikipedia.org/wiki/Dover'),
(106, 'Canterbury', '51.26000', '1.08300', 'https://it.wikipedia.org/wiki/Canterbury'),
(107, 'Winchester', '51.05000', '-1.30000', 'https://it.wikipedia.org/wiki/Winchester_(Hampshire)'),
(108, 'Londra', '51.50720', '-0.12750', 'https://it.wikipedia.org/wiki/Londra'),
(109, 'Ypres', '50.85000', '2.88300', 'https://it.wikipedia.org/wiki/Ypres'),
(110, 'Lilla', '50.63000', '3.06000', 'https://it.wikipedia.org/wiki/Lilla_(Francia)'),
(111, 'Arras', '50.28300', '2.78300', 'https://it.wikipedia.org/wiki/Arras'),
(112, 'Lihons', '49.81600', '2.76000', 'https://it.wikipedia.org/wiki/Lihons'),
(113, 'Praga', '50.08300', '4.41600', 'https://it.wikipedia.org/wiki/Praga'),
(114, 'Lussemburgo', '49.61139', '6.13083', 'https://it.wikipedia.org/wiki/Lussemburgo'),
(115, 'Gand', '51.05000', '3.70000', 'https://it.wikipedia.org/wiki/Gand'),
(116, 'Leicester', '52.71600', '-1.18300', 'https://it.wikipedia.org/wiki/Leicester'),
(117, 'Jugon-les-Lacs', '48.41000', '-2.32083', 'https://it.wikipedia.org/wiki/Jugon-les-Lacs'),
(118, 'Lamballe', '48.46000', '-2.51600', 'https://it.wikipedia.org/wiki/Lamballe'),
(119, 'Péronne', '49.93000', '2.93000', 'https://it.wikipedia.org/wiki/P%C3%A9ronne_(Somme)'),
(120, 'Cambrai', '50.16000', '3.23000', 'https://it.wikipedia.org/wiki/Cambrai'),
(121, 'Valenciennes', '50.35000', '3.53000', 'https://it.wikipedia.org/wiki/Valenciennes'),
(122, 'Douai', '50.37138', '3.08000', 'https://it.wikipedia.org/wiki/Douai'),
(123, 'Westrozebeke', '50.93270', '3.01380', NULL),
(124, 'Courtrai', '50.81600', '3.26000', 'https://it.wikipedia.org/wiki/Courtrai'),
(125, 'Louvres', '49.03000', '2.50000', 'https://it.wikipedia.org/wiki/Louvres'),
(126, 'Lier', '51.11600', '4.56000', 'https://it.wikipedia.org/wiki/Lier_(Belgio)'),
(127, 'Breda', '51.58750', '4.77500', 'https://it.wikipedia.org/wiki/Breda_(Paesi_Bassi)'),
(128, 'Geertruidenberg', '51.70083', '4.86027', 'https://it.wikipedia.org/wiki/Geertruidenberg'),
(129, 'Dordrecht', '51.80000', '4.66000', 'https://it.wikipedia.org/wiki/Dordrecht'),
(130, 'Rotterdam', '51.95000', '4.41600', 'https://it.wikipedia.org/wiki/Rotterdam'),
(131, 'Delft', '52.01110', '4.35750', 'https://it.wikipedia.org/wiki/Delft'),
(132, 'L’Aia', '52.08300', '4.16000', 'https://it.wikipedia.org/wiki/L%27Aia'),
(133, 'Monaco di Baviera', '48.13719', '11.57550', 'https://it.wikipedia.org/wiki/Monaco_di_Baviera'),
(134, 'Roma', '41.89306', '12.48278', 'https://it.wikipedia.org/wiki/Roma'),
(135, 'La Storta', '42.00269', '12.38254', 'https://it.wikipedia.org/wiki/La_Storta'),
(136, 'Valle di Baccano', '42.11897', '12.36703', 'https://it.wikipedia.org/wiki/Valle_di_Baccano'),
(137, 'Sutri', '42.24778', '12.21583', 'https://it.wikipedia.org/wiki/Sutri'),
(138, 'Vetralla', '42.31056', '12.07917', 'https://it.wikipedia.org/wiki/Vetralla'),
(139, 'Bullicame', '42.42042', '12.07292', 'https://it.wikipedia.org/wiki/Bullicame'),
(140, 'Montefiascone', '42.54028', '12.03694', 'https://it.wikipedia.org/wiki/Montefiascone'),
(141, 'Bolsena', '42.64472', '11.98583', 'https://it.wikipedia.org/wiki/Bolsena'),
(142, 'Acquapendente', '42.74472', '11.86500', 'https://it.wikipedia.org/wiki/Acquapendente'),
(143, 'Podere Voltole', '42.87711', '11.72925', 'https://it.wikipedia.org/wiki/Voltole'),
(144, 'Le Briccole', '42.98492', '11.68978', 'https://it.wikipedia.org/wiki/Le_Briccole'),
(145, 'San Quirico d’Orcia', '43.06667', '11.60000', 'https://it.wikipedia.org/wiki/San_Quirico_d%27Orcia'),
(146, 'Torrenieri', '43.08750', '11.54806', 'https://it.wikipedia.org/wiki/Torrenieri'),
(147, 'Ponte d’Arbia', '43.16806', '11.46556', 'https://it.wikipedia.org/wiki/Ponte_d%27Arbia'),
(148, 'Siena', '43.31833', '11.33139', 'https://it.wikipedia.org/wiki/Siena'),
(149, 'Pieve a Elsa', '43.39150', '11.13035', 'https://it.wikipedia.org/wiki/Pieve_a_Elsa'),
(150, 'Molino d’Aiano', '43.42914', '11.06749', 'https://it.wikipedia.org/wiki/San_Martino_in_Foci'),
(151, 'San Gimignano', '43.46772', '11.04322', 'https://it.wikipedia.org/wiki/San_Gimignano'),
(152, 'Chianni', '43.54692', '10.95789', 'https://it.wikipedia.org/wiki/Pieve_di_Santa_Maria_Assunta_a_Chianni'),
(153, 'Coiano', '43.61972', '10.91333', 'https://it.wikipedia.org/wiki/Coiano'),
(154, 'San Genesio', '43.69183', '10.88286', 'https://it.wikipedia.org/wiki/San_Genesio_(sito_archeologico)'),
(155, 'Fucecchio', '43.73333', '10.80000', 'https://it.wikipedia.org/wiki/Fucecchio'),
(156, 'Ponte a Cappiano', '43.74444', '10.76944', 'https://it.wikipedia.org/wiki/Ponte_a_Cappiano'),
(157, 'Porcari', '43.84152', '10.61632', 'https://it.wikipedia.org/wiki/Porcari'),
(158, 'Camaiore', '43.93333', '10.30000', 'https://it.wikipedia.org/wiki/Camaiore'),
(159, 'Luni', '44.06400', '10.01700', 'https://it.wikipedia.org/wiki/Luna_(colonia_romana)'),
(160, 'Santo Stefano di Magra', '44.16248', '9.91513', 'https://it.wikipedia.org/wiki/Santo_Stefano_di_Magra'),
(161, 'Aulla', '44.21667', '9.96667', 'https://it.wikipedia.org/wiki/Aulla'),
(162, 'Montelungo', '44.44575', '9.90864', 'https://it.wikipedia.org/wiki/Montelungo'),
(163, 'Madesano', '44.75678', '10.14031', 'https://it.wikipedia.org/wiki/Medesano'),
(164, 'Corte Sant’Andrea', '45.13333', '9.55750', 'https://it.wikipedia.org/wiki/Corte_Sant%27Andrea'),
(165, 'Santa Cristina', '45.11667', '9.46667', 'https://it.wikipedia.org/wiki/Santa_Cristina_(Santa_Cristina_e_Bissone)'),
(166, 'Pavia', '45.18528', '9.15500', 'https://it.wikipedia.org/wiki/Pavia'),
(167, 'Tromello', '45.21667', '8.86667', 'https://it.wikipedia.org/wiki/Tromello'),
(168, 'Santhià', '45.36667', '8.16667', 'https://it.wikipedia.org/wiki/Santhi%C3%A0'),
(169, 'Ivrea', '45.46222', '7.87472', 'https://it.wikipedia.org/wiki/Ivrea'),
(170, 'Montjovet', '45.70000', '7.68333', 'https://it.wikipedia.org/wiki/Montjovet'),
(171, 'Aosta', '45.73722', '7.32056', 'https://it.wikipedia.org/wiki/Aosta'),
(172, 'Saint-Rhémy-en-Bosses', '45.82374', '7.18219', 'https://it.wikipedia.org/wiki/Saint-Rh%C3%A9my-en-Bosses'),
(173, 'Bourg-Saint-Pierre', '45.94917', '7.20833', 'https://it.wikipedia.org/wiki/Bourg-Saint-Pierre'),
(174, 'Orsières', '46.03000', '7.14500', 'https://it.wikipedia.org/wiki/Orsi%C3%A8res'),
(175, 'San Maurizio d’Agauno', '46.21694', '7.00444', 'https://it.wikipedia.org/wiki/Saint-Maurice_(Svizzera)'),
(176, 'Yvorne', '46.33083', '6.96083', 'https://it.wikipedia.org/wiki/Yvorne'),
(177, 'Vevey', '46.45917', '6.84194', 'https://it.wikipedia.org/wiki/Vevey'),
(178, 'Losanna', '46.51983', '6.63350', 'https://it.wikipedia.org/wiki/Losanna'),
(179, 'Orbe', '46.72444', '6.53222', 'https://it.wikipedia.org/wiki/Orbe'),
(180, 'Jougne', '46.76667', '6.40000', 'https://it.wikipedia.org/wiki/Jougne'),
(181, 'Pontarlier', '46.90000', '6.36667', 'https://it.wikipedia.org/wiki/Pontarlier'),
(182, 'Nods', '47.10000', '6.33333', 'https://it.wikipedia.org/wiki/Nods_(Les_Premiers_Sapins)'),
(183, 'Besançon', '47.25000', '6.03333', 'https://it.wikipedia.org/wiki/Besan%C3%A7on'),
(184, 'Cussey-sur-l’Ognon', '47.33333', '5.93333', 'https://it.wikipedia.org/wiki/Cussey-sur-l%27Ognon'),
(185, 'Seveux', '47.55000', '5.75000', 'https://it.wikipedia.org/wiki/Seveux'),
(186, 'Grenant', '47.71667', '5.50000', 'https://it.wikipedia.org/wiki/Grenant'),
(187, 'Humes-Jorquenay', '47.90389', '5.30278', 'https://it.wikipedia.org/wiki/Humes-Jorquenay'),
(188, 'Blessonville', '48.06667', '5.00000', 'https://it.wikipedia.org/wiki/Blessonville'),
(189, 'Bar-sur-Aube', '48.23333', '4.71667', 'https://it.wikipedia.org/wiki/Bar-sur-Aube'),
(190, 'Brienne-la-Vieille', '48.36667', '4.53333', 'https://it.wikipedia.org/wiki/Brienne-la-Vieille'),
(191, 'Donnement', '48.51667', '4.43333', 'https://it.wikipedia.org/wiki/Donnement'),
(192, 'Fontaine-sur-Coole', '48.79694', '4.38389', NULL),
(193, 'Châlons-en-Champagne', '48.95000', '4.36667', 'https://it.wikipedia.org/wiki/Ch%C3%A2lons-en-Champagne'),
(194, 'Reims', '49.25000', '4.03333', 'https://it.wikipedia.org/wiki/Reims'),
(195, 'Corbeny', '49.46667', '3.81667', 'https://it.wikipedia.org/wiki/Corbeny'),
(196, 'Laon', '49.56667', '3.61667', 'https://it.wikipedia.org/wiki/Laon'),
(197, 'Seraucourt-le-Grand', '49.78333', '3.21667', 'https://it.wikipedia.org/wiki/Seraucourt-le-Grand'),
(198, 'Doingt', '49.91667', '2.96667', 'https://it.wikipedia.org/wiki/Doingt'),
(199, 'Bruay-la-Buissière', '50.48194', '2.54861', 'https://it.wikipedia.org/wiki/Bruay-la-Buissi%C3%A8re'),
(200, 'Thérouanne', '50.63333', '2.25000', 'https://it.wikipedia.org/wiki/Th%C3%A9rouanne'),
(201, 'Guînes', '50.86667', '1.86667', 'https://it.wikipedia.org/wiki/Gu%C3%AEnes'),
(202, 'Sombre', '50.88611', '1.66361', 'https://it.wikipedia.org/wiki/Sombre'),
(203, 'Bourbourg', '50.95000', '2.20000', 'https://it.wikipedia.org/wiki/Bourbourg'),
(204, 'Obourg', '50.47583', '4.00944', NULL),
(205, 'Hesdin', '50.36667', '2.03333', 'https://it.wikipedia.org/wiki/Hesdin'),
(206, 'Amiens', '49.90000', '2.30000', 'https://it.wikipedia.org/wiki/Amiens'),
(207, 'Cleremont', '49.38333', '2.40000', 'https://it.wikipedia.org/wiki/Clermont_(Oise)'),
(208, 'Creil', '49.26667', '2.48333', 'https://it.wikipedia.org/wiki/Creil'),
(209, 'Pontoise', '49.05000', '2.10000', 'https://it.wikipedia.org/wiki/Pontoise'),
(210, 'Mantova', '45.15639', '10.79111', 'https://it.wikipedia.org/wiki/Mantova'),
(211, 'Cremona', '45.13333', '10.03333', 'https://it.wikipedia.org/wiki/Cremona'),
(212, 'Briga-Glis', '46.31611', '7.98722', 'https://it.wikipedia.org/wiki/Briga-Glis'),
(213, 'Martigny', '46.10000', '7.06667', 'https://it.wikipedia.org/wiki/Martigny'),
(214, 'Ginevra', '46.20000', '6.15000', 'https://it.wikipedia.org/wiki/Ginevra'),
(215, 'Saint-Claude', '46.38333', '5.86667', 'https://it.wikipedia.org/wiki/Saint-Claude'),
(216, 'Orgelet', '46.51667', '5.61667', 'https://it.wikipedia.org/wiki/Orgelet'),
(217, 'Romans-sur-Isère', '45.05000', '5.05000', 'https://it.wikipedia.org/wiki/Romans-sur-Is%C3%A8re'),
(218, 'Saint-Antoine-l’Abbaye', '45.17583', '5.21722', 'https://it.wikipedia.org/wiki/Saint-Antoine-l%27Abbaye'),
(219, 'Grenoble', '45.16670', '5.71670', 'https://it.wikipedia.org/wiki/Grenoble'),
(220, 'Moncenisio', '45.20000', '6.98333', 'https://it.wikipedia.org/wiki/Moncenisio_(Italia)'),
(221, 'Asti', '44.90000', '8.20694', 'https://it.wikipedia.org/wiki/Asti'),
(222, 'Porto Venere', '44.05956', '9.83804', 'https://it.wikipedia.org/wiki/Porto_Venere'),
(223, 'Padova', '45.40639', '11.87778', 'https://it.wikipedia.org/wiki/Padova'),
(224, 'Venezia', '45.43972', '12.33194', 'https://it.wikipedia.org/wiki/Venezia'),
(225, 'Amberg', '49.45000', '11.86667', 'https://it.wikipedia.org/wiki/Amberg'),
(226, 'Oppenheim', '49.85000', '8.36667', 'https://it.wikipedia.org/wiki/Oppenheim_(Germania)'),
(227, 'Sacile', '45.95412', '12.50274', 'https://it.wikipedia.org/wiki/Sacile'),
(228, 'Valvasone', '46.00000', '12.86667', 'https://it.wikipedia.org/wiki/Valvasone'),
(229, 'Udine', '46.06667', '13.23333', 'https://it.wikipedia.org/wiki/Udine'),
(230, 'Cividale del Friuli', '46.09050', '13.43500', 'https://it.wikipedia.org/wiki/Cividale_del_Friuli'),
(231, 'Plezzo', '46.33778', '13.55222', 'https://it.wikipedia.org/wiki/Plezzo'),
(232, 'Tarvisio', '46.50000', '13.56667', 'https://it.wikipedia.org/wiki/Tarvisio'),
(233, 'Arnoldstein', '46.55056', '13.70389', 'https://it.wikipedia.org/wiki/Arnoldstein'),
(234, 'Villaco', '46.60000', '13.83333', 'https://it.wikipedia.org/wiki/Villaco'),
(235, 'Spittal an der Drau', '46.79167', '13.49583', 'https://it.wikipedia.org/wiki/Spittal_an_der_Drau'),
(236, 'Salisburgo', '47.79720', '13.04768', 'https://it.wikipedia.org/wiki/Salisburgo'),
(237, 'Ingolstadt', '48.76361', '11.42611', 'https://it.wikipedia.org/wiki/Ingolstadt'),
(238, 'Sulzbach-Rosenberg', '49.50000', '11.75000', 'https://it.wikipedia.org/wiki/Sulzbach-Rosenberg'),
(239, 'Norimberga', '49.45389', '11.07750', 'https://it.wikipedia.org/wiki/Norimberga'),
(240, 'Bad Mergentheim', '49.50000', '9.76667', 'https://it.wikipedia.org/wiki/Bad_Mergentheim'),
(241, 'Weinsberg', '49.15000', '9.28333', 'https://it.wikipedia.org/wiki/Weinsberg'),
(242, 'Heidelberg', '49.41222', '8.71000', 'https://it.wikipedia.org/wiki/Heidelberg'),
(243, 'Ulma', '48.39841', '9.99155', 'https://it.wikipedia.org/wiki/Ulma'),
(244, 'Magonza', '50.00000', '8.26667', 'https://it.wikipedia.org/wiki/Magonza'),
(245, 'Augusta', '48.37167', '10.89833', 'https://it.wikipedia.org/wiki/Augusta_(Germania)'),
(246, 'Innsbruck', '47.26833', '11.39333', 'https://it.wikipedia.org/wiki/Innsbruck'),
(247, 'Venzone', '46.33031', '13.13825', 'https://it.wikipedia.org/wiki/Venzone'),
(248, 'Portogruaro', '45.77564', '12.83752', 'https://it.wikipedia.org/wiki/Portogruaro'),
(249, 'Rovigo', '45.08090', '11.79400', 'https://it.wikipedia.org/wiki/Rovigo'),
(250, 'Francolino', '44.90444', '11.66000', 'https://it.wikipedia.org/wiki/Francolino'),
(251, 'Poggio Renatico', '44.76500', '11.48333', 'https://it.wikipedia.org/wiki/Poggio_Renatico'),
(252, 'Piombino', '42.93482', '10.52212', 'https://it.wikipedia.org/wiki/Piombino'),
(253, 'Treviso', '45.66528', '12.24444', 'https://it.wikipedia.org/wiki/Treviso'),
(254, 'Rio di Pusteria', '46.79660', '11.66754', 'https://it.wikipedia.org/wiki/Rio_di_Pusteria'),
(255, 'Bressanone', '46.71667', '11.65000', 'https://it.wikipedia.org/wiki/Bressanone'),
(256, 'Chiusa', '46.64001', '11.56573', 'https://it.wikipedia.org/wiki/Chiusa_(Italia)'),
(257, 'Bolzano', '46.50000', '11.35000', 'https://it.wikipedia.org/wiki/Bolzano'),
(258, 'Trento', '46.06667', '11.11667', 'https://it.wikipedia.org/wiki/Trento'),
(259, 'Latisana', '45.78333', '13.00000', 'https://it.wikipedia.org/wiki/Latisana'),
(260, 'Ferrara', '44.83530', '11.61986', 'https://it.wikipedia.org/wiki/Ferrara'),
(261, 'Argenta', '44.61306', '11.83639', 'https://it.wikipedia.org/wiki/Argenta'),
(262, 'Voltre', '44.03256', '12.03807', NULL),
(263, 'Tolosa', '43.60000', '1.43333', 'https://it.wikipedia.org/wiki/Tolosa'),
(264, 'Angers', '47.46667', '-0.55000', 'https://it.wikipedia.org/wiki/Angers'),
(265, 'Cotignola', '44.38333', '11.93333', 'https://it.wikipedia.org/wiki/Cotignola'),
(266, 'Colfiorito', '43.02639', '12.89000', 'https://it.wikipedia.org/wiki/Colfiorito'),
(267, 'Ischia', '40.71667', '13.90000', 'https://it.wikipedia.org/wiki/Isola_d%27Ischia'),
(268, 'Buonconvento', '43.13333', '11.48333', 'https://it.wikipedia.org/wiki/Buonconvento'),
(269, 'Montepulciano', '43.10000', '11.78333', 'https://it.wikipedia.org/wiki/Montepulciano'),
(270, 'Radicofani', '42.90000', '11.76667', 'https://it.wikipedia.org/wiki/Radicofani'),
(271, 'San Lorenzo alle Grotte', '42.68750', '11.90750', 'https://it.wikipedia.org/wiki/San_Lorenzo_Nuovo'),
(272, 'Viterbo', '42.41861', '12.10417', 'https://it.wikipedia.org/wiki/Viterbo'),
(273, 'Capranica', '42.25849', '12.17278', 'https://it.wikipedia.org/wiki/Capranica'),
(274, 'Nepi', '42.24361', '12.34639', 'https://it.wikipedia.org/wiki/Nepi'),
(275, 'Civita Castellana', '42.29611', '12.41000', 'https://it.wikipedia.org/wiki/Civita_Castellana'),
(276, 'Prato', '43.88081', '11.09656', 'https://it.wikipedia.org/wiki/Prato_(Italia)'),
(277, 'Pescara', '42.46428', '14.21419', 'https://it.wikipedia.org/wiki/Pescara');

-- --------------------------------------------------------

--
-- Struttura della tabella `mandante`
--

CREATE TABLE `mandante` (
  `scopo` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `mandante`
--

INSERT INTO `mandante` (`scopo`, `persona`) VALUES
(6, 8),
(7, 8),
(10, 8),
(26, 21),
(31, 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `Merce`
--

CREATE TABLE `Merce` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `quantita` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `valore` varchar(32) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Merce`
--

INSERT INTO `Merce` (`id`, `tipo`, `quantita`, `valore`) VALUES
(1, 'perle e gioielli', NULL, '3000 franchi d’oro'),
(2, 'denaro', NULL, '50.000 ducati');

-- --------------------------------------------------------

--
-- Struttura della tabella `motivo_tappa`
--

CREATE TABLE `motivo_tappa` (
  `tappa` smallint(6) NOT NULL,
  `scopo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `motivo_tappa`
--

INSERT INTO `motivo_tappa` (`tappa`, `scopo`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 1),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 5),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(86, 6),
(87, 6),
(88, 6),
(89, 6),
(90, 6),
(91, 6),
(92, 6),
(93, 6),
(94, 6),
(95, 6),
(96, 6),
(97, 6),
(98, 6),
(99, 6),
(100, 6),
(101, 7),
(102, 7),
(103, 7),
(104, 7),
(105, 7),
(106, 7),
(107, 7),
(108, 7),
(109, 7),
(110, 7),
(111, 8),
(112, 8),
(113, 8),
(114, 8),
(115, 8),
(116, 8),
(117, 8),
(118, 8),
(119, 8),
(120, 10),
(121, 10),
(122, 10),
(123, 10),
(124, 10),
(125, 10),
(126, 11),
(127, 11),
(128, 8),
(129, 12),
(130, 12),
(131, 12),
(132, 12),
(133, 12),
(134, 12),
(135, 12),
(136, 12),
(137, 12),
(138, 12),
(139, 12),
(140, 12),
(141, 12),
(142, 12),
(143, 12),
(144, 12),
(145, 12),
(146, 12),
(147, 12),
(148, 12),
(149, 12),
(150, 8),
(151, 8),
(152, 8),
(153, 8),
(154, 8),
(155, 8),
(156, 8),
(157, 8),
(158, 8),
(159, 8),
(160, 8),
(161, 8),
(162, 8),
(163, 8),
(164, 8),
(165, 8),
(166, 8),
(167, 8),
(168, 8),
(169, 8),
(170, 8),
(171, 13),
(172, 13),
(173, 13),
(174, 13),
(175, 13),
(176, 13),
(177, 13),
(178, 13),
(179, 13),
(180, 13),
(181, 13),
(182, 13),
(183, 13),
(184, 13),
(185, 13),
(186, 13),
(187, 13),
(188, 13),
(189, 13),
(190, 13),
(191, 13),
(192, 13),
(193, 13),
(194, 13),
(195, 13),
(196, 13),
(197, 13),
(198, 13),
(199, 13),
(200, 13),
(201, 13),
(202, 13),
(203, 13),
(204, 13),
(205, 13),
(206, 13),
(207, 13),
(208, 13),
(209, 13),
(210, 13),
(211, 13),
(212, 13),
(213, 13),
(214, 13),
(215, 13),
(216, 13),
(217, 13),
(218, 13),
(219, 13),
(220, 13),
(221, 13),
(222, 13),
(223, 13),
(224, 13),
(225, 13),
(226, 13),
(227, 13),
(228, 13),
(229, 13),
(230, 13),
(231, 13),
(232, 13),
(233, 13),
(234, 13),
(235, 13),
(236, 13),
(237, 13),
(238, 13),
(239, 13),
(240, 13),
(241, 13),
(242, 13),
(243, 13),
(244, 13),
(245, 13),
(246, 13),
(247, 13),
(248, 13),
(249, 14),
(250, 15),
(251, 15),
(252, 16),
(253, 8),
(254, 8),
(255, 8),
(256, 8),
(257, 8),
(258, 17),
(259, 17),
(260, 17),
(261, 17),
(262, 17),
(263, 17),
(264, 17),
(265, 17),
(266, 17),
(267, 17),
(268, 17),
(269, 17),
(270, 17),
(271, 17),
(272, 17),
(273, 17),
(274, 17),
(275, 17),
(276, 17),
(277, 17),
(278, 17),
(279, 17),
(280, 17),
(281, 17),
(282, 17),
(283, 18),
(284, 18),
(285, 18),
(286, 18),
(287, 18),
(288, 18),
(289, 18),
(290, 18),
(291, 18),
(292, 18),
(293, 18),
(294, 18),
(295, 18),
(296, 18),
(297, 18),
(298, 18),
(299, 18),
(300, 18),
(301, 18),
(302, 18),
(303, 18),
(304, 18),
(305, 18),
(307, 18),
(308, 18),
(309, 18),
(310, 18),
(311, 18),
(312, 18),
(313, 18),
(314, 18),
(315, 18),
(316, 18),
(317, 18),
(318, 18),
(319, 19),
(320, 20),
(321, 20),
(322, 20),
(323, 20),
(324, 20),
(325, 20),
(326, 20),
(327, 20),
(328, 20),
(329, 20),
(330, 20),
(331, 21),
(332, 21),
(320, 21),
(321, 21),
(322, 21),
(323, 21),
(324, 21),
(325, 21),
(326, 21),
(327, 21),
(328, 21),
(329, 21),
(330, 21),
(331, 21),
(332, 21),
(333, 21),
(334, 21),
(335, 21),
(336, 21),
(337, 21),
(338, 22),
(339, 22),
(340, 22),
(341, 23),
(342, 23),
(343, 23),
(344, 23),
(345, 23),
(346, 23),
(347, 23),
(348, 23),
(349, 23),
(350, 18),
(351, 18),
(352, 18),
(353, 18),
(354, 24),
(355, 25),
(356, 26),
(357, 26),
(358, 26),
(359, 27),
(360, 27),
(361, 27),
(362, 27),
(363, 27),
(364, 26),
(365, 26),
(366, 26),
(367, 28),
(268, 31),
(369, 29),
(370, 29),
(371, 29),
(372, 18),
(373, 18),
(374, 18),
(375, 18),
(376, 18),
(377, 33),
(378, 33),
(379, 33),
(380, 34),
(381, 34),
(382, 34),
(383, 34),
(384, 34),
(385, 34),
(386, 34),
(387, 34),
(388, 34),
(389, 35),
(390, 35),
(391, 35),
(392, 18),
(393, 36),
(394, 18),
(395, 37),
(396, 38),
(397, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `motivo_viaggio`
--

CREATE TABLE `motivo_viaggio` (
  `viaggio` smallint(6) NOT NULL,
  `scopo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `motivo_viaggio`
--

INSERT INTO `motivo_viaggio` (`viaggio`, `scopo`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 6),
(3, 7),
(4, 9),
(5, 10),
(6, 13),
(7, 14),
(7, 15),
(8, 17),
(9, 20),
(9, 21),
(10, 25),
(10, 27),
(11, 32);

-- --------------------------------------------------------

--
-- Struttura della tabella `Occupazione`
--

CREATE TABLE `Occupazione` (
  `id` smallint(6) NOT NULL,
  `attivita` varchar(32) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Occupazione`
--

INSERT INTO `Occupazione` (`id`, `attivita`) VALUES
(1, 'mercante'),
(2, 'giocatore d’azzardo'),
(3, 'ambasciatore fiorentino'),
(4, 'politico fiorentino'),
(5, 're di Napoli'),
(6, 're d’Ungheria'),
(7, 'capo dei fuorisciti'),
(8, 'banchiere parigino'),
(9, 'duca di Lussemburgo'),
(10, 'duca di Brabante'),
(11, 'duca di Lancaster'),
(12, 're di Castiglia'),
(13, 'duca d’Aquitania'),
(14, 'conte di Penthièvre'),
(15, 're di Francia'),
(16, 'duca di Genova'),
(17, 'duca di Baviera'),
(18, 'conte d’Olanda e Zelanda'),
(19, 'conte di Hainaut'),
(20, 'abate di Sant’Agostino'),
(21, 'vescovo di Ramsbury'),
(22, 'arcivescovo di Canterbury'),
(23, 'duca di Turenna'),
(24, 'duca di Borgogna'),
(25, 'dell’ordine teutonico'),
(26, 'signore di Padova'),
(27, 'elettore palatino'),
(28, 're dei Romani'),
(29, 'banchiere fiorentino'),
(30, 'doge di Venezia'),
(31, 'duca d’Angiò'),
(32, 'condottiero'),
(33, 'conte di Cotignola'),
(34, 'signore di Gallese'),
(35, 'antipapa');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipa_tappa`
--

CREATE TABLE `partecipa_tappa` (
  `persona` smallint(6) NOT NULL,
  `tappa` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `partecipa_tappa`
--

INSERT INTO `partecipa_tappa` (`persona`, `tappa`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(3, 32),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 45),
(3, 46),
(3, 47),
(3, 48),
(3, 49),
(3, 50),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(3, 57),
(3, 58),
(3, 59),
(3, 60),
(3, 61),
(3, 62),
(3, 63),
(3, 64),
(3, 65),
(3, 66),
(3, 67),
(3, 68),
(3, 69),
(3, 70),
(3, 71),
(3, 72),
(3, 73),
(3, 74),
(3, 75),
(3, 76),
(3, 77),
(3, 78),
(3, 79),
(3, 80),
(3, 81),
(3, 82),
(3, 83),
(3, 84),
(3, 85),
(1, 31),
(2, 31),
(3, 31),
(4, 31),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 98),
(1, 99),
(1, 100),
(1, 101),
(1, 102),
(1, 103),
(1, 104),
(1, 105),
(1, 106),
(1, 107),
(1, 108),
(1, 109),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 114),
(1, 115),
(1, 116),
(1, 117),
(1, 118),
(1, 119),
(1, 120),
(1, 121),
(1, 122),
(1, 123),
(1, 124),
(1, 125),
(1, 126),
(1, 127),
(1, 128),
(12, 126),
(12, 127),
(12, 128),
(1, 129),
(1, 130),
(1, 131),
(1, 132),
(1, 133),
(1, 134),
(1, 135),
(1, 136),
(1, 137),
(1, 138),
(1, 139),
(1, 140),
(1, 141),
(1, 142),
(1, 143),
(1, 144),
(1, 145),
(1, 146),
(1, 147),
(1, 148),
(1, 149),
(1, 150),
(1, 151),
(1, 152),
(1, 153),
(1, 154),
(1, 155),
(1, 156),
(1, 157),
(1, 158),
(1, 159),
(1, 160),
(1, 161),
(1, 162),
(1, 163),
(1, 164),
(1, 165),
(1, 166),
(1, 167),
(1, 168),
(1, 169),
(1, 170),
(13, 129),
(13, 130),
(13, 131),
(13, 132),
(13, 133),
(13, 134),
(13, 135),
(13, 136),
(13, 137),
(13, 138),
(13, 139),
(13, 140),
(13, 141),
(13, 142),
(13, 143),
(13, 144),
(13, 145),
(13, 146),
(13, 147),
(13, 148),
(13, 149),
(13, 150),
(13, 151),
(13, 152),
(13, 153),
(13, 154),
(13, 155),
(13, 156),
(13, 157),
(13, 158),
(13, 159),
(13, 160),
(13, 161),
(13, 162),
(13, 163),
(13, 164),
(13, 165),
(13, 166),
(13, 167),
(13, 168),
(13, 169),
(13, 170),
(15, 171),
(15, 172),
(15, 173),
(15, 174),
(15, 175),
(15, 176),
(15, 177),
(15, 178),
(15, 179),
(15, 180),
(15, 181),
(15, 182),
(15, 183),
(15, 184),
(15, 185),
(15, 186),
(15, 187),
(15, 188),
(15, 189),
(15, 190),
(15, 191),
(15, 192),
(15, 193),
(15, 194),
(15, 195),
(15, 196),
(15, 197),
(15, 198),
(15, 199),
(15, 200),
(15, 201),
(15, 202),
(15, 203),
(15, 204),
(15, 205),
(15, 206),
(15, 207),
(15, 208),
(15, 209),
(15, 210),
(15, 211),
(15, 212),
(15, 213),
(15, 214),
(15, 215),
(15, 216),
(15, 217),
(15, 218),
(15, 219),
(15, 220),
(15, 221),
(15, 222),
(15, 223),
(15, 224),
(15, 225),
(15, 226),
(15, 227),
(15, 228),
(15, 229),
(15, 230),
(15, 231),
(15, 232),
(15, 233),
(15, 234),
(15, 235),
(15, 236),
(15, 237),
(15, 238),
(15, 239),
(15, 240),
(15, 241),
(15, 242),
(15, 243),
(15, 244),
(15, 245),
(15, 246),
(15, 247),
(15, 248),
(1, 249),
(1, 250),
(1, 251),
(1, 252),
(1, 253),
(1, 254),
(1, 255),
(1, 256),
(1, 257),
(12, 249),
(12, 250),
(12, 251),
(12, 252),
(12, 253),
(12, 254),
(12, 255),
(12, 256),
(12, 257),
(16, 249),
(16, 250),
(16, 251),
(16, 252),
(16, 253),
(16, 254),
(16, 255),
(16, 256),
(16, 257),
(1, 258),
(1, 259),
(1, 260),
(1, 261),
(1, 262),
(1, 263),
(1, 264),
(1, 265),
(1, 266),
(1, 267),
(1, 268),
(1, 269),
(1, 270),
(1, 271),
(1, 272),
(1, 273),
(1, 274),
(1, 275),
(1, 276),
(1, 277),
(1, 278),
(1, 279),
(1, 280),
(1, 281),
(1, 282),
(1, 283),
(1, 284),
(1, 285),
(1, 286),
(1, 287),
(1, 288),
(1, 289),
(1, 290),
(1, 291),
(1, 292),
(1, 293),
(1, 294),
(1, 295),
(1, 296),
(1, 297),
(1, 298),
(1, 299),
(1, 300),
(1, 301),
(1, 302),
(1, 303),
(1, 304),
(1, 305),
(1, 307),
(1, 308),
(1, 309),
(1, 310),
(1, 311),
(1, 312),
(1, 313),
(1, 314),
(1, 315),
(1, 316),
(1, 317),
(1, 318),
(17, 258),
(17, 259),
(17, 260),
(17, 261),
(17, 262),
(17, 263),
(17, 264),
(17, 265),
(17, 266),
(17, 267),
(17, 268),
(17, 269),
(17, 270),
(17, 271),
(17, 272),
(17, 273),
(17, 274),
(17, 275),
(17, 276),
(17, 277),
(17, 278),
(17, 279),
(17, 280),
(17, 281),
(17, 282),
(17, 283),
(17, 284),
(17, 285),
(17, 286),
(17, 287),
(17, 288),
(17, 289),
(17, 290),
(17, 291),
(17, 292),
(17, 293),
(17, 294),
(17, 295),
(17, 296),
(17, 297),
(17, 298),
(17, 299),
(17, 300),
(17, 301),
(17, 302),
(17, 303),
(17, 304),
(17, 305),
(17, 307),
(17, 308),
(17, 309),
(17, 310),
(17, 311),
(17, 312),
(17, 313),
(17, 314),
(17, 315),
(17, 316),
(17, 317),
(17, 318),
(18, 258),
(18, 259),
(18, 260),
(18, 261),
(18, 262),
(18, 263),
(18, 264),
(18, 265),
(18, 266),
(18, 267),
(18, 268),
(18, 269),
(18, 270),
(18, 271),
(18, 272),
(18, 273),
(18, 274),
(18, 275),
(18, 276),
(18, 277),
(18, 278),
(18, 279),
(18, 280),
(18, 281),
(18, 282),
(18, 283),
(18, 284),
(18, 285),
(18, 286),
(18, 287),
(18, 288),
(18, 289),
(18, 290),
(18, 291),
(18, 292),
(18, 293),
(18, 294),
(18, 295),
(18, 296),
(18, 297),
(18, 298),
(18, 299),
(18, 300),
(18, 301),
(18, 302),
(18, 303),
(18, 304),
(18, 305),
(18, 307),
(18, 308),
(18, 309),
(18, 310),
(18, 311),
(18, 312),
(18, 313),
(18, 314),
(18, 315),
(18, 316),
(18, 317),
(18, 318),
(1, 319),
(1, 320),
(1, 321),
(1, 322),
(1, 323),
(1, 324),
(1, 325),
(1, 326),
(1, 327),
(1, 328),
(1, 329),
(1, 330),
(1, 331),
(1, 332),
(1, 333),
(1, 334),
(1, 335),
(1, 336),
(1, 337),
(1, 338),
(1, 339),
(1, 340),
(1, 341),
(1, 342),
(1, 343),
(1, 344),
(1, 345),
(1, 346),
(1, 347),
(1, 348),
(1, 349),
(1, 350),
(1, 351),
(1, 352),
(1, 353),
(19, 319),
(19, 320),
(19, 321),
(19, 322),
(19, 323),
(19, 324),
(19, 325),
(19, 326),
(19, 327),
(19, 328),
(19, 329),
(19, 330),
(19, 331),
(19, 332),
(19, 333),
(19, 334),
(19, 335),
(19, 336),
(19, 337),
(19, 338),
(19, 339),
(19, 340),
(19, 341),
(19, 342),
(19, 343),
(19, 344),
(19, 345),
(19, 346),
(19, 347),
(19, 348),
(19, 349),
(19, 350),
(19, 351),
(19, 352),
(19, 353),
(21, 333),
(21, 334),
(21, 335),
(21, 336),
(21, 337),
(21, 338),
(21, 339),
(21, 340),
(1, 354),
(1, 355),
(1, 356),
(1, 357),
(1, 358),
(1, 359),
(1, 360),
(1, 361),
(1, 362),
(1, 363),
(1, 364),
(1, 365),
(1, 366),
(1, 367),
(1, 368),
(1, 369),
(1, 370),
(1, 371),
(1, 372),
(1, 373),
(1, 374),
(1, 375),
(1, 376),
(21, 370),
(21, 371),
(22, 354),
(22, 355),
(22, 368),
(22, 370),
(22, 371),
(23, 354),
(1, 377),
(1, 378),
(1, 379),
(1, 380),
(1, 381),
(1, 382),
(1, 383),
(1, 384),
(1, 385),
(1, 386),
(1, 387),
(1, 388),
(1, 389),
(1, 390),
(1, 391),
(1, 392),
(1, 393),
(1, 394),
(1, 395),
(1, 396),
(1, 397),
(25, 377),
(25, 378),
(25, 379),
(25, 380),
(25, 381),
(25, 382),
(25, 383),
(25, 384),
(25, 385),
(25, 386),
(25, 387),
(25, 388),
(25, 389),
(25, 390),
(25, 391),
(25, 396),
(26, 377),
(26, 378),
(26, 379),
(26, 380),
(26, 381),
(26, 382),
(26, 383),
(26, 384),
(26, 385),
(26, 386),
(26, 387),
(26, 388),
(26, 389),
(26, 390),
(26, 391),
(27, 380),
(27, 381),
(27, 382),
(27, 383),
(27, 384),
(27, 385),
(27, 386),
(27, 387),
(27, 388),
(27, 389),
(27, 390),
(27, 391);

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipa_viaggio`
--

CREATE TABLE `partecipa_viaggio` (
  `persona` smallint(6) NOT NULL,
  `viaggio` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `partecipa_viaggio`
--

INSERT INTO `partecipa_viaggio` (`persona`, `viaggio`) VALUES
(1, 1),
(1, 2),
(3, 2),
(1, 3),
(1, 4),
(1, 5),
(13, 5),
(15, 6),
(1, 7),
(12, 7),
(16, 7),
(1, 8),
(17, 8),
(18, 8),
(1, 9),
(19, 9),
(1, 10),
(1, 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `Persona`
--

CREATE TABLE `Persona` (
  `id` smallint(6) NOT NULL,
  `nome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `soprannome` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `luogo_nascita` smallint(6) DEFAULT NULL,
  `data_morte` date DEFAULT NULL,
  `luogo_morte` smallint(6) DEFAULT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Persona`
--

INSERT INTO `Persona` (`id`, `nome`, `cognome`, `soprannome`, `data_nascita`, `luogo_nascita`, `data_morte`, `luogo_morte`, `uri`) VALUES
(1, 'Bonaccorso', 'Pitti', NULL, '1354-04-25', 1, '1432-08-05', 1, 'https://www.treccani.it/enciclopedia/buonaccorso-di-neri-pitti_%28Dizionario-Biografico%29/'),
(2, 'Carlo', 'd’Angiò-Durazzo', 'Carlo della Pace', '1345-00-00', 2, '1386-02-24', 3, 'https://www.treccani.it/enciclopedia/carlo-iii-d-angio-durazzo-re-di-napoli-detto-della-pace-o-il-piccolo_%28Dizionario-Biografico%29/'),
(3, 'Bernardo', 'di Lippo', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Giovanni', 'de’ Rossi', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Giovanni', 'dall’Antella', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Stoldo', 'Altoviti', NULL, NULL, NULL, '1392-12-05', NULL, 'https://www.treccani.it/enciclopedia/stoldo-altoviti_(Dizionario-Biografico)/'),
(7, 'Tommaso', 'Soderini', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Bernardo', 'Benvenuti de’ Nobili', NULL, NULL, 1, NULL, NULL, 'https://www.treccani.it/enciclopedia/benvenuti-de-nobili-bernardo_%28Dizionario-Biografico%29/'),
(9, 'Venceslao', 'di Lussemburgo', NULL, '1337-02-25', 113, '1383-12-07', 114, 'https://www.treccani.it/enciclopedia/venceslao-duca-di-lussemburgo-di-brabante-e-di-limburgo/'),
(10, 'Giovanni', 'di Lancaster', 'Giovanni di Gand', '1340-03-06', 115, '1399-02-03', 116, 'https://www.treccani.it/enciclopedia/john-of-gaunt-duca-di-lancaster/'),
(11, 'Giovanni', 'di Châtillon', 'Giovanni di Bretagna', '1345-02-05', 117, '1404-01-16', 118, NULL),
(12, 'Carlo', 'di Valois', 'Carlo VI  il folle di Francia', '1368-12-03', 84, '1422-10-21', 84, 'https://www.treccani.it/enciclopedia/carlo-vi-re-di-francia_%28Enciclopedia-Italiana%29/'),
(13, 'Cino', 'Benvenuti de’ Nobili', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Alberto', 'di Wittelsbach', 'Alberto di Baviera', '1336-07-25', 133, '1404-12-13', 132, 'https://it.wikipedia.org/wiki/Alberto_I_di_Baviera'),
(15, 'Sigerico', 'di Canterbury', 'Sigerico il Serio', NULL, NULL, '0994-10-28', 106, 'https://it.wikipedia.org/wiki/Sigerico_di_Canterbury'),
(16, 'Filippo', 'di Valois-Borgona', 'Filippo II l’ardito di Borgogna', '1342-01-17', 95, '1404-04-27', 209, 'https://www.treccani.it/enciclopedia/filippo-l-ardito-duca-di-borgogna/'),
(17, 'Maso', 'degli Albizzi', NULL, '1343-00-00', 1, '1417-10-02', 1, 'https://www.treccani.it/enciclopedia/maso-albizzi_(Dizionario-Biografico)/'),
(18, 'Vanni', 'Stefani', NULL, NULL, 1, NULL, 1, NULL),
(19, 'Pero', 'da San Miniato', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Francesco', 'da Carrara', 'Francesco Novello da Carrara', '1359-05-29', 223, '1406-01-17', 224, 'https://www.treccani.it/enciclopedia/carrara-francesco-da-il-novello_(Dizionario-Biografico)/'),
(21, 'Roberto', 'di Wittelsbach', 'Roberto del Palatinato', '1352-05-05', 225, '1410-05-18', 226, 'https://www.treccani.it/enciclopedia/roberto-elettore-del-palatinato-e-re-di-germania/'),
(22, 'Andrea', 'Vettori', NULL, NULL, 1, '1409-00-00', 252, 'https://www.treccani.it/enciclopedia/vettori_%28Dizionario-Biografico%29/'),
(23, 'Giovanni', 'de’ Medici', NULL, '1360-02-18', 1, '1429-02-20', 1, 'https://www.treccani.it/enciclopedia/giovanni-di-bicci-de-medici_res-0d7a7119-9b6c-11e6-9e53-00271042e8d9_%28Dizionario-Biografico%29/'),
(24, 'Michele', 'Steno', NULL, '1331-00-00', 224, '1413-12-26', 224, 'https://www.treccani.it/enciclopedia/michele-steno_%28Dizionario-Biografico%29/'),
(25, 'Luigi', 'd’Angiò', 'Luigi II d’Angiò', '1377-10-05', 263, '1417-04-29', 264, 'https://www.treccani.it/enciclopedia/luigi-ii-d-angio-re-di-sicilia_(Dizionario-Biografico)'),
(26, 'Iacopo', 'Salviati', NULL, NULL, 1, NULL, 1, 'https://www.treccani.it/enciclopedia/salviati_(Enciclopedia-Italiana)/'),
(27, 'Muzio', 'Attendolo', 'Sforza da Cotignola', '1369-05-28', 165, '1424-01-04', 277, 'https://www.treccani.it/enciclopedia/attendolo-muzio-detto-sforza_(Dizionario-Biografico)/'),
(28, 'Paolo', 'Orsini', NULL, '1369-00-00', NULL, '1416-08-05', 266, 'https://www.treccani.it/enciclopedia/paolo-orsini_(Dizionario-Biografico)'),
(29, 'Baldassarre', 'Cossia', 'Giovanni XXII', '1370-00-00', 267, '1419-12-22', 1, 'https://www.treccani.it/enciclopedia/antipapa-giovanni-xxiii_(Dizionario-Biografico)');

-- --------------------------------------------------------

--
-- Struttura della tabella `relazione`
--

CREATE TABLE `relazione` (
  `id` smallint(6) NOT NULL,
  `persona1` smallint(6) NOT NULL,
  `persona2` smallint(6) NOT NULL,
  `tipo` smallint(6) NOT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `relazione`
--

INSERT INTO `relazione` (`id`, `persona1`, `persona2`, `tipo`, `data_inizio`, `data_fine`) VALUES
(1, 1, 2, 1, '1380-00-00', '1380-00-00'),
(2, 1, 3, 1, '1380-00-00', '1380-00-00'),
(3, 1, 4, 1, '1380-00-00', '1380-00-00'),
(4, 1, 8, 2, '1380-00-00', '1383-00-00'),
(5, 11, 10, 3, '1356-00-00', '1387-00-00'),
(6, 1, 12, 1, '1382-00-00', '1395-00-00'),
(7, 12, 8, 2, NULL, NULL),
(8, 1, 16, 1, '1383-00-00', '1383-00-00');

-- --------------------------------------------------------

--
-- Struttura della tabella `Scopo`
--

CREATE TABLE `Scopo` (
  `id` smallint(6) NOT NULL,
  `tipo` smallint(6) NOT NULL,
  `successo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Scopo`
--

INSERT INTO `Scopo` (`id`, `tipo`, `successo`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 0),
(8, 8, 1),
(9, 9, 1),
(10, 10, 0),
(11, 1, 1),
(12, 10, 1),
(13, 11, 1),
(14, 12, 1),
(15, 13, 0),
(16, 14, 1),
(17, 15, 1),
(18, 16, 1),
(19, 17, 1),
(20, 18, 1),
(21, 15, 1),
(22, 19, 1),
(23, 20, 1),
(24, 21, 1),
(25, 22, 1),
(26, 23, 1),
(27, 24, 1),
(28, 22, 1),
(29, 25, 1),
(30, 22, 0),
(31, 15, 1),
(32, 26, 1),
(33, 27, 1),
(34, 27, 0),
(35, 28, 1),
(36, 29, 0),
(37, 5, 1),
(38, 30, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Tappa`
--

CREATE TABLE `Tappa` (
  `id` smallint(6) NOT NULL,
  `viaggio` smallint(6) NOT NULL,
  `luogo_partenza` smallint(6) NOT NULL,
  `data_partenza` date DEFAULT NULL,
  `luogo_arrivo` smallint(6) NOT NULL,
  `data_arrivo` date DEFAULT NULL,
  `fonte` smallint(6) NOT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Tappa`
--

INSERT INTO `Tappa` (`id`, `viaggio`, `luogo_partenza`, `data_partenza`, `luogo_arrivo`, `data_arrivo`, `fonte`, `pagine`) VALUES
(1, 1, 4, NULL, 5, NULL, 1, 'p. 480'),
(2, 1, 5, NULL, 6, NULL, 1, 'p. 480'),
(3, 1, 6, NULL, 7, NULL, 1, 'p. 480'),
(4, 1, 7, NULL, 8, NULL, 1, 'p. 480'),
(5, 1, 8, NULL, 9, NULL, 1, 'p. 480'),
(6, 1, 9, NULL, 10, NULL, 1, 'p. 480'),
(7, 1, 10, NULL, 11, NULL, 1, 'p. 480'),
(8, 1, 11, NULL, 12, NULL, 1, 'p. 480'),
(9, 1, 12, NULL, 13, NULL, 1, 'p. 480'),
(10, 1, 13, NULL, 14, NULL, 1, 'p. 480'),
(11, 1, 14, NULL, 15, NULL, 1, 'pp. 378 e 480'),
(12, 1, 15, NULL, 16, NULL, 1, 'p. 480'),
(13, 1, 16, NULL, 17, NULL, 1, 'p. 480'),
(14, 1, 17, NULL, 18, NULL, 1, 'pp. 378 e 480'),
(15, 1, 18, NULL, 19, NULL, 1, 'p. 480'),
(16, 1, 19, NULL, 20, NULL, 1, 'p. 480'),
(17, 1, 20, NULL, 21, NULL, 1, 'p. 480'),
(18, 1, 21, NULL, 22, NULL, 1, 'p. 480'),
(19, 1, 22, NULL, 23, NULL, 1, 'p. 378 e 480'),
(20, 1, 23, NULL, 24, NULL, 1, 'p. 480'),
(21, 1, 24, NULL, 25, NULL, 1, 'p. 378 e 480'),
(22, 1, 25, NULL, 26, NULL, 1, 'p. 480'),
(23, 1, 26, NULL, 27, NULL, 1, 'p. 480'),
(24, 1, 27, NULL, 28, NULL, 1, 'p. 480'),
(25, 1, 28, NULL, 29, NULL, 1, 'p. 480'),
(26, 1, 29, NULL, 30, NULL, 1, 'p. 480'),
(27, 1, 30, NULL, 31, NULL, 1, 'p. 480'),
(28, 1, 31, NULL, 32, NULL, 1, 'p. 378 e 480'),
(29, 1, 32, NULL, 33, NULL, 1, 'p. 378 e 480'),
(30, 1, 33, NULL, 34, NULL, 1, 'p. 480'),
(31, 1, 34, NULL, 32, NULL, 1, 'p. 480'),
(32, 2, 33, NULL, 35, NULL, 1, 'pp. 480-481'),
(33, 2, 35, NULL, 36, NULL, 1, 'pp. 480-481'),
(34, 2, 36, NULL, 37, NULL, 1, 'pp. 480-481'),
(35, 2, 37, NULL, 31, NULL, 1, 'pp. 480-481'),
(36, 2, 31, NULL, 25, NULL, 1, 'pp. 379-380 e 480-481'),
(37, 2, 25, NULL, 38, NULL, 1, 'pp. 480-481'),
(38, 2, 38, NULL, 12, NULL, 1, 'pp. 480-481'),
(39, 2, 12, NULL, 39, NULL, 1, 'pp. 480-481'),
(40, 2, 39, NULL, 40, NULL, 1, 'pp. 480-481'),
(41, 2, 40, NULL, 41, NULL, 1, 'pp. 480-481'),
(42, 2, 41, NULL, 42, NULL, 1, 'pp. 480-481'),
(43, 2, 42, NULL, 43, NULL, 1, 'pp. 480-481'),
(44, 2, 43, NULL, 44, NULL, 1, 'pp. 480-481'),
(45, 2, 44, NULL, 45, NULL, 1, 'pp. 480-481'),
(46, 2, 45, NULL, 46, NULL, 1, 'pp. 480-481'),
(47, 2, 46, NULL, 47, NULL, 1, 'pp. 480-481'),
(48, 2, 47, NULL, 48, NULL, 1, 'pp. 480-481'),
(49, 2, 48, NULL, 49, NULL, 1, 'pp. 480-481'),
(50, 2, 49, NULL, 50, NULL, 1, 'pp. 480-481'),
(51, 2, 50, NULL, 51, NULL, 1, 'pp. 480-481'),
(52, 2, 51, NULL, 52, NULL, 1, 'pp. 480-481'),
(53, 2, 52, NULL, 53, NULL, 1, 'pp. 480-481'),
(54, 2, 53, NULL, 54, NULL, 1, 'pp. 480-481'),
(55, 2, 54, NULL, 55, NULL, 1, 'pp. 480-481'),
(56, 2, 55, NULL, 56, NULL, 1, 'pp. 480-481'),
(57, 2, 56, NULL, 57, NULL, 1, 'pp. 379-380 e 480-481'),
(58, 2, 57, NULL, 58, NULL, 1, 'pp. 379-380 e 480-481'),
(59, 2, 58, NULL, 57, NULL, 1, 'pp. 480-481'),
(60, 2, 57, NULL, 59, NULL, 1, 'pp. 480-481'),
(61, 2, 59, NULL, 60, NULL, 1, 'pp. 480-481'),
(62, 2, 60, NULL, 61, NULL, 1, 'pp. 480-481'),
(63, 2, 61, NULL, 62, NULL, 1, 'pp. 480-481'),
(64, 2, 62, NULL, 63, NULL, 1, 'pp. 480-481'),
(65, 2, 63, NULL, 64, NULL, 1, 'pp. 480-481'),
(66, 2, 64, NULL, 65, NULL, 1, 'pp. 480-481'),
(67, 2, 65, NULL, 66, NULL, 1, 'pp. 480-481'),
(68, 2, 66, NULL, 67, NULL, 1, 'pp. 480-481'),
(69, 2, 67, NULL, 68, NULL, 1, 'pp. 480-481'),
(70, 2, 68, NULL, 69, NULL, 1, 'pp. 480-481'),
(71, 2, 69, NULL, 70, NULL, 1, 'pp. 480-481'),
(72, 2, 70, NULL, 71, NULL, 1, 'pp. 480-481'),
(73, 2, 71, NULL, 72, NULL, 1, 'pp. 480-481'),
(74, 2, 72, NULL, 73, NULL, 1, 'pp. 480-481'),
(75, 2, 73, NULL, 74, NULL, 1, 'pp. 480-481'),
(76, 2, 74, NULL, 75, NULL, 1, 'pp. 480-481'),
(77, 2, 75, NULL, 76, NULL, 1, 'pp. 480-481'),
(78, 2, 76, NULL, 77, NULL, 1, 'pp. 480-481'),
(79, 2, 77, NULL, 78, NULL, 1, 'pp. 480-481'),
(80, 2, 78, NULL, 79, NULL, 1, 'pp. 480-481'),
(81, 2, 79, NULL, 80, NULL, 1, 'pp. 480-481'),
(82, 2, 80, NULL, 81, NULL, 1, 'pp. 480-481'),
(83, 2, 81, NULL, 82, NULL, 1, 'pp. 480-481'),
(84, 2, 82, NULL, 83, NULL, 1, 'pp. 480-481'),
(85, 2, 83, NULL, 84, NULL, 1, 'pp. 379-380 e 480-481'),
(86, 3, 84, NULL, 85, NULL, 1, 'p. 481'),
(87, 3, 85, NULL, 86, NULL, 1, 'p. 481'),
(88, 3, 86, NULL, 87, NULL, 1, 'p. 481'),
(89, 3, 87, NULL, 88, NULL, 1, 'p. 481'),
(90, 3, 88, NULL, 89, NULL, 1, 'p. 481'),
(91, 3, 89, NULL, 90, NULL, 1, 'p. 481'),
(92, 3, 90, NULL, 91, NULL, 1, 'p. 481'),
(93, 3, 91, NULL, 92, NULL, 1, 'p. 481'),
(94, 3, 92, NULL, 93, NULL, 1, 'p. 481'),
(95, 3, 93, NULL, 94, NULL, 1, 'p. 481'),
(96, 3, 94, NULL, 95, NULL, 1, 'p. 481'),
(97, 3, 95, NULL, 96, NULL, 1, 'p. 481'),
(98, 3, 96, NULL, 97, NULL, 1, 'p. 481'),
(99, 3, 97, NULL, 98, NULL, 1, 'p. 481'),
(100, 3, 98, NULL, 96, NULL, 1, 'pp. 380-381 e 481'),
(101, 3, 96, NULL, 99, NULL, 1, 'p. 481'),
(102, 3, 99, NULL, 100, NULL, 1, 'p. 481'),
(103, 3, 100, NULL, 101, NULL, 1, 'p. 481'),
(104, 3, 101, NULL, 102, NULL, 1, 'p. 481'),
(105, 3, 102, NULL, 103, NULL, 1, 'p. 481'),
(106, 3, 103, NULL, 104, NULL, 1, 'p. 481'),
(107, 3, 104, NULL, 105, NULL, 1, 'p. 481'),
(108, 3, 105, NULL, 106, NULL, 1, 'p. 481'),
(109, 3, 106, NULL, 107, NULL, 1, 'p. 481'),
(110, 3, 107, NULL, 108, NULL, 1, 'pp. 380-381 e 481'),
(111, 3, 108, NULL, 107, NULL, 1, 'p. 481'),
(112, 3, 107, NULL, 106, NULL, 1, 'p. 481'),
(113, 3, 106, NULL, 105, NULL, 1, 'p. 481'),
(114, 3, 105, NULL, 104, NULL, 1, 'p. 481'),
(115, 3, 104, NULL, 109, NULL, 1, 'p. 481'),
(116, 3, 109, NULL, 110, NULL, 1, 'p. 481'),
(117, 3, 110, NULL, 111, NULL, 1, 'p. 481'),
(118, 3, 111, NULL, 112, NULL, 1, 'p. 481'),
(119, 3, 112, NULL, 84, NULL, 1, 'pp. 380-381 e 481'),
(120, 4, 84, NULL, 119, NULL, 1, 'p. 482'),
(121, 4, 119, NULL, 120, NULL, 1, 'p. 482'),
(122, 4, 120, NULL, 121, NULL, 1, 'p. 482'),
(123, 4, 121, NULL, 122, NULL, 1, 'p. 482'),
(124, 4, 122, NULL, 123, NULL, 1, 'p. 482'),
(125, 4, 123, NULL, 110, NULL, 1, 'p. 482'),
(126, 4, 110, NULL, 123, '1382-11-30', 1, 'pp. 382-286'),
(127, 4, 123, '1382-11-30', 124, NULL, 1, 'pp. 382-286'),
(128, 4, 124, NULL, 84, '1383-01-00', 1, 'pp. 382-286 e 482'),
(129, 5, 84, '1383-02-00', 125, NULL, 1, 'pp. 482-483'),
(130, 5, 125, NULL, 85, NULL, 1, 'pp. 482-483'),
(131, 5, 85, NULL, 86, NULL, 1, 'pp. 482-483'),
(132, 5, 86, NULL, 87, NULL, 1, 'pp. 482-483'),
(133, 5, 87, NULL, 88, NULL, 1, 'pp. 482-483'),
(134, 5, 88, NULL, 89, NULL, 1, 'pp. 482-483'),
(135, 5, 89, NULL, 90, NULL, 1, 'pp. 482-483'),
(136, 5, 90, NULL, 91, NULL, 1, 'pp. 482-483'),
(137, 5, 91, NULL, 92, NULL, 1, 'pp. 482-483'),
(138, 5, 92, NULL, 93, NULL, 1, 'pp. 482-483'),
(139, 5, 93, NULL, 94, NULL, 1, 'pp. 482-483'),
(140, 5, 94, NULL, 95, NULL, 1, 'pp. 482-483'),
(141, 5, 95, NULL, 96, NULL, 1, 'pp. 386-387 e 482-483'),
(142, 5, 96, NULL, 98, NULL, 1, 'pp. 482-483'),
(143, 5, 98, NULL, 126, NULL, 1, 'pp. 482-483'),
(144, 5, 126, NULL, 127, NULL, 1, 'pp. 482-483'),
(145, 5, 127, NULL, 128, NULL, 1, 'pp. 482-483'),
(146, 5, 128, NULL, 129, NULL, 1, 'pp. 482-483'),
(147, 5, 129, NULL, 130, NULL, 1, 'pp. 482-483'),
(148, 5, 130, NULL, 131, NULL, 1, 'pp. 482-483'),
(149, 5, 131, NULL, 132, NULL, 1, 'pp. 386-387 e 482-483'),
(150, 5, 132, NULL, 131, NULL, 1, 'pp. 482-483'),
(151, 5, 131, NULL, 130, NULL, 1, 'pp. 482-483'),
(152, 5, 130, NULL, 129, NULL, 1, 'pp. 482-483'),
(153, 5, 129, NULL, 128, NULL, 1, 'pp. 482-483'),
(154, 5, 128, NULL, 127, NULL, 1, 'pp. 482-483'),
(155, 5, 127, NULL, 126, NULL, 1, 'pp. 482-483'),
(156, 5, 126, NULL, 98, NULL, 1, 'pp. 482-483'),
(157, 5, 98, NULL, 96, NULL, 1, 'pp. 482-483'),
(158, 5, 96, NULL, 95, NULL, 1, 'pp. 482-483'),
(159, 5, 95, NULL, 94, NULL, 1, 'pp. 482-483'),
(160, 5, 94, NULL, 93, NULL, 1, 'pp. 482-483'),
(161, 5, 93, NULL, 92, NULL, 1, 'pp. 482-483'),
(162, 5, 92, NULL, 91, NULL, 1, 'pp. 482-483'),
(163, 5, 91, NULL, 90, NULL, 1, 'pp. 482-483'),
(164, 5, 90, NULL, 89, NULL, 1, 'pp. 482-483'),
(165, 5, 89, NULL, 88, NULL, 1, 'pp. 482-483'),
(166, 5, 88, NULL, 87, NULL, 1, 'pp. 482-483'),
(167, 5, 87, NULL, 86, NULL, 1, 'pp. 482-483'),
(168, 5, 86, NULL, 85, NULL, 1, 'pp. 482-483'),
(169, 5, 85, NULL, 125, NULL, 1, 'pp. 482-483'),
(170, 5, 125, NULL, 84, '1383-04-00', 1, 'pp. 386-387 e 482-483'),
(171, 6, 134, NULL, 135, NULL, 2, NULL),
(172, 6, 135, NULL, 136, NULL, 2, NULL),
(173, 6, 136, NULL, 137, NULL, 2, NULL),
(174, 6, 137, NULL, 138, NULL, 2, NULL),
(175, 6, 138, NULL, 139, NULL, 2, NULL),
(176, 6, 139, NULL, 140, NULL, 2, NULL),
(177, 6, 140, NULL, 141, NULL, 2, NULL),
(178, 6, 141, NULL, 142, NULL, 2, NULL),
(179, 6, 142, NULL, 143, NULL, 2, NULL),
(180, 6, 143, NULL, 144, NULL, 2, NULL),
(181, 6, 144, NULL, 145, NULL, 2, NULL),
(182, 6, 145, NULL, 146, NULL, 2, NULL),
(183, 6, 146, NULL, 147, NULL, 2, NULL),
(184, 6, 147, NULL, 148, NULL, 2, NULL),
(185, 6, 148, NULL, 34, NULL, 2, NULL),
(186, 6, 34, NULL, 149, NULL, 2, NULL),
(187, 6, 149, NULL, 150, NULL, 2, NULL),
(188, 6, 150, NULL, 151, NULL, 2, NULL),
(189, 6, 151, NULL, 152, NULL, 2, NULL),
(190, 6, 153, NULL, 154, NULL, 2, NULL),
(191, 6, 154, NULL, 155, NULL, 2, NULL),
(192, 6, 155, NULL, 156, NULL, 2, NULL),
(193, 6, 156, NULL, 157, NULL, 2, NULL),
(194, 6, 157, NULL, 6, NULL, 2, NULL),
(195, 6, 6, NULL, 158, NULL, 2, NULL),
(196, 6, 158, NULL, 159, NULL, 2, NULL),
(197, 6, 159, NULL, 160, NULL, 2, NULL),
(198, 6, 160, NULL, 161, NULL, 2, NULL),
(199, 6, 161, NULL, 162, NULL, 2, NULL),
(200, 6, 162, NULL, 9, NULL, 2, NULL),
(201, 6, 9, NULL, 11, NULL, 2, NULL),
(202, 6, 11, NULL, 163, NULL, 2, NULL),
(203, 6, 163, NULL, 41, NULL, 2, NULL),
(204, 6, 41, NULL, 42, NULL, 2, NULL),
(205, 6, 42, NULL, 43, NULL, 2, NULL),
(206, 6, 43, NULL, 164, NULL, 2, NULL),
(207, 6, 164, NULL, 165, NULL, 2, NULL),
(208, 6, 165, NULL, 166, NULL, 2, NULL),
(209, 6, 166, NULL, 167, NULL, 2, NULL),
(210, 6, 167, NULL, 48, NULL, 2, NULL),
(211, 6, 48, NULL, 168, NULL, 2, NULL),
(212, 6, 168, NULL, 169, NULL, 2, NULL),
(213, 6, 169, NULL, 170, NULL, 2, NULL),
(214, 6, 170, NULL, 171, NULL, 2, NULL),
(215, 6, 171, NULL, 172, NULL, 2, NULL),
(216, 6, 172, NULL, 173, NULL, 2, NULL),
(217, 6, 173, NULL, 174, NULL, 2, NULL),
(218, 6, 174, NULL, 175, NULL, 2, NULL),
(219, 6, 175, NULL, 176, NULL, 2, NULL),
(220, 6, 176, NULL, 177, NULL, 2, NULL),
(221, 6, 177, NULL, 178, NULL, 2, NULL),
(222, 6, 178, NULL, 179, NULL, 2, NULL),
(223, 6, 179, NULL, 180, NULL, 2, NULL),
(224, 6, 180, NULL, 181, NULL, 2, NULL),
(225, 6, 181, NULL, 182, NULL, 2, NULL),
(226, 6, 182, NULL, 183, NULL, 2, NULL),
(227, 6, 183, NULL, 184, NULL, 2, NULL),
(228, 6, 184, NULL, 185, NULL, 2, NULL),
(229, 6, 185, NULL, 186, NULL, 2, NULL),
(230, 6, 186, NULL, 187, NULL, 2, NULL),
(231, 6, 187, NULL, 188, NULL, 2, NULL),
(232, 6, 188, NULL, 189, NULL, 2, NULL),
(233, 6, 189, NULL, 190, NULL, 2, NULL),
(234, 6, 190, NULL, 191, NULL, 2, NULL),
(235, 6, 191, NULL, 192, NULL, 2, NULL),
(236, 6, 192, NULL, 193, NULL, 2, NULL),
(237, 6, 193, NULL, 194, NULL, 2, NULL),
(238, 6, 194, NULL, 195, NULL, 2, NULL),
(239, 6, 195, NULL, 196, NULL, 2, NULL),
(240, 6, 196, NULL, 197, NULL, 2, NULL),
(241, 6, 197, NULL, 198, NULL, 2, NULL),
(242, 6, 198, NULL, 111, NULL, 2, NULL),
(243, 6, 111, NULL, 199, NULL, 2, NULL),
(244, 6, 199, NULL, 200, NULL, 2, NULL),
(245, 6, 200, NULL, 201, NULL, 2, NULL),
(246, 6, 201, NULL, 202, NULL, 2, NULL),
(247, 6, 202, NULL, 105, NULL, 2, NULL),
(248, 6, 105, NULL, 106, NULL, 2, NULL),
(249, 7, 84, NULL, 93, NULL, 1, 'pp. 387-389 e 482'),
(250, 7, 93, NULL, 203, NULL, 1, 'pp. 482'),
(251, 7, 203, NULL, 204, NULL, 1, 'pp. 387-389'),
(252, 7, 204, NULL, 93, NULL, 1, 'pp. 387-389 e 482'),
(253, 7, 93, NULL, 205, NULL, 1, 'pp. 482'),
(254, 7, 205, NULL, 206, NULL, 1, 'pp. 482'),
(255, 7, 206, NULL, 207, NULL, 1, 'pp. 482'),
(256, 7, 207, NULL, 208, NULL, 1, 'pp. 482'),
(257, 7, 208, NULL, 84, NULL, 1, 'pp. 482'),
(258, 8, 1, '1396-07-20', 38, NULL, 1, 'pp. 486'),
(259, 8, 38, NULL, 210, NULL, 1, 'pp. 486'),
(260, 8, 210, NULL, 211, NULL, 1, 'pp. 486'),
(261, 8, 211, NULL, 44, NULL, 1, 'pp. 486'),
(262, 8, 44, NULL, 46, NULL, 1, 'pp. 486'),
(263, 8, 46, NULL, 212, NULL, 1, 'pp. 486'),
(264, 8, 212, NULL, 213, NULL, 1, 'pp. 486'),
(265, 8, 213, NULL, 214, NULL, 1, 'pp. 486'),
(266, 8, 214, NULL, 215, NULL, 1, 'pp. 486'),
(267, 8, 215, NULL, 216, NULL, 1, 'pp. 486'),
(268, 8, 216, NULL, 69, NULL, 1, 'pp. 486'),
(269, 8, 69, NULL, 70, NULL, 1, 'pp. 486'),
(270, 8, 71, NULL, 72, NULL, 1, 'pp. 486'),
(271, 8, 72, NULL, 73, NULL, 1, 'pp. 486'),
(272, 8, 73, NULL, 74, NULL, 1, 'pp. 486'),
(273, 8, 74, NULL, 75, NULL, 1, 'pp. 486'),
(274, 8, 75, NULL, 76, NULL, 1, 'pp. 486'),
(275, 8, 76, NULL, 77, NULL, 1, 'pp. 486'),
(276, 8, 77, NULL, 78, NULL, 1, 'pp. 486'),
(277, 8, 78, NULL, 79, NULL, 1, 'pp. 486'),
(278, 8, 79, NULL, 80, NULL, 1, 'pp. 486'),
(279, 8, 80, NULL, 81, NULL, 1, 'pp. 486'),
(280, 8, 81, NULL, 82, NULL, 1, 'pp. 486'),
(281, 8, 82, NULL, 83, NULL, 1, 'pp. 486'),
(282, 8, 83, NULL, 84, NULL, 1, 'pp. 404-406 e 486'),
(283, 8, 84, NULL, 83, NULL, 1, 'pp. 486'),
(284, 8, 83, NULL, 82, NULL, 1, 'pp. 486'),
(285, 8, 82, NULL, 81, NULL, 1, 'pp. 486'),
(286, 8, 81, NULL, 80, NULL, 1, 'pp. 486'),
(287, 8, 80, NULL, 79, NULL, 1, 'pp. 486'),
(288, 8, 79, NULL, 78, NULL, 1, 'pp. 486'),
(289, 8, 78, NULL, 77, NULL, 1, 'pp. 486'),
(290, 8, 77, NULL, 76, NULL, 1, 'pp. 486'),
(291, 8, 76, NULL, 75, NULL, 1, 'pp. 486'),
(292, 8, 75, NULL, 74, NULL, 1, 'pp. 486'),
(293, 8, 74, NULL, 73, NULL, 1, 'pp. 486'),
(294, 8, 73, NULL, 72, NULL, 1, 'pp. 486'),
(295, 8, 72, NULL, 71, NULL, 1, 'pp. 486'),
(296, 8, 71, NULL, 70, NULL, 1, 'pp. 486'),
(297, 8, 70, NULL, 69, NULL, 1, 'pp. 486'),
(298, 8, 69, NULL, 68, NULL, 1, 'pp. 486'),
(299, 8, 68, NULL, 67, NULL, 1, 'pp. 486'),
(300, 8, 67, NULL, 66, NULL, 1, 'pp. 486'),
(301, 8, 66, NULL, 65, NULL, 1, 'pp. 486'),
(302, 8, 65, NULL, 64, NULL, 1, 'pp. 486'),
(303, 8, 64, NULL, 63, NULL, 1, 'pp. 486'),
(304, 8, 63, NULL, 62, NULL, 1, 'pp. 486'),
(305, 8, 62, NULL, 61, NULL, 1, 'pp. 486'),
(307, 8, 61, NULL, 60, NULL, 1, 'pp. 486'),
(308, 8, 60, NULL, 59, NULL, 1, 'pp. 486'),
(309, 8, 59, NULL, 58, NULL, 1, 'pp. 486'),
(310, 8, 58, NULL, 57, '1396-11-11', 1, 'pp. 404-406 e 486'),
(311, 8, 57, NULL, 217, NULL, 1, 'pp. 486'),
(312, 8, 217, NULL, 218, NULL, 1, 'pp. 486'),
(313, 8, 218, NULL, 219, NULL, 1, 'pp. 486'),
(314, 8, 219, NULL, 220, NULL, 1, 'pp. 486'),
(315, 8, 220, NULL, 221, NULL, 1, 'pp. 404-406 e 486'),
(316, 8, 221, NULL, 4, NULL, 1, 'pp. 404-406 e 486'),
(317, 8, 4, NULL, 222, NULL, 1, 'pp. 404-406'),
(318, 8, 222, NULL, 1, '1396-12-25', 1, 'pp. 404-406 e 486'),
(319, 9, 1, '1401-03-15', 223, NULL, 1, 'pp. 416-422 e 487'),
(320, 9, 223, NULL, 227, NULL, 1, 'pp. 487'),
(321, 9, 227, NULL, 228, NULL, 1, 'pp. 487'),
(322, 9, 228, NULL, 229, NULL, 1, 'pp. 487'),
(323, 9, 229, NULL, 230, NULL, 1, 'pp. 487'),
(324, 9, 230, NULL, 231, NULL, 1, 'pp. 487'),
(325, 9, 231, NULL, 232, NULL, 1, 'pp. 487'),
(326, 9, 232, NULL, 233, NULL, 1, 'pp. 487'),
(327, 9, 233, NULL, 234, NULL, 1, 'pp. 487'),
(328, 9, 234, NULL, 235, NULL, 1, 'pp. 487'),
(329, 9, 235, NULL, 236, NULL, 1, 'pp. 416-422 e 487'),
(330, 9, 236, NULL, 133, NULL, 1, 'pp. 416-422 e 487'),
(331, 9, 133, NULL, 237, NULL, 1, 'pp. 416-422 e 487'),
(332, 9, 237, NULL, 225, NULL, 1, 'pp. 416-422 e 487'),
(333, 9, 225, NULL, 238, NULL, 1, 'pp. 487'),
(334, 9, 238, NULL, 239, NULL, 1, 'pp. 416-422 e 487'),
(335, 9, 239, NULL, 240, NULL, 1, 'pp. 487'),
(336, 9, 240, NULL, 241, NULL, 1, 'pp. 487'),
(337, 9, 241, NULL, 242, NULL, 1, 'pp. 416-422 e 487'),
(338, 9, 242, NULL, 243, NULL, 1, 'pp. 487'),
(339, 9, 243, NULL, 226, NULL, 1, 'pp. 487'),
(340, 9, 226, NULL, 244, NULL, 1, 'pp. 416-422 e 487'),
(341, 9, 244, NULL, 242, '1401-07-18', 1, 'pp. 416-422 e 487'),
(342, 9, 242, NULL, 245, NULL, 1, 'pp. 487'),
(343, 9, 245, NULL, 133, NULL, 1, 'pp. 487'),
(344, 9, 242, NULL, 245, NULL, 1, 'pp. 487'),
(345, 9, 245, NULL, 246, NULL, 1, 'pp. 487'),
(346, 9, 246, NULL, 247, NULL, 1, 'pp. 487'),
(347, 9, 247, NULL, 248, NULL, 1, 'pp. 487'),
(348, 9, 248, NULL, 224, NULL, 1, 'pp. 487'),
(349, 9, 224, NULL, 223, '1401-07-30', 1, 'pp. 416-422 e 487'),
(350, 9, 223, NULL, 249, NULL, 1, 'pp. 487'),
(351, 9, 249, NULL, 250, NULL, 1, 'pp. 487'),
(352, 9, 250, NULL, 251, NULL, 1, 'pp. 487'),
(353, 9, 251, NULL, 1, NULL, 1, 'pp. 416-422 e 487'),
(354, 10, 1, '1401-08-15', 224, NULL, 1, 'pp. 422-428 e 487-488'),
(355, 10, 224, NULL, 245, NULL, 1, 'pp. 422-428 e 487-488'),
(356, 10, 245, NULL, 247, NULL, 1, 'pp. 487-488'),
(357, 10, 247, NULL, 253, NULL, 1, 'pp. 487-488'),
(358, 10, 253, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488'),
(359, 10, 224, NULL, 254, NULL, 1, 'pp. 487-488'),
(360, 10, 254, NULL, 255, NULL, 1, 'pp. 487-488'),
(361, 10, 255, NULL, 256, NULL, 1, 'pp. 487-488'),
(362, 10, 256, NULL, 257, NULL, 1, 'pp. 487-488'),
(363, 10, 257, NULL, 258, NULL, 1, 'pp. 422-428 e 487-488'),
(364, 10, 258, NULL, 247, NULL, 1, 'pp. 422-428'),
(365, 10, 247, NULL, 248, NULL, 1, 'pp. 422-428 e 487-488'),
(366, 10, 248, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488'),
(367, 10, 224, NULL, 223, NULL, 1, 'pp. 422-428 e 487-488'),
(368, 10, 223, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488'),
(369, 10, 224, NULL, 259, NULL, 1, 'pp. 422-428 e 487-488'),
(370, 10, 259, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488'),
(371, 10, 224, NULL, 223, NULL, 1, 'pp. 422-428 e 487-488'),
(372, 10, 223, NULL, 260, NULL, 1, 'pp. 487-488'),
(373, 10, 260, NULL, 261, NULL, 1, 'pp. 487-488'),
(374, 10, 261, NULL, 262, NULL, 1, 'pp. 487-488'),
(375, 10, 262, NULL, 38, NULL, 1, 'pp. 487-488'),
(376, 10, 38, NULL, 1, NULL, 1, 'pp. 422-428 e 487-488'),
(377, 11, 1, '1410-07-24', 148, NULL, 1, 'pp. 488-489'),
(378, 11, 138, NULL, 268, NULL, 1, 'pp. 488-489'),
(379, 11, 268, NULL, 269, NULL, 1, 'pp. 444-446 e 488-489'),
(380, 11, 269, NULL, 270, NULL, 1, 'pp. 488-489'),
(381, 11, 270, NULL, 142, NULL, 1, 'pp. 488-489'),
(382, 11, 142, NULL, 271, NULL, 1, 'pp. 488-489'),
(383, 11, 271, NULL, 141, NULL, 1, 'pp. 488-489'),
(384, 11, 141, NULL, 140, NULL, 1, 'pp. 488-489'),
(385, 11, 140, NULL, 272, NULL, 1, 'pp. 488-489'),
(386, 11, 272, NULL, 137, NULL, 1, 'pp. 488-489'),
(387, 11, 137, NULL, 273, NULL, 1, 'pp. 488-489'),
(388, 11, 273, NULL, 134, NULL, 1, 'pp. 444-446 e 488-489'),
(389, 11, 134, '1410-12-31', 274, NULL, 1, 'pp. 488-489'),
(390, 11, 274, NULL, 275, NULL, 1, 'pp. 488-489'),
(391, 11, 275, NULL, 276, NULL, 1, 'pp. 444-446'),
(392, 11, 276, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489'),
(393, 11, 1, NULL, 38, NULL, 1, 'pp. 444-446 e 488-489'),
(394, 11, 38, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489'),
(395, 11, 1, NULL, 276, NULL, 1, 'pp. 444-446'),
(396, 11, 276, NULL, 148, NULL, 1, 'pp. 444-446 e 488-489'),
(397, 11, 148, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489');

-- --------------------------------------------------------

--
-- Struttura della tabella `Tipo_Relazione`
--

CREATE TABLE `Tipo_Relazione` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Tipo_Relazione`
--

INSERT INTO `Tipo_Relazione` (`id`, `tipo`) VALUES
(1, 'al seguito di'),
(2, 'lavora per'),
(3, 'prigioniero di');

-- --------------------------------------------------------

--
-- Struttura della tabella `Tipo_Scopo`
--

CREATE TABLE `Tipo_Scopo` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Tipo_Scopo`
--

INSERT INTO `Tipo_Scopo` (`id`, `tipo`) VALUES
(1, 'raggiungere l’esercito di'),
(2, 'combattere per conto di'),
(3, 'trasferirsi a Parigi'),
(4, 'ottenere un prestito da'),
(5, 'visitare'),
(6, 'giocare d\'azzardo con'),
(7, 'trattare la liberazione di Giovanni di Bretagna con'),
(8, 'rientrare a Parigi'),
(9, 'combattere i ribelli di Gand per conto di'),
(10, 'vendere o giocare con'),
(11, 'rientrare a Canterbury'),
(12, 'conquistare Mons'),
(13, 'sconfiggere gli inglesi'),
(14, 'ritirarsi'),
(15, 'formare un alleanza con'),
(16, 'rientrare a Firenze'),
(17, 'chiedere un salvacondotto a'),
(18, 'riconoscere l’elezione di'),
(19, 'organizzare il pagamento per'),
(20, 'rientrare a Padova'),
(21, 'trasportare fondi per'),
(22, 'fare ambasciata a'),
(23, 'prendere fondi'),
(24, 'consegnare fondi a'),
(25, 'persuadere a rimanere'),
(26, 'aiutare l’esercito di'),
(27, 'assoldare'),
(28, 'rientrare a Prato'),
(29, 'chiedere aiuto legale a'),
(30, 'accompagnare');

-- --------------------------------------------------------

--
-- Struttura della tabella `trasporta`
--

CREATE TABLE `trasporta` (
  `tappa` smallint(6) NOT NULL,
  `merce` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `trasporta`
--

INSERT INTO `trasporta` (`tappa`, `merce`) VALUES
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(354, 2),
(359, 2),
(360, 2),
(361, 2),
(362, 2),
(363, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE `Utente` (
  `nick` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `nome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `ente` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `ruolo` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`nick`, `nome`, `cognome`, `ente`, `ruolo`, `password`) VALUES
('acignoni', 'Alessandro', 'Cignoni', 'Università di Pisa', 'Studente', 'alessandro1');

-- --------------------------------------------------------

--
-- Struttura della tabella `Viaggio`
--

CREATE TABLE `Viaggio` (
  `id` smallint(6) NOT NULL,
  `titolo` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `luogo_partenza` smallint(6) NOT NULL,
  `data_partenza` date DEFAULT NULL,
  `luogo_meta` smallint(6) NOT NULL,
  `data_fine` date DEFAULT NULL,
  `piano` blob DEFAULT NULL,
  `fonte` smallint(6) NOT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `scala` varchar(16) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Viaggio`
--

INSERT INTO `Viaggio` (`id`, `titolo`, `luogo_partenza`, `data_partenza`, `luogo_meta`, `data_fine`, `piano`, `fonte`, `pagine`, `scala`) VALUES
(1, 'Dietro a Carlo della Pace', 4, '1380-00-00', 1, '1380-00-00', 0x7261676769756e67657265204361726c6f2064656c6c612050616365206520756e6972736920616c2073756f20657365726369746f20636f73c3ac2063686520696c207265207265696e7365646961737365206ce280996f6c6967617263686961206120466972656e7a652c20646f6d696e61746120616c6c6f72612064616c20726567696d65206465692043696f6d70690a, 1, 'pp. 377-379 e 480', 'Italia'),
(2, 'Trasferimento a Parigi', 32, '1380-00-00', 84, '1380-00-00', NULL, 1, 'pp. 379-380 e 480-481', 'Europa'),
(3, 'Gioco d’azzardo e prigionieri', 84, '1380-00-00', 96, '1380-00-00', NULL, 1, 'pp. 380-381 e 481', 'Fiandre'),
(4, 'Guerra contro Gand', 84, '1382-00-00', 115, '1383-00-00', 0x736564617265206c61207269766f6c7461206465676c692061626974616e74692064692047616e64, 1, 'pp. 382-286 e 482', 'Fiandre'),
(5, 'Perle per il duca', 84, '1383-02-00', 132, '1383-04-00', NULL, 1, 'pp. 386-387 e 482-483', 'Fiandre'),
(6, '“Adventus archiespiscopi nostri”', 134, '0990-00-00', 106, '0990-00-00', NULL, 2, NULL, 'Europa'),
(7, 'La guerra dei cent’anni', 84, '1383-00-00', 93, '1383-00-00', NULL, 1, 'pp. 387-389 e 482', 'Fiandre'),
(8, '“Conchiudere lega” col re di Francia', 1, '1396-07-20', 84, '1396-12-15', NULL, 1, 'pp. 404-406 e 486', 'Europa'),
(9, '“In Alemagna al nuovo eletto Imperadore”', 1, '1401-03-15', 225, '1401-12-30', NULL, 1, 'pp. 416-422 e 487', 'Europa'),
(10, 'Discesa in Italia', 1, '1401-08-15', 46, '1402-00-00', 0x61697574617265206ce28099696d70657261746f726520526f626572746f2064656c2050616c6174696e61746f20612064697363656e6465726520696e204974616c6961207065722073636f6e6669676765726520696c2064756361206469204d696c616e6f, 1, 'pp. 422-428 e 487-488', 'Europa'),
(11, 'Dietro a Luigi d’Angiò', 1, '1410-07-24', 134, '1411-00-00', 0x616e6461726520696e2067756572726120636f6e74726f20696c207265204c616469736c616f2049206469204e61706f6c69, 1, 'pp. 444-446 e 488-489', 'Italia');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Biografia`
--
ALTER TABLE `Biografia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_biografia_persona` (`persona`),
  ADD KEY `fk_biografia_viaggio1` (`viaggio1`),
  ADD KEY `fk_biografia_viaggio2` (`viaggio2`);

--
-- Indici per le tabelle `Commento_Biografia`
--
ALTER TABLE `Commento_Biografia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_commento_biografia_autore` (`autore`),
  ADD KEY `fk_commento_biografia_biografia` (`biografia`);

--
-- Indici per le tabelle `Commento_Viaggio`
--
ALTER TABLE `Commento_Viaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_commento_viaggio_autore` (`autore`),
  ADD KEY `fk_commento_viaggio_viaggio` (`viaggio`);

--
-- Indici per le tabelle `destinatario`
--
ALTER TABLE `destinatario`
  ADD KEY `fk_destnatario_scopo` (`scopo`),
  ADD KEY `fk_destinatario_persona` (`persona`);

--
-- Indici per le tabelle `Evento`
--
ALTER TABLE `Evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_biografia` (`biografia`),
  ADD KEY `fk_evento_immagine` (`immagine`);

--
-- Indici per le tabelle `Fonte`
--
ALTER TABLE `Fonte`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Immagine`
--
ALTER TABLE `Immagine`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locazione` (`locazione`);

--
-- Indici per le tabelle `lavora_come`
--
ALTER TABLE `lavora_come`
  ADD KEY `fk_lavora_come_persona` (`persona`),
  ADD KEY `fk_lavora_come_occupazione` (`occupazione`);

--
-- Indici per le tabelle `Luogo`
--
ALTER TABLE `Luogo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `mandante`
--
ALTER TABLE `mandante`
  ADD KEY `fk_mandante_scopo` (`scopo`),
  ADD KEY `fk_mandante_persona` (`persona`);

--
-- Indici per le tabelle `Merce`
--
ALTER TABLE `Merce`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `motivo_tappa`
--
ALTER TABLE `motivo_tappa`
  ADD KEY `fk_motivo_tappa_tappa` (`tappa`),
  ADD KEY `fk_motivo_tappa_scopo` (`scopo`);

--
-- Indici per le tabelle `motivo_viaggio`
--
ALTER TABLE `motivo_viaggio`
  ADD KEY `fk_motivo_viaggio_scopo` (`scopo`),
  ADD KEY `fk_motivo_viaggio_viaggio` (`viaggio`);

--
-- Indici per le tabelle `Occupazione`
--
ALTER TABLE `Occupazione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `partecipa_tappa`
--
ALTER TABLE `partecipa_tappa`
  ADD KEY `fk_partecipa_tappa_persona` (`persona`),
  ADD KEY `fk_partecipa_tappa_tappa` (`tappa`);

--
-- Indici per le tabelle `partecipa_viaggio`
--
ALTER TABLE `partecipa_viaggio`
  ADD KEY `fk_partecipa_viaggio_viaggio` (`viaggio`),
  ADD KEY `fk_partecipa_viaggio_persona` (`persona`);

--
-- Indici per le tabelle `Persona`
--
ALTER TABLE `Persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_persona_luogo_nascita` (`luogo_nascita`),
  ADD KEY `fk_persona_luogo_morte` (`luogo_morte`);

--
-- Indici per le tabelle `relazione`
--
ALTER TABLE `relazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_partecipa_tappa_persona1` (`persona1`),
  ADD KEY `fk_partecipa_tappa_persona2` (`persona2`),
  ADD KEY `fk_relazione_tipo` (`tipo`);

--
-- Indici per le tabelle `Scopo`
--
ALTER TABLE `Scopo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_scopo_tipo` (`tipo`);

--
-- Indici per le tabelle `Tappa`
--
ALTER TABLE `Tappa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tappa_luogo_partenza` (`luogo_partenza`),
  ADD KEY `fk_viaggio_luogo_arrivo` (`luogo_arrivo`);

--
-- Indici per le tabelle `Tipo_Relazione`
--
ALTER TABLE `Tipo_Relazione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `Tipo_Scopo`
--
ALTER TABLE `Tipo_Scopo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `trasporta`
--
ALTER TABLE `trasporta`
  ADD KEY `fk_trasporta_tappa` (`tappa`),
  ADD KEY `fk_trasporta_merce` (`merce`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`nick`);

--
-- Indici per le tabelle `Viaggio`
--
ALTER TABLE `Viaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_viaggio_luogo_partenza` (`luogo_partenza`),
  ADD KEY `fk_viaggio_luogo_meta` (`luogo_meta`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Biografia`
--
ALTER TABLE `Biografia`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Commento_Biografia`
--
ALTER TABLE `Commento_Biografia`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `Commento_Viaggio`
--
ALTER TABLE `Commento_Viaggio`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Evento`
--
ALTER TABLE `Evento`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `Fonte`
--
ALTER TABLE `Fonte`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Immagine`
--
ALTER TABLE `Immagine`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `Luogo`
--
ALTER TABLE `Luogo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT per la tabella `Merce`
--
ALTER TABLE `Merce`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Occupazione`
--
ALTER TABLE `Occupazione`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `Persona`
--
ALTER TABLE `Persona`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT per la tabella `relazione`
--
ALTER TABLE `relazione`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `Scopo`
--
ALTER TABLE `Scopo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT per la tabella `Tappa`
--
ALTER TABLE `Tappa`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=398;

--
-- AUTO_INCREMENT per la tabella `Tipo_Relazione`
--
ALTER TABLE `Tipo_Relazione`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `Tipo_Scopo`
--
ALTER TABLE `Tipo_Scopo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `Viaggio`
--
ALTER TABLE `Viaggio`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Biografia`
--
ALTER TABLE `Biografia`
  ADD CONSTRAINT `fk_biografia_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_biografia_viaggio1` FOREIGN KEY (`viaggio1`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_biografia_viaggio2` FOREIGN KEY (`viaggio2`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Commento_Biografia`
--
ALTER TABLE `Commento_Biografia`
  ADD CONSTRAINT `fk_commento_biografia_autore` FOREIGN KEY (`autore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commento_biografia_biografia` FOREIGN KEY (`biografia`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Commento_Viaggio`
--
ALTER TABLE `Commento_Viaggio`
  ADD CONSTRAINT `fk_commento_viaggio_autore` FOREIGN KEY (`autore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commento_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `destinatario`
--
ALTER TABLE `destinatario`
  ADD CONSTRAINT `fk_destinatario_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_destnatario_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Evento`
--
ALTER TABLE `Evento`
  ADD CONSTRAINT `fk_evento_biografia` FOREIGN KEY (`biografia`) REFERENCES `Biografia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evento_immagine` FOREIGN KEY (`immagine`) REFERENCES `Immagine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `lavora_come`
--
ALTER TABLE `lavora_come`
  ADD CONSTRAINT `fk_lavora_come_occupazione` FOREIGN KEY (`occupazione`) REFERENCES `Occupazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lavora_come_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `mandante`
--
ALTER TABLE `mandante`
  ADD CONSTRAINT `fk_mandante_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mandante_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `motivo_tappa`
--
ALTER TABLE `motivo_tappa`
  ADD CONSTRAINT `fk_motivo_tappa_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_motivo_tappa_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `motivo_viaggio`
--
ALTER TABLE `motivo_viaggio`
  ADD CONSTRAINT `fk_motivo_viaggio_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_motivo_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `partecipa_tappa`
--
ALTER TABLE `partecipa_tappa`
  ADD CONSTRAINT `fk_partecipa_tappa_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_partecipa_tappa_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `partecipa_viaggio`
--
ALTER TABLE `partecipa_viaggio`
  ADD CONSTRAINT `fk_partecipa_viaggio_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_partecipa_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Persona`
--
ALTER TABLE `Persona`
  ADD CONSTRAINT `fk_persona_luogo_morte` FOREIGN KEY (`luogo_morte`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_luogo_nascita` FOREIGN KEY (`luogo_nascita`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `relazione`
--
ALTER TABLE `relazione`
  ADD CONSTRAINT `fk_partecipa_tappa_persona1` FOREIGN KEY (`persona1`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_partecipa_tappa_persona2` FOREIGN KEY (`persona2`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relazione_tipo` FOREIGN KEY (`tipo`) REFERENCES `Tipo_Relazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Scopo`
--
ALTER TABLE `Scopo`
  ADD CONSTRAINT `fk_scopo_tipo` FOREIGN KEY (`tipo`) REFERENCES `Tipo_Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Tappa`
--
ALTER TABLE `Tappa`
  ADD CONSTRAINT `fk_tappa_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_luogo_arrivo` FOREIGN KEY (`luogo_arrivo`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `trasporta`
--
ALTER TABLE `trasporta`
  ADD CONSTRAINT `fk_trasporta_merce` FOREIGN KEY (`merce`) REFERENCES `Merce` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trasporta_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Viaggio`
--
ALTER TABLE `Viaggio`
  ADD CONSTRAINT `fk_viaggio_luogo_meta` FOREIGN KEY (`luogo_meta`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Utenti aggiunti per aplm
--

INSERT INTO `user` (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`, `ssl_type`, `ssl_cipher`, `x509_issuer`, `x509_subject`, `max_questions`, `max_updates`, `max_connections`, `max_user_connections`, `plugin`, `authentication_string`, `password_expired`, `is_role`, `default_role`, `max_statement_time`) VALUES
('localhost', 'visitatore', '', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0, 'mysql_native_password', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19', 'N', 'N', '', '0.000000'),
('localhost', 'commentatore', '', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0, 'mysql_native_password', '', 'N', 'N', '', '0.000000');



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
