-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 6 月 09 日 14:28
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_graduation_program`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `store_db`
--

CREATE TABLE `store_db` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `filesurl` varchar(8190) COLLATE utf8mb4_bin NOT NULL,
  `category` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `moodselect` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `moodtext` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `foodtext` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `message` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `scene` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `budget` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `openday` date NOT NULL,
  `postadress` int(11) NOT NULL,
  `adress` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `tell` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `store_db`
--

INSERT INTO `store_db` (`id`, `name`, `filesurl`, `category`, `moodselect`, `moodtext`, `foodtext`, `message`, `scene`, `budget`, `openday`, `postadress`, `adress`, `tell`, `created_at`, `updated_at`, `username`) VALUES
(35, 'おざわ', 'https://firebasestorage.googleapis.com/v0/b/graduationprogram-45052.appspot.com/o/Store_main_img%2Fboy_india.png?alt=media&token=5c8c68f5-3962-47f3-ae0e-14a3299aed87', '居酒屋', '20代ぐらいの人が多め', 'あああ', 'ああああああ', 'ああ', 'お昼', '~1000円', '2022-06-01', 88888888, '福岡市東区', '0368332979', '2022-06-08 00:49:57', '2022-06-08 01:07:46', 'わたし');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `store_db`
--
ALTER TABLE `store_db`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `store_db`
--
ALTER TABLE `store_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
