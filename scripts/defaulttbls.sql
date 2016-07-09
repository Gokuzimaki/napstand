-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 02, 2015 at 07:32 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `muyiwasblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE IF NOT EXISTS `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) NOT NULL,
  `landingpage` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `activepage` varchar(255) NOT NULL,
  `clicks` int(11) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `blogentries`
--

CREATE TABLE IF NOT EXISTS `blogentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogtypeid` int(11) NOT NULL,
  `blogcatid` int(11) NOT NULL,
  `blogentrytype` varchar(255) NOT NULL,
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
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `eventtitle` varchar(255) NOT NULL,
  `eventdetails` text NOT NULL,
  `dateperiod` varchar(255) NOT NULL,
  `d` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallerytitle` varchar(255) NOT NULL,
  `gallerydetails` text NOT NULL,
  `entrydate` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `filesize` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `newsletter` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `qotd`
--

CREATE TABLE IF NOT EXISTS `qotd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `quote` varchar(255) NOT NULL,
  `quotedperson` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `servicerequest`
--

CREATE TABLE IF NOT EXISTS `servicerequest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `organizationname` varchar(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  `eventtype` varchar(255) NOT NULL,
  `startdateperiod` varchar(255) NOT NULL,
  `enddateperiod` varchar(255) NOT NULL,
  `expectedattendance` varchar(255) NOT NULL,
  `phoneone` varchar(20) NOT NULL,
  `phonetwo` varchar(20) NOT NULL,
  `venue` text NOT NULL,
  `extrainfo` text NOT NULL,
  `datetime` varchar(255) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
