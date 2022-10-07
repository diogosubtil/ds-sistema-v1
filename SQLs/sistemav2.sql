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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caixa`
--

LOCK TABLES `caixa` WRITE;
/*!40000 ALTER TABLE `caixa` DISABLE KEYS */;
INSERT INTO `caixa` VALUES (40,NULL,NULL,'Diogo Subtil',1,'Entrada','mes 05',200.00,'2022-05-31'),(41,NULL,NULL,'Diogo Subtil',1,'Entrada','mes 04',250.00,'2022-04-13'),(42,NULL,116,'Diogo Subtil',1,'Entrada','Venda',500.00,'2022-05-31'),(43,NULL,117,'Diogo Subtil',1,'Entrada','Venda',1000.00,'2022-04-13'),(44,95,NULL,'Diogo Subtil',1,'Entrada','Serviço',250.00,'2022-05-31'),(45,96,NULL,'Diogo Subtil',1,'Entrada','Serviço',500.00,'2022-04-14'),(47,97,NULL,'Alysson Paiva',1,'Entrada','Serviço',2500.00,'2022-06-01'),(48,NULL,NULL,'Diogo Subtil',1,'Saida','Teste',-2000.00,'2022-06-02'),(49,NULL,119,'Diogo Subtil',1,'Entrada','Venda',500.00,'2022-06-02'),(50,NULL,120,'Diogo Subtil',1,'Entrada','Venda',1000.00,'2022-06-02'),(51,NULL,121,'Diogo Subtil',1,'Entrada','Venda',1500.00,'2022-06-02'),(52,NULL,122,'Diogo Subtil',1,'Entrada','Venda',500.00,'2022-06-02'),(53,NULL,123,'Diogo Subtil',1,'Entrada','Venda',1000.00,'2022-06-02'),(54,NULL,124,'Diogo Subtil',1,'Entrada','Venda',500.00,'2022-06-02'),(55,NULL,125,'Diogo Subtil',1,'Entrada','Venda',500.00,'2022-06-02');
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` VALUES (63,'CAPA CASE','capa','Teste',250.00,'6',500.00,1,3000,'2022-05-31');
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
INSERT INTO `ordemdeservico` VALUES (2,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-03-31'),(3,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-04-01'),(4,'diogo','Milena','Sansumg','S21','R43HR73489YH2','Sem defeitos','Troca de tela',250.00,'2022-04-01');
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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicos`
--

LOCK TABLES `servicos` WRITE;
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
INSERT INTO `servicos` VALUES (95,'Diogo Subtil','Diogo','D','Troca de tela',100.00,250.00,'2022-05-31',1),(96,'Diogo Subtil','Milena','D','Troca de tela',250.00,500.00,'2022-04-14',1),(97,'Alysson Paiva','Milena','D','Troca de tela',250.00,2500.00,'2022-06-01',1);
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
INSERT INTO `unidades` VALUES (1,'80010-130','Centro','Curitiba','PR','(41) 99983-6534','2021-11-10','100000',1,'Av. Mal. Floriano Peixoto','781','America/Parana','s','2022-05-30 00:00:00','2022-05-27 14:05:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'1','Diogo Subtil','diogosubtil20@gmail.com','diogo','$2y$10$ckWOvqZFHbkXnlZ457YaB.NvBuO3Oc8IPlPJDsc3GvyBrfeDHmKXe','41995507801','1','n','s','2022-05-18 21:10:38','2022-05-28 02:07:54'),(43,'1','Teste teste','teste@gmail.com','teste','$2y$10$ha3eQWP/T9L.0ssy8SBC8uRSktUtYewRrtJTxPy3PlmBedzvl79nq','41995507801','1','n','n','2022-05-27 15:30:04','2022-05-27 13:57:16'),(44,'1','Rooana Subtil','rosubtil@gmail.com','rooana','$2y$10$yaEcZ2c.6dkrgeS9MMcHBeoaKT6i7/d4cVErubXafVJuphNDWcEmS','41997151973','1','n','s','2022-06-02 23:40:17','2022-06-02 21:40:17');
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
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` VALUES (116,'Diogo Subtil','Milena','D',63,1,'1',500.00,500.00,'2022-05-31'),(117,'Diogo Subtil','Milena','D',63,1,'2',500.00,1000.00,'2022-04-13'),(119,'Diogo Subtil','Diogo','D',63,1,'1',500.00,500.00,'2022-06-02'),(120,'Diogo Subtil','Diogo','D',63,1,'2',500.00,1000.00,'2022-06-02'),(121,'Diogo Subtil','Milena','CC',63,1,'3',500.00,1500.00,'2022-06-02'),(122,'Diogo Subtil','Milena','D',63,1,'1',500.00,500.00,'2022-06-02'),(123,'Diogo Subtil','Diogo','CD',63,1,'2',500.00,1000.00,'2022-06-02'),(124,'Diogo Subtil','Milena','TB',63,1,'1',500.00,500.00,'2022-06-02'),(125,'Diogo Subtil','Diogo','Pix',63,1,'1',500.00,500.00,'2022-06-02');
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

-- Dump completed on 2022-06-02 19:12:51
