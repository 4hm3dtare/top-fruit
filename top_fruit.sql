-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2025 at 09:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `top fruit`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'mostafa', 'cf46cd628802f4a714a85a66fdc93bfb1c73872c');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `img_url` varchar(100) NOT NULL,
  `ingredients` varchar(200) DEFAULT NULL,
  `L_price` int(3) DEFAULT NULL,
  `M_price` int(3) DEFAULT NULL,
  `S_price` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `category`, `img_url`, `ingredients`, `L_price`, `M_price`, `S_price`) VALUES
(1, 'Dom With Milk', 'Top Fruit', '', 'Dom + Milk', 65, 35, 30),
(2, 'Dates', 'Top Fruit', '', 'Sweet and chewy fruits', 60, 35, 30),
(3, 'Plum', 'Top Fruit', '', 'Plum fresh', 80, 50, 40),
(4, 'Pomegranate', 'Top Fruit', '', 'Made with a fresh pomegranate', 70, 40, 35),
(5, 'Kaka', 'Top Fruit', '', 'Kaka juice', 65, 40, 35),
(6, 'Orange and Ginger', 'Top Fruit', '', 'Beverage with orange and ginger', 80, 50, 40),
(7, 'Lemon and Ginger', 'Top Fruit', '', 'Beverage with lemon and ginger', 70, 40, 35),
(8, 'Carrots and Oranges', 'Top Fruit', '', 'Carrots + Oranges', 65, 40, 35),
(9, 'Orange Juice', 'Juices', '', 'Freshly squeezed orange juice', 65, 40, 35),
(10, 'Lemon Juice', 'Juices', '', 'Made with real lemons and a hint of sweetness', 55, 30, 25),
(11, 'Lemon Mint Juice', 'Juices', '', 'Made with real lemons, fresh mint and a hint of sweetness', 60, 35, 30),
(12, 'Cantaloupe Juice', 'Juices', '', 'Refreshing and juicy cantaloupe juice, made from perfectly ripened melons', 65, 40, 35),
(13, 'Watermelon Juice', 'Juices', '', 'Made with a fresh watermelon', 60, 40, 30),
(14, 'Watermelon Mint Juice', 'Juices', '', 'watermelon, mint, water and sugar', 60, 40, 30),
(15, 'Strawberry Juice', 'Juices', '', 'Tangy citrus flavor. Packed with vitamin c', 60, 40, 30),
(16, 'Apple Juice', 'Juices', '', 'good source of vitamins A and C, as well as potassium and fiber. It is also a good source of antioxi', 60, 40, 30),
(17, 'Arugula Juice', 'Juices', '', 'Arugula, Lemon juice and water', 60, 40, 30),
(18, 'Orange and Beet Juice', 'Juices', '', 'Orange and beet mix', 60, 40, 30),
(19, 'Grapefruit Juice', 'Juices', '', 'Made from freshly grapefruit. It is a natural source of vitamins and minerals', 60, 40, 30),
(20, 'Lemon and Milk Juice', 'Juices', '', 'Lemon and Milk mix', 60, 40, 30),
(21, 'Lemon with Milk and Mint Juice', 'Juices', '', 'Lemon with Milk and Mint mix', 60, 40, 30),
(22, 'Guava Juice', 'Juices', '', 'Pure and refreshing guava extract', 60, 40, 30),
(23, 'Tangerine Juice', 'Juices', '', 'Freshly squeezed tangerine juice', 60, 40, 30),
(24, 'Ground Cherry Juice', 'Juices', '', 'Ground Cherry Fresh', 60, 40, 30),
(25, 'Kiwi Juice', 'Juices', '', 'Made from freshly squeezed kiwis, packed with natural sweetness, vitamins and minerals', 60, 40, 30),
(26, 'Banana Juice', 'Juices', '', 'Made with bananas and touch of milk', 60, 40, 30),
(27, 'Banana Pieces', 'Juices', '', 'Banana pieces fresh', 60, 40, 30),
(28, 'Carrot Juice', 'Juices', '', 'Made with freshly squeezed carrots, rich source of vitamin A and other essential nutrients', 60, 40, 30),
(29, 'Plum Juice', 'Juices', '', 'plum', 60, 40, 30),
(30, 'Strawberry With Pieces Juice', 'Juices', '', 'Strawberry With Pieces fresh', 60, 40, 30),
(31, 'Persimmon Juice', 'Juices', '', 'Persimmon fresh', 60, 40, 30),
(32, 'Mango Special', 'Special Juices', '', 'Mango, ice cream and coconut', 60, 40, 30),
(33, 'Special Banana Juice', 'Special Juices', '', 'Banana pieces and ice cream', 60, 40, 30),
(34, 'Mango', 'Mango Juices', '', 'Fresh mango, healthy and filled dose of vitamins and nutrients', 60, 40, 30),
(35, 'Mango Orzo', 'Mango Juices', '', 'Mango, banana and ice cream', 60, 40, 30),
(36, 'Awar Qalb', 'Mango Juices', '', 'Mango, strawberry and ice cream', 60, 40, 30),
(37, 'Mango Clip Juice', 'Mango Juices', '', 'Mango juice with banana pieces', 60, 40, 30),
(38, 'Avocado Honey', 'Avocado Juices', '', 'Pure avocado and packed with essential nutrients', 60, 40, 30),
(39, 'Octopus', 'Avocado Juices', '', 'Avocado and mango', 60, 40, 30),
(40, 'El Joker', 'Avocado Juices', '', 'Avocado and dates', 60, 40, 30),
(41, 'Al Fankush', 'Avocado Juices', '', 'Avocado and kiwi', 60, 40, 30),
(42, 'Super Avocado', 'Avocado Juices', '', 'Avocado, cashew and honey', 60, 40, 30),
(43, 'Avocado Viagra', 'Avocado Juices', '', 'Avocado, dates, banana and arugula', 60, 40, 30),
(44, 'Super Power', 'Avocado Juices', '', 'Avocado, Peanut and Halawa', 60, 40, 30),
(45, 'Lotus', 'Chocolate Juices', '', 'Popular brand of biscuit or spread', 60, 40, 30),
(46, 'Twinkies Mango', 'Chocolate Juices', '', 'Twinkies+ mango', 60, 40, 30),
(47, 'HoHos Chocolate Juice', 'Chocolate Juices', '', 'Hohos chocolate+ milk', 60, 40, 30),
(48, 'Twinkies Chocolate Juice', 'Chocolate Juices', '', 'Twinkies Chocolate and milk', 60, 40, 30),
(49, 'Borio Chocolate Juice', 'Chocolate Juices', '', 'Borio Chocolate Juice + Borio pieces + Ice cream bowl', 60, 40, 30),
(50, 'Lotus', 'Chocolate Juices', '', 'Popular brand of biscuit or spread', 60, 40, 30),
(51, 'Twinkies Mango', 'Chocolate Juices', '', 'Twinkies+ mango', 60, 40, 30),
(52, 'HoHos Chocolate Juice', 'Chocolate Juices', '', 'Hohos chocolate+ milk', 60, 40, 30),
(53, 'Twinkies Chocolate Juice', 'Chocolate Juices', '', 'Twinkies Chocolate and milk', 60, 40, 30),
(54, 'Borio Chocolate Juice', 'Chocolate Juices', '', 'Borio Chocolate Juice + Borio pieces + Ice cream bowl', 60, 40, 30),
(55, 'Strawberry yogurt', 'Yogurt Juices', '', 'Fat Milk, Sugar, Strawberries, Starch, Water', 60, 40, 30),
(56, 'Yogurt With Mango Juice', 'Yogurt Juices', '', 'Yogurt + mango', 60, 40, 30),
(57, 'Yogurt With Honey Juice', 'Yogurt Juices', '', 'Yogurt + Honey', 60, 40, 30),
(58, 'Plain Yogurt Juice', 'Yogurt Juices', '', 'Yogurt-based drink blended with water and sugar with no additional ingredients', 60, 40, 30),
(59, 'Yogurt With Fruit Juice', 'Yogurt Juices', '', 'Yogurt+ fruit', 60, 40, 30),
(60, 'Yogurt With Berry Juice', 'Yogurt Juices', '', 'Yogurt and berry', 60, 40, 30),
(61, 'Dates With Cashews', 'Nuts Juices', '', 'Dates and cashews blend', 60, 40, 30),
(62, 'Peanut With Vanilla Juice', 'Nuts Juices', '', 'A beverage made with peanuts, vanilla extract, and water', 60, 40, 30),
(63, 'Coconut', 'Nuts Juices', '', 'A tropical fruit', 60, 40, 30),
(64, 'Peanut With Chocolate Juice', 'Nuts Juices', '', 'A blended beverage made with peanuts, chocolate, water, and sugar', 60, 40, 30),
(65, 'Blueberry Milkshake', 'Milkshakes', '', 'Savor the sweet and tangy taste of fresh blueberries blended into a creamy and indulgent milkshake', 60, 40, 30),
(66, 'Caramel Milkshake', 'Milkshakes', '', 'Satisfy your sweet tooth with our velvety smooth Caramel Milkshake, made with creamy ice cream and drizzled with sticky-sweet caramel sauce for an indulgent treat', 60, 40, 30),
(67, 'Milkshake Mocha', 'Milkshakes', '', 'Coffee and chocolate milkshake blend', 60, 40, 30),
(68, 'Vanilla Milkshake', 'Milkshakes', '', 'Made with vanilla ice cream and milk for a classic and delicious taste. Perfect for any time of day, our milkshake is sure to be a hit with anyone who loves the taste of rich vanilla', 60, 40, 30),
(69, 'Chocolate Milkshake', 'Milkshakes', '', 'Satisfy your sweet tooth with our rich and creamy Chocolate Milkshake, made with chocolate ice cream and milk', 60, 40, 30),
(70, 'Mango Milkshake', 'Milkshakes', '', 'Made with mangoes, milk and ice cream, it\'s a perfect blend of sweet and creamy, perfect to enjoy on a hot summer day or any time you crave something sweet', 60, 40, 30),
(71, 'Strawberry Milkshake', 'Milkshakes', '', 'Made with strawberries and creamy vanilla ice cream for a sweet and satisfying treat. Perfect for any time of the day, our milkshake is sure to be a hit with anyone who loves the taste of fresh strawb', 60, 40, 30),
(72, 'Lotus', 'Chocolate Juices', '', 'Popular brand of biscuit or spread', 60, 40, 30),
(73, 'Twinkies Mango', 'Chocolate Juices', '', 'Twinkies+ mango', 60, 40, 30),
(74, 'HoHos Chocolate Juice', 'Chocolate Juices', '', 'Hohos chocolate+ milk', 60, 40, 30),
(75, 'Twinkies Chocolate Juice', 'Chocolate Juices', '', 'Twinkies Chocolate and milk', 60, 40, 30),
(76, 'Borio Chocolate Juice', 'Chocolate Juices', '', 'Borio Chocolate Juice + Borio pieces + Ice cream bowl', 60, 40, 30),
(77, 'Strawberry yogurt', 'Yogurt Juices', '', 'Fat Milk, Sugar, Strawberries, Starch, Water', 60, 40, 30),
(78, 'Yogurt With Mango Juice', 'Yogurt Juices', '', 'Yogurt + mango', 60, 40, 30),
(79, 'Yogurt With Honey Juice', 'Yogurt Juices', '', 'Yogurt + Honey', 60, 40, 30),
(80, 'Plain Yogurt Juice', 'Yogurt Juices', '', 'Yogurt-based drink blended with water and sugar with no additional ingredients', 60, 40, 30),
(81, 'Yogurt With Fruit Juice', 'Yogurt Juices', '', 'Yogurt+ fruit', 60, 40, 30),
(82, 'Yogurt With Berry Juice', 'Yogurt Juices', '', 'Yogurt and berry', 60, 40, 30),
(83, 'Dates With Cashews', 'Nuts Juices', '', 'Dates and cashews blend', 60, 40, 30),
(84, 'Peanut With Vanilla Juice', 'Nuts Juices', '', 'A beverage made with peanuts, vanilla extract, and water', 60, 40, 30),
(85, 'Coconut', 'Nuts Juices', '', 'A tropical fruit', 60, 40, 30),
(86, 'Peanut With Chocolate Juice', 'Nuts Juices', '', 'A blended beverage made with peanuts, chocolate, water, and sugar', 60, 40, 30),
(87, 'Blueberry Milkshake', 'Milkshakes', '', 'Savor the sweet and tangy taste of fresh blueberries blended into a creamy and indulgent milkshake', 60, 40, 30),
(88, 'Caramel Milkshake', 'Milkshakes', '', 'Satisfy your sweet tooth with our velvety smooth Caramel Milkshake, made with creamy ice cream and drizzled with sticky-sweet caramel sauce for an indulgent treat', 60, 40, 30),
(89, 'Milkshake Mocha', 'Milkshakes', '', 'Coffee and chocolate milkshake blend', 60, 40, 30),
(90, 'Vanilla Milkshake', 'Milkshakes', '', 'Made with vanilla ice cream and milk for a classic and delicious taste. Perfect for any time of day, our milkshake is sure to be a hit with anyone who loves the taste of rich vanilla', 60, 40, 30),
(91, 'Chocolate Milkshake', 'Milkshakes', '', 'Satisfy your sweet tooth with our rich and creamy Chocolate Milkshake, made with chocolate ice cream and milk', 60, 40, 30),
(92, 'Mango Milkshake', 'Milkshakes', '', 'Made with mangoes, milk and ice cream, it\'s a perfect blend of sweet and creamy, perfect to enjoy on a hot summer day or any time you crave something sweet', 60, 40, 30),
(93, 'Strawberry Milkshake', 'Milkshakes', '', 'Made with strawberries and creamy vanilla ice cream for a sweet and satisfying treat. Perfect for any time of the day, our milkshake is sure to be a hit with anyone who loves the taste of fresh strawb', 60, 40, 30),
(94, 'Sahar Al Lyaly', 'Al Moghazyat', '', 'Orange, lemon and honey', 60, 40, 30),
(95, 'Vitamin C', 'Al Moghazyat', '', 'Orange, lemon, guava and honey', 60, 40, 30),
(96, 'Super Vitamin C', 'Al Moghazyat', '', 'Orange, lemon, ginger and honey', 60, 40, 30),
(97, 'Alligator Juice', 'El Radaat', '', 'Cantaloupe and kiwis', 60, 40, 30),
(98, 'El Fahd Juice', 'El Radaat', '', 'Soda with vanilla ice cream', 60, 40, 30),
(99, 'El Zarafa Juice', 'El Radaat', '', 'Soda with strawberry ice cream', 60, 40, 30),
(100, 'Ghayel Juice', 'El Radaat', '', 'Soda with chocolate ice cream', 60, 40, 30),
(101, 'El Thaalab Juice', 'El Radaat', '', 'Soda with mango ice cream', 60, 40, 30),
(102, 'Laban El Asfour Juice', 'El Radaat', '', 'Mocha and soda', 60, 40, 30),
(103, 'Schweppes', 'Top Fruit Cocktails', '', 'Tangerine orange', 60, 40, 30),
(104, 'Florida', 'Top Fruit Cocktails', '', 'Banana, strawberry and milk', 60, 40, 30),
(105, 'Viagra Dates', 'Top Fruit Cocktails', '', 'Dates, arugula and banana', 60, 40, 30),
(106, 'Frelero', 'Top Fruit Cocktails', '', 'Banana, guava and milk', 60, 40, 30),
(107, 'Fifa', 'Top Fruit Cocktails', '', 'Orange and apple', 60, 40, 30),
(108, 'Al Tariq', 'Top Fruit Cocktails', '', 'Banana, pineapple, milk and apple', 60, 40, 30),
(109, 'Al Ghandour', 'Top Fruit Cocktails', '', 'Banana, mango, strawberry and honey', 60, 40, 30),
(110, 'Sambo', 'Top Fruit Cocktails', '', 'Banana and chocolate', 60, 40, 30),
(111, 'Beet', 'Top Fruit Cocktails', '', 'Pomegranate and beet', 60, 40, 30),
(112, 'Super Beet', 'Top Fruit Cocktails', '', 'Orange, pomegranate and beet', 60, 40, 30),
(113, 'Monkey', 'Top Fruit Cocktails', '', 'Banana, peanut and chocolate', 60, 40, 30),
(114, 'Red Juice', 'Top Fruit Cocktails', '', 'Pomegranate, strawberry and beet', 60, 40, 30),
(115, 'El Caf Cocktail', 'Top Fruit Cocktails', '', 'Banana, dates and vanilla ice cream', 60, 40, 30),
(116, 'Super Viagra Dates Cocktail', 'Top Fruit Cocktails', '', 'Dates, kiwi, banana and arugula', 60, 40, 30),
(117, 'El Samksh Cocktail', 'Top Fruit Cocktails', '', 'Dates, milk and borio', 60, 40, 30),
(118, 'El Eskafator Cocktail', 'Top Fruit Cocktails', '', 'Cantaloupe, kiwi and vanilla ice cream', 60, 40, 30),
(119, 'Sahar Al Lyaly', 'Al Moghazyat', '', 'Orange, lemon and honey', 60, 40, 30),
(120, 'Vitamin C', 'Al Moghazyat', '', 'Orange, lemon, guava and honey', 60, 40, 30),
(121, 'Super Vitamin C', 'Al Moghazyat', '', 'Orange, lemon, ginger and honey', 60, 40, 30),
(122, 'Alligator Juice', 'El Radaat', '', 'Cantaloupe and kiwis', 60, 40, 30),
(123, 'El Fahd Juice', 'El Radaat', '', 'Soda with vanilla ice cream', 60, 40, 30),
(124, 'El Zarafa Juice', 'El Radaat', '', 'Soda with strawberry ice cream', 60, 40, 30),
(125, 'Ghayel Juice', 'El Radaat', '', 'Soda with chocolate ice cream', 60, 40, 30),
(126, 'El Thaalab Juice', 'El Radaat', '', 'Soda with mango ice cream', 60, 40, 30),
(127, 'Laban El Asfour Juice', 'El Radaat', '', 'Mocha and soda', 60, 40, 30),
(128, 'Schweppes', 'Top Fruit Cocktails', '', 'Tangerine orange', 60, 40, 30),
(129, 'Florida', 'Top Fruit Cocktails', '', 'Banana, strawberry and milk', 60, 40, 30),
(130, 'Viagra Dates', 'Top Fruit Cocktails', '', 'Dates, arugula and banana', 60, 40, 30),
(131, 'Frelero', 'Top Fruit Cocktails', '', 'Banana, guava and milk', 60, 40, 30),
(132, 'Fifa', 'Top Fruit Cocktails', '', 'Orange and apple', 60, 40, 30),
(133, 'Al Tariq', 'Top Fruit Cocktails', '', 'Banana, pineapple, milk and apple', 60, 40, 30),
(134, 'Al Ghandour', 'Top Fruit Cocktails', '', 'Banana, mango, strawberry and honey', 60, 40, 30),
(135, 'Sambo', 'Top Fruit Cocktails', '', 'Banana and chocolate', 60, 40, 30),
(136, 'Beet', 'Top Fruit Cocktails', '', 'Pomegranate and beet', 60, 40, 30),
(137, 'Super Beet', 'Top Fruit Cocktails', '', 'Orange, pomegranate and beet', 60, 40, 30),
(138, 'Monkey', 'Top Fruit Cocktails', '', 'Banana, peanut and chocolate', 60, 40, 30),
(139, 'Red Juice', 'Top Fruit Cocktails', '', 'Pomegranate, strawberry and beet', 60, 40, 30),
(140, 'El Caf Cocktail', 'Top Fruit Cocktails', '', 'Banana, dates and vanilla ice cream', 60, 40, 30),
(141, 'Super Viagra Dates Cocktail', 'Top Fruit Cocktails', '', 'Dates, kiwi, banana and arugula', 60, 40, 30),
(142, 'El Samksh Cocktail', 'Top Fruit Cocktails', '', 'Dates, milk and borio', 60, 40, 30),
(143, 'El Eskafator Cocktail', 'Top Fruit Cocktails', '', 'Cantaloupe, kiwi and vanilla ice cream', 60, 40, 30);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_num` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`order_num`)),
  `order` int(11) NOT NULL,
  `total_price` date NOT NULL,
  `order_state` tinyint(1) NOT NULL,
  `time` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
