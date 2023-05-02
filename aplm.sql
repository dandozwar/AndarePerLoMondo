-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 25, 2023 alle 11:29
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
  `presentazione` varchar(256) COLLATE latin1_general_cs DEFAULT NULL,
  `descrizione` blob DEFAULT NULL,
  `viaggio1` smallint(6) DEFAULT NULL,
  `viaggio2` smallint(6) DEFAULT NULL,
  `pubblico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Biografia`
--

INSERT INTO `Biografia` (`id`, `persona`, `presentazione`, `descrizione`, `viaggio1`, `viaggio2`, `pubblico`) VALUES
(1, 1, 'Bonaccorso Pitti (1354-1432) fu un mercante, un giocatore d’azzardo e un politico fiorentino.', 0x426f6e6163636f72736f206469204e6572692050697474692028466972656e7a652c20323520617072696c652031333534202d20466972656e7a6520342061676f73746f20313433322920667520756e206d657263616e74652c20756e2067696f6361746f72652064e28099617a7a6172646f206520756e20706f6c697469636f2066696f72656e74696e6f206469207061727465206775656c66612e20446f706f206c61207269766f6c7461206465692043696f6d70692c20766961676769c3b2207072696e636970616c6d656e746520667261204672616e6369612065204669616e6472652c2070657220706f6920746f726e617265206120466972656e7a6520652073667275747461726520692070726f70726920636f6e74617474692070657220696c2062656e652064656c20436f6d756e652c206f7474656e656e646f20636f73c3ac20696c2072616e676f206e6f62696c696172652064616c6c27696d70657261746f726520526f626572746f20646920426176696572612e2041207365677569746f20646920756e612070657269636f6c6f736120636f6e7465736120636f6e206c612066616d69676c696120726976616c65206465692052696361736f6c692c2073637269766572c3a0206c652070726f70726965206d656d6f726965206e6569205269636f7264692e0a, 2, 8, 1),
(2, 15, 'Sigerico di Canterbury († 994) fu un arcivescovo anglosassone.', 0x536967657269636f2064692043616e746572627572792028e280a0203239206f74746f6272652039393429206675206ce2809961726369766573636f766f2064692043616e746572627572792064616c203939302066696e6f20616c6c61206d6f7274652e204f6c747265206368652070657220696c2073756f20636f696e766f6c67696d656e746f206e656c6c6520747261747461746976652066726120616e676c6f736173736f6e69206520696e7661736f72692064616e6573692c20c3a8207269636f726461746f20696e207175616e746f207072696d6f2074657374696d6f6e652064656c20706572636f72736f2064656c6c6120566961204672616e636967656e612c2064692063756920617070756e74c3b2206c6520746170706520646120526f6d612066696e6f20612043616e746572627572792e, 6, NULL, 1);

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
(32, 25),
(43, 19);

-- --------------------------------------------------------

--
-- Struttura della tabella `Evento`
--

