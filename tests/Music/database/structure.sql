-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: mysql    Database: cutron01_test
-- ------------------------------------------------------
-- Server version	5.5.5-10.2.25-MariaDB


--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` char(200) NOT NULL DEFAULT '',
  `year` int(11) DEFAULT NULL,
  `genreId` int(11) DEFAULT NULL,
  `artistId` int(11) NOT NULL DEFAULT 0,
  `coverId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `album_ibfk_1` FOREIGN KEY (`genreId`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `album_ibfk_2` FOREIGN KEY (`artistId`) REFERENCES `artist` (`id`) ON DELETE CASCADE,
  CONSTRAINT `album_ibfk_3` FOREIGN KEY (`coverId`) REFERENCES `cover` (`id`) ON DELETE CASCADE
);

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `cover`
--

CREATE TABLE `cover` (
  `id` int(11) NOT NULL,
  `jpeg` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `albumId` int(11) NOT NULL DEFAULT 0,
  `songId` int(11) NOT NULL DEFAULT 0,
  `number` int(11) NOT NULL DEFAULT 0,
  `disknumber` int(11) NOT NULL DEFAULT 0,
  `duration` mediumint(11) DEFAULT 0,
  PRIMARY KEY (`albumId`,`songId`,`number`,`disknumber`),
  CONSTRAINT `track_ibfk_1` FOREIGN KEY (`albumId`) REFERENCES `album` (`id`) ON DELETE CASCADE,
  CONSTRAINT `track_ibfk_2` FOREIGN KEY (`songId`) REFERENCES `song` (`id`) ON DELETE CASCADE
);


-- Dump completed on 2019-10-10 15:32:04
