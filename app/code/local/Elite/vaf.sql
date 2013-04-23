SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `magento`
--

-- --------------------------------------------------------

--
-- Table structure for table `elite_1_definition`
--

CREATE TABLE IF NOT EXISTS `elite_1_definition` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `make_id` int(15) NOT NULL,
  `model_id` int(15) NOT NULL,
  `year_id` int(15) NOT NULL,
  `service_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `make_id_2` (`make_id`,`model_id`,`year_id`),
  KEY `make_id` (`make_id`),
  KEY `model_id` (`model_id`),
  KEY `year_id` (`year_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_1_mapping`
--

CREATE TABLE IF NOT EXISTS `elite_1_mapping` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `make_id` int(15) NOT NULL,
  `model_id` int(15) NOT NULL,
  `year_id` int(15) NOT NULL,
  `entity_id` int(25) NOT NULL,
  `universal` int(1) NOT NULL COMMENT 'if there is a row with this flag set for a product ( entity_id ) then it should be returned universally for all vehicles',
  `related` int(1) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `make_id_2` (`make_id`,`model_id`,`year_id`,`universal`,`entity_id`),
  KEY `universal` (`universal`),
  KEY `make_id` (`make_id`),
  KEY `model_id` (`model_id`),
  KEY `year_id` (`year_id`),
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_definition_wheel`
--

CREATE TABLE IF NOT EXISTS `elite_definition_wheel` (
  `leaf_id` int(50) NOT NULL,
  `lug_count` int(1) NOT NULL,
  `bolt_distance` decimal(4,1) NOT NULL COMMENT 'bolt distance in mm',
  `offset` float NOT NULL,
  PRIMARY KEY (`leaf_id`,`lug_count`,`bolt_distance`),
  KEY `leaf_id` (`leaf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elite_import`
--

CREATE TABLE IF NOT EXISTS `elite_import` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `make` varchar(255) NOT NULL,
  `make_id` int(50) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(50) NOT NULL,
  `year` varchar(255) NOT NULL,
  `year_id` int(50) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `universal` int(1) DEFAULT '0',
  `existing` int(1) NOT NULL,
  `line` int(255) NOT NULL,
  `mapping_id` int(255) NOT NULL,
  `note_message` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `service_code` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_level_1_make`
--

CREATE TABLE IF NOT EXISTS `elite_level_1_make` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_level_1_model`
--

CREATE TABLE IF NOT EXISTS `elite_level_1_model` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_level_1_year`
--

CREATE TABLE IF NOT EXISTS `elite_level_1_year` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_mapping_notes`
--

CREATE TABLE IF NOT EXISTS `elite_mapping_notes` (
  `fit_id` int(50) NOT NULL,
  `note_id` varchar(50) NOT NULL,
  PRIMARY KEY (`fit_id`,`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elite_mapping_paint`
--

CREATE TABLE IF NOT EXISTS `elite_mapping_paint` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `mapping_id` int(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mapping_id` (`mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_note`
--

CREATE TABLE IF NOT EXISTS `elite_note` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `elite_product_servicecode`
--

CREATE TABLE IF NOT EXISTS `elite_product_servicecode` (
  `product_id` int(100) NOT NULL,
  `service_code` varchar(100) NOT NULL,
  `category1_id` int(10) NOT NULL,
  `category2_id` int(10) NOT NULL,
  `category3_id` int(10) NOT NULL,
  `category4_id` int(10) NOT NULL,
  `illustration_id` varchar(10) NOT NULL DEFAULT '',
  `callout` int(3) NOT NULL,
  PRIMARY KEY (`product_id`,`service_code`,`category1_id`,`category2_id`,`category3_id`,`category4_id`,`illustration_id`,`callout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elite_product_tire`
--

CREATE TABLE IF NOT EXISTS `elite_product_tire` (
  `entity_id` int(50) NOT NULL,
  `section_width` int(3) NOT NULL,
  `aspect_ratio` int(3) NOT NULL,
  `diameter` int(3) NOT NULL,
  `tire_type` int(1) NOT NULL,
  UNIQUE KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elite_product_wheel`
--

CREATE TABLE IF NOT EXISTS `elite_product_wheel` (
  `entity_id` int(50) NOT NULL,
  `lug_count` int(1) NOT NULL,
  `bolt_distance` decimal(4,1) NOT NULL COMMENT 'bolt distance in mm',
  `offset` float NOT NULL,
  PRIMARY KEY (`entity_id`,`lug_count`,`bolt_distance`),
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elite_product_wheeladapter`
--

CREATE TABLE IF NOT EXISTS `elite_product_wheeladapter` (
  `entity_id` int(50) NOT NULL,
  `lug_count` int(1) NOT NULL,
  `bolt_distance` decimal(4,1) NOT NULL COMMENT 'bolt distance in mm',
  PRIMARY KEY (`entity_id`,`lug_count`,`bolt_distance`),
  KEY `entity_id` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `elite_schema`
--

CREATE TABLE IF NOT EXISTS `elite_schema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(25) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `elite_schema`
--

INSERT INTO `elite_schema` (`id`, `key`, `value`) VALUES
(1, 'levels', 'make,model,year'),
(2, 'make_global', '1');

-- --------------------------------------------------------

--
-- Table structure for table `elite_vehicle_tire`
--

CREATE TABLE IF NOT EXISTS `elite_vehicle_tire` (
  `leaf_id` int(50) NOT NULL,
  `section_width` int(3) NOT NULL,
  `aspect_ratio` int(3) NOT NULL,
  `diameter` int(3) NOT NULL,
  `tire_type` int(1) NOT NULL,
  UNIQUE KEY `leaf_id` (`leaf_id`,`section_width`,`aspect_ratio`,`diameter`,`tire_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `elite_version`
--

CREATE TABLE IF NOT EXISTS `elite_version` (
  `version` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `elite_version`
--

INSERT INTO `elite_version` (`version`) VALUES
(26);