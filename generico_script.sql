-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.7.19 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para generico
DROP DATABASE IF EXISTS `generico`;
CREATE DATABASE IF NOT EXISTS `generico` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `generico`;

-- Copiando estrutura para tabela generico.tab_activity
CREATE TABLE IF NOT EXISTS `tab_activity` (
  `cd_activity` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_activity` varchar(255) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_activity`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_activity: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_activity` DISABLE KEYS */;
INSERT INTO `tab_activity` (`cd_activity`, `ds_activity`, `dt_register`, `dt_updated`) VALUES
	(1, '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_activity` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_adress
CREATE TABLE IF NOT EXISTS `tab_adress` (
  `cd_adress` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_adress` varchar(60) DEFAULT NULL,
  `ds_city` varchar(50) DEFAULT NULL,
  `cd_uf` varchar(30) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_adress`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_adress: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_adress` DISABLE KEYS */;
INSERT INTO `tab_adress` (`cd_adress`, `ds_adress`, `ds_city`, `cd_uf`, `dt_register`, `dt_updated`) VALUES
	(1, '', '', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_adress` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_card
CREATE TABLE IF NOT EXISTS `tab_card` (
  `cd_card` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_title` varchar(50) DEFAULT NULL,
  `ds_content` text,
  `img_front_card` varchar(50) DEFAULT NULL,
  `img_card` varchar(50) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_card`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_card: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_card` DISABLE KEYS */;
INSERT INTO `tab_card` (`cd_card`, `ds_title`, `ds_content`, `img_front_card`, `img_card`, `dt_register`, `dt_updated`) VALUES
	(1, 'Título do Card ', 'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.', '', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46'),
	(2, 'Título do Card ', 'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.', '', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46'),
	(3, 'Título do Card ', 'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.', '', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_card` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_code
CREATE TABLE IF NOT EXISTS `tab_code` (
  `cd_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lnk_script` text,
  `id_app` varchar(20) DEFAULT NULL,
  `secret_app` varchar(32) DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_code: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_code` DISABLE KEYS */;
INSERT INTO `tab_code` (`cd_code`, `lnk_script`, `id_app`, `secret_app`, `dt_updated`) VALUES
	(1, '<div id=\'fb-root\'></div> <script>(function(d, s, id) {   var js, fjs = d.getElementsByTagName(s)[0];   if (d.getElementById(id)) return;   js = d.createElement(s); js.id = id;   js.src = \'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2\';   fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script>', NULL, NULL, '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_code` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_config
CREATE TABLE IF NOT EXISTS `tab_config` (
  `cd_config` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `st_contact` tinyint(1) DEFAULT NULL,
  `st_service` tinyint(1) DEFAULT NULL,
  `st_product` tinyint(1) DEFAULT NULL,
  `st_promotion` tinyint(1) DEFAULT NULL,
  `st_adress` tinyint(1) DEFAULT NULL,
  `st_activity` tinyint(1) DEFAULT NULL,
  `st_comment` tinyint(1) DEFAULT NULL,
  `st_fbpage` tinyint(1) DEFAULT NULL,
  `st_map` tinyint(1) DEFAULT NULL,
  `st_document` tinyint(1) DEFAULT NULL,
  `st_card` tinyint(1) DEFAULT NULL,
  `st_post` tinyint(1) DEFAULT NULL,
  `sp_relevance` int(11) DEFAULT NULL,
  `sp_amount` int(11) DEFAULT NULL,
  `ss_relevance` int(11) DEFAULT NULL,
  `ss_amount` int(11) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_config`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_config: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_config` DISABLE KEYS */;
INSERT INTO `tab_config` (`cd_config`, `st_contact`, `st_service`, `st_product`, `st_promotion`, `st_adress`, `st_activity`, `st_comment`, `st_fbpage`, `st_map`, `st_document`, `st_card`, `st_post`, `sp_relevance`, `sp_amount`, `ss_relevance`, `ss_amount`, `dt_register`, `dt_updated`) VALUES
	(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 10, 1, 10, '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_config` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_content
CREATE TABLE IF NOT EXISTS `tab_content` (
  `cd_info` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nm_company` varchar(60) DEFAULT NULL,
  `ds_presentation` text,
  `ds_email` varchar(60) DEFAULT NULL,
  `ds_document` varchar(18) DEFAULT NULL,
  `cd_phone_1` varchar(20) DEFAULT NULL,
  `cd_phone_2` varchar(20) DEFAULT NULL,
  `ds_text_footer` varchar(255) DEFAULT NULL,
  `lnk_map` text,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_info`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_content: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_content` DISABLE KEYS */;
INSERT INTO `tab_content` (`cd_info`, `nm_company`, `ds_presentation`, `ds_email`, `ds_document`, `cd_phone_1`, `cd_phone_2`, `ds_text_footer`, `lnk_map`, `dt_register`, `dt_updated`) VALUES
	(1, 'Empresa', 'Coloque aqui uma descrição breve sobre o negócio/empresa, seu ramo de atividade, seus produtos ou serviços, seus objetivos, o foco, os diferenciais ou o que tem a oferecer de bom para o mundo. Também é interessante conter um pouco da história da empresa no mercado ou algo que convide o consumidor a conhecer mais sobre o negocio ou entrar em contato. Palavras chaves e frases de impacto também são super bem vindas e por fim, insira uma imagem a seu gosto para ilustrar sua apresentação ou remova a imagem padrão welcome e deixe so o texto, é por sua conta. Seja criativo e Boa divulgação!.', 'empresa@contato.com', '00.000.000/0001-12', '0000000000', '0000000000', 'Texto que fica exposto no rodapé, também pode conter o slogan da empresa, um convite ou agradecimento.', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_content` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_cupom
CREATE TABLE IF NOT EXISTS `tab_cupom` (
  `cd_cpm` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_cupom` varchar(12) DEFAULT NULL,
  `ds_discount` int(11) DEFAULT NULL,
  `ds_type` varchar(2) DEFAULT NULL,
  `nm_customer` varchar(50) DEFAULT NULL,
  `dt_valid` datetime DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_cpm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_cupom: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_cupom` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_cupom` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_imagem
CREATE TABLE IF NOT EXISTS `tab_imagem` (
  `cd_img` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_header` varchar(50) DEFAULT NULL,
  `img_panel` varchar(50) DEFAULT NULL,
  `img_body` varchar(50) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_img`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_imagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_imagem` DISABLE KEYS */;
INSERT INTO `tab_imagem` (`cd_img`, `img_header`, `img_panel`, `img_body`, `dt_register`, `dt_updated`) VALUES
	(1, 'images/logo.png', 'images/panel.jpg', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_imagem` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_link
CREATE TABLE IF NOT EXISTS `tab_link` (
  `cd_link` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_link_face` varchar(120) DEFAULT NULL,
  `ds_link_twit` varchar(120) DEFAULT NULL,
  `ds_link_linked` varchar(120) DEFAULT NULL,
  `ds_link_insta` varchar(120) DEFAULT NULL,
  `ds_link_olx` varchar(120) DEFAULT NULL,
  `ds_link_market` varchar(120) DEFAULT NULL,
  `ds_link_ytb` varchar(120) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_link`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_link: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_link` DISABLE KEYS */;
INSERT INTO `tab_link` (`cd_link`, `ds_link_face`, `ds_link_twit`, `ds_link_linked`, `ds_link_insta`, `ds_link_olx`, `ds_link_market`, `ds_link_ytb`, `dt_register`, `dt_updated`) VALUES
	(1, 'https://www.facebook.com/', 'https://twitter.com/login?lang=pt', 'https://br.linkedin.com/', 'https://www.instagram.com/', '', '', '', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_link` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_log
CREATE TABLE IF NOT EXISTS `tab_log` (
  `cd_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dt_hour` datetime DEFAULT NULL,
  `cd_login` varchar(50) DEFAULT NULL,
  `ds_message` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`cd_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_log: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_log` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_post
CREATE TABLE IF NOT EXISTS `tab_post` (
  `cd_post` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_title` varchar(50) DEFAULT NULL,
  `ds_content` varchar(255) DEFAULT NULL,
  `nm_autor` varchar(30) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_post: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_post` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_product
CREATE TABLE IF NOT EXISTS `tab_product` (
  `cd_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_alternative_product` varchar(12) DEFAULT NULL,
  `nm_product` varchar(32) DEFAULT NULL,
  `ds_category` varchar(22) DEFAULT NULL,
  `vl_product` float DEFAULT NULL,
  `ds_description` text,
  `ds_unity` varchar(12) DEFAULT NULL,
  `st_promotion` tinyint(1) DEFAULT NULL,
  `img_product` varchar(50) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_product`),
  UNIQUE KEY `cd_alternative_product` (`cd_alternative_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_product: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_product` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_promotion
CREATE TABLE IF NOT EXISTS `tab_promotion` (
  `cd_promotion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ds_type` varchar(2) DEFAULT NULL,
  `ds_discount` int(11) DEFAULT NULL,
  `qt_days` int(11) DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_promotion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_promotion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_promotion` DISABLE KEYS */;
INSERT INTO `tab_promotion` (`cd_promotion`, `ds_type`, `ds_discount`, `qt_days`, `dt_updated`) VALUES
	(1, 'pc', 5, 7, '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_promotion` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_prospect
CREATE TABLE IF NOT EXISTS `tab_prospect` (
  `cd_prospect` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nm_prospect` varchar(50) DEFAULT NULL,
  `ds_email` varchar(50) DEFAULT NULL,
  `cd_phone` varchar(20) DEFAULT NULL,
  `ds_channel` varchar(120) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_prospect`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_prospect: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_prospect` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_prospect` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_service
CREATE TABLE IF NOT EXISTS `tab_service` (
  `cd_service` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_alternative_service` varchar(12) DEFAULT NULL,
  `nm_service` varchar(32) DEFAULT NULL,
  `vl_service` float DEFAULT NULL,
  `ds_description` text,
  `st_promotion` tinyint(1) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_service`),
  UNIQUE KEY `cd_alternative_service` (`cd_alternative_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_service: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_service` ENABLE KEYS */;

-- Copiando estrutura para tabela generico.tab_user
CREATE TABLE IF NOT EXISTS `tab_user` (
  `cd_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_login` varchar(50) DEFAULT NULL,
  `cd_password` varchar(32) DEFAULT NULL,
  `nm_user` varchar(50) DEFAULT NULL,
  `ds_email` varchar(50) DEFAULT NULL,
  `cd_permition` varchar(32) DEFAULT NULL,
  `dt_register` datetime DEFAULT NULL,
  `dt_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`cd_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela generico.tab_user: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tab_user` DISABLE KEYS */;
INSERT INTO `tab_user` (`cd_user`, `cd_login`, `cd_password`, `nm_user`, `ds_email`, `cd_permition`, `dt_register`, `dt_updated`) VALUES
	(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'rrcosta94@gmail.com', '11111111111111111111111111111111', '2019-03-19 22:31:46', '2019-03-19 22:31:46'),
	(2, 'Ana', '276b6c4692e78d4799c12ada515bc3e4', 'Ana Oliveira', 'ana.oliveira@gmail.com', '01111111111111111111111111111111', '2019-03-19 22:31:46', '2019-03-19 22:31:46');
/*!40000 ALTER TABLE `tab_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
