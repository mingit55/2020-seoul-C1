-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-07-13 02:14
-- 서버 버전: 10.1.30-MariaDB
-- PHP 버전: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `seoul_1`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `iid` int(11) NOT NULL,
  `contents` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `answers`
--

INSERT INTO `answers` (`id`, `iid`, `contents`, `created_at`) VALUES
(1, 1, '0', '2020-07-10 11:51:33'),
(2, 2, '끝', '2020-07-10 11:55:37');

-- --------------------------------------------------------

--
-- 테이블 구조 `artworks`
--

CREATE TABLE `artworks` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `contents` longtext NOT NULL,
  `uid` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `artworks`
--

INSERT INTO `artworks` (`id`, `title`, `contents`, `uid`, `image`, `created_at`, `tags`) VALUES
(9, '이상한 나라의 밤하늘', '테스트 내용', 4, '1594469286.jpeg', '2020-07-11 12:08:06', '[{\"id\":0,\"data\":\"#밤하늘\"},{\"id\":1,\"data\":\"#이상한\"}]');

-- --------------------------------------------------------

--
-- 테이블 구조 `artwork_bin`
--

CREATE TABLE `artwork_bin` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `contents` longtext NOT NULL,
  `uid` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tags` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `artwork_tags`
--

CREATE TABLE `artwork_tags` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `artwork_tags`
--

INSERT INTO `artwork_tags` (`id`, `aid`, `name`) VALUES
(5, 9, '#밤하늘'),
(6, 9, '#이상한');

-- --------------------------------------------------------

--
-- 테이블 구조 `has_papers`
--

CREATE TABLE `has_papers` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `infinity` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `has_papers`
--

INSERT INTO `has_papers` (`id`, `uid`, `pid`, `count`, `infinity`) VALUES
(3, 4, 6, -6, 1),
(4, 4, 7, -1, 1),
(5, 4, 8, 0, 1),
(6, 4, 9, -2, 1),
(7, 4, 10, -3, 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `inquires`
--

CREATE TABLE `inquires` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `contents` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `inquires`
--

INSERT INTO `inquires` (`id`, `uid`, `title`, `contents`, `created_at`) VALUES
(1, 2, '문의 테스트', '테스트 내용입니다.', '2020-07-10 11:09:52'),
(2, 2, '123', '\\', '2020-07-10 11:43:45');

-- --------------------------------------------------------

--
-- 테이블 구조 `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `contents` longtext NOT NULL,
  `files` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `papers`
--

CREATE TABLE `papers` (
  `id` int(11) NOT NULL,
  `image` varchar(60) NOT NULL,
  `paper_name` varchar(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `width_size` int(11) NOT NULL,
  `height_size` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `papers`
--

INSERT INTO `papers` (`id`, `image`, `paper_name`, `uid`, `width_size`, `height_size`, `point`) VALUES
(6, '1594451275.png', '밤하늘 한지', 4, 300, 500, 200),
(7, '1594451337.png', '자연의 한지', 4, 300, 200, 210),
(8, '1594451391.png', '그냥 한지임', 4, 200, 200, 200),
(9, '1594451571.png', '또 이 한지', 4, 200, 200, 200),
(10, '1594451786.png', '또 또 그냥 한지', 4, 200, 200, 200);

-- --------------------------------------------------------

--
-- 테이블 구조 `paper_tags`
--

CREATE TABLE `paper_tags` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `paper_tags`
--

INSERT INTO `paper_tags` (`id`, `pid`, `name`) VALUES
(6, 6, '#하늘'),
(7, 6, '#아련한'),
(8, 6, '#밤하늘'),
(9, 7, '#자연'),
(10, 7, '#초록색'),
(11, 8, '#200'),
(12, 8, '#한지'),
(13, 8, '#그냥_한지'),
(14, 9, '#200'),
(15, 9, '#그냥'),
(16, 9, '#한지'),
(17, 9, '#그냥_한지'),
(18, 10, '#200'),
(19, 10, '#그냥'),
(20, 10, '#한지'),
(21, 10, '#그냥_한지'),
(22, 10, '#또_그냥');

-- --------------------------------------------------------

--
-- 테이블 구조 `sale_history`
--

CREATE TABLE `sale_history` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `sale_history`
--

INSERT INTO `sale_history` (`id`, `cid`, `point`) VALUES
(4, 4, 200),
(5, 4, 200);

-- --------------------------------------------------------

--
-- 테이블 구조 `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `score` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `scores`
--

INSERT INTO `scores` (`id`, `uid`, `aid`, `score`) VALUES
(2, 1, 9, 2),
(3, 8, 9, 5);

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `type` varchar(10) NOT NULL,
  `image` varchar(30) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_name`, `type`, `image`, `point`) VALUES
(1, 'mingit55@gmail.com', '89d5d6b337b2233ad2b1bfc6814ffd76c6f012ee9c9cdd202402fad694988273', '김민재', 'normal', '1594366570DeXLAdaUQAEV6Uu.jpg', 270),
(2, 'user2@gmail.com', '89d5d6b337b2233ad2b1bfc6814ffd76c6f012ee9c9cdd202402fad694988273', '이유저', 'normal', '1594366613.png', 1000),
(3, 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '관리자', 'normal', '', 1000),
(4, 'company_1@gmail.com', '89d5d6b337b2233ad2b1bfc6814ffd76c6f012ee9c9cdd202402fad694988273', '기능반 주식회사', 'company', '1594445380.png', 1630),
(5, '__@naver.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1234', 'normal', '1594445518.jpg', 1000),
(6, '__@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '에이 설마 안되겠어', 'company', '1594445775.jpg', 1000),
(7, 'user1@naver.com', '2c835ba8966d902120fb4504037fad34effa4b9461e988e4c4da073ad50dae82', '일유저', 'normal', '1594446127', 1000),
(8, 'user1@gmail.com', '2c835ba8966d902120fb4504037fad34effa4b9461e988e4c4da073ad50dae82', '일유저', 'normal', '1594469941', 1000),
(9, 'user3@gmail.com', '2c835ba8966d902120fb4504037fad34effa4b9461e988e4c4da073ad50dae82', '이유저', 'normal', '1594469986', 1000);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iid` (`iid`);

--
-- 테이블의 인덱스 `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `artwork_tags`
--
ALTER TABLE `artwork_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- 테이블의 인덱스 `has_papers`
--
ALTER TABLE `has_papers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `inquires`
--
ALTER TABLE `inquires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- 테이블의 인덱스 `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `paper_tags`
--
ALTER TABLE `paper_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `sale_history`
--
ALTER TABLE `sale_history`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `artworks`
--
ALTER TABLE `artworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `artwork_tags`
--
ALTER TABLE `artwork_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `has_papers`
--
ALTER TABLE `has_papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `inquires`
--
ALTER TABLE `inquires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 테이블의 AUTO_INCREMENT `paper_tags`
--
ALTER TABLE `paper_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 테이블의 AUTO_INCREMENT `sale_history`
--
ALTER TABLE `sale_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`iid`) REFERENCES `inquires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `artwork_tags`
--
ALTER TABLE `artwork_tags`
  ADD CONSTRAINT `artwork_tags_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artworks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `has_papers`
--
ALTER TABLE `has_papers`
  ADD CONSTRAINT `has_papers_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `papers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `inquires`
--
ALTER TABLE `inquires`
  ADD CONSTRAINT `inquires_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `paper_tags`
--
ALTER TABLE `paper_tags`
  ADD CONSTRAINT `paper_tags_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `papers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `artworks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
