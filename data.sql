CREATE TABLE `tblParticipantes` (
  `nId` int(11) NOT NULL,
  `cNombre` varchar(100) DEFAULT NULL,
  `cApellidos` varchar(250) DEFAULT NULL,
  `cTel` varchar(50) DEFAULT NULL,
  `cEmail` varchar(100) DEFAULT NULL,
  `cGenero` varchar(15) DEFAULT NULL,
  `cRazones` text,
  `cUrl_Ine` varchar(250) DEFAULT NULL,
  `cUrl_Comprobante_Domicilio` varchar(250) DEFAULT NULL,
  `bTerminos` tinyint(4) DEFAULT NULL,
  `cEstatus` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`nId`),
  UNIQUE KEY `id_UNIQUE` (`nId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