CREATE TABLE `Evento` (
  `id` smallint(6) NOT NULL,
  `biografia` smallint(6) NOT NULL,
  `immagine` smallint(6) DEFAULT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `titolo` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `didascalia` blob DEFAULT NULL,
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
  `autore` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `titolo` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `titolo_volume` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `titolo_rivista` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `numero` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `curatore` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `luogo` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `editore` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `nome_sito` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `anno` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `collana` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `pagine` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `url` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `schedatore` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Fonte`
--

INSERT INTO `Fonte` (`id`, `autore`, `titolo`, `titolo_volume`, `titolo_rivista`, `numero`, `curatore`, `luogo`, `editore`, `nome_sito`, `anno`, `collana`, `pagine`, `url`, `schedatore`) VALUES
(1, 'Bonaccorso Pitti', 'Ricordi', 'Mercanti Scrittori. Ricordi nella Firenze tra Medioevo e Rinascimento', '', '', 'Vittore Branca', 'Milano', 'Rusconi', '', '1986', '', 'pp. 341-503', '', 'acignoni'),
(2, '', 'L\'itinerario di Sigerico', '', '', '', '', '', '', 'Via Francigena', '2021', '', '', 'https://www.viefrancigene.org/it/litinerario-di-sigerico/', 'acignoni');

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
(1, './img/eventi/StemmaPitti.jpg', 'Lo stemma della famiglia Pitti', 'Archivio di Stato di Firenze, Raccolta Caramelli Papiani'),
(2, './img/eventi/RivoltaCiompi.jpg', 'G. L. Gatteri, Il tumulto dei Ciompi, 1877', 'Civici Musei di Storia ed Arte di Trieste'),
(3, './img/eventi/ImperatoreRoberto.jpg', 'L’imperatore Roberto di Wittelsbach', 'Chiesa Collegiata di Neustadt an der Weinstrasse, Germania'),
(4, './img/eventi/StemmaRicasoli.jpg', 'Lo stemma della famiglia Ricasoli', 'Luigi Passerini, Genealogia e storia della famiglia Ricasoli, Firenze, 1864'),
(5, './img/eventi/ManoscrittoPitti.png', 'Il manoscritto autografo dei Ricordi', 'Manoscritto II, III, 245, Biblioteca Nazionale Centrale di Firenze'),
(6, './img/eventi/AbbaziaSAgostino.jpg', 'L’ex-monastero benedettino di Sant’Agostino', 'L’entrata privata dell’attuale King’s School'),
(7, './img/eventi/Dunstan.jpg', 'Possibile autoritratto dell’arcivescovo di Canterbury Dunstano', 'St Dunstan’s Classbook, MS. Auct. F. 4. 32, Biblioteche di Oxford'),
(8, './img/eventi/ItinerarioSigerico.jpg', 'Trascrizione dell’XI secolo', 'British Library, Cotton MS. Tiberius B.V, f.23v'),
(9, './img/eventi/ReEthelred.jpg', 'Re Etelredo II d’Inghilterra detto lo Sconsigliato', 'Copia del XIII secolo del Historia Ecclesie Abbendonensis'),
(10, './img/eventi/CattedraleCanterbury.jpg', 'La cattedrale di Canterbury', 'Vista dall’entrata');

-- --------------------------------------------------------

--
-- Struttura della tabella `Intervallo`
--

CREATE TABLE `Intervallo` (
  `id` smallint(6) NOT NULL,
  `stringa` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `valore` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Intervallo`
--

INSERT INTO `Intervallo` (`id`, `stringa`, `valore`) VALUES
(1, 'V secolo, quarto quarto', '0487-00-00'),
(3, 'VI secolo, prima metà', '0525-00-00'),
(4, 'VI secolo, seconda metà', '0575-00-00'),
(5, 'VI secolo, primo quarto', '0512-00-00'),
(6, 'VI secolo, secondo quarto', '0537-00-00'),
(7, 'VI secolo, terzo quarto', '0562-00-00'),
(8, 'VI secolo, quarto quarto', '0587-00-00'),
(10, 'VII secolo, prima metà', '0625-00-00'),
(11, 'VII secolo, seconda metà', '0675-00-00'),
(12, 'VII secolo, primo quarto', '0612-00-00'),
(13, 'VII secolo, secondo quarto', '0637-00-00'),
(14, 'VII secolo, terzo quarto', '0662-00-00'),
(15, 'VII secolo, quarto quarto', '0687-00-00'),
(17, 'VIII secolo, prima metà', '0725-00-00'),
(18, 'VIII secolo, seconda metà', '0775-00-00'),
(19, 'VIII secolo, primo quarto', '0712-00-00'),
(20, 'VIII secolo, secondo quarto', '0737-00-00'),
(21, 'VIII secolo, terzo quarto', '0762-00-00'),
(22, 'VIII secolo, quarto quarto', '0787-00-00'),
(24, 'IX secolo, prima metà', '0825-00-00'),
(25, 'IX secolo, seconda metà', '0875-00-00'),
(26, 'IX secolo, primo quarto', '0812-00-00'),
(27, 'IX secolo, secondo quarto', '0837-00-00'),
(28, 'IX secolo, terzo quarto', '0862-00-00'),
(29, 'IX secolo, quarto quarto', '0887-00-00'),
(31, 'X secolo, prima metà', '0925-00-00'),
(32, 'X secolo, seconda metà', '0975-00-00'),
(33, 'X secolo, primo quarto', '0912-00-00'),
(34, 'X secolo, secondo quarto', '0937-00-00'),
(35, 'X secolo, terzo quarto', '0962-00-00'),
(36, 'X secolo, quarto quarto', '0987-00-00'),
(38, 'XI secolo, prima metà', '1025-00-00'),
(39, 'XI secolo, seconda metà', '1075-00-00'),
(40, 'XI secolo, primo quarto', '1012-00-00'),
(41, 'XI secolo, secondo quarto', '1037-00-00'),
(42, 'XI secolo, terzo quarto', '1062-00-00'),
(43, 'XI secolo, quarto quarto', '1087-00-00'),
(45, 'XII secolo, prima metà', '1125-00-00'),
(46, 'XII secolo, seconda metà', '1175-00-00'),
(47, 'XII secolo, primo quarto', '1112-00-00'),
(48, 'XII secolo, secondo quarto', '1137-00-00'),
(49, 'XII secolo, terzo quarto', '1162-00-00'),
(50, 'XII secolo, quarto quarto', '1187-00-00'),
(52, 'XIII secolo, prima metà', '1225-00-00'),
(53, 'XIII secolo, seconda metà', '1275-00-00'),
(54, 'XIII secolo, primo quarto', '1212-00-00'),
(55, 'XIII secolo, secondo quarto', '1237-00-00'),
(56, 'XIII secolo, terzo quarto', '1262-00-00'),
(57, 'XIII secolo, quarto quarto', '1287-00-00'),
(59, 'XIV secolo, prima metà', '1325-00-00'),
(60, 'XIV secolo, seconda metà', '1375-00-00'),
(61, 'XIV secolo, primo quarto', '1312-00-00'),
(62, 'XIV secolo, secondo quarto', '1337-00-00'),
(63, 'XIV secolo, terzo quarto', '1362-00-00'),
(64, 'XIV secolo, quarto quarto', '1387-00-00'),
(66, 'XV secolo, prima metà', '1425-00-00'),
(67, 'XV secolo, seconda metà', '1475-00-00'),
(68, 'XV secolo, primo quarto', '1412-00-00'),
(69, 'XV secolo, secondo quarto', '1437-00-00'),
(70, 'XV secolo, terzo quarto', '1462-00-00'),
(71, 'XV secolo, quarto quarto', '1487-00-00');

-- --------------------------------------------------------

--
-- Struttura della tabella `lavora_come`
--

CREATE TABLE `lavora_come` (
  `id` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL,
  `occupazione` smallint(6) DEFAULT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `intervallo_inizio` smallint(6) DEFAULT NULL,
  `intervallo_fine` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `lavora_come`
--

INSERT INTO `lavora_come` (`id`, `persona`, `occupazione`, `data_inizio`, `data_fine`, `intervallo_inizio`, `intervallo_fine`) VALUES
(1, 1, 1, '1374-04-25', '1432-08-05', NULL, NULL),
(2, 1, 2, '1376-00-00', '1398-00-00', NULL, NULL),
(3, 1, 3, '1396-07-20', '1426-02-26', NULL, NULL),
(4, 1, 4, '1399-09-22', '1427-06-27', NULL, NULL),
(5, 2, 5, '1382-05-12', '1386-02-24', NULL, NULL),
(6, 2, 6, '1385-12-31', '1386-02-24', NULL, NULL),
(7, 3, 7, '1378-00-00', '1382-00-00', NULL, NULL),
(8, 4, 7, '1378-00-00', '1382-00-00', NULL, NULL),
(9, 6, 3, '1372-00-00', '1381-00-00', NULL, NULL),
(10, 6, 4, '1382-00-00', '1391-00-00', NULL, NULL),
(11, 8, 8, NULL, NULL, NULL, NULL),
(12, 8, 4, '1392-00-00', '1404-00-00', NULL, NULL),
(13, 9, 9, '1346-08-26', '1383-12-07', NULL, NULL),
(14, 9, 10, '1355-12-05', '1383-12-07', NULL, NULL),
(15, 10, 11, '1362-11-13', '1399-02-03', NULL, NULL),
(16, 10, 12, '1372-02-26', '1388-07-08', NULL, NULL),
(17, 10, 13, '1390-03-02', '1399-02-03', NULL, NULL),
(18, 11, 14, '1364-09-29', '1404-01-16', NULL, NULL),
(19, 12, 15, '1380-09-16', '1422-10-21', NULL, NULL),
(20, 12, 16, '1396-11-27', '1413-03-21', NULL, NULL),
(21, 13, 2, NULL, NULL, NULL, NULL),
(22, 14, 17, '1347-10-11', '1404-12-13', NULL, NULL),
(23, 14, 18, '1354-00-00', '1404-12-13', NULL, NULL),
(24, 14, 19, '1356-06-23', '1404-12-13', NULL, NULL),
(25, 15, 20, '0975-00-00', '0990-00-00', NULL, NULL),
(26, 15, 21, '0985-00-00', '0990-00-00', NULL, NULL),
(27, 15, 22, '0990-00-00', '0994-10-28', NULL, NULL),
(28, 16, 23, '1360-00-00', '1363-00-00', NULL, NULL),
(29, 16, 24, '1363-00-00', '1404-04-27', NULL, NULL),
(30, 17, 3, '1368-00-00', '1402-02-17', NULL, NULL),
(31, 17, 25, '1372-00-00', '1381-00-00', NULL, NULL),
(32, 17, 4, '1381-00-00', '1417-10-02', NULL, NULL),
(33, 18, 3, NULL, NULL, NULL, NULL),
(34, 19, 3, NULL, NULL, NULL, NULL),
(35, 20, 26, '1388-06-29', '1405-11-17', NULL, NULL),
(36, 21, 27, '1398-01-06', '1410-05-18', NULL, NULL),
(37, 21, 28, '1400-08-21', '1410-05-18', NULL, NULL),
(38, 22, 4, '1382-00-00', '1409-00-00', NULL, NULL),
(39, 22, 3, NULL, NULL, NULL, NULL),
(40, 23, 4, '1401-00-00', '1429-02-20', NULL, NULL),
(41, 23, 3, '1402-00-00', '1424-00-00', NULL, NULL),
(42, 23, 29, '1385-00-00', '1429-02-20', NULL, NULL),
(43, 24, 30, '1400-12-01', '1413-12-26', NULL, NULL),
(44, 25, 31, '1384-09-20', '1417-04-29', NULL, NULL),
(45, 26, 3, NULL, NULL, NULL, NULL),
(46, 26, 4, NULL, NULL, NULL, NULL),
(47, 27, 32, '1383-05-00', '1424-01-24', NULL, NULL),
(48, 27, 33, '1411-00-00', '1424-01-24', NULL, NULL),
(49, 28, 32, NULL, '1416-08-05', NULL, NULL),
(50, 28, 34, NULL, '1416-08-05', NULL, NULL),
(51, 29, 35, '1410-05-17', '1415-05-29', NULL, NULL),
(52, 31, 36, NULL, '0480-00-00', 1, NULL),
(53, 31, 32, NULL, NULL, NULL, NULL),
(54, 31, 35, NULL, NULL, NULL, NULL);

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
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
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
(397, 18),
(1, 1),
(331, 21),
(332, 21);

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
(2, 31),
(4, 31),
(12, 126),
(12, 127),
(12, 128),
(15, 171),
(15, 172),
(15, 173),
(15, 174),
(15, 175),
(21, 333),
(21, 334),
(21, 335),
(21, 336),
(21, 337),
(21, 338),
(21, 339),
(21, 340),
(21, 370),
(21, 371),
(22, 354),
(22, 355),
(22, 368),
(22, 370),
(22, 371),
(23, 354),
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
  `nome` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `soprannome` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `luogo_nascita` smallint(6) DEFAULT NULL,
  `data_morte` date DEFAULT NULL,
  `luogo_morte` smallint(6) DEFAULT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL,
  `intervallo_nascita` smallint(6) DEFAULT NULL,
  `intervallo_morte` smallint(6) DEFAULT NULL,
  `schedatore` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Persona`
--

INSERT INTO `Persona` (`id`, `nome`, `cognome`, `soprannome`, `data_nascita`, `luogo_nascita`, `data_morte`, `luogo_morte`, `uri`, `intervallo_nascita`, `intervallo_morte`, `schedatore`) VALUES
(1, 'Bonaccorso', 'Pitti', NULL, '1354-04-25', 1, '1432-08-05', 1, 'https://www.treccani.it/enciclopedia/buonaccorso-di-neri-pitti_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(2, 'Carlo', 'd’Angiò-Durazzo', 'Carlo della Pace', '1345-00-00', 2, '1386-02-24', 3, 'https://www.treccani.it/enciclopedia/carlo-iii-d-angio-durazzo-re-di-napoli-detto-della-pace-o-il-piccolo_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(3, 'Bernardo', 'di Lippo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(4, 'Giovanni', 'de’ Rossi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(5, 'Giovanni', 'dall’Antella', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(6, 'Stoldo', 'Altoviti', NULL, NULL, NULL, '1392-12-05', NULL, 'https://www.treccani.it/enciclopedia/stoldo-altoviti_(Dizionario-Biografico)/', NULL, NULL, 'acignoni'),
(7, 'Tommaso', 'Soderini', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(8, 'Bernardo', 'Benvenuti de’ Nobili', NULL, NULL, 1, NULL, NULL, 'https://www.treccani.it/enciclopedia/benvenuti-de-nobili-bernardo_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(9, 'Venceslao', 'di Lussemburgo', NULL, '1337-02-25', 113, '1383-12-07', 114, 'https://www.treccani.it/enciclopedia/venceslao-duca-di-lussemburgo-di-brabante-e-di-limburgo/', NULL, NULL, 'acignoni'),
(10, 'Giovanni', 'di Lancaster', 'Giovanni di Gand', '1340-03-06', 115, '1399-02-03', 116, 'https://www.treccani.it/enciclopedia/john-of-gaunt-duca-di-lancaster/', NULL, NULL, 'acignoni'),
(11, 'Giovanni', 'di Châtillon', 'Giovanni di Bretagna', '1345-02-05', 117, '1404-01-16', 118, NULL, NULL, NULL, 'acignoni'),
(12, 'Carlo', 'di Valois', 'Carlo VI  il folle di Francia', '1368-12-03', 84, '1422-10-21', 84, 'https://www.treccani.it/enciclopedia/carlo-vi-re-di-francia_%28Enciclopedia-Italiana%29/', NULL, NULL, 'acignoni'),
(13, 'Cino', 'Benvenuti de’ Nobili', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(14, 'Alberto', 'di Wittelsbach', 'Alberto di Baviera', '1336-07-25', 133, '1404-12-13', 132, 'https://it.wikipedia.org/wiki/Alberto_I_di_Baviera', NULL, NULL, 'acignoni'),
(15, 'Sigerico', 'di Canterbury', 'Sigerico il Serio', NULL, NULL, '0994-10-28', 106, 'https://it.wikipedia.org/wiki/Sigerico_di_Canterbury', NULL, NULL, 'acignoni'),
(16, 'Filippo', 'Valois-Borgogna', 'Filippo II l’ardito di Borgogna', '1342-01-17', 95, '1404-04-27', 209, 'https://www.treccani.it/enciclopedia/filippo-l-ardito-duca-di-borgogna/', NULL, NULL, 'acignoni'),
(17, 'Maso', 'degli Albizzi', NULL, '1343-00-00', 1, '1417-10-02', 1, 'https://www.treccani.it/enciclopedia/maso-albizzi_(Dizionario-Biografico)/', NULL, NULL, 'acignoni'),
(18, 'Vanni', 'Stefani', NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, 'acignoni'),
(19, 'Pero', 'da San Miniato', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'acignoni'),
(20, 'Francesco', 'da Carrara', 'Francesco Novello da Carrara', '1359-05-29', 223, '1406-01-17', 224, 'https://www.treccani.it/enciclopedia/carrara-francesco-da-il-novello_(Dizionario-Biografico)/', NULL, NULL, 'acignoni'),
(21, 'Roberto', 'di Wittelsbach', 'Roberto del Palatinato', '1352-05-05', 225, '1410-05-18', 226, 'https://www.treccani.it/enciclopedia/roberto-elettore-del-palatinato-e-re-di-germania/', NULL, NULL, 'acignoni'),
(22, 'Andrea', 'Vettori', NULL, NULL, 1, '1409-00-00', 252, 'https://www.treccani.it/enciclopedia/vettori_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(23, 'Giovanni', 'de’ Medici', NULL, '1360-02-18', 1, '1429-02-20', 1, 'https://www.treccani.it/enciclopedia/giovanni-di-bicci-de-medici_res-0d7a7119-9b6c-11e6-9e53-00271042e8d9_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(24, 'Michele', 'Steno', NULL, '1331-00-00', 224, '1413-12-26', 224, 'https://www.treccani.it/enciclopedia/michele-steno_%28Dizionario-Biografico%29/', NULL, NULL, 'acignoni'),
(25, 'Luigi', 'd’Angiò', 'Luigi II d’Angiò', '1377-10-05', 263, '1417-04-29', 264, 'https://www.treccani.it/enciclopedia/luigi-ii-d-angio-re-di-sicilia_(Dizionario-Biografico)', NULL, NULL, 'acignoni'),
(26, 'Iacopo', 'Salviati', NULL, NULL, 1, NULL, 1, 'https://www.treccani.it/enciclopedia/salviati_(Enciclopedia-Italiana)/', NULL, NULL, 'acignoni'),
(27, 'Muzio', 'Attendolo', 'Sforza da Cotignola', '1369-05-28', 165, '1424-01-04', 277, 'https://www.treccani.it/enciclopedia/attendolo-muzio-detto-sforza_(Dizionario-Biografico)/', NULL, NULL, 'acignoni'),
(28, 'Paolo', 'Orsini', NULL, '1369-00-00', NULL, '1416-08-05', 266, 'https://www.treccani.it/enciclopedia/paolo-orsini_(Dizionario-Biografico)', NULL, NULL, 'acignoni'),
(29, 'Baldassarre', 'Cossia', 'Giovanni XXII', '1370-00-00', 267, '1419-12-22', 1, 'https://www.treccani.it/enciclopedia/antipapa-giovanni-xxiii_(Dizionario-Biografico)', NULL, NULL, 'acignoni');

-- --------------------------------------------------------

--
-- Struttura della tabella `relazione`
--

CREATE TABLE `relazione` (
  `id` smallint(6) NOT NULL,
  `persona1` smallint(6) NOT NULL,
  `persona2` smallint(6) DEFAULT NULL,
  `tipo` smallint(6) DEFAULT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `intervallo_inizio` smallint(6) DEFAULT NULL,
  `intervallo_fine` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `relazione`
--

INSERT INTO `relazione` (`id`, `persona1`, `persona2`, `tipo`, `data_inizio`, `data_fine`, `intervallo_inizio`, `intervallo_fine`) VALUES
(1, 1, 2, 1, '1380-00-00', '1380-00-00', NULL, NULL),
(2, 1, 3, 1, '1380-00-00', '1380-00-00', NULL, NULL),
(3, 1, 4, 1, '1380-00-00', '1380-00-00', NULL, NULL),
(4, 1, 8, 2, '1380-00-00', '1383-00-00', NULL, NULL),
(5, 11, 10, 3, '1356-00-00', '1387-00-00', NULL, NULL),
(6, 1, 12, 1, '1382-00-00', '1395-00-00', NULL, NULL),
(7, 12, 8, 2, NULL, NULL, NULL, NULL),
(8, 1, 16, 1, '1383-00-00', '1383-00-00', NULL, NULL),
(14, 31, 18, 4, NULL, NULL, 1, NULL),
(20, 31, 6, 3, '0477-00-00', '0478-00-00', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Scopo`
--

CREATE TABLE `Scopo` (
  `id` smallint(6) NOT NULL,
  `tipo` smallint(6) DEFAULT NULL,
  `successo` tinyint(1) DEFAULT NULL,
  `schedatore` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Scopo`
--

INSERT INTO `Scopo` (`id`, `tipo`, `successo`, `schedatore`) VALUES
(1, 1, 1, 'acignoni'),
(2, 2, 1, 'acignoni'),
(3, 3, 1, 'acignoni'),
(4, 4, 1, 'acignoni'),
(5, 5, 1, 'acignoni'),
(6, 6, 1, 'acignoni'),
(7, 7, 0, 'acignoni'),
(8, 8, 1, 'acignoni'),
(9, 9, 1, 'acignoni'),
(10, 10, 0, 'acignoni'),
(11, 1, 1, 'acignoni'),
(12, 10, 1, 'acignoni'),
(13, 11, 1, 'acignoni'),
(14, 12, 1, 'acignoni'),
(15, 13, 0, 'acignoni'),
(16, 14, 1, 'acignoni'),
(17, 15, 1, 'acignoni'),
(18, 16, 1, 'acignoni'),
(19, 17, 1, 'acignoni'),
(20, 18, 1, 'acignoni'),
(21, 15, 1, 'acignoni'),
(22, 19, 1, 'acignoni'),
(23, 20, 1, 'acignoni'),
(24, 21, 1, 'acignoni'),
(25, 22, 1, 'acignoni'),
(26, 23, 1, 'acignoni'),
(27, 24, 1, 'acignoni'),
(28, 22, 1, 'acignoni'),
(29, 25, 1, 'acignoni'),
(30, 22, 0, 'acignoni'),
(31, 15, 1, 'acignoni'),
(32, 26, 1, 'acignoni'),
(33, 27, 1, 'acignoni'),
(34, 27, 0, 'acignoni'),
(35, 28, 1, 'acignoni'),
(36, 29, 0, 'acignoni'),
(43, 30, 1, 'acignoni');

-- --------------------------------------------------------

--
-- Struttura della tabella `Tappa`
--

CREATE TABLE `Tappa` (
  `id` smallint(6) NOT NULL,
  `viaggio` smallint(6) NOT NULL,
  `luogo_partenza` smallint(6) DEFAULT NULL,
  `data_partenza` date DEFAULT NULL,
  `luogo_arrivo` smallint(6) DEFAULT NULL,
  `data_arrivo` date DEFAULT NULL,
  `fonte` smallint(6) DEFAULT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `posizione` smallint(6) NOT NULL,
  `intervallo_partenza` smallint(6) DEFAULT NULL,
  `intervallo_arrivo` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Tappa`
--

INSERT INTO `Tappa` (`id`, `viaggio`, `luogo_partenza`, `data_partenza`, `luogo_arrivo`, `data_arrivo`, `fonte`, `pagine`, `posizione`, `intervallo_partenza`, `intervallo_arrivo`) VALUES
(1, 1, 4, NULL, 5, NULL, 1, 'p. 480', 1, NULL, NULL),
(2, 1, 5, NULL, 6, NULL, 1, 'p. 480', 2, NULL, NULL),
(3, 1, 6, NULL, 7, NULL, 1, 'p. 480', 3, NULL, NULL),
(4, 1, 7, NULL, 8, NULL, 1, 'p. 480', 4, NULL, NULL),
(5, 1, 8, NULL, 9, NULL, 1, 'p. 480', 5, NULL, NULL),
(6, 1, 9, NULL, 10, NULL, 1, 'p. 480', 6, NULL, NULL),
(7, 1, 10, NULL, 11, NULL, 1, 'p. 480', 7, NULL, NULL),
(8, 1, 11, NULL, 12, NULL, 1, 'p. 480', 8, NULL, NULL),
(9, 1, 12, NULL, 13, NULL, 1, 'p. 480', 9, NULL, NULL),
(10, 1, 13, NULL, 14, NULL, 1, 'p. 480', 10, NULL, NULL),
(11, 1, 14, NULL, 15, NULL, 1, 'pp. 378 e 480', 11, NULL, NULL),
(12, 1, 15, NULL, 16, NULL, 1, 'p. 480', 12, NULL, NULL),
(13, 1, 16, NULL, 17, NULL, 1, 'p. 480', 13, NULL, NULL),
(14, 1, 17, NULL, 18, NULL, 1, 'pp. 378 e 480', 14, NULL, NULL),
(15, 1, 18, NULL, 19, NULL, 1, 'p. 480', 15, NULL, NULL),
(16, 1, 19, NULL, 20, NULL, 1, 'p. 480', 16, NULL, NULL),
(17, 1, 20, NULL, 21, NULL, 1, 'p. 480', 17, NULL, NULL),
(18, 1, 21, NULL, 22, NULL, 1, 'p. 480', 18, NULL, NULL),
(19, 1, 22, NULL, 23, NULL, 1, 'p. 378 e 480', 19, NULL, NULL),
(20, 1, 23, NULL, 24, NULL, 1, 'p. 480', 20, NULL, NULL),
(21, 1, 24, NULL, 25, NULL, 1, 'p. 378 e 480', 21, NULL, NULL),
(22, 1, 25, NULL, 26, NULL, 1, 'p. 480', 22, NULL, NULL),
(23, 1, 26, NULL, 27, NULL, 1, 'p. 480', 23, NULL, NULL),
(24, 1, 27, NULL, 28, NULL, 1, 'p. 480', 24, NULL, NULL),
(25, 1, 28, NULL, 29, NULL, 1, 'p. 480', 25, NULL, NULL),
(26, 1, 29, NULL, 30, NULL, 1, 'p. 480', 26, NULL, NULL),
(27, 1, 30, NULL, 31, NULL, 1, 'p. 480', 27, NULL, NULL),
(28, 1, 31, NULL, 32, NULL, 1, 'p. 378 e 480', 28, NULL, NULL),
(29, 1, 32, NULL, 33, NULL, 1, 'p. 378 e 480', 29, NULL, NULL),
(30, 1, 33, NULL, 34, NULL, 1, 'p. 480', 30, NULL, NULL),
(31, 1, 34, NULL, 32, NULL, 1, 'p. 480', 31, NULL, NULL),
(32, 2, 33, NULL, 35, NULL, 1, 'pp. 480-481', 1, NULL, NULL),
(33, 2, 35, NULL, 36, NULL, 1, 'pp. 480-481', 2, NULL, NULL),
(34, 2, 36, NULL, 37, NULL, 1, 'pp. 480-481', 3, NULL, NULL),
(35, 2, 37, NULL, 31, NULL, 1, 'pp. 480-481', 4, NULL, NULL),
(36, 2, 31, NULL, 25, NULL, 1, 'pp. 379-380 e 480-481', 5, NULL, NULL),
(37, 2, 25, NULL, 38, NULL, 1, 'pp. 480-481', 6, NULL, NULL),
(38, 2, 38, NULL, 12, NULL, 1, 'pp. 480-481', 7, NULL, NULL),
(39, 2, 12, NULL, 39, NULL, 1, 'pp. 480-481', 8, NULL, NULL),
(40, 2, 39, NULL, 40, NULL, 1, 'pp. 480-481', 9, NULL, NULL),
(41, 2, 40, NULL, 41, NULL, 1, 'pp. 480-481', 10, NULL, NULL),
(42, 2, 41, NULL, 42, NULL, 1, 'pp. 480-481', 11, NULL, NULL),
(43, 2, 42, NULL, 43, NULL, 1, 'pp. 480-481', 12, NULL, NULL),
(44, 2, 43, NULL, 44, NULL, 1, 'pp. 480-481', 13, NULL, NULL),
(45, 2, 44, NULL, 45, NULL, 1, 'pp. 480-481', 14, NULL, NULL),
(46, 2, 45, NULL, 46, NULL, 1, 'pp. 480-481', 15, NULL, NULL),
(47, 2, 46, NULL, 47, NULL, 1, 'pp. 480-481', 16, NULL, NULL),
(48, 2, 47, NULL, 48, NULL, 1, 'pp. 480-481', 17, NULL, NULL),
(49, 2, 48, NULL, 49, NULL, 1, 'pp. 480-481', 18, NULL, NULL),
(50, 2, 49, NULL, 50, NULL, 1, 'pp. 480-481', 19, NULL, NULL),
(51, 2, 50, NULL, 51, NULL, 1, 'pp. 480-481', 20, NULL, NULL),
(52, 2, 51, NULL, 52, NULL, 1, 'pp. 480-481', 21, NULL, NULL),
(53, 2, 52, NULL, 53, NULL, 1, 'pp. 480-481', 22, NULL, NULL),
(54, 2, 53, NULL, 54, NULL, 1, 'pp. 480-481', 23, NULL, NULL),
(55, 2, 54, NULL, 55, NULL, 1, 'pp. 480-481', 24, NULL, NULL),
(56, 2, 55, NULL, 56, NULL, 1, 'pp. 480-481', 25, NULL, NULL),
(57, 2, 56, NULL, 57, NULL, 1, 'pp. 379-380 e 480-481', 26, NULL, NULL),
(58, 2, 57, NULL, 58, NULL, 1, 'pp. 379-380 e 480-481', 27, NULL, NULL),
(59, 2, 58, NULL, 57, NULL, 1, 'pp. 480-481', 28, NULL, NULL),
(60, 2, 57, NULL, 59, NULL, 1, 'pp. 480-481', 29, NULL, NULL),
(61, 2, 59, NULL, 60, NULL, 1, 'pp. 480-481', 30, NULL, NULL),
(62, 2, 60, NULL, 61, NULL, 1, 'pp. 480-481', 31, NULL, NULL),
(63, 2, 61, NULL, 62, NULL, 1, 'pp. 480-481', 32, NULL, NULL),
(64, 2, 62, NULL, 63, NULL, 1, 'pp. 480-481', 33, NULL, NULL),
(65, 2, 63, NULL, 64, NULL, 1, 'pp. 480-481', 34, NULL, NULL),
(66, 2, 64, NULL, 65, NULL, 1, 'pp. 480-481', 35, NULL, NULL),
(67, 2, 65, NULL, 66, NULL, 1, 'pp. 480-481', 36, NULL, NULL),
(68, 2, 66, NULL, 67, NULL, 1, 'pp. 480-481', 37, NULL, NULL),
(69, 2, 67, NULL, 68, NULL, 1, 'pp. 480-481', 38, NULL, NULL),
(70, 2, 68, NULL, 69, NULL, 1, 'pp. 480-481', 39, NULL, NULL),
(71, 2, 69, NULL, 70, NULL, 1, 'pp. 480-481', 40, NULL, NULL),
(72, 2, 70, NULL, 71, NULL, 1, 'pp. 480-481', 41, NULL, NULL),
(73, 2, 71, NULL, 72, NULL, 1, 'pp. 480-481', 42, NULL, NULL),
(74, 2, 72, NULL, 73, NULL, 1, 'pp. 480-481', 43, NULL, NULL),
(75, 2, 73, NULL, 74, NULL, 1, 'pp. 480-481', 44, NULL, NULL),
(76, 2, 74, NULL, 75, NULL, 1, 'pp. 480-481', 45, NULL, NULL),
(77, 2, 75, NULL, 76, NULL, 1, 'pp. 480-481', 46, NULL, NULL),
(78, 2, 76, NULL, 77, NULL, 1, 'pp. 480-481', 47, NULL, NULL),
(79, 2, 77, NULL, 78, NULL, 1, 'pp. 480-481', 48, NULL, NULL),
(80, 2, 78, NULL, 79, NULL, 1, 'pp. 480-481', 49, NULL, NULL),
(81, 2, 79, NULL, 80, NULL, 1, 'pp. 480-481', 50, NULL, NULL),
(82, 2, 80, NULL, 81, NULL, 1, 'pp. 480-481', 51, NULL, NULL),
(83, 2, 81, NULL, 82, NULL, 1, 'pp. 480-481', 52, NULL, NULL),
(84, 2, 82, NULL, 83, NULL, 1, 'pp. 480-481', 53, NULL, NULL),
(85, 2, 83, NULL, 84, NULL, 1, 'pp. 379-380 e 480-481', 54, NULL, NULL),
(86, 3, 84, NULL, 85, NULL, 1, 'p. 481', 1, NULL, NULL),
(87, 3, 85, NULL, 86, NULL, 1, 'p. 481', 2, NULL, NULL),
(88, 3, 86, NULL, 87, NULL, 1, 'p. 481', 3, NULL, NULL),
(89, 3, 87, NULL, 88, NULL, 1, 'p. 481', 4, NULL, NULL),
(90, 3, 88, NULL, 89, NULL, 1, 'p. 481', 5, NULL, NULL),
(91, 3, 89, NULL, 90, NULL, 1, 'p. 481', 6, NULL, NULL),
(92, 3, 90, NULL, 91, NULL, 1, 'p. 481', 7, NULL, NULL),
(93, 3, 91, NULL, 92, NULL, 1, 'p. 481', 8, NULL, NULL),
(94, 3, 92, NULL, 93, NULL, 1, 'p. 481', 9, NULL, NULL),
(95, 3, 93, NULL, 94, NULL, 1, 'p. 481', 10, NULL, NULL),
(96, 3, 94, NULL, 95, NULL, 1, 'p. 481', 11, NULL, NULL),
(97, 3, 95, NULL, 96, NULL, 1, 'p. 481', 12, NULL, NULL),
(98, 3, 96, NULL, 97, NULL, 1, 'p. 481', 13, NULL, NULL),
(99, 3, 97, NULL, 98, NULL, 1, 'p. 481', 14, NULL, NULL),
(100, 3, 98, NULL, 96, NULL, 1, 'pp. 380-381 e 481', 15, NULL, NULL),
(101, 3, 96, NULL, 99, NULL, 1, 'p. 481', 16, NULL, NULL),
(102, 3, 99, NULL, 100, NULL, 1, 'p. 481', 17, NULL, NULL),
(103, 3, 100, NULL, 101, NULL, 1, 'p. 481', 18, NULL, NULL),
(104, 3, 101, NULL, 102, NULL, 1, 'p. 481', 19, NULL, NULL),
(105, 3, 102, NULL, 103, NULL, 1, 'p. 481', 20, NULL, NULL),
(106, 3, 103, NULL, 104, NULL, 1, 'p. 481', 21, NULL, NULL),
(107, 3, 104, NULL, 105, NULL, 1, 'p. 481', 22, NULL, NULL),
(108, 3, 105, NULL, 106, NULL, 1, 'p. 481', 23, NULL, NULL),
(109, 3, 106, NULL, 107, NULL, 1, 'p. 481', 24, NULL, NULL),
(110, 3, 107, NULL, 108, NULL, 1, 'pp. 380-381 e 481', 25, NULL, NULL),
(111, 3, 108, NULL, 107, NULL, 1, 'p. 481', 26, NULL, NULL),
(112, 3, 107, NULL, 106, NULL, 1, 'p. 481', 27, NULL, NULL),
(113, 3, 106, NULL, 105, NULL, 1, 'p. 481', 28, NULL, NULL),
(114, 3, 105, NULL, 104, NULL, 1, 'p. 481', 29, NULL, NULL),
(115, 3, 104, NULL, 109, NULL, 1, 'p. 481', 30, NULL, NULL),
(116, 3, 109, NULL, 110, NULL, 1, 'p. 481', 31, NULL, NULL),
(117, 3, 110, NULL, 111, NULL, 1, 'p. 481', 32, NULL, NULL),
(118, 3, 111, NULL, 112, NULL, 1, 'p. 481', 33, NULL, NULL),
(119, 3, 112, NULL, 84, NULL, 1, 'pp. 380-381 e 481', 34, NULL, NULL),
(120, 4, 84, NULL, 119, NULL, 1, 'p. 482', 1, NULL, NULL),
(121, 4, 119, NULL, 120, NULL, 1, 'p. 482', 2, NULL, NULL),
(122, 4, 120, NULL, 121, NULL, 1, 'p. 482', 3, NULL, NULL),
(123, 4, 121, NULL, 122, NULL, 1, 'p. 482', 4, NULL, NULL),
(124, 4, 122, NULL, 123, NULL, 1, 'p. 482', 5, NULL, NULL),
(125, 4, 123, NULL, 110, NULL, 1, 'p. 482', 6, NULL, NULL),
(126, 4, 110, NULL, 123, '1382-11-30', 1, 'pp. 382-286', 7, NULL, NULL),
(127, 4, 123, '1382-11-30', 124, NULL, 1, 'pp. 382-286', 8, NULL, NULL),
(128, 4, 124, NULL, 84, '1383-01-00', 1, 'pp. 382-286 e 482', 9, NULL, NULL),
(129, 5, 84, '1383-02-00', 125, NULL, 1, 'pp. 482-483', 1, NULL, NULL),
(130, 5, 125, NULL, 85, NULL, 1, 'pp. 482-483', 2, NULL, NULL),
(131, 5, 85, NULL, 86, NULL, 1, 'pp. 482-483', 3, NULL, NULL),
(132, 5, 86, NULL, 87, NULL, 1, 'pp. 482-483', 4, NULL, NULL),
(133, 5, 87, NULL, 88, NULL, 1, 'pp. 482-483', 5, NULL, NULL),
(134, 5, 88, NULL, 89, NULL, 1, 'pp. 482-483', 6, NULL, NULL),
(135, 5, 89, NULL, 90, NULL, 1, 'pp. 482-483', 7, NULL, NULL),
(136, 5, 90, NULL, 91, NULL, 1, 'pp. 482-483', 8, NULL, NULL),
(137, 5, 91, NULL, 92, NULL, 1, 'pp. 482-483', 9, NULL, NULL),
(138, 5, 92, NULL, 93, NULL, 1, 'pp. 482-483', 10, NULL, NULL),
(139, 5, 93, NULL, 94, NULL, 1, 'pp. 482-483', 11, NULL, NULL),
(140, 5, 94, NULL, 95, NULL, 1, 'pp. 482-483', 12, NULL, NULL),
(141, 5, 95, NULL, 96, NULL, 1, 'pp. 386-387 e 482-483', 13, NULL, NULL),
(142, 5, 96, NULL, 98, NULL, 1, 'pp. 482-483', 14, NULL, NULL),
(143, 5, 98, NULL, 126, NULL, 1, 'pp. 482-483', 15, NULL, NULL),
(144, 5, 126, NULL, 127, NULL, 1, 'pp. 482-483', 16, NULL, NULL),
(145, 5, 127, NULL, 128, NULL, 1, 'pp. 482-483', 17, NULL, NULL),
(146, 5, 128, NULL, 129, NULL, 1, 'pp. 482-483', 18, NULL, NULL),
(147, 5, 129, NULL, 130, NULL, 1, 'pp. 482-483', 19, NULL, NULL),
(148, 5, 130, NULL, 131, NULL, 1, 'pp. 482-483', 20, NULL, NULL),
(149, 5, 131, NULL, 132, NULL, 1, 'pp. 386-387 e 482-483', 21, NULL, NULL),
(150, 5, 132, NULL, 131, NULL, 1, 'pp. 482-483', 22, NULL, NULL),
(151, 5, 131, NULL, 130, NULL, 1, 'pp. 482-483', 23, NULL, NULL),
(152, 5, 130, NULL, 129, NULL, 1, 'pp. 482-483', 24, NULL, NULL),
(153, 5, 129, NULL, 128, NULL, 1, 'pp. 482-483', 25, NULL, NULL),
(154, 5, 128, NULL, 127, NULL, 1, 'pp. 482-483', 26, NULL, NULL),
(155, 5, 127, NULL, 126, NULL, 1, 'pp. 482-483', 27, NULL, NULL),
(156, 5, 126, NULL, 98, NULL, 1, 'pp. 482-483', 28, NULL, NULL),
(157, 5, 98, NULL, 96, NULL, 1, 'pp. 482-483', 29, NULL, NULL),
(158, 5, 96, NULL, 95, NULL, 1, 'pp. 482-483', 30, NULL, NULL),
(159, 5, 95, NULL, 94, NULL, 1, 'pp. 482-483', 31, NULL, NULL),
(160, 5, 94, NULL, 93, NULL, 1, 'pp. 482-483', 32, NULL, NULL),
(161, 5, 93, NULL, 92, NULL, 1, 'pp. 482-483', 33, NULL, NULL),
(162, 5, 92, NULL, 91, NULL, 1, 'pp. 482-483', 34, NULL, NULL),
(163, 5, 91, NULL, 90, NULL, 1, 'pp. 482-483', 35, NULL, NULL),
(164, 5, 90, NULL, 89, NULL, 1, 'pp. 482-483', 36, NULL, NULL),
(165, 5, 89, NULL, 88, NULL, 1, 'pp. 482-483', 37, NULL, NULL),
(166, 5, 88, NULL, 87, NULL, 1, 'pp. 482-483', 38, NULL, NULL),
(167, 5, 87, NULL, 86, NULL, 1, 'pp. 482-483', 39, NULL, NULL),
(168, 5, 86, NULL, 85, NULL, 1, 'pp. 482-483', 40, NULL, NULL),
(169, 5, 85, NULL, 125, NULL, 1, 'pp. 482-483', 41, NULL, NULL),
(170, 5, 125, NULL, 84, '1383-04-00', 1, 'pp. 386-387 e 482-483', 42, NULL, NULL),
(171, 6, 134, NULL, 135, NULL, 2, NULL, 1, NULL, NULL),
(172, 6, 135, NULL, 136, NULL, 2, NULL, 2, NULL, NULL),
(173, 6, 136, NULL, 137, NULL, 2, NULL, 3, NULL, NULL),
(174, 6, 137, NULL, 138, NULL, 2, NULL, 4, NULL, NULL),
(175, 6, 138, NULL, 139, NULL, 2, NULL, 5, NULL, NULL),
(176, 6, 139, NULL, 140, NULL, 2, NULL, 6, NULL, NULL),
(177, 6, 140, NULL, 141, NULL, 2, NULL, 7, NULL, NULL),
(178, 6, 141, NULL, 142, NULL, 2, NULL, 8, NULL, NULL),
(179, 6, 142, NULL, 143, NULL, 2, NULL, 9, NULL, NULL),
(180, 6, 143, NULL, 144, NULL, 2, NULL, 10, NULL, NULL),
(181, 6, 144, NULL, 145, NULL, 2, NULL, 11, NULL, NULL),
(182, 6, 145, NULL, 146, NULL, 2, NULL, 12, NULL, NULL),
(183, 6, 146, NULL, 147, NULL, 2, NULL, 13, NULL, NULL),
(184, 6, 147, NULL, 148, NULL, 2, NULL, 14, NULL, NULL),
(185, 6, 148, NULL, 34, NULL, 2, NULL, 15, NULL, NULL),
(186, 6, 34, NULL, 149, NULL, 2, NULL, 16, NULL, NULL),
(187, 6, 149, NULL, 150, NULL, 2, NULL, 17, NULL, NULL),
(188, 6, 150, NULL, 151, NULL, 2, NULL, 18, NULL, NULL),
(189, 6, 151, NULL, 152, NULL, 2, NULL, 19, NULL, NULL),
(190, 6, 153, NULL, 154, NULL, 2, NULL, 21, NULL, NULL),
(191, 6, 154, NULL, 155, NULL, 2, NULL, 22, NULL, NULL),
(192, 6, 155, NULL, 156, NULL, 2, NULL, 23, NULL, NULL),
(193, 6, 156, NULL, 157, NULL, 2, NULL, 24, NULL, NULL),
(194, 6, 157, NULL, 6, NULL, 2, NULL, 25, NULL, NULL),
(195, 6, 6, NULL, 158, NULL, 2, NULL, 26, NULL, NULL),
(196, 6, 158, NULL, 159, NULL, 2, NULL, 27, NULL, NULL),
(197, 6, 159, NULL, 160, NULL, 2, NULL, 28, NULL, NULL),
(198, 6, 160, NULL, 161, NULL, 2, NULL, 29, NULL, NULL),
(199, 6, 161, NULL, 162, NULL, 2, NULL, 30, NULL, NULL),
(200, 6, 162, NULL, 9, NULL, 2, NULL, 31, NULL, NULL),
(201, 6, 9, NULL, 11, NULL, 2, NULL, 32, NULL, NULL),
(202, 6, 11, NULL, 163, NULL, 2, NULL, 33, NULL, NULL),
(203, 6, 163, NULL, 41, NULL, 2, NULL, 34, NULL, NULL),
(204, 6, 41, NULL, 42, NULL, 2, NULL, 35, NULL, NULL),
(205, 6, 42, NULL, 43, NULL, 2, NULL, 36, NULL, NULL),
(206, 6, 43, NULL, 164, NULL, 2, NULL, 37, NULL, NULL),
(207, 6, 164, NULL, 165, NULL, 2, NULL, 38, NULL, NULL),
(208, 6, 165, NULL, 166, NULL, 2, NULL, 39, NULL, NULL),
(209, 6, 166, NULL, 167, NULL, 2, NULL, 40, NULL, NULL),
(210, 6, 167, NULL, 48, NULL, 2, NULL, 41, NULL, NULL),
(211, 6, 48, NULL, 168, NULL, 2, NULL, 42, NULL, NULL),
(212, 6, 168, NULL, 169, NULL, 2, NULL, 43, NULL, NULL),
(213, 6, 169, NULL, 170, NULL, 2, NULL, 44, NULL, NULL),
(214, 6, 170, NULL, 171, NULL, 2, NULL, 45, NULL, NULL),
(215, 6, 171, NULL, 172, NULL, 2, NULL, 46, NULL, NULL),
(216, 6, 172, NULL, 173, NULL, 2, NULL, 47, NULL, NULL),
(217, 6, 173, NULL, 174, NULL, 2, NULL, 48, NULL, NULL),
(218, 6, 174, NULL, 175, NULL, 2, NULL, 49, NULL, NULL),
(219, 6, 175, NULL, 176, NULL, 2, NULL, 50, NULL, NULL),
(220, 6, 176, NULL, 177, NULL, 2, NULL, 51, NULL, NULL),
(221, 6, 177, NULL, 178, NULL, 2, NULL, 52, NULL, NULL),
(222, 6, 178, NULL, 179, NULL, 2, NULL, 53, NULL, NULL),
(223, 6, 179, NULL, 180, NULL, 2, NULL, 54, NULL, NULL),
(224, 6, 180, NULL, 181, NULL, 2, NULL, 55, NULL, NULL),
(225, 6, 181, NULL, 182, NULL, 2, NULL, 56, NULL, NULL),
(226, 6, 182, NULL, 183, NULL, 2, NULL, 57, NULL, NULL),
(227, 6, 183, NULL, 184, NULL, 2, NULL, 58, NULL, NULL),
(228, 6, 184, NULL, 185, NULL, 2, NULL, 59, NULL, NULL),
(229, 6, 185, NULL, 186, NULL, 2, NULL, 60, NULL, NULL),
(230, 6, 186, NULL, 187, NULL, 2, NULL, 61, NULL, NULL),
(231, 6, 187, NULL, 188, NULL, 2, NULL, 62, NULL, NULL),
(232, 6, 188, NULL, 189, NULL, 2, NULL, 63, NULL, NULL),
(233, 6, 189, NULL, 190, NULL, 2, NULL, 64, NULL, NULL),
(234, 6, 190, NULL, 191, NULL, 2, NULL, 65, NULL, NULL),
(235, 6, 191, NULL, 192, NULL, 2, NULL, 66, NULL, NULL),
(236, 6, 192, NULL, 193, NULL, 2, NULL, 67, NULL, NULL),
(237, 6, 193, NULL, 194, NULL, 2, NULL, 68, NULL, NULL),
(238, 6, 194, NULL, 195, NULL, 2, NULL, 69, NULL, NULL),
(239, 6, 195, NULL, 196, NULL, 2, NULL, 70, NULL, NULL),
(240, 6, 196, NULL, 197, NULL, 2, NULL, 71, NULL, NULL),
(241, 6, 197, NULL, 198, NULL, 2, NULL, 72, NULL, NULL),
(242, 6, 198, NULL, 111, NULL, 2, NULL, 73, NULL, NULL),
(243, 6, 111, NULL, 199, NULL, 2, NULL, 74, NULL, NULL),
(244, 6, 199, NULL, 200, NULL, 2, NULL, 75, NULL, NULL),
(245, 6, 200, NULL, 201, NULL, 2, NULL, 76, NULL, NULL),
(246, 6, 201, NULL, 202, NULL, 2, NULL, 77, NULL, NULL),
(247, 6, 202, NULL, 105, NULL, 2, NULL, 78, NULL, NULL),
(248, 6, 105, NULL, 106, NULL, 2, NULL, 79, NULL, NULL),
(249, 7, 84, NULL, 93, NULL, 1, 'pp. 387-389 e 482', 1, NULL, NULL),
(250, 7, 93, NULL, 203, NULL, 1, 'pp. 482', 2, NULL, NULL),
(251, 7, 203, NULL, 204, NULL, 1, 'pp. 387-389', 3, NULL, NULL),
(252, 7, 204, NULL, 93, NULL, 1, 'pp. 387-389 e 482', 4, NULL, NULL),
(253, 7, 93, NULL, 205, NULL, 1, 'pp. 482', 5, NULL, NULL),
(254, 7, 205, NULL, 206, NULL, 1, 'pp. 482', 6, NULL, NULL),
(255, 7, 206, NULL, 207, NULL, 1, 'pp. 482', 7, NULL, NULL),
(256, 7, 207, NULL, 208, NULL, 1, 'pp. 482', 8, NULL, NULL),
(257, 7, 208, NULL, 84, NULL, 1, 'pp. 482', 9, NULL, NULL),
(258, 8, 1, '1396-07-20', 38, NULL, 1, 'pp. 486', 1, NULL, NULL),
(259, 8, 38, NULL, 210, NULL, 1, 'pp. 486', 2, NULL, NULL),
(260, 8, 210, NULL, 211, NULL, 1, 'pp. 486', 3, NULL, NULL),
(261, 8, 211, NULL, 44, NULL, 1, 'pp. 486', 4, NULL, NULL),
(262, 8, 44, NULL, 46, NULL, 1, 'pp. 486', 5, NULL, NULL),
(263, 8, 46, NULL, 212, NULL, 1, 'pp. 486', 6, NULL, NULL),
(264, 8, 212, NULL, 213, NULL, 1, 'pp. 486', 7, NULL, NULL),
(265, 8, 213, NULL, 214, NULL, 1, 'pp. 486', 8, NULL, NULL),
(266, 8, 214, NULL, 215, NULL, 1, 'pp. 486', 9, NULL, NULL),
(267, 8, 215, NULL, 216, NULL, 1, 'pp. 486', 10, NULL, NULL),
(268, 8, 216, NULL, 69, NULL, 1, 'pp. 486', 11, NULL, NULL),
(269, 8, 69, NULL, 70, NULL, 1, 'pp. 486', 12, NULL, NULL),
(270, 8, 71, NULL, 72, NULL, 1, 'pp. 486', 13, NULL, NULL),
(271, 8, 72, NULL, 73, NULL, 1, 'pp. 486', 14, NULL, NULL),
(272, 8, 73, NULL, 74, NULL, 1, 'pp. 486', 15, NULL, NULL),
(273, 8, 74, NULL, 75, NULL, 1, 'pp. 486', 16, NULL, NULL),
(274, 8, 75, NULL, 76, NULL, 1, 'pp. 486', 17, NULL, NULL),
(275, 8, 76, NULL, 77, NULL, 1, 'pp. 486', 18, NULL, NULL),
(276, 8, 77, NULL, 78, NULL, 1, 'pp. 486', 19, NULL, NULL),
(277, 8, 78, NULL, 79, NULL, 1, 'pp. 486', 20, NULL, NULL),
(278, 8, 79, NULL, 80, NULL, 1, 'pp. 486', 21, NULL, NULL),
(279, 8, 80, NULL, 81, NULL, 1, 'pp. 486', 22, NULL, NULL),
(280, 8, 81, NULL, 82, NULL, 1, 'pp. 486', 23, NULL, NULL),
(281, 8, 82, NULL, 83, NULL, 1, 'pp. 486', 24, NULL, NULL),
(282, 8, 83, NULL, 84, NULL, 1, 'pp. 404-406 e 486', 25, NULL, NULL),
(283, 8, 84, NULL, 83, NULL, 1, 'pp. 486', 26, NULL, NULL),
(284, 8, 83, NULL, 82, NULL, 1, 'pp. 486', 27, NULL, NULL),
(285, 8, 82, NULL, 81, NULL, 1, 'pp. 486', 28, NULL, NULL),
(286, 8, 81, NULL, 80, NULL, 1, 'pp. 486', 29, NULL, NULL),
(287, 8, 80, NULL, 79, NULL, 1, 'pp. 486', 30, NULL, NULL),
(288, 8, 79, NULL, 78, NULL, 1, 'pp. 486', 31, NULL, NULL),
(289, 8, 78, NULL, 77, NULL, 1, 'pp. 486', 32, NULL, NULL),
(290, 8, 77, NULL, 76, NULL, 1, 'pp. 486', 33, NULL, NULL),
(291, 8, 76, NULL, 75, NULL, 1, 'pp. 486', 34, NULL, NULL),
(292, 8, 75, NULL, 74, NULL, 1, 'pp. 486', 35, NULL, NULL),
(293, 8, 74, NULL, 73, NULL, 1, 'pp. 486', 36, NULL, NULL),
(294, 8, 73, NULL, 72, NULL, 1, 'pp. 486', 37, NULL, NULL),
(295, 8, 72, NULL, 71, NULL, 1, 'pp. 486', 38, NULL, NULL),
(296, 8, 71, NULL, 70, NULL, 1, 'pp. 486', 39, NULL, NULL),
(297, 8, 70, NULL, 69, NULL, 1, 'pp. 486', 40, NULL, NULL),
(298, 8, 69, NULL, 68, NULL, 1, 'pp. 486', 41, NULL, NULL),
(299, 8, 68, NULL, 67, NULL, 1, 'pp. 486', 42, NULL, NULL),
(300, 8, 67, NULL, 66, NULL, 1, 'pp. 486', 43, NULL, NULL),
(301, 8, 66, NULL, 65, NULL, 1, 'pp. 486', 44, NULL, NULL),
(302, 8, 65, NULL, 64, NULL, 1, 'pp. 486', 45, NULL, NULL),
(303, 8, 64, NULL, 63, NULL, 1, 'pp. 486', 46, NULL, NULL),
(304, 8, 63, NULL, 62, NULL, 1, 'pp. 486', 47, NULL, NULL),
(305, 8, 62, NULL, 61, NULL, 1, 'pp. 486', 48, NULL, NULL),
(307, 8, 61, NULL, 60, NULL, 1, 'pp. 486', 49, NULL, NULL),
(308, 8, 60, NULL, 59, NULL, 1, 'pp. 486', 50, NULL, NULL),
(309, 8, 59, NULL, 58, NULL, 1, 'pp. 486', 51, NULL, NULL),
(310, 8, 58, NULL, 57, '1396-11-11', 1, 'pp. 404-406 e 486', 52, NULL, NULL),
(311, 8, 57, NULL, 217, NULL, 1, 'pp. 486', 53, NULL, NULL),
(312, 8, 217, NULL, 218, NULL, 1, 'pp. 486', 54, NULL, NULL),
(313, 8, 218, NULL, 219, NULL, 1, 'pp. 486', 55, NULL, NULL),
(314, 8, 219, NULL, 220, NULL, 1, 'pp. 486', 56, NULL, NULL),
(315, 8, 220, NULL, 221, NULL, 1, 'pp. 404-406 e 486', 57, NULL, NULL),
(316, 8, 221, NULL, 4, NULL, 1, 'pp. 404-406 e 486', 58, NULL, NULL),
(317, 8, 4, NULL, 222, NULL, 1, 'pp. 404-406', 59, NULL, NULL),
(318, 8, 222, NULL, 1, '1396-12-25', 1, 'pp. 404-406 e 486', 60, NULL, NULL),
(319, 9, 1, '1401-03-15', 223, NULL, 1, 'pp. 416-422 e 487', 1, NULL, NULL),
(320, 9, 223, NULL, 227, NULL, 1, 'pp. 487', 2, NULL, NULL),
(321, 9, 227, NULL, 228, NULL, 1, 'pp. 487', 3, NULL, NULL),
(322, 9, 228, NULL, 229, NULL, 1, 'pp. 487', 4, NULL, NULL),
(323, 9, 229, NULL, 230, NULL, 1, 'pp. 487', 5, NULL, NULL),
(324, 9, 230, NULL, 231, NULL, 1, 'pp. 487', 6, NULL, NULL),
(325, 9, 231, NULL, 232, NULL, 1, 'pp. 487', 7, NULL, NULL),
(326, 9, 232, NULL, 233, NULL, 1, 'pp. 487', 8, NULL, NULL),
(327, 9, 233, NULL, 234, NULL, 1, 'pp. 487', 9, NULL, NULL),
(328, 9, 234, NULL, 235, NULL, 1, 'pp. 487', 10, NULL, NULL),
(329, 9, 235, NULL, 236, NULL, 1, 'pp. 416-422 e 487', 11, NULL, NULL),
(330, 9, 236, NULL, 133, NULL, 1, 'pp. 416-422 e 487', 12, NULL, NULL),
(331, 9, 133, NULL, 237, NULL, 1, 'pp. 416-422 e 487', 13, NULL, NULL),
(332, 9, 237, NULL, 225, NULL, 1, 'pp. 416-422 e 487', 14, NULL, NULL),
(333, 9, 225, NULL, 238, NULL, 1, 'pp. 487', 15, NULL, NULL),
(334, 9, 238, NULL, 239, NULL, 1, 'pp. 416-422 e 487', 16, NULL, NULL),
(335, 9, 239, NULL, 240, NULL, 1, 'pp. 487', 17, NULL, NULL),
(336, 9, 240, NULL, 241, NULL, 1, 'pp. 487', 18, NULL, NULL),
(337, 9, 241, NULL, 242, NULL, 1, 'pp. 416-422 e 487', 19, NULL, NULL),
(338, 9, 242, NULL, 243, NULL, 1, 'pp. 487', 20, NULL, NULL),
(339, 9, 243, NULL, 226, NULL, 1, 'pp. 487', 21, NULL, NULL),
(340, 9, 226, NULL, 244, NULL, 1, 'pp. 416-422 e 487', 22, NULL, NULL),
(341, 9, 244, NULL, 242, '1401-07-18', 1, 'pp. 416-422 e 487', 23, NULL, NULL),
(342, 9, 242, NULL, 245, NULL, 1, 'pp. 487', 24, NULL, NULL),
(343, 9, 245, NULL, 133, NULL, 1, 'pp. 487', 25, NULL, NULL),
(344, 9, 242, NULL, 245, NULL, 1, 'pp. 487', 26, NULL, NULL),
(345, 9, 245, NULL, 246, NULL, 1, 'pp. 487', 27, NULL, NULL),
(346, 9, 246, NULL, 247, NULL, 1, 'pp. 487', 28, NULL, NULL),
(347, 9, 247, NULL, 248, NULL, 1, 'pp. 487', 29, NULL, NULL),
(348, 9, 248, NULL, 224, NULL, 1, 'pp. 487', 30, NULL, NULL),
(349, 9, 224, NULL, 223, '1401-07-30', 1, 'pp. 416-422 e 487', 31, NULL, NULL),
(350, 9, 223, NULL, 249, NULL, 1, 'pp. 487', 32, NULL, NULL),
(351, 9, 249, NULL, 250, NULL, 1, 'pp. 487', 33, NULL, NULL),
(352, 9, 250, NULL, 251, NULL, 1, 'pp. 487', 34, NULL, NULL),
(353, 9, 251, NULL, 1, NULL, 1, 'pp. 416-422 e 487', 35, NULL, NULL),
(354, 10, 1, '1401-08-15', 224, NULL, 1, 'pp. 422-428 e 487-488', 1, NULL, NULL),
(355, 10, 224, NULL, 245, NULL, 1, 'pp. 422-428 e 487-488', 2, NULL, NULL),
(356, 10, 245, NULL, 247, NULL, 1, 'pp. 487-488', 3, NULL, NULL),
(357, 10, 247, NULL, 253, NULL, 1, 'pp. 487-488', 4, NULL, NULL),
(358, 10, 253, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488', 5, NULL, NULL),
(359, 10, 224, NULL, 254, NULL, 1, 'pp. 487-488', 6, NULL, NULL),
(360, 10, 254, NULL, 255, NULL, 1, 'pp. 487-488', 7, NULL, NULL),
(361, 10, 255, NULL, 256, NULL, 1, 'pp. 487-488', 8, NULL, NULL),
(362, 10, 256, NULL, 257, NULL, 1, 'pp. 487-488', 9, NULL, NULL),
(363, 10, 257, NULL, 258, NULL, 1, 'pp. 422-428 e 487-488', 10, NULL, NULL),
(364, 10, 258, NULL, 247, NULL, 1, 'pp. 422-428', 11, NULL, NULL),
(365, 10, 247, NULL, 248, NULL, 1, 'pp. 422-428 e 487-488', 12, NULL, NULL),
(366, 10, 248, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488', 13, NULL, NULL),
(367, 10, 224, NULL, 223, NULL, 1, 'pp. 422-428 e 487-488', 14, NULL, NULL),
(368, 10, 223, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488', 15, NULL, NULL),
(369, 10, 224, NULL, 259, NULL, 1, 'pp. 422-428 e 487-488', 16, NULL, NULL),
(370, 10, 259, NULL, 224, NULL, 1, 'pp. 422-428 e 487-488', 17, NULL, NULL),
(371, 10, 224, NULL, 223, NULL, 1, 'pp. 422-428 e 487-488', 18, NULL, NULL),
(372, 10, 223, NULL, 260, NULL, 1, 'pp. 487-488', 19, NULL, NULL),
(373, 10, 260, NULL, 261, NULL, 1, 'pp. 487-488', 20, NULL, NULL),
(374, 10, 261, NULL, 262, NULL, 1, 'pp. 487-488', 21, NULL, NULL),
(375, 10, 262, NULL, 38, NULL, 1, 'pp. 487-488', 22, NULL, NULL),
(376, 10, 38, NULL, 1, NULL, 1, 'pp. 422-428 e 487-488', 23, NULL, NULL),
(377, 11, 1, '1410-07-24', 148, NULL, 1, 'pp. 488-489', 1, NULL, NULL),
(378, 11, 138, NULL, 268, NULL, 1, 'pp. 488-489', 2, NULL, NULL),
(379, 11, 268, NULL, 269, NULL, 1, 'pp. 444-446 e 488-489', 3, NULL, NULL),
(380, 11, 269, NULL, 270, NULL, 1, 'pp. 488-489', 4, NULL, NULL),
(381, 11, 270, NULL, 142, NULL, 1, 'pp. 488-489', 5, NULL, NULL),
(382, 11, 142, NULL, 271, NULL, 1, 'pp. 488-489', 6, NULL, NULL),
(383, 11, 271, NULL, 141, NULL, 1, 'pp. 488-489', 7, NULL, NULL),
(384, 11, 141, NULL, 140, NULL, 1, 'pp. 488-489', 8, NULL, NULL),
(385, 11, 140, NULL, 272, NULL, 1, 'pp. 488-489', 9, NULL, NULL),
(386, 11, 272, NULL, 137, NULL, 1, 'pp. 488-489', 10, NULL, NULL),
(387, 11, 137, NULL, 273, NULL, 1, 'pp. 488-489', 11, NULL, NULL),
(388, 11, 273, NULL, 134, NULL, 1, 'pp. 444-446 e 488-489', 12, NULL, NULL),
(389, 11, 134, '1410-12-31', 274, NULL, 1, 'pp. 488-489', 13, NULL, NULL),
(390, 11, 274, NULL, 275, NULL, 1, 'pp. 488-489', 14, NULL, NULL),
(391, 11, 275, NULL, 276, NULL, 1, 'pp. 444-446', 15, NULL, NULL),
(392, 11, 276, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489', 16, NULL, NULL),
(393, 11, 1, NULL, 38, NULL, 1, 'pp. 444-446 e 488-489', 17, NULL, NULL),
(394, 11, 38, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489', 18, NULL, NULL),
(395, 11, 1, NULL, 276, NULL, 1, 'pp. 444-446', 19, NULL, NULL),
(396, 11, 276, NULL, 148, NULL, 1, 'pp. 444-446 e 488-489', 20, NULL, NULL),
(397, 11, 148, NULL, 1, NULL, 1, 'pp. 444-446 e 488-489', 21, NULL, NULL),
(398, 6, 152, NULL, 153, NULL, 2, NULL, 20, NULL, NULL);

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
(3, 'prigioniero di'),
(4, 'amico di');

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
(30, 'accompagnare'),
(31, 'pubblicizzarsi');

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
('acignoni', 'Alessandro', 'Cignoni', 'Università di Pisa', 'Studente', 'alessandro1'),
('esalvatori', 'Enrica', 'Salvatore', 'Università di Pisa', 'Professoressa', 'enrica3'),
('lgaloppini', 'Laura', 'Galoppini', 'Università di Pisa', 'Professoressa', 'laura4'),
('vcasarosa', 'Vittore', 'Casarosa', 'Università di Pisa', 'Professore', 'vittore2');

-- --------------------------------------------------------

--
-- Struttura della tabella `Viaggio`
--

CREATE TABLE `Viaggio` (
  `id` smallint(6) NOT NULL,
  `titolo` varchar(64) COLLATE latin1_general_cs DEFAULT NULL,
  `luogo_partenza` smallint(6) DEFAULT NULL,
  `data_partenza` date DEFAULT NULL,
  `intervallo_partenza` smallint(6) DEFAULT NULL,
  `luogo_meta` smallint(6) DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `intervallo_fine` smallint(6) DEFAULT NULL,
  `piano` blob DEFAULT NULL,
  `fonte` smallint(6) DEFAULT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `schedatore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `pubblico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dump dei dati per la tabella `Viaggio`
--

INSERT INTO `Viaggio` (`id`, `titolo`, `luogo_partenza`, `data_partenza`, `intervallo_partenza`, `luogo_meta`, `data_fine`, `intervallo_fine`, `piano`, `fonte`, `pagine`, `schedatore`, `pubblico`) VALUES
(1, 'Dietro a Carlo della Pace', 4, '1380-00-00', NULL, 1, '1380-00-00', NULL, 0x556e6120766f6c746120756e69746f736920616c6c27657365726369746f206469204361726c6f2064656c6c61205061636520692066756f726975736369746920646120466972656e7a6520737065726176616e6f2063686520717565737469207265696e736564696173736520696c20726567696d65206f6c69676172636869636f20726f7665736369616e646f207175656c6c6f206465692043696f6d70692e, 1, 'pp. 377-379 e 480', 'acignoni', 1),
(2, 'Trasferimento a Parigi', 32, '1380-00-00', NULL, 84, '1380-00-00', NULL, NULL, 1, 'pp. 379-380 e 480-481', 'acignoni', 1),
(3, 'Gioco d’azzardo e prigionieri', 84, '1380-00-00', NULL, 96, '1380-00-00', NULL, NULL, 1, 'pp. 380-381 e 481', 'acignoni', 1),
(4, 'Guerra contro Gand', 84, '1382-00-00', NULL, 115, '1383-00-00', NULL, 0x4c27657365726369746f2064656c207265206469204672616e636961206d6972617661206120736564617265206c61207269766f6c7461206465676c692061626974616e74692064692047616e642e, 1, 'pp. 382-286 e 482', 'acignoni', 1),
(5, 'Perle per il duca', 84, '1383-02-00', NULL, 132, '1383-04-00', NULL, NULL, 1, 'pp. 386-387 e 482-483', 'acignoni', 1),
(6, '“Adventus archiespiscopi nostri”', 134, '0990-00-00', NULL, 106, '0990-00-00', NULL, 0x4920766573636f766920616e676f6c6f736173736f6e692074726164697a696f6e616c6d656e74652072696365766576616e6f20696c2070616c6c696f2064616c207061706120696e20706572736f6e612c20536967657269636f207175696e646920746f726ec3b220646120526f6d612066696e6f20612043616e7465726275727920756e6120766f6c7461206e6f6d696e61746f2061726369766573636f766f2e, 2, NULL, 'acignoni', 1),
(7, 'La guerra dei cent’anni', 84, '1383-00-00', NULL, 93, '1383-00-00', NULL, 0x4e656c2071756164726f2064656c6c6120677565727261206465692063656e7427616e6e692c206c27657365726369746f206672616e63657365207269636f6e7175697374c3b2206c612063697474c3a0206469204d6f6e732c206d61206e6f6e207269757363c3ac20612072696361636369617265206c27657365726369746f206465676c6920696e676c6573692e, 1, 'pp. 387-389 e 482', 'acignoni', 1),
(8, '“Conchiudere lega” col re di Francia', 1, '1396-07-20', NULL, 84, '1396-12-15', NULL, 0x4e656c6c276f747469636120646920756e6120636f616c697a696f6e6520616e7469766973636f6e7465612c206c61207265707562626c69636120646920466972656e7a652063657263c3b220646920737472696e6765726520756e27616c6c65616e7a612064656c207265206469204672616e6369612e, 1, 'pp. 404-406 e 486', 'acignoni', 1),
(9, '“In Alemagna al nuovo eletto Imperadore”', 1, '1401-03-15', NULL, 225, '1401-12-30', NULL, NULL, 1, 'pp. 416-422 e 487', 'acignoni', 1),
(10, 'Discesa in Italia', 1, '1401-08-15', NULL, 46, '1402-00-00', NULL, 0x4772617a696520616c20736f737465676e6f2065636f6e6f6d69636f2064656c6c61207265707562626c69636120646920466972656e7a652c206c27696d70657261746f7265206469736365736520696e204974616c69612070657220706f7272652066696e6520616c6c6f2073747261706f746572652064656920566973636f6e74692c2073656e7a6120706572c3b220726975736369726520612073636f6e6669676765726c69206520746f726e616e646f204f6c7472616c7065206e6f6e6f7374616e746520676c692073666f727a69206469706c6f6d61746963692065642065636f6e6f6d69636920646920466972656e7a652e, 1, 'pp. 422-428 e 487-488', 'acignoni', 1),
(11, 'Dietro a Luigi d’Angiò', 1, '1410-07-24', NULL, 134, '1411-00-00', NULL, 0x4c612073706564697a696f6e6520636f6e74726f20696c207265206469204e61706f6c6920736920636f6e636c75736520696e20756e206e69656e746520646920666174746f206e65692070726573736920646920526f6d612e, 1, 'pp. 444-446 e 488-489', 'acignoni', 1);

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
-- Indici per le tabelle `Intervallo`
--
ALTER TABLE `Intervallo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `lavora_come`
--
ALTER TABLE `lavora_come`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lavora_come_persona` (`persona`),
  ADD KEY `fk_lavora_come_occupazione` (`occupazione`),
  ADD KEY `fk_lavora_come_intervallo_inizio` (`intervallo_inizio`),
  ADD KEY `fk_lavora_come_intervallo_fine` (`intervallo_fine`);

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
  ADD KEY `fk_persona_luogo_morte` (`luogo_morte`),
  ADD KEY `fk_persona_schedatore` (`schedatore`),
  ADD KEY `fk_persona_intervallo_nascita` (`intervallo_nascita`),
  ADD KEY `fk_persona_intervallo_morte` (`intervallo_morte`);

--
-- Indici per le tabelle `relazione`
--
ALTER TABLE `relazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_relazione_persona1` (`persona1`),
  ADD KEY `fk_relazione_persona2` (`persona2`),
  ADD KEY `fk_relazione_tipo` (`tipo`),
  ADD KEY `fk_relazione_intervallo_inizio` (`intervallo_inizio`),
  ADD KEY `fk_relazione_intervallo_fine` (`intervallo_fine`);

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
  ADD KEY `fk_tappa_luogo_arrivo` (`luogo_arrivo`) USING BTREE,
  ADD KEY `fk_tappa_viaggio` (`viaggio`),
  ADD KEY `fk_tappa_intervallo_partenza` (`intervallo_partenza`),
  ADD KEY `fk_tappa_intervallo_arrivo` (`intervallo_arrivo`);

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
  ADD KEY `fk_viaggio_luogo_meta` (`luogo_meta`),
  ADD KEY `fk_viaggio_fonte` (`fonte`),
  ADD KEY `fk_viaggio_schedatore` (`schedatore`),
  ADD KEY `fk_intervallo_partenza` (`intervallo_partenza`),
  ADD KEY `fk_intervallo_fine` (`intervallo_fine`);

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
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `Commento_Viaggio`
--
ALTER TABLE `Commento_Viaggio`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT per la tabella `Intervallo`
--
ALTER TABLE `Intervallo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT per la tabella `lavora_come`
--
ALTER TABLE `lavora_come`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `Scopo`
--
ALTER TABLE `Scopo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `Tappa`
--
ALTER TABLE `Tappa`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=399;

--
-- AUTO_INCREMENT per la tabella `Tipo_Relazione`
--
ALTER TABLE `Tipo_Relazione`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `Tipo_Scopo`
--
ALTER TABLE `Tipo_Scopo`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  ADD CONSTRAINT `fk_persona_intervallo_morte` FOREIGN KEY (`intervallo_morte`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_intervallo_nascita` FOREIGN KEY (`intervallo_nascita`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_luogo_morte` FOREIGN KEY (`luogo_morte`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_luogo_nascita` FOREIGN KEY (`luogo_nascita`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persona_schedatore` FOREIGN KEY (`schedatore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Scopo`
--
ALTER TABLE `Scopo`
  ADD CONSTRAINT `fk_scopo_tipo` FOREIGN KEY (`tipo`) REFERENCES `Tipo_Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Tappa`
--
ALTER TABLE `Tappa`
  ADD CONSTRAINT `fk_tappa_intervallo_arrivo` FOREIGN KEY (`intervallo_arrivo`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tappa_intervallo_partenza` FOREIGN KEY (`intervallo_partenza`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tappa_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tappa_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `fk_intervallo_fine` FOREIGN KEY (`intervallo_fine`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_intervallo_partenza` FOREIGN KEY (`intervallo_partenza`) REFERENCES `Intervallo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_fonte` FOREIGN KEY (`fonte`) REFERENCES `Fonte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_luogo_meta` FOREIGN KEY (`luogo_meta`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_viaggio_schedatore` FOREIGN KEY (`schedatore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
