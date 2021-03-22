-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 02:59 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `activateUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='UPDATE users SET deleted=NULL WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkUser` (IN `username` VARCHAR(250), IN `password` VARCHAR(250))  NO SQL
BEGIN
SET @sql='SELECT * FROM users WHERE username=? AND password=? AND deleted IS NULL';
SET @username=username;
SET @password=password;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @username,@password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `checkUserMail` (IN `email` VARCHAR(255))  NO SQL
BEGIN
SET @sql='SELECT * FROM users WHERE email=?';
SET @old=email;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @old;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createCategory` (IN `title` VARCHAR(255))  NO SQL
BEGIN
SET @query='INSERT INTO categories(title) VALUES(?)';
SET @title=title;
PREPARE p FROM @query;
EXECUTE p USING @title;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createSubcategory` (IN `id` INT, IN `title` VARCHAR(255))  NO SQL
BEGIN
SET @query='INSERT INTO subcategories(title,category_id) VALUES(?,?)';
SET @title=title;
SET @id=id;
PREPARE p FROM @query;
EXECUTE p USING @title,@id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createTransaction` (IN `money_amount` INT, IN `time` DATE, IN `description` TEXT, IN `target` INT, IN `category` INT, IN `subcategory` INT, IN `type` INT, IN `visibility` INT, IN `user` INT)  NO SQL
BEGIN
SET @sql='INSERT INTO transactions(money_amount,time,description,target_id,category_id,subcategory_id,type_id,visibility_id,user_id) VALUES(?,?,?,?,?,?,?,?,?)';
PREPARE s FROM @sql;
SET @money_amount=money_amount;
SET @time=time;
SET @description=description;
SET @target=target;
SET @category=category;
SET @subcategory=subcategory;
SET @type=type;
SET @visibility=visibility;
SET @user=user;
EXECUTE s USING @money_amount,@time,@description,@target,@category,@subcategory,@type,@visibility,@user;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCategory` (IN `id` INT)  NO SQL
BEGIN
SET @sql='DELETE FROM categories WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteSubcategory` (IN `id` INT)  NO SQL
BEGIN
SET @sql='DELETE FROM subcategories WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='DELETE FROM users WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `forgottenPassword` (IN `new` VARCHAR(255), IN `email` VARCHAR(255))  NO SQL
BEGIN
SET @sql='UPDATE users SET password=? WHERE email=?';
SET @old=email;
SET @new=new;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @new,@old;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategories` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM categories';
PREPARE s FROM @sql;
EXECUTE s;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategory` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM categories WHERE id=?';
SET @id=id;
PREPARE s FROM @sql;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategoryId` (IN `a` VARCHAR(255))  NO SQL
BEGIN
IF (EXISTS(SELECT id FROM categories WHERE title=a)) THEN
SELECT id FROM categories WHERE title=a;
ELSE
INSERT INTO categories(title) VALUES (a);
SELECT id FROM categories WHERE title=a;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategoryWithTitle` (IN `title` VARCHAR(255))  NO SQL
BEGIN
SET @sql='SELECT * FROM categories WHERE title=?';
SET @id=title;
PREPARE s FROM @sql;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFROM` (IN `aid` VARCHAR(50))  BEGIN
SET @sql=CONCAT('SELECT * FROM ',aid);
PREPARE s1 FROM @sql;
EXECUTE s1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRole` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT title FROM roles WHERE id=?';
SET @id=id;
PREPARE s FROM @sql;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getRoles` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM roles';
PREPARE s FROM @sql;
EXECUTE s;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubcategories` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM subcategories WHERE category_id=?';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubcategory` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM subcategories WHERE id=?';
SET @id=id;
PREPARE s FROM @sql;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubcategoryId` (IN `a` VARCHAR(255), IN `b` INT)  NO SQL
BEGIN
IF (EXISTS(SELECT id FROM subcategories WHERE title=a)) THEN
SELECT id FROM subcategories WHERE title=a;
ELSE
IF (a<>'') THEN
INSERT INTO subcategories(title,category_id) VALUES (a,b);
END IF;
SELECT id FROM subcategories WHERE title=a;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTarget` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM target WHERE id=?';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTargetId` (IN `a` VARCHAR(255))  NO SQL
BEGIN
IF (EXISTS(SELECT id FROM target WHERE title=a)) THEN
SELECT id FROM target WHERE title=a;
ELSE
INSERT INTO target(title) VALUES (a);
SELECT id FROM target WHERE title=a;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTargets` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM target';
PREPARE a FROM @sql;
EXECUTE a;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTransactions` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM transactions WHERE user_id=? ORDER BY time';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getType` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM transaction_types WHERE id=?';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTypes` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM transaction_types';
PREPARE a FROM @sql;
EXECUTE a;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVisibilities` ()  NO SQL
BEGIN
SET @sql='SELECT * FROM transaction_visibility';
PREPARE a FROM @sql;
EXECUTE a;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVisibility` (IN `id` INT)  NO SQL
BEGIN
SET @sql='SELECT * FROM transaction_visibility WHERE id=?';
PREPARE a FROM @sql;
SET @id=id;
EXECUTE a USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `hideUser` (IN `id` INT)  NO SQL
BEGIN
SET @sql='UPDATE users SET deleted=1 WHERE id=?';
PREPARE s FROM @sql;
SET @id=id;
EXECUTE s USING @id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategory` (IN `id` INT, IN `title` VARCHAR(255), IN `id1` INT)  NO SQL
BEGIN
SET @sql='UPDATE categories SET id=?,title=? WHERE id=?';
SET @id=id;
SET @title=title;
SET @id1=id1;
PREPARE s FROM @sql;
EXECUTE s USING @id,@title,@id1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePassword` (IN `old` VARCHAR(250), IN `new` VARCHAR(250))  NO SQL
BEGIN
SET @sql='UPDATE users SET password=? WHERE password=?';
SET @old=old;
SET @new=new;
PREPARE s1 FROM @sql;
EXECUTE s1 USING @new,@old;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSubcategory` (IN `id` INT, IN `title` VARCHAR(255), IN `id1` INT)  NO SQL
BEGIN
SET @sql='UPDATE subcategories SET id=?,title=? WHERE id=?';
SET @id=id;
SET @title=title;
SET @id1=id1;
PREPARE s FROM @sql;
EXECUTE s USING @id,@title,@id1;
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
(3, 'IT', NULL),
(4, 'new', NULL);

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
(2, 'Tablet', NULL, 3),
(3, 'Mobilni', NULL, 3),
(4, 'Tastatura', NULL, 3),
(5, 'Pica', NULL, 2),
(9, 'Programiranje', NULL, 3),
(10, 'Ostalo', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `title`) VALUES
(1, 'Posao'),
(2, 'Tetka iz Kanade'),
(3, 'Javno komunalno preduće'),
(4, 'Poreska uprava'),
(5, 'Crkveni odbor Jovanovac'),
(6, 'Tehnomanija'),
(7, 'Pera Limar'),
(8, 'Deda');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `money_amount` int(11) NOT NULL,
  `time` date NOT NULL,
  `description` text,
  `target_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `visibility_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `money_amount`, `time`, `description`, `target_id`, `user_id`, `category_id`, `subcategory_id`, `type_id`, `visibility_id`) VALUES
