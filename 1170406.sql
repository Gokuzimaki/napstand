-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 03, 2016 at 09:15 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `napstannd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `parentheader` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `accesslevel` int(11) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `parentheader`, `fullname`, `accesslevel`, `status`) VALUES
(1, 'indeuc', 'gerrard', '', 'Okebukola Olagoke', 0, 'active'),
(3, 'testuseradmin', 'user2016', '', 'Napstand Test Admin', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `blogcategories`
--

CREATE TABLE IF NOT EXISTS `blogcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `rssname` varchar(255) NOT NULL,
  `subtext` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blogentries`
--

CREATE TABLE IF NOT EXISTS `blogentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `blogcatid` int(11) NOT NULL,
  `blogentrytype` varchar(255) NOT NULL,
  `betype` varchar(255) NOT NULL,
  `becode` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `introparagraph` text NOT NULL,
  `blogpost` text NOT NULL,
  `entrydate` varchar(255) NOT NULL,
  `modifydate` varchar(255) NOT NULL,
  `feeddate` varchar(255) NOT NULL,
  `views` int(11) NOT NULL,
  `coverphoto` int(11) NOT NULL,
  `coverphotoset` int(11) NOT NULL,
  `pagename` varchar(255) NOT NULL,
  `commentsonoff` int(11) NOT NULL,
  `featuredpost` varchar(3) NOT NULL DEFAULT 'no',
  `scheduledpost` varchar(4) NOT NULL DEFAULT 'no',
  `postperiod` datetime NOT NULL,
  `date` datetime NOT NULL COMMENT 'The date of this entry, for archive purposes',
  `tags` text NOT NULL,
  `seometakeywords` text NOT NULL,
  `posterid` int(11) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blogtype`
--

CREATE TABLE IF NOT EXISTS `blogtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `foldername` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rssname` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `capitalexpenditure`
--

CREATE TABLE IF NOT EXISTS `capitalexpenditure` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `subclass` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=303311 ;

--
-- Dumping data for table `capitalexpenditure`
--

INSERT INTO `capitalexpenditure` (`code`, `description`, `subclass`, `class`) VALUES
(30000, 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30001, 'Purchase of Motor Vehicles', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30002, 'Purchase of Ambulances', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30003, 'Purchase of Buses and Mass Transit', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30004, 'Purchase of Delivery Vans', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30005, 'Purchase of Truck and Tractors', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30006, 'Purchase of Towing Vans', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30007, 'Purchase of Tippers', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30008, 'Purchase of Tankers ', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30009, 'Purchase of Fire Fighting Vans', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30010, 'Purchase of Motor Cycles', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30099, 'Purchase of Other Transport equipment', 'PURCHASE OF TRANSPORT EQUIPMENT', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30100, 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30101, 'Purchase of Office Equipment', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30102, 'Purchase of Residential Equipment', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30103, 'Purchase of Industrial Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30104, 'Purchase of Agricultural Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30105, 'Purchase of Medical/Science/.Equipment', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30106, 'Purchase of Science/Lab Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30107, 'Purchase of Training Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30108, 'Purchase of Sporting Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30109, 'Purchase of Patrol and Security Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30110, 'Purchase of Fire Fighting Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30111, 'Purchase of Survey Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30112, 'Purchase of Sanitary Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30113, 'Purchase of Electrical Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30114, 'Purchase of Kitchen Utensils ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30115, 'Purchase of Spare Parts and Tools ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30116, 'Purchase of ICT Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30117, 'Purchase of Computers ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30118, 'Purchase of Generators ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30119, 'Public address system and information equipment', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30120, 'Purchase of Water Supply Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30121, 'Purchase of Road Construction Equipment ', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30122, 'Purchase of Heavy Duty Plant and Machine', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30199, 'Purchase of Other Machine and Equipment', 'PURCHASE OF EQUIPMENT GENERAL', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30200, 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30201, 'Purchase of office Furniture and Fittings', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30202, 'Purchase of Residential Furniture and Fittings ', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30203, 'Purchase of Hospital Furniture and Fittings', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30204, 'Purchase of School Furniture and Fittings ', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30205, 'Purchase of Hotels and Lodges Furniture  ', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30206, 'Purchase of Other Furniture and Fittings', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30207, 'Purchase/Acquisition of Land', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30208, 'Purchase/Acquisition of Building ', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30209, 'Cultivation of Farm Land', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30299, 'Purchase and Acquisition of Other Fixed Assets ', 'PURCHASE OF FURNITURE AND FITTINGS', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30300, 'CONSTRUCTIONS GENERAL ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30301, 'Construction of Office Building ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30302, 'Construction of Staff Quarters', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30303, 'Construction of Residential Building ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30304, 'Construction of Hotels and Lodges ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30305, 'Construction of Hospital Buildings ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30306, 'Construction of Medical/Health Centre', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30307, 'Construction of School Buildings ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30308, 'Construction of Educational Institution ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30309, 'Construction of Mosques and Islamiya', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(303310, 'Construction of Sporting Facilities', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30311, 'Construction of Halls and Theaters', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30312, 'Construction of Industrial Buildings', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30313, 'Construction of Workshop Buildings ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30314, 'Upgrading of PHC', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30399, 'Construction of other Buildings  ', 'CONSTRUCTIONS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30400, 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30401, 'Construction of Township Roads', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30402, 'Construction of State Roads', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30403, 'Construction of Federal High ways', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30404, 'Construction of Asphalt', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30405, 'Construction of Bridges', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30406, 'Construction of Drainages and Culverts', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30407, 'Construction of Irrigation and Dams', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30499, 'Construction of other Roads', 'CONSTRUCTION OF ROADS, BRIDGES AND DRAINAGES', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30500, 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30501, 'Construction of Infrastructures', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30502, 'Construction of Power Generating Plants', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30503, 'Construction of Power/Electricity Distribution ', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30504, 'Construction of Erection of Street Lights', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30505, 'Construction of Traffic Lights', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30506, 'Construction of Water Supply (Boreholes, Wells etc)', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30549, 'Construction of Other Infrastructure ', 'CONTRUCTION OF OTHER INFRASTRUCTURE', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30550, 'REHABILITATION, RENOVATION AND REPAIRS GENERAL ', 'REHABILITATION, RENOVATION AND REPAIRS GENERAL ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30551, 'Repairs of Motor Vehicle and Other Transport Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30552, 'Repairs of Office Equipment  ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30553, 'Repairs of Industrial Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30554, 'Repairs of Agricultural Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30555, 'Repairs of Medical and Laboratory Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30556, 'Repairs of Science Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30557, 'Repairs of Road Construction Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30558, 'Repairs of Water Supply Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30559, 'Repairs of Training Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30560, 'Repairs of Sporting Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30561, 'Repairs of Patrol and Security Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30562, 'Repairs of Fire Fighting Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30563, 'Repairs of Survey Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30564, 'Repairs of Sanitary Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30565, 'Repairs of ICT Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30566, 'Repairs of Computers Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30567, 'Repairs and Maint. of Generators ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30568, 'Repairs of Plant and Machines Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30569, 'Repairs of Power Generating Plants Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30570, 'Repairs of Electricity Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30571, 'Repairs of Street Lights ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30572, 'Repairs of Traffic Equipment ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30573, 'Rehabilitation and Maintenance of Water Supply', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30574, 'Rehabilitation/Renovation of Furniture and Fittings', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30575, 'Rehabilitation/Renovation of Office Building ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30576, 'Rehabilitation/Renovation of Staff Quarters', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30577, 'Rehabilitation/Renovation of Residential Building ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30578, 'Rehabilitation/Renovation of Hotels and Lodges', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30579, 'Rehabilitation/Renovation of Industrial', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30580, 'Rehabilitation/Renovation of Hospital', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30581, 'Rehabilitation/Renovation of School', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30582, 'Rehabilitation/Renovation of Sporting Facilities ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30583, 'Rehabilitation/Renovation of Mosques and Islamiya', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30584, 'Rehabilitation/Renovation of Halls and Threatres ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30585, 'Rehabilitation/Renovation of Workshop Building', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30586, 'Rehabilitation/Renovation of Other Buildings ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30587, 'Rehabilitation/Renovation of Township Roads', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30588, 'Rehabilitation/Renovation of State Roads', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30589, 'Rehabilitation/Renovation of Federal High Ways', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30590, 'Rehabilitation/Renovation of Bridges ', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30591, 'Rehabilitation/Renovation of Drainages and Culverts', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30592, 'Rehabilitation/Renovation of Dams and Irrigation', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30649, 'Other Rehabilitation/Renovation', 'Repairs of Motor Vehicle and Other Transport Equipment ', 'PURCHASE AND ACQUISITION OF FIXED ASSETS'),
(30650, 'Capital contributions', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30651, 'Subvention to boards and parastatals ', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30652, 'Grants ', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30653, 'Counterpart Funding ', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30654, 'Capitalization and Sustainability Funds', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30655, 'Contribution to Yobe Islamic centre', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30656, 'Contribution to National volunteer service', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30657, 'Korean Technical Funding', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30699, 'Other Contributions', 'Capital contributions', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30700, 'RESEARCH AND DEVELOPMENT ', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30701, 'Statistics, Research and Development ', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30702, 'Planning and Design ', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30703, 'Maps, Survey and Design ', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30704, 'Data Collection and Analysis', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30705, 'Feasibility & Consultancy Services', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30706, 'Solid Mineral Development ', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30707, 'Archives and Publications', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30708, 'Development strategies', 'RESEARCH AND DEVELOPMENT ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30750, 'PRESERVATION/CONSERVATION', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30751, 'Water Conservation', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30752, 'Soil Conservation ', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30753, 'Wildlife and Game Reserves', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30754, 'Wood lot and Shelter Belt', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30755, 'Landscape and Tree Planting ', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30756, 'Wetland Management and Protection ', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30757, 'Excavation and Preservation of Dufuna Canoe ', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30758, 'Dredging of River and Ponds', 'PRESERVATION/CONSERVATION', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30800, 'PROCUREMENT GENERAL ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30801, 'Procurement of Foodstuff and Feeds', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30802, 'Procurement of Grains', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30803, 'Procurement of Fertilizer', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30804, 'Procurement of Relief Materials ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30805, 'Procurement of Raw Materials ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30806, 'Procurement of Instructional and Working Materials', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30807, 'Procurement of Other Materials', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30808, 'Procurement of Drugs', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30809, 'Procurement of Vaccine', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30810, 'Procurement of Chemicals and Re-agent ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30811, 'Procurement of Seeds and Seedlings ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30812, 'Procurement of Uniforms and Other Clothing ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30813, 'Procurement of Kerosene Stove and Alternative Energy ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30899, 'Other Procurement ', 'PROCUREMENT GENERAL ', 'CAPITAL INVESTMENT ON NON FIXED ASSEST'),
(30900, 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30901, 'Production, Publication and Journals', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30902, 'Inspection and Monitoring  ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30903, 'Manpower Development and Training', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30904, 'License and Insurance Cover', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30905, 'Advocacy, Enlightenment and Campaign   ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30906, 'Festivals, Carnivals and Ceremonies ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30907, 'Committees and Commission ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30908, 'National Councils Meeting and Conferences ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30909, 'Printing of Documents', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30910, 'Task Force on Food and Drug Regulation Control ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30911, 'Sign Posts and Bill Boards ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30912, 'Competitions and Debates', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30913, 'Trade Fairs and Other Exhibitions', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30914, 'Support to Community Development ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30915, 'Contributions and Annual Fees', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30916, 'Production and Distribution ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30917, 'Summons and Prosecutions ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30918, 'Arbitration and Resolutions ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30919, 'Outfit Allowance ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30920, 'Election Activities ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30921, 'Environmental pollution control', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30922, 'Distil water control', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30923, 'Registration and Exam Fees', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30924, 'Tuition and School Fees', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30925, 'French/Kanuri Activities ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30926, 'Family Life and Health Education ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30927, 'Establishment of Orchards/Oases ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30928, 'Hide and Skin Management ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30929, 'Cattle Range Management ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30930, 'Quarantine and Animals loading', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30931, 'Cattle Production ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30932, 'Poultry Production ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30933, 'Sheep and Goat Production    ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30934, 'Fish Ponds and Production ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30935, 'Thereafter and Surgery   ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30936, 'Assistance to Destitute', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE '),
(30937, 'Repayment of loans ', 'MISCELLANEOUS CAPITAL EXPENDITURE ', 'MISCELLANEOUS CAPITAL EXPENDITURE ');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `businessname` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='For handling magazies and news paper entries' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `blogentryid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contentcategories`
--

CREATE TABLE IF NOT EXISTS `contentcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `contentcategories`
--

