--
-- Database: `aplm`
--

--
-- Tabella `Luogo`
--

CREATE TABLE `Luogo` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `latitudine` decimal(8,5) NOT NULL,
  `longitudine` decimal(8,5) NOT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Persona`
--

CREATE TABLE `Persona` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `soprannome` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `luogo_nascita` smallint(6) DEFAULT NULL,
  CONSTRAINT `fk_persona_luogo_nascita` FOREIGN KEY (`luogo_nascita`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_morte` date DEFAULT NULL,
  `luogo_morte` smallint(6) DEFAULT NULL,
  CONSTRAINT `fk_persona_luogo_morte` FOREIGN KEY (`luogo_morte`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Occupazione`
--

CREATE TABLE `Occupazione` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `attivita` varchar(32) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `lavora_come`
--

CREATE TABLE `lavora_come` (
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_lavora_come_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `occupazione` smallint(6) NOT NULL,
  CONSTRAINT `fk_lavora_come_occupazione` FOREIGN KEY (`occupazione`) REFERENCES `Occupazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_fine` date DEFAULT NULL,
  `data_inizio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Tipo_Relazione`
--

CREATE TABLE `Tipo_Relazione` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `relazione`
--

CREATE TABLE `relazione` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `persona1` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_tappa_persona1` FOREIGN KEY (`persona1`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `persona2` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_tappa_persona2` FOREIGN KEY (`persona2`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `tipo` smallint(6) NOT NULL,
  CONSTRAINT `fk_relazione_tipo` FOREIGN KEY (`tipo`) REFERENCES `Tipo_Relazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Fonte`
--

CREATE TABLE `Fonte` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cit_biblio` varchar(256) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Viaggio`
--

CREATE TABLE `Viaggio` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `titolo` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `luogo_partenza` smallint(6) NOT NULL,
  CONSTRAINT `fk_viaggio_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_partenza` date DEFAULT NULL,
  `luogo_meta` smallint(6) NOT NULL,
  CONSTRAINT `fk_viaggio_luogo_meta` FOREIGN KEY (`luogo_meta`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_fine` date DEFAULT NULL,
  `piano` blob DEFAULT NULL,
  `fonte` smallint(6) NOT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `scala` varchar(16) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `partecipa_viaggio`
--

CREATE TABLE `partecipa_viaggio` (
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_viaggio_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `viaggio` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Tipo_Scopo`
--

CREATE TABLE `Tipo_Scopo` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Scopo`
--

CREATE TABLE `Scopo` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tipo` smallint(6) NOT NULL,
  CONSTRAINT `fk_scopo_tipo` FOREIGN KEY (`tipo`) REFERENCES `Tipo_Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `successo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `destinatario`
--

CREATE TABLE `destinatario` (
  `scopo` smallint(6) NOT NULL,
  CONSTRAINT `fk_destinatario_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_destinatario_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `mandante`
--

CREATE TABLE `mandante` (
  `scopo` smallint(6) NOT NULL,
  CONSTRAINT `fk_mandante_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_mandante_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `motivo_viaggio`
--

CREATE TABLE `motivo_viaggio` (
  `viaggio` smallint(6) NOT NULL,
  CONSTRAINT `fk_motivo_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `scopo` smallint(6) NOT NULL,
  CONSTRAINT `fk_motivo_viaggio_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Tappa`
--

CREATE TABLE `Tappa` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `viaggio` smallint(6) NOT NULL,
  `luogo_partenza` smallint(6) NOT NULL,
  CONSTRAINT `fk_tappa_luogo_partenza` FOREIGN KEY (`luogo_partenza`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_partenza` date DEFAULT NULL,
  `luogo_arrivo` smallint(6) NOT NULL,
  CONSTRAINT `fk_viaggio_luogo_arrivo` FOREIGN KEY (`luogo_arrivo`) REFERENCES `Luogo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_arrivo` date DEFAULT NULL,
  `fonte` smallint(6) NOT NULL,
  `pagine` varchar(32) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `partecipa_tappa`
--

CREATE TABLE `partecipa_tappa` (
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_tappa_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `tappa` smallint(6) NOT NULL,
  CONSTRAINT `fk_partecipa_tappa_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `motivo_tappa`
--

CREATE TABLE `motivo_tappa` (
  `tappa` smallint(6) NOT NULL,
  CONSTRAINT `fk_motivo_tappa_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `scopo` smallint(6) NOT NULL,
  CONSTRAINT `fk_motivo_tappa_scopo` FOREIGN KEY (`scopo`) REFERENCES `Scopo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Merce`
--

CREATE TABLE `Merce` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `quantita` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `valore` varchar(32) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `trasporta`
--

CREATE TABLE `trasporta` (
  `tappa` smallint(6) NOT NULL,
  CONSTRAINT `fk_trasporta_tappa` FOREIGN KEY (`tappa`) REFERENCES `Tappa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `merce` smallint(6) NOT NULL,
  CONSTRAINT `fk_trasporta_merce` FOREIGN KEY (`merce`) REFERENCES `Merce` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Biografia`
--

CREATE TABLE `Biografia` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `persona` smallint(6) NOT NULL,
  CONSTRAINT `fk_biografia_persona` FOREIGN KEY (`persona`) REFERENCES `Persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `presentazione` varchar(256) COLLATE latin1_general_cs NOT NULL,
  `descrizione` blob NOT NULL,
  `viaggio1` smallint(6) DEFAULT NULL,
  CONSTRAINT `fk_biografia_viaggio1` FOREIGN KEY (`viaggio1`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `viaggio2` smallint(6) DEFAULT NULL,
  CONSTRAINT `fk_biografia_viaggio2` FOREIGN KEY (`viaggio2`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Immagine`
--

CREATE TABLE `Immagine` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `locazione` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `didascalia` varchar(256) COLLATE latin1_general_cs NOT NULL,
  `provenienza` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Evento`
--

CREATE TABLE `Evento` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `biografia` smallint(6) NOT NULL,
  CONSTRAINT `fk_evento_biografia` FOREIGN KEY (`biografia`) REFERENCES `Biografia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `immagine` smallint(6) DEFAULT NULL,
  CONSTRAINT `fk_evento_immagine` FOREIGN KEY (`immagine`) REFERENCES `Immagine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `data_inizio` date NOT NULL,
  `data_fine` date DEFAULT NULL,
  `titolo` varchar(128) COLLATE latin1_general_cs NOT NULL,
  `didascalia` blob NOT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Utente`
--

CREATE TABLE `Utente` (
  `nick` varchar(16) COLLATE latin1_general_cs NOT NULL PRIMARY KEY,
  `nome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `ente` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `ruolo` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Commento_Biografia`
--

CREATE TABLE `Commento_Biografia` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  CONSTRAINT `fk_commento_biografia_autore` FOREIGN KEY (`autore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE,
  `biografia` smallint(6) NOT NULL,
  CONSTRAINT `fk_commento_biografia_biografia` FOREIGN KEY (`biografia`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Tabella `Commento_Viaggio`
--

CREATE TABLE `Commento_Viaggio` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  CONSTRAINT `fk_commento_viaggio_autore` FOREIGN KEY (`autore`) REFERENCES `Utente` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE,
  `viaggio` smallint(6) NOT NULL,
  CONSTRAINT `fk_commento_viaggio_viaggio` FOREIGN KEY (`viaggio`) REFERENCES `Viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Utenti aggiunti per aplm
--

INSERT INTO `user` (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`, `ssl_type`, `ssl_cipher`, `x509_issuer`, `x509_subject`, `max_questions`, `max_updates`, `max_connections`, `max_user_connections`, `plugin`, `authentication_string`, `password_expired`, `is_role`, `default_role`, `max_statement_time`) VALUES
('localhost', 'visitatore', '', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0, 'mysql_native_password', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19', 'N', 'N', '', '0.000000'),
('localhost', 'commentatore', '', 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0, 'mysql_native_password', '', 'N', 'N', '', '0.000000');