(1, 4000, '2020-03-26', NULL, 1, 2, 1, NULL, 2, 1),
(2, 5000, '2020-05-03', 'Uplata', 1, 2, 3, 9, 1, 1),
(4, 10000, '2020-05-01', 'Prilog za crkvu', 5, 2, 1, 10, 2, 1),
(5, 30000, '2020-05-03', 'Kupovina laptopa', 6, 2, 3, 1, 2, 2),
(6, 20000, '2020-05-03', 'Dato na zajam', 7, 2, 1, 10, 2, 2),
(7, 500, '2020-05-03', 'Penzija', 8, 2, 1, NULL, 1, 2);

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
(1, 'Admin', 'admin', 'admin@gmail.com', 'admin', 'Srbija,Kragujevac,Jovanovac bb', NULL, 'Ja sam Admin', 1),
(2, 'user1', 'user1', 'user1@gmail.com', 'user1', 'User address', NULL, 'aa', 2),
(3, 'Blank', 'blank', 'pravljenjesajta1@gmail.com', 'O9ocfyzT', 'None', NULL, '', 1),
(4, 'Pera', 'pera', 'pera@gmail.com', 'pera', 'per', NULL, '', 1),
(6, 'Pera', 'pera', 'peric', 'debil@gmail.com', 'a', NULL, '', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `visibility_id` (`visibility_id`),
  ADD KEY `target_id` (`target_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `transactions_ibfk_5` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `transactions_ibfk_6` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`),
  ADD CONSTRAINT `transactions_ibfk_7` FOREIGN KEY (`visibility_id`) REFERENCES `transaction_visibility` (`id`),
  ADD CONSTRAINT `transactions_ibfk_8` FOREIGN KEY (`target_id`) REFERENCES `target` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
