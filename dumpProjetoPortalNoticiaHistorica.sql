-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: portalnoticias_bd
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noticia_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `noticia_id` (`noticia_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`noticia_id`) REFERENCES `noticias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionarios`
--

DROP TABLE IF EXISTS `funcionarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `sexo` enum('M','F','Outro') DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `estado_civil` varchar(50) DEFAULT NULL,
  `raca_cor` varchar(50) DEFAULT NULL,
  `escolaridade` varchar(100) DEFAULT NULL,
  `nacionalidade` varchar(50) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionarios`
--

LOCK TABLES `funcionarios` WRITE;
/*!40000 ALTER TABLE `funcionarios` DISABLE KEYS */;
INSERT INTO `funcionarios` VALUES (5,26,'teste','teste','2000-02-21','235324325235','M','51999999999','teste@gmail.com','rua ','solteiro','branco','completa','','432423423432',NULL);
/*!40000 ALTER TABLE `funcionarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticias`
--

DROP TABLE IF EXISTS `noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `noticia` text NOT NULL,
  `data` datetime DEFAULT NULL,
  `autor` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticias`
--

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` VALUES (6,'Descoberta HistÃ³rica: O Primeiro FÃ³ssil de Dinossauro Identificado','Londres, 1824 â€” Em um marco histÃ³rico para a ciÃªncia, o geÃ³logo e paleontÃ³logo britÃ¢nico William Buckland anunciou, em janeiro de 1824, a primeira descriÃ§Ã£o cientÃ­fica de um dinossauro, que recebeu o nome de Megalosaurus, o \"lagarto gigante\".\r\n\r\nA descoberta representa um divisor de Ã¡guas para os estudos da vida prÃ©-histÃ³rica, sendo o primeiro registro reconhecido oficialmente de um dinossauro pela comunidade cientÃ­fica. Buckland apresentou seu estudo Ã  Sociedade GeolÃ³gica de Londres, baseando-se em fÃ³sseis encontrados na regiÃ£o de Oxfordshire, no sul da Inglaterra.\r\n\r\nSegundo o relatÃ³rio de Buckland, os fÃ³sseis incluÃ­am partes de uma mandÃ­bula com dentes afiados, fragmentos de vÃ©rtebras e outros ossos do esqueleto. Pela anÃ¡lise do tamanho e formato dos restos mortais, Buckland concluiu que o animal era um enorme rÃ©ptil terrestre, atÃ© entÃ£o sem equivalente conhecido.\r\n\r\nâ€œEra evidente que se tratava de um animal carnÃ­voro gigantesco, com dentes preparados para cortar carne, diferente de qualquer criatura vivaâ€, afirmou Buckland em sua publicaÃ§Ã£o.\r\n\r\nNa Ã©poca, o termo \"dinossauro\" ainda nÃ£o existia. Ele sÃ³ seria cunhado quase duas dÃ©cadas depois, em 1842, pelo tambÃ©m cientista britÃ¢nico Richard Owen, para agrupar criaturas prÃ©-histÃ³ricas como o Megalosaurus, o Iguanodon e o Hylaeosaurus, com base em caracterÃ­sticas Ã³sseas comuns.\r\n\r\nRevoluÃ§Ã£o CientÃ­fica\r\nA descriÃ§Ã£o do Megalosaurus foi o ponto de partida para a paleontologia moderna e inspirou uma nova geraÃ§Ã£o de cientistas a estudar os fÃ³sseis de animais extintos. Com o passar do tempo, novas espÃ©cies de dinossauros seriam descobertas em vÃ¡rias partes do mundo, mudando para sempre o entendimento da histÃ³ria da Terra.\r\n\r\nO Megalosaurus viveu hÃ¡ cerca de 166 milhÃµes de anos, durante o perÃ­odo JurÃ¡ssico MÃ©dio, e estima-se que media entre 7 a 9 metros de comprimento. Era um predador bÃ­pede que ocupava o topo da cadeia alimentar em seu ecossistema.\r\n\r\nLegado\r\nAtualmente, o Megalosaurus Ã© amplamente reconhecido como o primeiro dinossauro nomeado e descrito pela ciÃªncia, e seu esqueleto Ã© uma peÃ§a central em museus de histÃ³ria natural, como o de Oxford.\r\n\r\nA descoberta de Buckland nÃ£o apenas revelou a existÃªncia de criaturas gigantescas que habitaram a Terra muito antes dos humanos, como tambÃ©m ajudou a consolidar a geologia, a biologia evolutiva e a paleontologia como ciÃªncias fundamentais para entender o passado do planeta.','2025-06-25 19:06:03',25,'https://ichef.bbci.co.uk/ace/ws/640/cpsprodpb/11EFE/production/_101907437_2482_tp_00001r_preview.jpg.webp'),(8,'Curiosidade HistÃ³rica: Queijo Mais Antigo do Mundo Ã© Encontrado em Tumba EgÃ­pcia','<p data-start=\"164\" data-end=\"360\">Egito</p>\r\n<p data-start=\"164\" data-end=\"360\">Saqqara, Egito &ndash; 2018 &mdash; Arque&oacute;logos eg&iacute;pcios anunciaram a descoberta do queijo mais antigo do mundo, com mais de 3.200 anos, durante escava&ccedil;&otilde;es em uma tumba da regi&atilde;o de Saqqara, pr&oacute;ximo ao Cairo.</p>\r\n<p data-start=\"362\" data-end=\"662\">O alimento fossilizado foi encontrado dentro de um jarro selado na tumba de Ptahmes, um alto funcion&aacute;rio eg&iacute;pcio da 19&ordf; dinastia. Ap&oacute;s an&aacute;lises qu&iacute;micas feitas por cientistas italianos, foi confirmado que o conte&uacute;do era uma mistura de leite de ovelha e cabra &mdash; provavelmente um tipo de queijo branco.</p>\r\n<p data-start=\"664\" data-end=\"895\">Al&eacute;m de impressionar pelo tempo de conserva&ccedil;&atilde;o, os pesquisadores encontraram sinais de bact&eacute;rias perigosas no queijo, possivelmente causadoras da brucelose, uma doen&ccedil;a infecciosa transmitida pelo consumo de latic&iacute;nios contaminados.</p>\r\n<p data-start=\"897\" data-end=\"1071\">A descoberta fornece n&atilde;o s&oacute; uma janela rara sobre os h&aacute;bitos alimentares do Antigo Egito, mas tamb&eacute;m mostra como pr&aacute;ticas de conserva&ccedil;&atilde;o de alimentos j&aacute; existiam h&aacute; mil&ecirc;nios.</p>\r\n<hr data-start=\"1073\" data-end=\"1076\">\r\n<h3 data-start=\"1078\" data-end=\"1151\">Fato Hist&oacute;rico: O Assassinato de J&uacute;lio C&eacute;sar &mdash; 15 de Mar&ccedil;o de 44 a.C.</h3>\r\n<p data-start=\"1153\" data-end=\"1402\">Roma, Rep&uacute;blica Romana &ndash; 44 a.C. &mdash; No dia 15 de mar&ccedil;o, conhecido como os &ldquo;Idos de Mar&ccedil;o&rdquo;, o general e pol&iacute;tico romano J&uacute;lio C&eacute;sar foi assassinado por um grupo de senadores em pleno Senado de Roma, em um dos crimes pol&iacute;ticos mais famosos da hist&oacute;ria.</p>\r\n<p data-start=\"1404\" data-end=\"1653\">C&eacute;sar havia acumulado enorme poder ao ser nomeado ditador vital&iacute;cio, o que causou medo entre os senadores de que ele acabaria com a Rep&uacute;blica e se tornaria um rei. Liderados por Brutus e Cassius, cerca de 60 conspiradores apunhalaram C&eacute;sar 23 vezes.</p>\r\n<p data-start=\"1655\" data-end=\"1862\">Segundo o historiador romano Suet&ocirc;nio, as &uacute;ltimas palavras de C&eacute;sar teriam sido &ldquo;At&eacute; tu, Brutus?&rdquo;, ao ver seu filho adotivo entre os traidores &mdash; embora alguns estudiosos acreditem que ele morreu em sil&ecirc;ncio.</p>\r\n<p data-start=\"1864\" data-end=\"2064\">A morte de C&eacute;sar mergulhou Roma em uma nova guerra civil que, ironicamente, culminaria no fim da Rep&uacute;blica e na ascens&atilde;o do Imp&eacute;rio Romano, com seu herdeiro Otaviano (Augusto) como primeiro imperador.</p>','2025-06-25 21:31:19',25,'https://super.abril.com.br/wp-content/uploads/2018/08/queijoegito.png?resize=1080,565&crop=1'),(9,'Curiosidade HistÃ³rica: Quando Tomar Banho Era Malvisto na Europa','<p data-start=\"235\" data-end=\"489\"><strong data-start=\"235\" data-end=\"275\">Europa Medieval &ndash; S&eacute;culos XIV a XVII</strong> &mdash; Em tempos medievais e at&eacute; a Idade Moderna, <strong data-start=\"321\" data-end=\"363\">tomar banho era visto com desconfian&ccedil;a</strong> por boa parte da popula&ccedil;&atilde;o europeia. Acreditava-se que a &aacute;gua quente abria os poros do corpo e permitia a entrada de doen&ccedil;as.</p>\r\n<p data-start=\"491\" data-end=\"729\">Durante a Idade M&eacute;dia, os banhos p&uacute;blicos &mdash; populares nos tempos do Imp&eacute;rio Romano &mdash; foram sendo desativados, sobretudo ap&oacute;s surtos de peste e doen&ccedil;as contagiosas. Com o tempo, associar-se &agrave; &aacute;gua passou a ser perigoso aos olhos de muitos.</p>\r\n<p data-start=\"731\" data-end=\"963\">No s&eacute;culo XVII, era comum que <strong data-start=\"761\" data-end=\"821\">nobres trocassem apenas de roupa interior com frequ&ecirc;ncia</strong>, mas evitassem lavar o corpo. A rainha Isabel I da Inglaterra, por exemplo, teria afirmado que \"tomava banho uma vez por m&ecirc;s, queira ou n&atilde;o\".</p>\r\n<p data-start=\"965\" data-end=\"1182\">Curiosamente, o perfume ganhou grande popularidade nesse per&iacute;odo, servindo como disfarce para os odores do corpo. Os banhos s&oacute; voltariam a ser vistos como ben&eacute;ficos com o avan&ccedil;o da medicina e da higiene no s&eacute;culo XIX.</p>\r\n<hr data-start=\"1184\" data-end=\"1187\">\r\n<h3 data-start=\"1189\" data-end=\"1274\">ðŸ“œ <strong data-start=\"1196\" data-end=\"1274\">Fato Hist&oacute;rico: O Dia em que o Muro de Berlim Caiu &mdash; 9 de Novembro de 1989</strong></h3>\r\n<p data-start=\"1276\" data-end=\"1534\"><strong data-start=\"1276\" data-end=\"1303\">Berlim, Alemanha &ndash; 1989</strong> &mdash; Em um momento emocionante e inesperado, milhares de alem&atilde;es tomaram as ruas de Berlim em 9 de novembro de 1989, quando o infame <strong data-start=\"1434\" data-end=\"1452\">Muro de Berlim</strong>, s&iacute;mbolo da Guerra Fria, come&ccedil;ou a ser derrubado ap&oacute;s 28 anos dividindo a cidade.</p>\r\n<p data-start=\"1536\" data-end=\"1761\">Constru&iacute;do em 1961 pela Alemanha Oriental (comunista), o muro visava impedir a fuga de cidad&atilde;os para o lado ocidental (capitalista). Durante d&eacute;cadas, fam&iacute;lias foram separadas, e mais de 100 pessoas morreram tentando cruz&aacute;-lo.</p>\r\n<p data-start=\"1763\" data-end=\"2140\">A queda foi desencadeada por uma s&eacute;rie de protestos populares, crise econ&ocirc;mica no bloco sovi&eacute;tico e reformas iniciadas por Mikhail Gorbachev, l&iacute;der da Uni&atilde;o Sovi&eacute;tica. Uma declara&ccedil;&atilde;o confusa de um porta-voz do governo da Alemanha Oriental &mdash; afirmando que as fronteiras estavam abertas &mdash; levou multid&otilde;es aos postos de controle, onde guardas acabaram permitindo a passagem livre.</p>\r\n<p data-start=\"2142\" data-end=\"2345\">Pessoas subiram no muro, choraram, se abra&ccedil;aram e come&ccedil;aram a derrub&aacute;-lo com marretas. O mundo inteiro assistiu ao vivo a uma nova era nascendo: <strong data-start=\"2287\" data-end=\"2344\">o fim da Guerra Fria e o in&iacute;cio da reunifica&ccedil;&atilde;o alem&atilde;</strong>.</p>','2025-06-25 21:34:39',25,'https://jornalnota.com.br/wp-content/uploads/2021/10/banho-capa2_widelg-1.png'),(10,'A â€œMaldiÃ§Ã£oâ€ de TutancÃ¢mon: MistÃ©rio HistÃ³rico Intriga o Mundo Desde 1922','<p data-start=\"215\" data-end=\"483\"><strong data-start=\"215\" data-end=\"238\">Luxor, Egito &ndash; 1922</strong> &mdash; A descoberta da tumba do fara&oacute; Tutanc&acirc;mon, no Vale dos Reis, marcou um dos maiores achados arqueol&oacute;gicos da hist&oacute;ria. No entanto, al&eacute;m de tesouros milenares, o t&uacute;mulo revelou um enigma que persiste at&eacute; hoje: a suposta <strong data-start=\"459\" data-end=\"482\">\"maldi&ccedil;&atilde;o do fara&oacute;\"</strong>.</p>\r\n<p data-start=\"485\" data-end=\"849\">O arque&oacute;logo brit&acirc;nico <strong data-start=\"508\" data-end=\"525\">Howard Carter</strong> liderava a equipe que, em 4 de novembro de 1922, encontrou a entrada do t&uacute;mulo quase intacto do jovem fara&oacute;, que governou o Egito h&aacute; mais de 3.000 anos. Pouco tempo depois da abertura da tumba, o patrocinador da expedi&ccedil;&atilde;o, <strong data-start=\"749\" data-end=\"767\">Lord Carnarvon</strong>, morreu misteriosamente devido a uma infec&ccedil;&atilde;o causada por uma picada de mosquito.</p>\r\n<p data-start=\"851\" data-end=\"1110\">A partir da&iacute;, surgiram rumores de que todos os envolvidos na escava&ccedil;&atilde;o estariam amaldi&ccedil;oados. Outros membros da equipe tamb&eacute;m morreram nos anos seguintes, muitas vezes em circunst&acirc;ncias consideradas estranhas, o que alimentou o mito da maldi&ccedil;&atilde;o de Tutanc&acirc;mon.</p>\r\n<h3 data-start=\"1112\" data-end=\"1141\">Coincid&ecirc;ncia ou Maldi&ccedil;&atilde;o?</h3>\r\n<p data-start=\"1143\" data-end=\"1243\">Na entrada do t&uacute;mulo, havia uma inscri&ccedil;&atilde;o (em hier&oacute;glifos) que muitos interpretaram como um aviso:</p>\r\n<blockquote data-start=\"1244\" data-end=\"1324\">\r\n<p data-start=\"1246\" data-end=\"1324\">&ldquo;A morte vir&aacute; com asas velozes para aquele que perturbar o descanso do fara&oacute;.&rdquo;</p>\r\n</blockquote>\r\n<p data-start=\"1326\" data-end=\"1558\">Embora muitos cientistas considerem os relatos exagerados ou atribu&iacute;dos ao acaso, a hist&oacute;ria se espalhou rapidamente pelos jornais da &eacute;poca e capturou a imagina&ccedil;&atilde;o popular, tornando-se parte do folclore moderno sobre o Antigo Egito.</p>\r\n<h3 data-start=\"1560\" data-end=\"1584\">O Que Diz a Ci&ecirc;ncia?</h3>\r\n<p data-start=\"1586\" data-end=\"1884\">Pesquisas mais recentes sugerem que a &ldquo;maldi&ccedil;&atilde;o&rdquo; pode ter explica&ccedil;&otilde;es naturais. Alguns estudiosos apontam que fungos t&oacute;xicos encontrados nas tumbas fechadas por s&eacute;culos poderiam ter afetado a sa&uacute;de de quem as abriu. Outros dizem que a maioria dos envolvidos viveu por muitos anos ap&oacute;s a descoberta.</p>\r\n<h3 data-start=\"1886\" data-end=\"1896\">Legado</h3>\r\n<p data-start=\"1898\" data-end=\"2211\">A tumba de Tutanc&acirc;mon revelou mais de 5.000 artefatos preciosos, incluindo a famosa <strong data-start=\"1982\" data-end=\"2010\">m&aacute;scara dourada do fara&oacute;</strong>, que se tornou um &iacute;cone da arqueologia mundial. At&eacute; hoje, Tutanc&acirc;mon permanece um dos fara&oacute;s mais conhecidos, n&atilde;o por seu reinado, mas pelo mist&eacute;rio e fasc&iacute;nio que cercam sua morte &mdash; e sua &ldquo;maldi&ccedil;&atilde;o&rdquo;.</p>','2025-06-25 21:36:25',26,'https://santhatela.com.br/wp-content/uploads/2019/07/van-eyck-adoracao-ao-cordeiro-mistico-d.jpg'),(11,'A RevoluÃ§Ã£o Francesa e a Queda da Bastilha â€” 14 de Julho de 1789','<p data-start=\"168\" data-end=\"461\">Paris, Fran&ccedil;a &ndash; 1789 &mdash; No dia 14 de julho de 1789, a tomada da <strong data-start=\"231\" data-end=\"243\">Bastilha</strong>, uma antiga pris&atilde;o s&iacute;mbolo do poder absolutista da monarquia francesa, marcou o in&iacute;cio da Revolu&ccedil;&atilde;o Francesa. Milhares de parisienses revoltados se reuniram para derrubar o que representava a opress&atilde;o do rei Lu&iacute;s XVI.</p>\r\n<p data-start=\"463\" data-end=\"697\">A queda da Bastilha n&atilde;o foi apenas um ato simb&oacute;lico: foi o estopim para uma s&eacute;rie de mudan&ccedil;as radicais na Fran&ccedil;a, incluindo o fim do regime mon&aacute;rquico, a Declara&ccedil;&atilde;o dos Direitos do Homem e do Cidad&atilde;o, e o estabelecimento da Rep&uacute;blica.</p>\r\n<p data-start=\"699\" data-end=\"844\">A Revolu&ccedil;&atilde;o tamb&eacute;m inspirou movimentos democr&aacute;ticos em todo o mundo, mesmo diante do per&iacute;odo turbulento de guerras e instabilidade que se seguiu.</p>\r\n<hr data-start=\"846\" data-end=\"849\">\r\n<h3 data-start=\"851\" data-end=\"916\">Fato Hist&oacute;rico: O Primeiro Homem na Lua &mdash; 20 de Julho de 1969</h3>\r\n<p data-start=\"918\" data-end=\"1134\">Lua &ndash; 1969 &mdash; Em uma das maiores conquistas da hist&oacute;ria da humanidade, o astronauta americano <strong data-start=\"1011\" data-end=\"1029\">Neil Armstrong</strong> pisou pela primeira vez na superf&iacute;cie da Lua em 20 de julho de 1969, durante a miss&atilde;o Apollo 11 da NASA.</p>\r\n<p data-start=\"1136\" data-end=\"1445\">Ao descer do m&oacute;dulo lunar, Armstrong proferiu a famosa frase: &ldquo;&Eacute; um pequeno passo para o homem, um salto gigantesco para a humanidade.&rdquo; A miss&atilde;o simbolizou a vit&oacute;ria dos Estados Unidos na Corrida Espacial contra a Uni&atilde;o Sovi&eacute;tica e abriu caminho para avan&ccedil;os cient&iacute;ficos e tecnol&oacute;gicos na explora&ccedil;&atilde;o espacial.</p>\r\n<p data-start=\"1447\" data-end=\"1610\">Os astronautas Neil Armstrong, Buzz Aldrin e Michael Collins foram celebrados mundialmente, e a miss&atilde;o permanece como um marco na hist&oacute;ria da explora&ccedil;&atilde;o do espa&ccedil;o.</p>','2025-06-25 21:37:33',26,'https://static.historiadomundo.com.br/2024/05/a-queda-da-bastilha-retratada-em-pintura-de-1791.jpg');
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `sexo` char(1) NOT NULL,
  `fone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `chave_recuperar_senha` varchar(255) DEFAULT NULL,
  `codigo_autenticacao` varchar(20) DEFAULT NULL,
  `data_codigo_autenticacao` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (7,'Priscila','F','51999999998','priscila@gmail.com','$2y$10$qLsRtA1OBXE7bU6gf3N/2u0y.8Cgg3redt/zWWA2iwOJy051O.yzS',NULL,NULL,NULL,1,NULL),(25,'Gabriel Costa Bock','M','51999999999','gabrielcostabock@gmail.com','$2y$10$RFuc3ofuLkPQV3G/T9Fe.ObvHtGqa8n8gT3.Cv/PMHaD/tPC6Fg3S',NULL,'n8hct9a2gl',NULL,1,'uploads/685c9cb67b611.png'),(26,'teste','','','teste@gmail.com','$2y$10$PL4Dht64sakgsWgus4TL6u72kCej/a2T/.aQV/eoDtM6oalvYm8iu',NULL,NULL,NULL,0,NULL),(27,'leon','M','51999999999','leon@gmail.com','$2y$10$Gjfl5LiPMwXf55ZJZCSGF.iAACqjFF1Ah3cLVUKXsMzBPp4/GCg2m',NULL,NULL,NULL,0,NULL),(31,'leon','M','51999999999','leon2@gmail.com','$2y$10$YKROi8wcjiX4/zbld1TUS.Q5nlG6e.pOQSl3t4l/n.C0CoQLvWqUK',NULL,NULL,NULL,0,NULL),(32,'fgfgfdg','M','51999999999','afdafa@gmail.com','$2y$10$KAbyGnvzO8ale7hCEtS.fORCbs9i0odSCa0U2wWbq01kpq.laNf26',NULL,NULL,NULL,0,NULL),(34,'fgfgfdgsds','M','51999999999','afsdafa@gmail.com','$2y$10$rFS2JJv82iUl1I1VKnIH2.ttmex.c8z6WU00U4DWVTbUFbFiFRI7.',NULL,NULL,NULL,0,NULL),(35,'fgfgfdgdsds','M','51999999999','afsddafa@gmail.com','$2y$10$nHAgMmRS8b4cTx/zGoBxKuXv8dzqnfR/ORqNvL51K.5fZW6vKgs7W',NULL,NULL,NULL,0,NULL),(36,'fgfgfdgddsds','M','51999999999','afssddafa@gmail.com','$2y$10$Q14sOBKzFN54dsTrUU9oq.F8KNFDx.v2mmgO5JXZLjpcKelZ3A4P6',NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'portalnoticias_bd'
--

--
-- Dumping routines for database 'portalnoticias_bd'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-25 23:15:49
