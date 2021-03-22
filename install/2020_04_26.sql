-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2020 at 06:08 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maturski`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkUser` (IN `username` VARCHAR(250), IN `password` VARCHAR(250))  NO SQL
BEGIN
SET @sql='SELECT * FROM users WHERE username=? AND password=? ';
SET @username=username;
SET @password=password;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @username,@password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createUser` (IN `name` VARCHAR(250), IN `username` VARCHAR(250), IN `email` VARCHAR(250), IN `password` VARCHAR(250), IN `address` VARCHAR(250), IN `biography` TEXT)  NO SQL
BEGIN
SET @sql='INSERT INTO users(name,username,password,email,role_id,address,biography) VALUES(?,?,?,?,2,?,?)';
PREPARE s FROM @sql;
SET @username=username;
SET @name=name;
SET @password=password;
SET @email=email;
SET @address=address;
SET @biography=biography;
EXECUTE s USING @name,@username,@password,@email,@address,@biography;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='DELETE users WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategories` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM categories';
PREPARE s FROM @sql;
EXECUTE s;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFROM` (IN `aid` VARCHAR(50))  BEGIN
SET @sql=CONCAT('SELECT * FROM ',aid);
PREPARE s1 FROM @sql;
EXECUTE s1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubcategories` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM subcategories WHERE category_id=?';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM users WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers` ()  NO SQL
SELECT * FROM users$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hideUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='UPDATE users SET deleted=1 WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePassword` (IN `old` VARCHAR(250), IN `new` VARCHAR(250))  NO SQL
BEGIN
SET @sql='UPDATE users SET password=? WHERE password=?';
SET @old=old;
SET @new=new;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @new,@old;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUser` (IN `id` INT, IN `name` VARCHAR(250), IN `username` VARCHAR(250), IN `email` VARCHAR(250), IN `password` VARCHAR(250), IN `address` VARCHAR(250), IN `biography` TEXT, IN `deleted` BOOLEAN, IN `role_id` INT, IN `id1` INT)  NO SQL
BEGIN 
SET @sql='UPDATE users SET id=?,name=?,username=?,password=?,email=?,role_id=?,address=?,biography=?,deleted=? WHERE id=?'; 
PREPARE s FROM @sql; 
SET @username=username; SET @name=name; 
SET @password=password; SET @email=email; 
SET @address=address; 
SET @biography=biography; 
SET @id=id; 
SET @deleted=deleted;
SET @role_id=role_id;
SET @id1=id1;
EXECUTE s USING @id,@name,@username,@password,@email,@role_id,@address,@biography,@deleted,@id1; 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `verified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `verified`) VALUES
(1, 'Ostalo', NULL),
(2, 'Hrana', NULL),
(3, 'IT', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `title`) VALUES
(1, 'Javno komunalno preduzeće'),
(2, 'Poreska uprava');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `title`) VALUES
(1, 'Posao'),
(2, 'Tetka iz Kanade');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `title`, `verified`, `category_id`) VALUES
(1, 'Laptop', NULL, 3),
(2, 'Tablet', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `money_amount` int(11) NOT NULL,
  `time` date NOT NULL,
  `description` text,
  `source_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `visibility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `money_amount`, `time`, `description`, `source_id`, `destination_id`, `user_id`, `category_id`, `subcategory_id`, `type_id`, `visibility_id`) VALUES
(1, 4000, '2020-03-26', 'Izbaciti type_id i transaction_types i gledati da li je user_id source_id ili destination_id?\r\nDa li je moguce da se svi fajlovi uploaduju na server i da dobijemo nalog pa da mozemo to da menjamo i pratimo?', NULL, 1, 2, 1, NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE `transaction_types` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `title`) VALUES
(1, 'PRILIV'),
(2, 'ODLIV');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_visibility`
--

CREATE TABLE `transaction_visibility` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction_visibility`
--

INSERT INTO `transaction_visibility` (`id`, `title`) VALUES
(1, 'PUBLIC'),
(2, 'PRIVATE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `biography` text,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `address`, `deleted`, `biography`, `role_id`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 'admin', 'Srbija,Kragujevac,Jovanovac bb', NULL, NULL, 1),
(2, 'user1', 'user1', 'user1@gmail.com', 'user1', 'User address', NULL, NULL, 2),
(3, 'Pera', 'pera', 'pera@gmail.com', 'peric', 'Perina adresa', NULL, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sources`
--
ALTER TABLE `sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `visibility_id` (`visibility_id`);

--
-- Indexes for table `transaction_types`
--
ALTER TABLE `transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_visibility`
--
ALTER TABLE `transaction_visibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sources`
--
ALTER TABLE `sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction_types`
--
ALTER TABLE `transaction_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_visibility`
--
ALTER TABLE `transaction_visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `transaction_types` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`),
  ADD CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `transactions_ibfk_5` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `transactions_ibfk_6` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`),
  ADD CONSTRAINT `transactions_ibfk_7` FOREIGN KEY (`visibility_id`) REFERENCES `transaction_visibility` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
