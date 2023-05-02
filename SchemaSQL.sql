
CREATE TABLE `Biografia` (
  `id` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL,
  `presentazione` varchar(256) COLLATE latin1_general_cs DEFAULT NULL,
  `descrizione` blob DEFAULT NULL,
  `viaggio1` smallint(6) DEFAULT NULL,
  `viaggio2` smallint(6) DEFAULT NULL,
  `pubblico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Commento_Biografia` (
  `id` smallint(6) NOT NULL,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `biografia` smallint(6) NOT NULL,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Commento_Viaggio` (
  `id` smallint(6) NOT NULL,
  `autore` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `viaggio` smallint(6) NOT NULL,
  `commento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `destinatario` (
  `scopo` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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

CREATE TABLE `Immagine` (
  `id` smallint(6) NOT NULL,
  `locazione` varchar(128) COLLATE latin1_general_cs DEFAULT NULL,
  `didascalia` varchar(256) COLLATE latin1_general_cs NOT NULL,
  `provenienza` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Intervallo` (
  `id` smallint(6) NOT NULL,
  `stringa` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `valore` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `lavora_come` (
  `id` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL,
  `occupazione` smallint(6) DEFAULT NULL,
  `data_inizio` date DEFAULT NULL,
  `data_fine` date DEFAULT NULL,
  `intervallo_inizio` smallint(6) DEFAULT NULL,
  `intervallo_fine` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;CREATE TABLE `Luogo` (
  `id` smallint(6) NOT NULL,
  `nome` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `latitudine` decimal(8,5) NOT NULL,
  `longitudine` decimal(8,5) NOT NULL,
  `uri` varchar(256) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `mandante` (
  `scopo` smallint(6) NOT NULL,
  `persona` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Merce` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL,
  `quantita` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `valore` varchar(32) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `motivo_tappa` (
  `tappa` smallint(6) NOT NULL,
  `scopo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;
CREATE TABLE `motivo_viaggio` (
  `viaggio` smallint(6) NOT NULL,
  `scopo` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Occupazione` (
  `id` smallint(6) NOT NULL,
  `attivita` varchar(32) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `partecipa_tappa` (
  `persona` smallint(6) NOT NULL,
  `tappa` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `partecipa_viaggio` (
  `persona` smallint(6) NOT NULL,
  `viaggio` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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

CREATE TABLE `Scopo` (
  `id` smallint(6) NOT NULL,
  `tipo` smallint(6) DEFAULT NULL,
  `successo` tinyint(1) DEFAULT NULL,
  `schedatore` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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

CREATE TABLE `Tipo_Relazione` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Tipo_Scopo` (
  `id` smallint(6) NOT NULL,
  `tipo` varchar(64) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `trasporta` (
  `tappa` smallint(6) NOT NULL,
  `merce` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

CREATE TABLE `Utente` (
  `nick` varchar(16) COLLATE latin1_general_cs NOT NULL,
  `nome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `cognome` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `ente` varchar(32) COLLATE latin1_general_cs DEFAULT NULL,
  `ruolo` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(16) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
