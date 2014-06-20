-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2014 at 11:27 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jobSearch`
--

--
-- Dumping data for table `EmailType`
--

INSERT INTO `EmailType` VALUES(1, 'personal');
INSERT INTO `EmailType` VALUES(2, 'work');

--
-- Dumping data for table `PhoneType`
--

INSERT INTO `PhoneType` VALUES(1, 'work');
INSERT INTO `PhoneType` VALUES(2, 'home');
INSERT INTO `PhoneType` VALUES(3, 'cell');
INSERT INTO `PhoneType` VALUES(4, 'fax');