INSERT INTO `contentcategories` (`id`, `catname`, `description`, `status`) VALUES
(1, 'News Paper', 'News paper based content', 'active'),
(2, 'Blogazine', 'Bloggers collate their content into magazine content', 'active'),
(3, 'Comics', 'The richest Nigerian content available on the market', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `contententries`
--

CREATE TABLE IF NOT EXISTS `contententries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT 'The id for the user, 0 value means its a napstand admin entry',
  `catid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `releasedate` datetime NOT NULL,
  `price` float NOT NULL,
  `publishstatus` varchar(255) NOT NULL DEFAULT 'published' COMMENT 'the status of the entry, values are, published,dontpublish&scheduled',
  `scheduledate` datetime NOT NULL,
  `entrydate` datetime NOT NULL COMMENT 'The date the post was made',
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table for holding unified entry content details' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `contententries`
--

INSERT INTO `contententries` (`id`, `userid`, `catid`, `parentid`, `title`, `details`, `releasedate`, `price`, `publishstatus`, `scheduledate`, `entrydate`, `status`) VALUES
(1, 9, 2, 3, 'Episode 1', 'Welcome to heed magazine, a lovely place to learn more about the awesome opportunities around you.', '2016-06-21 01:38:46', 0, 'published', '0000-00-00 00:00:00', '2016-06-21 01:38:46', 'active'),
(2, 9, 2, 3, 'Heed Blogazine', 'Some text here', '2016-06-21 20:05:53', 3000, 'published', '0000-00-00 00:00:00', '2016-06-21 20:05:53', 'active'),
(3, 9, 2, 3, '', '', '2016-06-22 19:12:16', 900, 'published', '0000-00-00 00:00:00', '2016-06-22 18:29:03', 'active'),
(4, 9, 2, 3, '', '', '2016-06-22 20:12:12', 0, 'published', '0000-00-00 00:00:00', '2016-06-22 20:12:12', 'active'),
(5, 9, 2, 3, 'Titled doulou', '', '0000-00-00 00:00:00', 0, 'dontpublish', '0000-00-00 00:00:00', '2016-06-22 21:23:22', 'active'),
(6, 9, 2, 3, 'Schedule Test', '', '0000-00-00 00:00:00', 0, 'scheduled', '2016-06-23 08:00:00', '2016-06-22 22:58:51', 'active'),
(7, 9, 2, 3, '', '', '2016-06-23 22:31:03', 0, 'dontpublish', '0000-00-00 00:00:00', '2016-06-23 22:31:03', 'active'),
(8, 9, 2, 3, '', '', '2016-06-23 22:31:29', 0, 'dontpublish', '0000-00-00 00:00:00', '2016-06-23 22:31:29', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `contentusers`
--

CREATE TABLE IF NOT EXISTS `contentusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `pinterest` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='For possible blogazine and comic posters' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `title`, `content`, `status`) VALUES
(1, 'How to create an account', '<p>Creating an account is relatively simple, basically what you''ll need to do is first visit the&nbsp;<a href="../signupin.php" target="_blank">Signup Page</a>, next you''ll notice the registration form there, by default the account setup is for users, if you want to have a survey running on the site all you simply need to do is fill up all necessary fields on the form, do note that there is a monitor on the form ensuring that you provide information where needed.</p>\r\n<p>Endeavour to read the terms and conditions before submitting the form. after submission you are taken to your account immediately, an email is sent to the one you provided in the form, it contains a link for validating your account, please use it to activate your account permanently or your account will be disabled, if you have any more questions on this or feel this FAQ is lacking, do forward your messages via the contact form provided on this page</p>', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `contentid` int(11) NOT NULL,
  `contenttype` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `gallerytitle` varchar(255) NOT NULL,
  `gallerydetails` text NOT NULL,
  `entrydate` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `generalinfo`
--

CREATE TABLE IF NOT EXISTS `generalinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintype` varchar(255) NOT NULL,
  `subtype` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `intro` text NOT NULL,
  `content` text NOT NULL,
  `entrydate` datetime NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `local_govt`
--

CREATE TABLE IF NOT EXISTS `local_govt` (
  `id_no` int(10) NOT NULL AUTO_INCREMENT,
  `state_id` int(10) NOT NULL,
  `local_govt` text NOT NULL,
  PRIMARY KEY (`id_no`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COMMENT='Local governments in Nigeria.' AUTO_INCREMENT=775 ;

--
-- Dumping data for table `local_govt`
--

INSERT INTO `local_govt` (`id_no`, `state_id`, `local_govt`) VALUES
(1, 1, 'Aba North'),
(2, 1, 'Aba South'),
(3, 1, 'Arochukwu'),
(4, 1, 'Bende'),
(5, 1, 'Ikwuano'),
(6, 1, 'Isiala Ngwa North'),
(7, 1, 'Isiala Ngwa South'),
(8, 1, 'Isuikwuato'),
(9, 1, 'Obi Ngwa'),
(10, 1, 'Ohafia'),
(11, 1, 'Osisioma'),
(12, 1, 'Ugwunagbo'),
(13, 1, 'Ukwa East'),
(14, 1, 'Ukwa West'),
(15, 1, 'Umuahia North'),
(16, 1, 'Umuahia South'),
(17, 1, 'Umu Nneochi'),
(18, 2, 'Demsa'),
(19, 2, 'Fufure'),
(20, 2, 'Ganye'),
(21, 2, 'Gayuk'),
(22, 2, 'Gombi'),
(23, 2, 'Grie'),
(24, 2, 'Hong'),
(25, 2, 'Jada'),
(26, 2, 'Larmurde'),
(27, 2, 'Madagali'),
(28, 2, 'Maiha'),
(29, 2, 'Mayo Belwa'),
(30, 2, 'Michika'),
(31, 2, 'Mubi North'),
(32, 2, 'Mubi South'),
(33, 2, 'Numan'),
(34, 2, 'Shelleng'),
(35, 2, 'Song'),
(36, 2, 'Toungo'),
(37, 2, 'Yola North'),
(38, 2, 'Yola South'),
(39, 3, 'Abak'),
(40, 3, 'Eastern Obolo'),
(41, 3, 'Eket'),
(42, 3, 'Esit Eket'),
(43, 3, 'Essien Udim'),
(44, 3, 'Etim Ekpo'),
(45, 3, 'Etinan'),
(46, 3, 'Ibeno'),
(47, 3, 'Ibesikpo Asutan'),
(48, 3, 'Ibiono-Ibom'),
(49, 3, 'Ika'),
(50, 3, 'Ikono'),
(51, 3, 'Ikot Abasi'),
(52, 3, 'Ikot Ekpene'),
(53, 3, 'Ini'),
(54, 3, 'Itu'),
(55, 3, 'Mbo'),
(56, 3, 'Mkpat-Enin'),
(57, 3, 'Nsit-Atai'),
(58, 3, 'Nsit-Ibom'),
(59, 3, 'Nsit-Ubium'),
(60, 3, 'Obot Akara'),
(61, 3, 'Okobo'),
(62, 3, 'Onna'),
(63, 3, 'Oron'),
(64, 3, 'Oruk Anam'),
(65, 3, 'Udung-Uko'),
(66, 3, 'Ukanafun'),
(67, 3, 'Uruan'),
(68, 3, 'Urue-Offong/Oruko'),
(69, 3, 'Uyo'),
(70, 4, 'Aguata'),
(71, 4, 'Anambra East'),
(72, 4, 'Anambra West'),
(73, 4, 'Anaocha'),
(74, 4, 'Awka North'),
(75, 4, 'Awka South'),
(76, 4, 'Ayamelum'),
(77, 4, 'Dunukofia'),
(78, 4, 'Ekwusigo'),
(79, 4, 'Idemili North'),
(80, 4, 'Idemili South'),
(81, 4, 'Ihiala'),
(82, 4, 'Njikoka'),
(83, 4, 'Nnewi North'),
(84, 4, 'Nnewi South'),
(85, 4, 'Ogbaru'),
(86, 4, 'Onitsha North'),
(87, 4, 'Onitsha South'),
(88, 4, 'Orumba North'),
(89, 4, 'Orumba South'),
(90, 4, 'Oyi'),
(91, 5, 'Alkaleri'),
(92, 5, 'Bauchi'),
(93, 5, 'Bogoro'),
(94, 5, 'Damban'),
(95, 5, 'Darazo'),
(96, 5, 'Dass'),
(97, 5, 'Gamawa'),
(98, 5, 'Ganjuwa'),
(99, 5, 'Giade'),
(100, 5, 'Itas/Gadau'),
(101, 5, 'Jama''are'),
(102, 5, 'Katagum'),
(103, 5, 'Kirfi'),
(104, 5, 'Misau'),
(105, 5, 'Ningi'),
(106, 5, 'Shira'),
(107, 5, 'Tafawa Balewa'),
(108, 5, 'Toro'),
(109, 5, 'Warji'),
(110, 5, 'Zaki'),
(111, 6, 'Brass'),
(112, 6, 'Ekeremor'),
(113, 6, 'Kolokuma/Opokuma'),
(114, 6, 'Nembe'),
(115, 6, 'Ogbia'),
(116, 6, 'Sagbama'),
(117, 6, 'Southern Ijaw'),
(118, 6, 'Yenagoa'),
(119, 7, 'Agatu'),
(120, 7, 'Apa'),
(121, 7, 'Ado'),
(122, 7, 'Buruku'),
(123, 7, 'Gboko'),
(124, 7, 'Guma'),
(125, 7, 'Gwer East'),
(126, 7, 'Gwer West'),
(127, 7, 'Katsina-Ala'),
(128, 7, 'Konshisha'),
(129, 7, 'Kwande'),
(130, 7, 'Logo'),
(131, 7, 'Makurdi'),
(132, 7, 'Obi'),
(133, 7, 'Ogbadibo'),
(134, 7, 'Ohimini'),
(135, 7, 'Oju'),
(136, 7, 'Okpokwu'),
(137, 7, 'Oturkpo'),
(138, 7, 'Tarka'),
(139, 7, 'Ukum'),
(140, 7, 'Ushongo'),
(141, 7, 'Vandeikya'),
(142, 8, 'Abadam'),
(143, 8, 'Askira/Uba'),
(144, 8, 'Bama'),
(145, 8, 'Bayo'),
(146, 8, 'Biu'),
(147, 8, 'Chibok'),
(148, 8, 'Damboa'),
(149, 8, 'Dikwa'),
(150, 8, 'Gubio'),
(151, 8, 'Guzamala'),
(152, 8, 'Gwoza'),
(153, 8, 'Hawul'),
(154, 8, 'Jere'),
(155, 8, 'Kaga'),
(156, 8, 'Kala/Balge'),
(157, 8, 'Konduga'),
(158, 8, 'Kukawa'),
(159, 8, 'Kwaya Kusar'),
(160, 8, 'Mafa'),
(161, 8, 'Magumeri'),
(162, 8, 'Maiduguri'),
(163, 8, 'Marte'),
(164, 8, 'Mobbar'),
(165, 8, 'Monguno'),
(166, 8, 'Ngala'),
(167, 8, 'Nganzai'),
(168, 8, 'Shani'),
(169, 9, 'Abi'),
(170, 9, 'Akamkpa'),
(171, 9, 'Akpabuyo'),
(172, 9, 'Bakassi'),
(173, 9, 'Bekwarra'),
(174, 9, 'Biase'),
(175, 9, 'Boki'),
(176, 9, 'Calabar Municipal'),
(177, 9, 'Calabar South'),
(178, 9, 'Etung'),
(179, 9, 'Ikom'),
(180, 9, 'Obanliku'),
(181, 9, 'Obubra'),
(182, 9, 'Obudu'),
(183, 9, 'Odukpani'),
(184, 9, 'Ogoja'),
(185, 9, 'Yakuur'),
(186, 9, 'Yala'),
(187, 10, 'Aniocha North'),
(188, 10, 'Aniocha South'),
(189, 10, 'Bomadi'),
(190, 10, 'Burutu'),
(191, 10, 'Ethiope East'),
(192, 10, 'Ethiope West'),
(193, 10, 'Ika North East'),
(194, 10, 'Ika South'),
(195, 10, 'Isoko North'),
(196, 10, 'Isoko South'),
(197, 10, 'Ndokwa East'),
(198, 10, 'Ndokwa West'),
(199, 10, 'Okpe'),
(200, 10, 'Oshimili North'),
(201, 10, 'Oshimili South'),
(202, 10, 'Patani'),
(203, 10, 'Sapele, Delta'),
(204, 10, 'Udu'),
(205, 10, 'Ughelli North'),
(206, 10, 'Ughelli South'),
(207, 10, 'Ukwuani'),
(208, 10, 'Uvwie'),
(209, 10, 'Warri North'),
(210, 10, 'Warri South'),
(211, 10, 'Warri South West'),
(212, 11, 'Abakaliki'),
(213, 11, 'Afikpo North'),
(214, 11, 'Afikpo South'),
(215, 11, 'Ebonyi'),
(216, 11, 'Ezza North'),
(217, 11, 'Ezza South'),
(218, 11, 'Ikwo'),
(219, 11, 'Ishielu'),
(220, 11, 'Ivo'),
(221, 11, 'Izzi'),
(222, 11, 'Ohaozara'),
(223, 11, 'Ohaukwu'),
(224, 11, 'Onicha'),
(225, 12, 'Akoko-Edo'),
(226, 12, 'Egor'),
(227, 12, 'Esan Central'),
(228, 12, 'Esan North-East'),
(229, 12, 'Esan South-East'),
(230, 12, 'Esan West'),
(231, 12, 'Etsako Central'),
(232, 12, 'Etsako East'),
(233, 12, 'Etsako West'),
(234, 12, 'Igueben'),
(235, 12, 'Ikpoba Okha'),
(236, 12, 'Orhionmwon'),
(237, 12, 'Oredo'),
(238, 12, 'Ovia North-East'),
(239, 12, 'Ovia South-West'),
(240, 12, 'Owan East'),
(241, 12, 'Owan West'),
(242, 12, 'Uhunmwonde'),
(243, 13, 'Ado Ekiti'),
(244, 13, 'Efon'),
(245, 13, 'Ekiti East'),
(246, 13, 'Ekiti South-West'),
(247, 13, 'Ekiti West'),
(248, 13, 'Emure'),
(249, 13, 'Gbonyin'),
(250, 13, 'Ido Osi'),
(251, 13, 'Ijero'),
(252, 13, 'Ikere'),
(253, 13, 'Ikole'),
(254, 13, 'Ilejemeje'),
(255, 13, 'Irepodun/Ifelodun'),
(256, 13, 'Ise/Orun'),
(257, 13, 'Moba'),
(258, 13, 'Oye'),
(259, 14, 'Aninri'),
(260, 14, 'Awgu'),
(261, 14, 'Enugu East'),
(262, 14, 'Enugu North'),
(263, 14, 'Enugu South'),
(264, 14, 'Ezeagu'),
(265, 14, 'Igbo Etiti'),
(266, 14, 'Igbo Eze North'),
(267, 14, 'Igbo Eze South'),
(268, 14, 'Isi Uzo'),
(269, 14, 'Nkanu East'),
(270, 14, 'Nkanu West'),
(271, 14, 'Nsukka'),
(272, 14, 'Oji River'),
(273, 14, 'Udenu'),
(274, 14, 'Udi'),
(275, 14, 'Uzo Uwani'),
(276, 15, 'Abaji'),
(277, 15, 'Bwari'),
(278, 15, 'Gwagwalada'),
(279, 15, 'Kuje'),
(280, 15, 'Kwali'),
(281, 15, 'Municipal Area Council'),
(282, 16, 'Akko'),
(283, 16, 'Balanga'),
(284, 16, 'Billiri'),
(285, 16, 'Dukku'),
(286, 16, 'Funakaye'),
(287, 16, 'Gombe'),
(288, 16, 'Kaltungo'),
(289, 16, 'Kwami'),
(290, 16, 'Nafada'),
(291, 16, 'Shongom'),
(292, 16, 'Yamaltu/Deba'),
(293, 17, 'Aboh Mbaise'),
(294, 17, 'Ahiazu Mbaise'),
(295, 17, 'Ehime Mbano'),
(296, 17, 'Ezinihitte'),
(297, 17, 'Ideato North'),
(298, 17, 'Ideato South'),
(299, 17, 'Ihitte/Uboma'),
(300, 17, 'Ikeduru'),
(301, 17, 'Isiala Mbano'),
(302, 17, 'Isu'),
(303, 17, 'Mbaitoli'),
(304, 17, 'Ngor Okpala'),
(305, 17, 'Njaba'),
(306, 17, 'Nkwerre'),
(307, 17, 'Nwangele'),
(308, 17, 'Obowo'),
(309, 17, 'Oguta'),
(310, 17, 'Ohaji/Egbema'),
(311, 17, 'Okigwe'),
(312, 17, 'Orlu'),
(313, 17, 'Orsu'),
(314, 17, 'Oru East'),
(315, 17, 'Oru West'),
(316, 17, 'Owerri Municipal'),
(317, 17, 'Owerri North'),
(318, 17, 'Owerri West'),
(319, 17, 'Unuimo'),
(320, 18, 'Auyo'),
(321, 18, 'Babura'),
(322, 18, 'Biriniwa'),
(323, 18, 'Birnin Kudu'),
(324, 18, 'Buji'),
(325, 18, 'Dutse'),
(326, 18, 'Gagarawa'),
(327, 18, 'Garki'),
(328, 18, 'Gumel'),
(329, 18, 'Guri'),
(330, 18, 'Gwaram'),
(331, 18, 'Gwiwa'),
(332, 18, 'Hadejia'),
(333, 18, 'Jahun'),
(334, 18, 'Kafin Hausa'),
(335, 18, 'Kazaure'),
(336, 18, 'Kiri Kasama'),
(337, 18, 'Kiyawa'),
(338, 18, 'Kaugama'),
(339, 18, 'Maigatari'),
(340, 18, 'Malam Madori'),
(341, 18, 'Miga'),
(342, 18, 'Ringim'),
(343, 18, 'Roni'),
(344, 18, 'Sule Tankarkar'),
(345, 18, 'Taura'),
(346, 18, 'Yankwashi'),
(347, 19, 'Birnin Gwari'),
(348, 19, 'Chikun'),
(349, 19, 'Giwa'),
(350, 19, 'Igabi'),
(351, 19, 'Ikara'),
(352, 19, 'Jaba'),
(353, 19, 'Jema''a'),
(354, 19, 'Kachia'),
(355, 19, 'Kaduna North'),
(356, 19, 'Kaduna South'),
(357, 19, 'Kagarko'),
(358, 19, 'Kajuru'),
(359, 19, 'Kaura'),
(360, 19, 'Kauru'),
(361, 19, 'Kubau'),
(362, 19, 'Kudan'),
(363, 19, 'Lere'),
(364, 19, 'Makarfi'),
(365, 19, 'Sabon Gari'),
(366, 19, 'Sanga'),
(367, 19, 'Soba'),
(368, 19, 'Zangon Kataf'),
(369, 19, 'Zaria'),
(370, 20, 'Ajingi'),
(371, 20, 'Albasu'),
(372, 20, 'Bagwai'),
(373, 20, 'Bebeji'),
(374, 20, 'Bichi'),
(375, 20, 'Bunkure'),
(376, 20, 'Dala'),
(377, 20, 'Dambatta'),
(378, 20, 'Dawakin Kudu'),
(379, 20, 'Dawakin Tofa'),
(380, 20, 'Doguwa'),
(381, 20, 'Fagge'),
(382, 20, 'Gabasawa'),
(383, 20, 'Garko'),
(384, 20, 'Garun Mallam'),
(385, 20, 'Gaya'),
(386, 20, 'Gezawa'),
(387, 20, 'Gwale'),
(388, 20, 'Gwarzo'),
(389, 20, 'Kabo'),
(390, 20, 'Kano Municipal'),
(391, 20, 'Karaye'),
(392, 20, 'Kibiya'),
(393, 20, 'Kiru'),
(394, 20, 'Kumbotso'),
(395, 20, 'Kunchi'),
(396, 20, 'Kura'),
(397, 20, 'Madobi'),
(398, 20, 'Makoda'),
(399, 20, 'Minjibir'),
(400, 20, 'Nasarawa'),
(401, 20, 'Rano'),
(402, 20, 'Rimin Gado'),
(403, 20, 'Rogo'),
(404, 20, 'Shanono'),
(405, 20, 'Sumaila'),
(406, 20, 'Takai'),
(407, 20, 'Tarauni'),
(408, 20, 'Tofa'),
(409, 20, 'Tsanyawa'),
(410, 20, 'Tudun Wada'),
(411, 20, 'Ungogo'),
(412, 20, 'Warawa'),
(413, 20, 'Wudil'),
(414, 21, 'Bakori'),
(415, 21, 'Batagarawa'),
(416, 21, 'Batsari'),
(417, 21, 'Baure'),
(418, 21, 'Bindawa'),
(419, 21, 'Charanchi'),
(420, 21, 'Dandume'),
(421, 21, 'Danja'),
(422, 21, 'Dan Musa'),
(423, 21, 'Daura'),
(424, 21, 'Dutsi'),
(425, 21, 'Dutsin Ma'),
(426, 21, 'Faskari'),
(427, 21, 'Funtua'),
(428, 21, 'Ingawa'),
(429, 21, 'Jibia'),
(430, 21, 'Kafur'),
(431, 21, 'Kaita'),
(432, 21, 'Kankara'),
(433, 21, 'Kankia'),
(434, 21, 'Katsina'),
(435, 21, 'Kurfi'),
(436, 21, 'Kusada'),
(437, 21, 'Mai''Adua'),
(438, 21, 'Malumfashi'),
(439, 21, 'Mani'),
(440, 21, 'Mashi'),
(441, 21, 'Matazu'),
(442, 21, 'Musawa'),
(443, 21, 'Rimi'),
(444, 21, 'Sabuwa'),
(445, 21, 'Safana'),
(446, 21, 'Sandamu'),
(447, 21, 'Zango'),
(448, 22, 'Aleiro'),
(449, 22, 'Arewa Dandi'),
(450, 22, 'Argungu'),
(451, 22, 'Augie'),
(452, 22, 'Bagudo'),
(453, 22, 'Birnin Kebbi'),
(454, 22, 'Bunza'),
(455, 22, 'Dandi'),
(456, 22, 'Fakai'),
(457, 22, 'Gwandu'),
(458, 22, 'Jega'),
(459, 22, 'Kalgo'),
(460, 22, 'Koko/Besse'),
(461, 22, 'Maiyama'),
(462, 22, 'Ngaski'),
(463, 22, 'Sakaba'),
(464, 22, 'Shanga'),
(465, 22, 'Suru'),
(466, 22, 'Wasagu/Danko'),
(467, 22, 'Yauri'),
(468, 22, 'Zuru'),
(469, 23, 'Adavi'),
(470, 23, 'Ajaokuta'),
(471, 23, 'Ankpa'),
(472, 23, 'Bassa'),
(473, 23, 'Dekina'),
(474, 23, 'Ibaji'),
(475, 23, 'Idah'),
(476, 23, 'Igalamela Odolu'),
(477, 23, 'Ijumu'),
(478, 23, 'Kabba/Bunu'),
(479, 23, 'Kogi'),
(480, 23, 'Lokoja'),
(481, 23, 'Mopa Muro'),
(482, 23, 'Ofu'),
(483, 23, 'Ogori/Magongo'),
(484, 23, 'Okehi'),
(485, 23, 'Okene'),
(486, 23, 'Olamaboro'),
(487, 23, 'Omala'),
(488, 23, 'Yagba East'),
(489, 23, 'Yagba West'),
(490, 24, 'Asa'),
(491, 24, 'Baruten'),
(492, 24, 'Edu'),
(493, 24, 'Ekiti, Kwara State'),
(494, 24, 'Ifelodun'),
(495, 24, 'Ilorin East'),
(496, 24, 'Ilorin South'),
(497, 24, 'Ilorin West'),
(498, 24, 'Irepodun'),
(499, 24, 'Isin'),
(500, 24, 'Kaiama'),
(501, 24, 'Moro'),
(502, 24, 'Offa'),
(503, 24, 'Oke Ero'),
(504, 24, 'Oyun'),
(505, 24, 'Pategi'),
(506, 25, 'Agege'),
(507, 25, 'Ajeromi-Ifelodun'),
(508, 25, 'Alimosho'),
(509, 25, 'Amuwo-Odofin'),
(510, 25, 'Apapa'),
(511, 25, 'Badagry'),
(512, 25, 'Epe'),
(513, 25, 'Eti Osa'),
(514, 25, 'Ibeju-Lekki'),
(515, 25, 'Ifako-Ijaiye'),
(516, 25, 'Ikeja'),
(517, 25, 'Ikorodu'),
(518, 25, 'Kosofe'),
(519, 25, 'Lagos Island'),
(520, 25, 'Lagos Mainland'),
(521, 25, 'Mushin'),
(522, 25, 'Ojo'),
(523, 25, 'Oshodi-Isolo'),
(524, 25, 'Shomolu'),
(525, 25, 'Surulere, Lagos State'),
(526, 26, 'Akwanga'),
(527, 26, 'Awe'),
(528, 26, 'Doma'),
(529, 26, 'Karu'),
(530, 26, 'Keana'),
(531, 26, 'Keffi'),
(532, 26, 'Kokona'),
(533, 26, 'Lafia'),
(534, 26, 'Nasarawa'),
(535, 26, 'Nasarawa Egon'),
(536, 26, 'Obi'),
(537, 26, 'Toto'),
(538, 26, 'Wamba'),
(539, 27, 'Agaie'),
(540, 27, 'Agwara'),
(541, 27, 'Bida'),
(542, 27, 'Borgu'),
(543, 27, 'Bosso'),
(544, 27, 'Chanchaga'),
(545, 27, 'Edati'),
(546, 27, 'Gbako'),
(547, 27, 'Gurara'),
(548, 27, 'Katcha'),
(549, 27, 'Kontagora'),
(550, 27, 'Lapai'),
(551, 27, 'Lavun'),
(552, 27, 'Magama'),
(553, 27, 'Mariga'),
(554, 27, 'Mashegu'),
(555, 27, 'Mokwa'),
(556, 27, 'Moya'),
(557, 27, 'Paikoro'),
(558, 27, 'Rafi'),
(559, 27, 'Rijau'),
(560, 27, 'Shiroro'),
(561, 27, 'Suleja'),
(562, 27, 'Tafa'),
(563, 27, 'Wushishi'),
(564, 28, 'Abeokuta North'),
(565, 28, 'Abeokuta South'),
(566, 28, 'Ado-Odo/Ota'),
(567, 28, 'Egbado North'),
(568, 28, 'Egbado South'),
(569, 28, 'Ewekoro'),
(570, 28, 'Ifo'),
(571, 28, 'Ijebu East'),
(572, 28, 'Ijebu North'),
(573, 28, 'Ijebu North East'),
(574, 28, 'Ijebu Ode'),
(575, 28, 'Ikenne'),
(576, 28, 'Imeko Afon'),
(577, 28, 'Ipokia'),
(578, 28, 'Obafemi Owode'),
(579, 28, 'Odeda'),
(580, 28, 'Odogbolu'),
(581, 28, 'Ogun Waterside'),
(582, 28, 'Remo North'),
(583, 28, 'Shagamu'),
(584, 29, 'Akoko North-East'),
(585, 29, 'Akoko North-West'),
(586, 29, 'Akoko South-West'),
(587, 29, 'Akoko South-East'),
(588, 29, 'Akure North'),
(589, 29, 'Akure South'),
(590, 29, 'Ese Odo'),
(591, 29, 'Idanre'),
(592, 29, 'Ifedore'),
(593, 29, 'Ilaje'),
(594, 29, 'Ile Oluji/Okeigbo'),
(595, 29, 'Irele'),
(596, 29, 'Odigbo'),
(597, 29, 'Okitipupa'),
(598, 29, 'Ondo East'),
(599, 29, 'Ondo West'),
(600, 29, 'Ose'),
(601, 29, 'Owo'),
(602, 30, 'Atakunmosa East'),
(603, 30, 'Atakunmosa West'),
(604, 30, 'Aiyedaade'),
(605, 30, 'Aiyedire'),
(606, 30, 'Boluwaduro'),
(607, 30, 'Boripe'),
(608, 30, 'Ede North'),
(609, 30, 'Ede South'),
(610, 30, 'Ife Central'),
(611, 30, 'Ife East'),
(612, 30, 'Ife North'),
(613, 30, 'Ife South'),
(614, 30, 'Egbedore'),
(615, 30, 'Ejigbo'),
(616, 30, 'Ifedayo'),
(617, 30, 'Ifelodun'),
(618, 30, 'Ila'),
(619, 30, 'Ilesa East'),
(620, 30, 'Ilesa West'),
(621, 30, 'Irepodun'),
(622, 30, 'Irewole'),
(623, 30, 'Isokan'),
(624, 30, 'Iwo'),
(625, 30, 'Obokun'),
(626, 30, 'Odo Otin'),
(627, 30, 'Ola Oluwa'),
(628, 30, 'Olorunda'),
(629, 30, 'Oriade'),
(630, 30, 'Orolu'),
(631, 30, 'Osogbo'),
(632, 31, 'Afijio'),
(633, 31, 'Akinyele'),
(634, 31, 'Atiba'),
(635, 31, 'Atisbo'),
(636, 31, 'Egbeda'),
(637, 31, 'Ibadan North'),
(638, 31, 'Ibadan North-East'),
(639, 31, 'Ibadan North-West'),
(640, 31, 'Ibadan South-East'),
(641, 31, 'Ibadan South-West'),
(642, 31, 'Ibarapa Central'),
(643, 31, 'Ibarapa East'),
(644, 31, 'Ibarapa North'),
(645, 31, 'Ido'),
(646, 31, 'Irepo'),
(647, 31, 'Iseyin'),
(648, 31, 'Itesiwaju'),
(649, 31, 'Iwajowa'),
(650, 31, 'Kajola'),
(651, 31, 'Lagelu'),
(652, 31, 'Ogbomosho North'),
(653, 31, 'Ogbomosho South'),
(654, 31, 'Ogo Oluwa'),
(655, 31, 'Olorunsogo'),
(656, 31, 'Oluyole'),
(657, 31, 'Ona Ara'),
(658, 31, 'Orelope'),
(659, 31, 'Ori Ire'),
(660, 31, 'Oyo'),
(661, 31, 'Oyo East'),
(662, 31, 'Saki East'),
(663, 31, 'Saki West'),
(664, 31, 'Surulere, Oyo State'),
(665, 32, 'Bokkos'),
(666, 32, 'Barkin Ladi'),
(667, 32, 'Bassa'),
(668, 32, 'Jos East'),
(669, 32, 'Jos North'),
(670, 32, 'Jos South'),
(671, 32, 'Kanam'),
(672, 32, 'Kanke'),
(673, 32, 'Langtang South'),
(674, 32, 'Langtang North'),
(675, 32, 'Mangu'),
(676, 32, 'Mikang'),
(677, 32, 'Pankshin'),
(678, 32, 'Qua''an Pan'),
(679, 32, 'Riyom'),
(680, 32, 'Shendam'),
(681, 32, 'Wase'),
(682, 33, 'Abua/Odual'),
(683, 33, 'Ahoada East'),
(684, 33, 'Ahoada West'),
(685, 33, 'Akuku-Toru'),
(686, 33, 'Andoni'),
(687, 33, 'Asari-Toru'),
(688, 33, 'Bonny'),
(689, 33, 'Degema'),
(690, 33, 'Eleme'),
(691, 33, 'Emuoha'),
(692, 33, 'Etche'),
(693, 33, 'Gokana'),
(694, 33, 'Ikwerre'),
(695, 33, 'Khana'),
(696, 33, 'Obio/Akpor'),
(697, 33, 'Ogba/Egbema/Ndoni'),
(698, 33, 'Ogu/Bolo'),
(699, 33, 'Okrika'),
(700, 33, 'Omuma'),
(701, 33, 'Opobo/Nkoro'),
(702, 33, 'Oyigbo'),
(703, 33, 'Port Harcourt'),
(704, 33, 'Tai'),
(705, 34, 'Binji'),
(706, 34, 'Bodinga'),
(707, 34, 'Dange Shuni'),
(708, 34, 'Gada'),
(709, 34, 'Goronyo'),
(710, 34, 'Gudu'),
(711, 34, 'Gwadabawa'),
(712, 34, 'Illela'),
(713, 34, 'Isa'),
(714, 34, 'Kebbe'),
(715, 34, 'Kware'),
(716, 34, 'Rabah'),
(717, 34, 'Sabon Birni'),
(718, 34, 'Shagari'),
(719, 34, 'Silame'),
(720, 34, 'Sokoto North'),
(721, 34, 'Sokoto South'),
(722, 34, 'Tambuwal'),
(723, 34, 'Tangaza'),
(724, 34, 'Tureta'),
(725, 34, 'Wamako'),
(726, 34, 'Wurno'),
(727, 34, 'Yabo'),
(728, 35, 'Ardo Kola'),
(729, 35, 'Bali'),
(730, 35, 'Donga'),
(731, 35, 'Gashaka'),
(732, 35, 'Gassol'),
(733, 35, 'Ibi'),
(734, 35, 'Jalingo'),
(735, 35, 'Karim Lamido'),
(736, 35, 'Kumi'),
(737, 35, 'Lau'),
(738, 35, 'Sardauna'),
(739, 35, 'Takum'),
(740, 35, 'Ussa'),
(741, 35, 'Wukari'),
(742, 35, 'Yorro'),
(743, 35, 'Zing'),
(744, 36, 'Bade'),
(745, 36, 'Bursari'),
(746, 36, 'Damaturu'),
(747, 36, 'Fika'),
(748, 36, 'Fune'),
(749, 36, 'Geidam'),
(750, 36, 'Gujba'),
(751, 36, 'Gulani'),
(752, 36, 'Jakusko'),
(753, 36, 'Karasuwa'),
(754, 36, 'Machina'),
(755, 36, 'Nangere'),
(756, 36, 'Nguru'),
(757, 36, 'Potiskum'),
(758, 36, 'Tarmuwa'),
(759, 36, 'Yunusari'),
(760, 36, 'Yusufari'),
(761, 37, 'Anka'),
(762, 37, 'Bakura'),
(763, 37, 'Birnin Magaji/Kiyaw'),
(764, 37, 'Bukkuyum'),
(765, 37, 'Bungudu'),
(766, 37, 'Gummi'),
(767, 37, 'Gusau'),
(768, 37, 'Kaura Namoda'),
(769, 37, 'Maradun'),
(770, 37, 'Maru'),
(771, 37, 'Shinkafi'),
(772, 37, 'Talata Mafara'),
(773, 37, 'Chafe'),
(774, 37, 'Zurmi');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL,
  `ownertype` varchar(255) NOT NULL,
  `mainid` int(11) NOT NULL,
  `maintype` varchar(255) NOT NULL,
  `mediatype` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `location` varchar(255) NOT NULL COMMENT 'Holds original filepath for image and other file types',
  `medsize` varchar(6000) NOT NULL COMMENT 'Holds medium size displays for images only',
  `thumbnail` varchar(6000) NOT NULL COMMENT 'Holds thumb size displays for images only',
  `preview` varchar(6000) NOT NULL COMMENT 'Holds path to preview clip for audio and video file types',
  `details` text NOT NULL,
  `filesize` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `ownerid`, `ownertype`, `mainid`, `maintype`, `mediatype`, `categoryid`, `location`, `medsize`, `thumbnail`, `preview`, `details`, `filesize`, `width`, `height`, `title`, `status`) VALUES
(1, 1, 'contentcategory', 0, 'coverphoto', 'image', 0, './images/categoryimages/,2.jpg', './images/categoryimages/medsizes/,2.jpg', './images/categoryimages/thumbnails/,2.jpg', '', '', '82KB', 1076, 768, '', 'active'),
(2, 0, '', 0, 'muralimage', 'image', 0, './files/originals/,2.jpg', './files/medsizes/,2.jpg', './files/thumbnails/,2.jpg', '', '', '82KB', 1076, 768, '', 'active'),
(3, 0, 'none', 0, 'muralimage', 'image', 0, './files/originals/[AnimePaper]wallpapers_Bleach_VeNoM27_48817.jpg', './files/medsizes/[AnimePaper]wallpapers_Bleach_VeNoM27_48817.jpg', './files/thumbnails/[AnimePaper]wallpapers_Bleach_VeNoM27_48817.jpg', '', '', '781KB', 1440, 900, '', 'active'),
(4, 0, '', 0, 'muralimage', 'image', 0, './files/originals/1.JPG', './files/medsizes/1.JPG', './files/thumbnails/1.JPG', '', '', '171KB', 784, 544, '', 'active'),
(5, 0, '', 0, 'muralimage', 'image', 0, './files/originals/4as.jpg', './files/medsizes/4as.jpg', './files/thumbnails/4as.jpg', '', '', '329KB', 906, 539, '', 'active'),
(6, 1, 'client', 0, 'bizlogo', 'image', 0, './files/originals/punchlogo.png', '', './files/thumbnails/punchlogo.png', '', '', '4KB', 411, 122, '', 'active'),
(7, 0, '', 0, 'muralimage', 'image', 0, './files/originals/080.jpg', './files/medsizes/080.jpg', './files/thumbnails/080.jpg', '', '', '139KB', 800, 600, '', 'active'),
(8, 2, 'contentcategory', 0, 'coverphoto', 'image', 0, './images/categoryimages/1.JPG', './images/categoryimages/medsizes/1.JPG', './images/categoryimages/thumbnails/1.JPG', '', '', '171KB', 784, 544, '', 'active'),
(9, 3, 'contentcategory', 0, 'coverphoto', 'image', 0, './images/categoryimages/2g1679091c5a880faf6fb5e6087eb1b2dc.jpg', './images/categoryimages/medsizes/2ga87ff679a2f3e71d9181a67b7542122c.jpg', './images/categoryimages/thumbnails/2ga87ff679a2f3e71d9181a67b7542122c.jpg', '', '', '36KB', 600, 450, '', 'active'),
(10, 2, 'user', 0, 'profpic', 'image', 0, './files/originals/[AnimePaper]wallpapers_Bleach_angrycat_46065.jpg', './files/medsizes/[AnimePaper]wallpapers_Bleach_angrycat_46065.jpg', './files/thumbnails/[AnimePaper]wallpapers_Bleach_angrycat_46065.jpg', '', '', '799KB', 1920, 1200, '', 'active'),
(11, 0, '', 0, 'muralimage', 'image', 0, './files/originals/3j.jpg', './files/medsizes/3j.jpg', './files/thumbnails/3j.jpg', '', '', '65KB', 840, 850, '', 'active'),
(12, 4, 'client', 0, 'bizlogo', 'image', 0, './files/originals/theguardian.png', '', './files/thumbnails/theguardian.png', '', '', '4KB', 323, 60, '', 'active'),
(13, 5, 'user', 0, 'profpic', 'image', 0, './files/originals/[AnimePaper]wallpapers_Bleach_VeNoM27_48817c20ad4d76fe97759aa27a0c99bff6710.jpg', './files/medsizes/[AnimePaper]wallpapers_Bleach_VeNoM27_48817d3d9446802a44259755d38e6d163e820.jpg', './files/thumbnails/[AnimePaper]wallpapers_Bleach_VeNoM27_488176512bd43d9caa6e02c990b0a82652dca.jpg', '', '', '781KB', 1440, 900, '', 'active'),
(14, 6, 'user', 0, 'profpic', 'image', 0, './files/originals/096.jpg', './files/medsizes/096.jpg', './files/thumbnails/096.jpg', '', '', '343KB', 800, 600, '', 'active'),
(15, 7, 'user', 0, 'profpic', 'image', 0, './files/originals/2gaab3238922bcc25a6f606eb525ffdc56.jpg', './files/medsizes/2gc20ad4d76fe97759aa27a0c99bff6710.jpg', './files/thumbnails/2gc51ce410c124a10e0db5e4b97fc2af39.jpg', '', '', '36KB', 600, 450, '', 'active'),
(16, 8, 'user', 0, 'profpic', 'image', 0, './files/originals/,1.jpg', './files/medsizes/,1.jpg', './files/thumbnails/,1.jpg', '', '', '207KB', 1024, 768, '', 'active'),
(17, 9, 'user', 0, 'profpic', 'image', 0, './files/originals/3sdf.jpg', './files/medsizes/3sdf.jpg', './files/thumbnails/3sdf.jpg', '', '', '251KB', 1024, 768, '', 'active'),
(18, 3, 'client', 0, 'bizlogo', 'image', 0, './files/medsizes/downloadc74d97b01eae257e44aa9d5bade97baf.png', '', '', '', '', '2KB', 110, 24, '', 'active'),
(20, 1, 'parentcontent', 0, 'coverphoto', 'image', 0, './images/contentcovers/downloada87ff679a2f3e71d9181a67b7542122c.png', './images/contentcovers/medsizes/downloadc81e728d9d4c2f636f067f89cc14862c.png', './images/contentcovers/thumbnails/downloadc81e728d9d4c2f636f067f89cc14862c.png', '', '', '2KB', 200, 44, '', 'active'),
(21, 2, 'parentcontent', 0, 'coverphoto', 'image', 0, './images/contentcovers/punchlogo1679091c5a880faf6fb5e6087eb1b2dc.png', './images/contentcovers/medsizes/punchlogoa87ff679a2f3e71d9181a67b7542122c.png', './images/contentcovers/thumbnails/punchlogoa87ff679a2f3e71d9181a67b7542122c.png', '', '', '4KB', 411, 122, '', 'active'),
(22, 3, 'parentcontent', 0, 'coverphoto', 'image', 0, './images/contentcovers/IMG-20150620-WA002.jpg', './images/contentcovers/medsizes/IMG-20150620-WA002.jpg', './images/contentcovers/thumbnails/IMG-20150620-WA002.jpg', '', '', '45KB', 1280, 904, '', 'active'),
(23, 1, 'contententry', 7, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/1407536092197_wps_1_Students_at_the_London_Me.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1407536092197_wps_1_Students_at_the_London_Me.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1407536092197_wps_1_Students_at_the_London_Me.jpg', '', '', '59.74 KB', 634, 422, '', 'active'),
(24, 3, 'parentcontent', 3, 'coverphoto', 'image', 0, './images/contentcovers/1.JPG', './images/contentcovers/medsizes/1.JPG', './images/contentcovers/thumbnails/1.JPG', '', '', '171KB', 784, 544, '', 'active'),
(25, 1, 'contententry', 10, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/o-AFRICAN-AMERICAN-MAN-ON-COMPUTER-facebook.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/o-AFRICAN-AMERICAN-MAN-ON-COMPUTER-facebook.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/o-AFRICAN-AMERICAN-MAN-ON-COMPUTER-facebook.jpg', '', '', '239.78 KB', 2000, 1000, '', 'active'),
(26, 1, 'contententry', 5, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/IMG-20150703-WA000.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/IMG-20150703-WA000.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/IMG-20150703-WA000.jpg', '', '', '50.42 KB', 1280, 904, '', 'active'),
(27, 1, 'contententry', 3, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/175023_10150122669164441_624824440_6127538_4460493_o.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/175023_10150122669164441_624824440_6127538_4460493_o.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/175023_10150122669164441_624824440_6127538_4460493_o.jpg', '', '', '107.07 KB', 1024, 768, '', 'active'),
(28, 1, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image6.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image6.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image6.jpeg', '', '', '36.53 KB', 640, 480, '', 'active'),
(29, 1, 'contententry', 4, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image13.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image13.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image13.jpeg', '', '', '32.67 KB', 640, 480, '', 'active'),
(30, 1, 'contententry', 9, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image11.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image11.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image11.jpeg', '', '', '23.04 KB', 640, 480, '', 'active'),
(31, 1, 'contententry', 6, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image14.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image14.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image14.jpeg', '', '', '33.7 KB', 640, 480, '', 'active'),
(32, 1, 'contententry', 8, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image1.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image1.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image1.jpeg', '', '', '24.73 KB', 640, 480, '', 'active'),
(33, 1, 'contententry', 11, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/image8.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/image8.jpeg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/image8.jpeg', '', '', '27.37 KB', 640, 480, '', 'active'),
(34, 2, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/1.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1.jpg', '', '', '540.51 KB', 2592, 1944, '', 'active'),
(35, 2, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/2.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/2.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/2.jpg', '', '', '451.38 KB', 2592, 1944, '', 'active'),
(36, 2, 'contententry', 3, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/3.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/3.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/3.jpg', '', '', '684.63 KB', 2592, 1944, '', 'active'),
(37, 2, 'contententry', 4, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/4.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/4.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/4.jpg', '', '', '520.23 KB', 2592, 1944, '', 'active'),
(42, 2, 'contententry', 5, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/5.jpg', '', '', '591.22 KB', 2592, 1944, '', 'active'),
(43, 2, 'contententry', 6, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/6.jpg', '', '', '629.21 KB', 2592, 1944, '', 'active'),
(44, 2, 'contententry', 7, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/7.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/7.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/7.jpg', '', '', '609.09 KB', 2592, 1944, '', 'active'),
(45, 2, 'contententry', 8, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/8.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/8.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/8.jpg', '', '', '587.4 KB', 2592, 1944, '', 'active'),
(46, 2, 'contententry', 9, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/9.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/9.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/9.jpg', '', '', '547.54 KB', 2592, 1944, '', 'active'),
(47, 2, 'contententry', 10, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/10.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/10.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/10.jpg', '', '', '571.67 KB', 2592, 1944, '', 'active'),
(48, 2, 'contententry', 11, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/11.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/11.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/11.jpg', '', '', '575.59 KB', 2592, 1944, '', 'active'),
(49, 2, 'contententry', 12, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/12.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/12.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/12.jpg', '', '', '520.07 KB', 2592, 1944, '', 'active'),
(50, 2, 'contententry', 13, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/13.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/13.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/13.jpg', '', '', '470.49 KB', 2592, 1944, '', 'active'),
(51, 2, 'contententry', 14, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/14.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/14.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/14.jpg', '', '', '47.31 KB', 640, 480, '', 'active'),
(52, 2, 'contententry', 15, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/15.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/15.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/15.jpg', '', '', '735.19 KB', 2592, 1944, '', 'active'),
(53, 2, 'contententry', 16, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/16.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/16.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/16.jpg', '', '', '636.03 KB', 2592, 1944, '', 'active'),
(54, 2, 'contententry', 17, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/17.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/17.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/17.jpg', '', '', '547.36 KB', 2592, 1944, '', 'active'),
(55, 2, 'contententry', 18, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/18.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/18.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/18.jpg', '', '', '479.38 KB', 2592, 1944, '', 'active'),
(56, 2, 'contententry', 19, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/26ea9ab1baa0efb9e19094440c317e21b.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/26ea9ab1baa0efb9e19094440c317e21b.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/26ea9ab1baa0efb9e19094440c317e21b.jpg', '', '', '238.68 KB', 800, 600, '', 'active'),
(57, 2, 'contententry', 20, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/044.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/044.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/044.jpg', '', '', '83.42 KB', 1024, 768, '', 'active'),
(58, 1, 'contententry', 12, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/1c16a5320fa475530d9583c34fd356ef5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1c16a5320fa475530d9583c34fd356ef5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1c16a5320fa475530d9583c34fd356ef5.jpg', '', '', '540.51 KB', 2592, 1944, '', 'active'),
(59, 1, 'contententry', 13, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/26364d3f0f495b6ab9dcf8d3b5c6e0b01.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/26364d3f0f495b6ab9dcf8d3b5c6e0b01.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/26364d3f0f495b6ab9dcf8d3b5c6e0b01.jpg', '', '', '451.38 KB', 2592, 1944, '', 'active'),
(60, 1, 'contententry', 14, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/3182be0c5cdcd5072bb1864cdee4d3d6e.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/3182be0c5cdcd5072bb1864cdee4d3d6e.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/3182be0c5cdcd5072bb1864cdee4d3d6e.jpg', '', '', '684.63 KB', 2592, 1944, '', 'active'),
(61, 1, 'contententry', 15, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/4e369853df766fa44e1ed0ff613f563bd.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/4e369853df766fa44e1ed0ff613f563bd.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/4e369853df766fa44e1ed0ff613f563bd.jpg', '', '', '520.23 KB', 2592, 1944, '', 'active'),
(62, 1, 'contententry', 16, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/51c383cd30b7c298ab50293adfecb7b18.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/51c383cd30b7c298ab50293adfecb7b18.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/51c383cd30b7c298ab50293adfecb7b18.jpg', '', '', '591.22 KB', 2592, 1944, '', 'active'),
(63, 1, 'contententry', 17, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/619ca14e7ea6328a42e0eb13d585e4c22.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/619ca14e7ea6328a42e0eb13d585e4c22.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/619ca14e7ea6328a42e0eb13d585e4c22.jpg', '', '', '629.21 KB', 2592, 1944, '', 'active'),
(64, 1, 'contententry', 18, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/7a5bfc9e07964f8dddeb95fc584cd965d.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/7a5bfc9e07964f8dddeb95fc584cd965d.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/7a5bfc9e07964f8dddeb95fc584cd965d.jpg', '', '', '609.09 KB', 2592, 1944, '', 'active'),
(65, 1, 'contententry', 19, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/8a5771bce93e200c36f7cd9dfd0e5deaa.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/8a5771bce93e200c36f7cd9dfd0e5deaa.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/8a5771bce93e200c36f7cd9dfd0e5deaa.jpg', '', '', '587.4 KB', 2592, 1944, '', 'active'),
(66, 1, 'contententry', 21, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/9d67d8ab4f4c10bf22aa353e27879133c.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/9d67d8ab4f4c10bf22aa353e27879133c.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/9d67d8ab4f4c10bf22aa353e27879133c.jpg', '', '', '547.54 KB', 2592, 1944, '', 'active'),
(67, 1, 'contententry', 23, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/10d645920e395fedad7bbbed0eca3fe2e0.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/10d645920e395fedad7bbbed0eca3fe2e0.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/10d645920e395fedad7bbbed0eca3fe2e0.jpg', '', '', '571.67 KB', 2592, 1944, '', 'active'),
(68, 1, 'contententry', 24, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/113416a75f4cea9109507cacd8e2f2aefc.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/113416a75f4cea9109507cacd8e2f2aefc.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/113416a75f4cea9109507cacd8e2f2aefc.jpg', '', '', '575.59 KB', 2592, 1944, '', 'active'),
(69, 1, 'contententry', 20, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/Dash.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/Dash.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/Dash.jpg', '', '', '6.93 KB', 252, 192, '', 'active'),
(76, 3, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/2g.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/2g.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/2g.jpg', '', '', '36.17 KB', 600, 450, '', 'active'),
(70, 1, 'contententry', 22, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/1317e62166fc8586dfa4d1bc0e1742c08b.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1317e62166fc8586dfa4d1bc0e1742c08b.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1317e62166fc8586dfa4d1bc0e1742c08b.jpg', '', '', '470.49 KB', 2592, 1944, '', 'active'),
(71, 1, 'contententry', 25, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/14f7177163c833dff4b38fc8d2872f1ec6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/14f7177163c833dff4b38fc8d2872f1ec6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/14f7177163c833dff4b38fc8d2872f1ec6.jpg', '', '', '47.31 KB', 640, 480, '', 'active'),
(72, 1, 'contententry', 27, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/156c8349cc7260ae62e3b1396831a8398f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/156c8349cc7260ae62e3b1396831a8398f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/156c8349cc7260ae62e3b1396831a8398f.jpg', '', '', '735.19 KB', 2592, 1944, '', 'active'),
(73, 1, 'contententry', 26, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/16d9d4f495e875a2e075a1a4a6e1b9770f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/16d9d4f495e875a2e075a1a4a6e1b9770f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/16d9d4f495e875a2e075a1a4a6e1b9770f.jpg', '', '', '636.03 KB', 2592, 1944, '', 'active'),
(74, 3, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/1d82c8d1619ad8176d665453cfb2e55f0.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1f457c545a9ded88f18ecee47145a72c0.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1d82c8d1619ad8176d665453cfb2e55f0.jpg', '', '', '170.83 KB', 784, 544, '', 'active'),
(75, 1, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/18642e92efb79421734881b53e1e1b18b6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/18642e92efb79421734881b53e1e1b18b6.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/18642e92efb79421734881b53e1e1b18b6.jpg', '', '', '479.38 KB', 2592, 1944, '', 'active'),
(77, 4, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/01872b32a1f754ba1c09b3695e0cb6cde7f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/01872b32a1f754ba1c09b3695e0cb6cde7f.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/01872b32a1f754ba1c09b3695e0cb6cde7f.jpg', '', '', '210.16 KB', 1024, 768, '', 'active'),
(78, 4, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/14066f041e16a60928b05a7e228a89c3799.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/14066f041e16a60928b05a7e228a89c3799.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/14066f041e16a60928b05a7e228a89c3799.jpg', '', '', '603.02 KB', 800, 600, '', 'active'),
(79, 5, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/,2.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/,2.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/,2.jpg', '', '', '81.84 KB', 1076, 768, '', 'active'),
(80, 5, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/2g072b030ba126b2f4b2374f342be9ed44.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/2ga684eceee76fc522773286a895bc8436.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/2g66f041e16a60928b05a7e228a89c3799.jpg', '', '', '36.17 KB', 600, 450, '', 'active'),
(81, 6, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/cf1.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/cf1.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/cf1.jpg', '', '', '279.03 KB', 877, 612, '', 'active'),
(82, 6, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/GOTG004_800.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/GOTG004_800.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/GOTG004_800.jpg', '', '', '193.62 KB', 800, 600, '', 'active'),
(83, 7, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/d5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/d5.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/d5.jpg', '', '', '90.26 KB', 510, 900, '', 'active'),
(84, 7, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/11ea5d2f1c4608232e07d3aa3d998e5135.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/1166f041e16a60928b05a7e228a89c3799.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/1144f683a84163b3523afe57c2e008bc8c.jpg', '', '', '144.97 KB', 674, 690, '', 'active'),
(85, 7, 'contententry', 3, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/32.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/32.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/32.jpg', '', '', '318.05 KB', 1024, 768, '', 'active'),
(86, 8, 'contententry', 1, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/d53295c76acbf4caaed33c36b1b5fc2cb1.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/d5072b030ba126b2f4b2374f342be9ed44.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/d5ea5d2f1c4608232e07d3aa3d998e5135.jpg', '', '', '90.26 KB', 510, 900, '', 'active'),
(87, 8, 'contententry', 2, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/11735b90b4568125ed6c3f678819b6e058.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/117f39f8317fbdb1988ef4c628eba02591.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/11fc490ca45c00b1249bbe3554a4fdf6fb.jpg', '', '', '144.97 KB', 674, 690, '', 'active'),
(88, 8, 'contententry', 3, 'contententryimage', 'image', 0, './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/originals/32a3f390d88e4c41f2747bfa2f1b5f87db.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/medsizes/3244f683a84163b3523afe57c2e008bc8c.jpg', './files/users/45c48cce2e2d7fbdea1afc51c7c6ad26/heed blogazine3/thumbnails/323295c76acbf4caaed33c36b1b5fc2cb1.jpg', '', '', '318.05 KB', 1024, 768, '', 'active'),
(89, 3, 'user', 0, 'profpic', 'image', 0, './files/originals/70efdf2ec9b086079795c442636b55fb.', './files/medsizes/c74d97b01eae257e44aa9d5bade97baf.', './files/thumbnails/c74d97b01eae257e44aa9d5bade97baf.', '', '', '0KB', 0, 0, '', 'active'),
(90, 1, 'adminuser', 0, 'coverphoto', 'image', 0, './files/medsizes/09032011018.jpg', '', '', '', './files/thumbnails/09032011018.jpg', '541KB', 2592, 1944, '', 'active'),
(91, 10, 'appuser', 0, 'profpic', 'image', 0, './files/originals/70efdf2ec9b086079795c442636b55fb.', './files/medsizes/70efdf2ec9b086079795c442636b55fb.', './files/thumbnails/70efdf2ec9b086079795c442636b55fb.', '', '', '0KB', 0, 0, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `actionid` int(11) NOT NULL,
  `actiontype` varchar(255) NOT NULL,
  `actiondetails` text NOT NULL,
  `entrydate` datetime NOT NULL,
  `viewlevelid` int(11) NOT NULL,
  `viewleveltype` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `userid`, `usertype`, `action`, `actionid`, `actiontype`, `actiondetails`, `entrydate`, `viewlevelid`, `viewleveltype`, `status`) VALUES
(1, 10, 'users', 'login', 0, '', 'Logged in Successfully', '2016-06-25 10:46:43', 0, '', 'active'),
(2, 10, 'users', 'login', 0, '', 'Logged in Successfully', '2016-06-25 10:59:30', 0, '', 'active'),
(3, 10, 'users', 'login', 0, '', 'Logged in Successfully', '2016-06-25 11:57:17', 0, '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `parentcontent`
--

CREATE TABLE IF NOT EXISTS `parentcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenttitle` varchar(255) NOT NULL,
  `contentdescription` text NOT NULL,
  `contentstatus` varchar(20) NOT NULL DEFAULT 'ongoing' COMMENT 'values are, ongoing,hiatus,emded',
  `userid` int(11) NOT NULL,
  `contenttypeid` int(11) NOT NULL,
  `entrydate` datetime NOT NULL,
  `status` varchar(9) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `parentcontent`
--

INSERT INTO `parentcontent` (`id`, `contenttitle`, `contentdescription`, `contentstatus`, `userid`, `contenttypeid`, `entrydate`, `status`) VALUES
(1, 'Vanguard Newspaper', 'Popular newspaper in Nigeria', 'ongoing', 3, 1, '2016-06-05 18:52:14', 'active'),
(2, 'The Punch Newspaper', 'The best newspaper aroun', 'ongoing', 1, 1, '2016-06-06 10:08:00', 'active'),
(3, 'Heed Blogazine', 'Covering the latest in the tech industry, to which devices you should have per season and taste, heed blogazine puts the spot light on the important and saves you brain room to choose', 'ongoing', 9, 2, '2016-06-09 18:34:15', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `rssentries`
--

CREATE TABLE IF NOT EXISTS `rssentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `blogcategoryid` int(11) NOT NULL,
  `blogentryid` int(11) NOT NULL,
  `rssentry` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rssheaders`
--

CREATE TABLE IF NOT EXISTS `rssheaders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `blogcatid` int(11) NOT NULL,
  `headerdetails` text NOT NULL,
  `footerdetails` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id_no` int(10) NOT NULL,
  `state` text NOT NULL,
  PRIMARY KEY (`id_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='States in Nigeria.';

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id_no`, `state`) VALUES
(1, 'Abia'),
(2, 'Adamawa'),
(3, 'Akwa Ibom'),
(4, 'Anambra'),
(5, 'Bauchi'),
(6, 'Bayelsa'),
(7, 'Benue'),
(8, 'Borno'),
(9, 'Cross River'),
(10, 'Delta'),
(11, 'Ebonyi'),
(12, 'Edo'),
(13, 'Ekiti'),
(14, 'Enugu'),
(15, 'FCT'),
(16, 'Gombe'),
(17, 'Imo'),
(18, 'Jigawa'),
(19, 'Kaduna'),
(20, 'Kano'),
(21, 'Kastina'),
(22, 'Kebbi'),
(23, 'Kogi'),
(24, 'Kwara'),
(25, 'Lagos'),
(26, 'Nasarawa'),
(27, 'Niger'),
(28, 'Ogun'),
(29, 'Ondo'),
(30, 'Osun'),
(31, 'Oyo'),
(32, 'Plateau'),
(33, 'Rivers'),
(34, 'Sokoto'),
(35, 'Taraba'),
(36, 'Yobe'),
(37, 'Zamfara');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptionlist`
--

CREATE TABLE IF NOT EXISTS `subscriptionlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `blogcatid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactiontype` varchar(255) NOT NULL DEFAULT 'store',
  `apitype` varchar(255) NOT NULL DEFAULT 'voguepay',
  `voguerefid` varchar(255) NOT NULL,
  `useralpha` varchar(2) NOT NULL COMMENT 'Alphabet section of the Users refrenece id for course registration, format(AA-ZZ) change of alphabets depends on "userrnumeric" column',
  `usernumeric` varchar(3) NOT NULL COMMENT 'the numeric section of the user reference identification number, this is the portion that is used to tell when the maximum count has been reached for an alphabet section, that is, 999 will be the last entry for an id e.g AA999 last entry for AA entries',
  `amountpaid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `coursegroups` text NOT NULL COMMENT 'comma seperated list of course groups and their prices as at payment. Format is grouptitle|||subjects|||cost|||| and so on',
  `coursesubjects` text NOT NULL COMMENT 'comma seperated list of course subjects and their prices as at payment. Format is subjecttitle|||cost|||| ',
  `stublink` text NOT NULL,
  `fileid` int(11) NOT NULL,
  `contentid` int(11) NOT NULL COMMENT 'the id of a content paid for',
  `contenttype` varchar(255) NOT NULL COMMENT 'the table name for the content id',
  `downloads` int(11) NOT NULL,
  `transactiontime` datetime NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `voguestatus` varchar(30) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usertype` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL COMMENT 'the content category this user falls under',
  `uhash` varchar(32) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `socialhandles` text NOT NULL COMMENT 'delimited list of social handles/nicknames, key is tw|fb|gp|ln|pin|tblr|ig',
  `socialurls` text NOT NULL COMMENT 'delimited list of social urls',
  `fullname` varchar(255) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `maritalstatus` varchar(15) NOT NULL,
  `state` varchar(255) NOT NULL,
  `lga` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `genderchangedate` date NOT NULL,
  `maritalstatuschangedate` date NOT NULL,
  `dobchangedate` date NOT NULL,
  `statechangedate` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `phonenumber` text NOT NULL,
  `businessname` varchar(255) NOT NULL,
  `businessdescription` text NOT NULL,
  `businessaddress` varchar(255) NOT NULL,
  `regdate` date NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  `activationstatus` varchar(8) NOT NULL DEFAULT 'inactive',
  `activationdeadline` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usertype`, `catid`, `uhash`, `firstname`, `middlename`, `lastname`, `nickname`, `details`, `socialhandles`, `socialurls`, `fullname`, `gender`, `maritalstatus`, `state`, `lga`, `dob`, `genderchangedate`, `maritalstatuschangedate`, `dobchangedate`, `statechangedate`, `email`, `pword`, `phonenumber`, `businessname`, `businessdescription`, `businessaddress`, `regdate`, `status`, `activationstatus`, `activationdeadline`) VALUES
(1, 'client', 1, '', '', '', '', '0', '0', '', '', '', '', '', 'Lagos', '516', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'gokuzimaki@gmail.com', 'edotensei', '(234) 905-114-3917[|><|](234) 906-838-9458[|><|]', 'The Punch Nigeria', 'The punch newspaper is one of the most widely read newspapers in nigeria today', 'No. 12, lagos ibadan express way, some local government i cant be thinking about right now', '2016-05-15', 'active', 'inactive', '0000-00-00'),
(2, 'user', 3, 'c81e728d9d4c2f636f067f89cc14862c', 'Shazam', 'endocrine', 'Naynette', 'The Mind Rapist', 'I''m awesome and wonderful, take your pick', '@gokuzimaki[|><|]gokuzimaki[|><|]gokuzimaki[|><|][|><|][|><|][|><|]', 'http://twitter.com/gokuzimaki[|><|]http://facebook.com/gokuzimaki[|><|]htttp://plus.google.com/gokuzimaki[|><|][|><|][|><|][|><|]', 'Shazam endocrine Naynette', 'male', '', 'Lagos', '506', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'gokuzimaki@gmail.com', 'edotensei', '(234) 909-487-3873[|><|][|><|]', '', '', 'some address', '2016-05-18', 'active', 'inactive', '2016-05-25'),
(3, 'client', 1, '', '', '', '', '', '', '', '', '', '', '', 'Ogun', '565', '0000-00-00', '2016-06-24', '0000-00-00', '0000-00-00', '2016-06-24', 'admin@vanguardngr.com', 'edotensei', '[|><|][|><|]', 'Vanguard Newspapers', 'Vanguard Newspaper is your one stop information hotspot for the latest happenings around you.', '43, mafoluku drive abeokuta city limits', '2016-06-05', 'active', 'inactive', '0000-00-00'),
(4, 'client', 1, '', '', '', '', '', '', '', '', '', '', '', 'Lagos', '511', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'admin@theguardian.com', 'edotensei', '(234) 909-349-8434[|><|](234) 883-844-8923[|><|]', 'The Guardian', 'The best hip and trendy newspaper around, we give you the news raw and clear.', '34, some street, across the wishing willow tree trunk', '2016-06-05', 'active', 'inactive', '0000-00-00'),
(5, 'user', 2, 'e4da3b7fbbce2345d7772b0674a318d5', 'Sully', 'nagrieb', 'Madden', 'Sulltan', 'The awesome, my awesome, were awesome', 'Sullivan_Real[|><|][|><|][|><|][|><|][|><|][|><|]', 'http://twitter.com/Sullireal[|><|][|><|][|><|][|><|][|><|][|><|]', 'Sully nagrieb Madden', 'male', '', 'Lagos', '508', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'sully3000@gmail.com', 'pinto', '(234) 834-895-3984[|><|](234) 948-954-8539[|><|](234) 849-845-3489', '', '', 'Stadium bastard lane', '2016-06-05', 'active', 'inactive', '2016-06-12'),
(6, 'user', 2, '1679091c5a880faf6fb5e6087eb1b2dc', 'Damian', 'Maktub', 'Dreadlock', 'DDread', 'Im a man in the blogazine, a blogga man', '[|><|][|><|][|><|][|><|][|><|][|><|]', '[|><|][|><|][|><|][|><|][|><|][|><|]', 'Damian Maktub Dreadlock', 'male', '', 'Akwa Ibom', '42', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'ddread_4000@gmail.com', 'dread06', '(234) 984-938-4932[|><|](234) 894-884-3483[|><|]', '', '', 'Esit Eket central dust out', '2016-06-05', 'active', 'inactive', '2016-06-12'),
(7, 'user', 3, '8f14e45fceea167a5a36dedd4bea2543', 'Bradley', 'Dopeman', 'Darken', 'BRad', 'Say something cutre, and youll find that its me', '[|><|][|><|][|><|][|><|][|><|][|><|]', '[|><|][|><|][|><|][|><|][|><|][|><|]', 'Bradley Dopeman Darken', 'male', '', 'Anambra', '83', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'bradawesome@gmail.com', 'bradtley', '(234) 993-849-8423[|><|](234) 838-474-5883[|><|]', '', '', 'Nnewi north my ass', '2016-06-05', 'active', 'inactive', '2016-06-12'),
(8, 'user', 3, 'c9f0f895fb98ab9159f51fd0297e236d', 'Pinstripe', 'Maloney', 'Preotor', 'Pinprick', 'You will never find an awesome like me', '[|><|][|><|][|><|][|><|][|><|][|><|]', '[|><|][|><|][|><|][|><|][|><|][|><|]', 'Pinstripe Maloney Preotor', 'male', '', 'Delta', '198', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'pinstripe@gmail.com', 'pinstripe', '(234) 998-349-4348[|><|](234) 898-448-9443[|><|]', '', '', 'Ndokwa west my foot', '2016-06-05', 'active', 'inactive', '2016-06-12'),
(9, 'user', 2, '45c48cce2e2d7fbdea1afc51c7c6ad26', 'Saheed', 'Murktar', 'Ajibulu', 'stunna4real', 'Im saheed, a fantaistic man, that gives and even better fantaistic beating', '[|><|][|><|][|><|][|><|][|><|][|><|]', '[|><|][|><|][|><|][|><|][|><|][|><|]', 'Saheed Murktar Ajibulu', 'male', '', 'Ebonyi', '224', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'stunna4real@gmail.com', 'edotensei', '(234) 903-945-8039[|><|](234) 940-495-8349[|><|]', '', '', 'Onicha my ass', '2016-06-05', 'active', 'inactive', '2016-06-12'),
(10, 'appuser', 0, 'd3d9446802a44259755d38e6d163e820', 'Ureka', 'Eneryu', 'Mazinode', '', '', '', '', 'Ureka Eneryu Mazinode', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'gokuzimaki@gmail.com', 'mayhem', '', '', '', '', '2016-06-24', 'active', 'inactive', '0000-00-00'),
(11, 'appuser', 0, '6512bd43d9caa6e02c990b0a82652dca', 'Gokuzimaki', '', 'Shiratenseo', '', '', '', '', 'Gokuzimaki  Shiratenseo', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'comso@raidit.com', 'placebo', '', '', '', '', '2016-06-25', 'active', 'inactive', '0000-00-00'),
(12, 'appuser', 0, 'c20ad4d76fe97759aa27a0c99bff6710', 'saheedt', '', 'ajibson', '', '', '', '', 'saheedt  ajibson', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'stunnafrsh007@gmail.com', 'testingtester', '', '', '', '', '2016-06-25', 'active', 'inactive', '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
