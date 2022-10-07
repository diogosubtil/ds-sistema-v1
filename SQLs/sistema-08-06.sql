-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: sistemadegestaov2
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caixa`
--

DROP TABLE IF EXISTS `caixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caixa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idservico` int(11) DEFAULT NULL,
  `idvenda` int(11) DEFAULT NULL,
  `usuario` varchar(200) DEFAULT NULL,
  `unidade` int(11) DEFAULT NULL,
  `tipo` enum('Entrada','Saida') DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caixa`
--

LOCK TABLES `caixa` WRITE;
/*!40000 ALTER TABLE `caixa` DISABLE KEYS */;
INSERT INTO `caixa` (`id`, `idservico`, `idvenda`, `usuario`, `unidade`, `tipo`, `descricao`, `valor`, `data`) VALUES (61,NULL,127,'Diogo Subtil',1,'Entrada','Venda',90.00,'2022-06-08'),(62,NULL,128,'Diogo Subtil',1,'Entrada','Venda',250.00,'2022-06-08'),(63,NULL,129,'Diogo Subtil',1,'Entrada','Venda',50.00,'2022-06-08'),(64,NULL,130,'Diogo Subtil',1,'Entrada','Venda',80.00,'2022-06-08'),(65,NULL,131,'Diogo Subtil',1,'Entrada','Venda',2500.00,'2022-06-08'),(66,NULL,132,'Diogo Subtil',1,'Entrada','Venda',120.00,'2022-06-08'),(67,99,NULL,'Diogo Subtil',1,'Entrada','Serviço',250.00,'2022-06-08'),(68,100,NULL,'Diogo Subtil',1,'Entrada','Serviço',100.00,'2022-06-08'),(69,NULL,NULL,'Diogo Subtil',1,'Saida','Gasolina',-100.00,'2022-06-08');
/*!40000 ALTER TABLE `caixa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estoque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `quantidade` varchar(30) DEFAULT NULL,
  `valorvenda` decimal(8,2) DEFAULT NULL,
  `unidade` int(11) DEFAULT NULL,
  `totalvalor` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` (`id`, `nome`, `tipo`, `descricao`, `valor`, `quantidade`, `valorvenda`, `unidade`, `totalvalor`, `data`) VALUES (65,'Capinha','capa','Preta',15.00,'25',40.00,1,1000,'2022-06-08'),(66,'Carregador','carregador','Branco',20.00,'19',90.00,1,1710,'2022-06-08'),(67,'Caixa de Som','caixadesom','JBL',50.00,'4',250.00,1,1000,'2022-06-08'),(68,'Fone de Ouvido','fonedeouvido','LG',20.00,'20',90.00,1,1800,'2022-06-08'),(69,'Nokia','celular','Preto',800.00,'1',2500.00,1,2500,'2022-06-08'),(70,'Pelicula','acessorios','Vidro',6.00,'19',50.00,1,950,'2022-06-08');
/*!40000 ALTER TABLE `estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordemdeservico`
--

DROP TABLE IF EXISTS `ordemdeservico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordemdeservico` (
  `idos` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `nomecliente` varchar(50) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `imei` varchar(50) NOT NULL,
  `condicao` varchar(100) DEFAULT NULL,
  `servicorealizado` varchar(100) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `dia` date DEFAULT NULL,
  PRIMARY KEY (`idos`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordemdeservico`
--

LOCK TABLES `ordemdeservico` WRITE;
/*!40000 ALTER TABLE `ordemdeservico` DISABLE KEYS */;
INSERT INTO `ordemdeservico` (`idos`, `nome`, `nomecliente`, `marca`, `modelo`, `imei`, `condicao`, `servicorealizado`, `valor`, `dia`) VALUES (2,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-03-31'),(3,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-04-01'),(4,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-04-01');
/*!40000 ALTER TABLE `ordemdeservico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomevendedor` varchar(30) NOT NULL,
  `nomecliente` varchar(30) NOT NULL,
  `pagamento` enum('D','CD','CC','Pix','TB') DEFAULT NULL,
  `servico` varchar(50) DEFAULT NULL,
  `custo` decimal(8,2) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `unidade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicos`
--

LOCK TABLES `servicos` WRITE;
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
INSERT INTO `servicos` (`id`, `nomevendedor`, `nomecliente`, `pagamento`, `servico`, `custo`, `valor`, `data`, `unidade`) VALUES (99,'Diogo Subtil','Fabio','Pix','Troca de tela',100.00,250.00,'2022-06-08',1),(100,'Diogo Subtil','Milena','D','Conector novo',50.00,100.00,'2022-06-08',1);
/*!40000 ALTER TABLE `servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `dataAbertura` date NOT NULL,
  `meta` varchar(255) NOT NULL,
  `gerente` int(11) NOT NULL,
  `endereco` mediumtext DEFAULT NULL,
  `numero` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `ativo` enum('s','n') NOT NULL DEFAULT 's',
  `dataCadastro` datetime NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` (`id`, `cep`, `bairro`, `cidade`, `estado`, `whatsapp`, `dataAbertura`, `meta`, `gerente`, `endereco`, `numero`, `timezone`, `ativo`, `dataCadastro`, `dataAtualizacao`) VALUES (1,'80010-130','Centro','Curitiba','PR','(41) 99983-6534','2021-11-10','100000',1,'Av. Mal. Floriano Peixoto','781','America/Parana','s','2022-05-30 00:00:00','2022-05-27 14:05:18');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `unidade` varchar(255) DEFAULT '0',
  `treinamento` enum('s','n') NOT NULL DEFAULT 'n',
  `ativo` enum('s','n') NOT NULL DEFAULT 's',
  `dataCadastro` datetime NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `funcao`, `nome`, `email`, `usuario`, `senha`, `telefone`, `unidade`, `treinamento`, `ativo`, `dataCadastro`, `dataAtualizacao`) VALUES (1,'1','Diogo Subtil','diogosubtil20@gmail.com','diogo','$2y$10$ckWOvqZFHbkXnlZ457YaB.NvBuO3Oc8IPlPJDsc3GvyBrfeDHmKXe','41995507801','1','n','s','2022-05-18 21:10:38','2022-05-28 02:07:54'),(43,'1','Teste teste','teste@gmail.com','teste','$2y$10$ha3eQWP/T9L.0ssy8SBC8uRSktUtYewRrtJTxPy3PlmBedzvl79nq','41995507801','1','n','n','2022-05-27 15:30:04','2022-05-27 13:57:16'),(44,'1','Rooana Subtil','rosubtil@gmail.com','rooana','$2y$10$yaEcZ2c.6dkrgeS9MMcHBeoaKT6i7/d4cVErubXafVJuphNDWcEmS','41997151973','1','n','n','2022-06-02 23:40:17','2022-06-04 16:09:06'),(45,'2','Rafael Bueno','rafael@cwbsmart.com','rafael','$2y$10$mh3t1IANoSYwhansN3iQXOc6ZZHAcTpddxnN/xYZiT9m5of.oZfWO','41999999999','1','n','s','2022-06-04 18:08:27','2022-06-04 16:08:27'),(46,'2','Jessica Candeu','jessica@cwbsmart.com','jessica','$2y$10$18u4xDiWOa.ftxx5m7MhYeXD05VvD3S9IlL3cSaFs9svadlwol0su','41999999999','1','n','s','2022-06-04 18:08:52','2022-06-04 16:08:52');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomevendedor` varchar(30) NOT NULL,
  `nomecliente` varchar(30) NOT NULL,
  `tipo` enum('D','CD','CC','Pix','TB') DEFAULT NULL,
  `idproduto` int(11) DEFAULT NULL,
  `unidade` int(11) DEFAULT NULL,
  `quantidade` varchar(30) NOT NULL,
  `valorproduto` decimal(8,2) DEFAULT NULL,
  `valortotal` decimal(8,2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` (`id`, `nomevendedor`, `nomecliente`, `tipo`, `idproduto`, `unidade`, `quantidade`, `valorproduto`, `valortotal`, `data`) VALUES (127,'Diogo Subtil','Milena','D',66,1,'1',90.00,90.00,'2022-06-08'),(128,'Diogo Subtil','Maria','Pix',67,1,'1',250.00,250.00,'2022-06-08'),(129,'Diogo Subtil','Carlos','CD',70,1,'1',50.00,50.00,'2022-06-08'),(130,'Diogo Subtil','Henrrique','CC',65,1,'2',40.00,80.00,'2022-06-08'),(131,'Diogo Subtil','Fabio','TB',69,1,'1',2500.00,2500.00,'2022-06-08'),(132,'Diogo Subtil','Milena','Pix',65,1,'3',40.00,120.00,'2022-06-08');
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-08 13:49:19
