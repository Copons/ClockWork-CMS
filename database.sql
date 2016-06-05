-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2016 at 08:50 AM
-- Server version: 5.5.41-log
-- PHP Version: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `clockwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `cw_admin`
--

CREATE TABLE IF NOT EXISTS `cw_admin` (
`id` tinyint(3) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_modified` datetime NOT NULL,
  `editor` tinyint(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cw_admin`
--

INSERT INTO `cw_admin` (`id`, `username`, `password`, `role`, `email`, `description`, `date_modified`, `editor`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'test@copons.it', 'Default administrator', '2016-06-04 20:35:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cw_articles`
--

CREATE TABLE IF NOT EXISTS `cw_articles` (
`id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `content` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `parent` bigint(20) unsigned NOT NULL,
  `position` bigint(20) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL,
  `date_published` date NOT NULL,
  `date_modified` datetime NOT NULL,
  `editor` tinyint(3) unsigned NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cw_config`
--

CREATE TABLE IF NOT EXISTS `cw_config` (
`id` tinyint(3) unsigned NOT NULL,
  `item` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date_modified` datetime NOT NULL,
  `editor` tinyint(3) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cw_config`
--

INSERT INTO `cw_config` (`id`, `item`, `value`, `date_modified`, `editor`) VALUES
(1, 'name', 'ClockWork CMS', '2016-06-04 20:45:10', 1),
(2, 'description', 'A demo site!', '2016-06-04 20:45:10', 1),
(3, 'url', 'http://localhost/Clockwork-CMS/', '2016-06-04 21:16:35', 1),
(4, 'email', 'test@copons.it', '2016-06-04 21:21:29', 1),
(5, 'footer', 'ClockWork CMS 2.5 &copy; 2009-2016 Jacopo Tomasone', '2016-06-04 23:24:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cw_logs`
--

CREATE TABLE IF NOT EXISTS `cw_logs` (
`id` bigint(20) unsigned NOT NULL,
  `log_time` datetime NOT NULL,
  `editor` tinyint(3) unsigned NOT NULL,
  `page` varchar(255) NOT NULL,
  `action` enum('save','update','delete','duplicate') NOT NULL,
  `element` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cw_meta`
--

CREATE TABLE IF NOT EXISTS `cw_meta` (
`id` bigint(20) unsigned NOT NULL,
  `article` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cw_meta`
--

-- --------------------------------------------------------

--
-- Table structure for table `cw_users`
--

CREATE TABLE IF NOT EXISTS `cw_users` (
`id` bigint(20) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_registered` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `editor` tinyint(3) unsigned NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cw_admin`
--
ALTER TABLE `cw_admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cw_articles`
--
ALTER TABLE `cw_articles`
 ADD PRIMARY KEY (`id`), ADD KEY `article_position` (`position`), ADD KEY `article_type` (`type`), ADD KEY `article_status` (`status`), ADD KEY `article_parent` (`parent`);

--
-- Indexes for table `cw_config`
--
ALTER TABLE `cw_config`
 ADD PRIMARY KEY (`id`), ADD KEY `config_item` (`item`);

--
-- Indexes for table `cw_logs`
--
ALTER TABLE `cw_logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cw_meta`
--
ALTER TABLE `cw_meta`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cw_users`
--
ALTER TABLE `cw_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cw_admin`
--
ALTER TABLE `cw_admin`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cw_articles`
--
ALTER TABLE `cw_articles`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cw_config`
--
ALTER TABLE `cw_config`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cw_logs`
--
ALTER TABLE `cw_logs`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cw_meta`
--
ALTER TABLE `cw_meta`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cw_users`
--
ALTER TABLE `cw_users`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
