-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Maio-2025 às 11:57
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fct`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `capitais`
--

CREATE TABLE `capitais` (
  `id` int(11) NOT NULL,
  `nome_pais` varchar(100) NOT NULL,
  `nome_capital` varchar(100) NOT NULL,
  `latitude` decimal(9,6) NOT NULL,
  `longitude` decimal(9,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `capitais`
--

INSERT INTO `capitais` (`id`, `nome_pais`, `nome_capital`, `latitude`, `longitude`) VALUES
(1, 'Afghanistan', 'Kabul', 34.528900, 69.172500),
(2, 'Albania', 'Tiranë (Tirana)', 41.327500, 19.818900),
(3, 'Algeria', 'El Djazaïr  (Algiers)', 36.752500, 3.042000),
(4, 'American Samoa', 'Pago Pago', -14.278100, -170.702500),
(5, 'Andorra', 'Andorra la Vella', 42.507800, 1.521100),
(6, 'Angola', 'Luanda', -8.836800, 13.234300),
(7, 'Anguilla', 'The Valley', 18.217000, -63.057800),
(8, 'Antigua and Barbuda', 'St. John\'s', 17.117200, -61.845700),
(9, 'Argentina', 'Buenos Aires', -34.605100, -58.400400),
(10, 'Armenia', 'Yerevan', 40.182000, 44.514600),
(11, 'Aruba', 'Oranjestad', 12.524000, -70.027000),
(12, 'Australia', 'Canberra', -35.283500, 149.128100),
(13, 'Austria', 'Wien (Vienna)', 48.206400, 16.370700),
(14, 'Azerbaijan', 'Baku', 40.377700, 49.892000),
(15, 'Bahamas', 'Nassau', 25.058200, -77.343100),
(16, 'Bahrain', 'Al-Manamah (Manama)', 26.215400, 50.583200),
(17, 'Bangladesh', 'Dhaka', 23.710400, 90.407400),
(18, 'Barbados', 'Bridgetown', 13.100000, -59.616700),
(19, 'Belarus', 'Minsk', 53.900000, 27.566700),
(20, 'Belgium', 'Bruxelles-Brussel', 50.846700, 4.349900),
(21, 'Belize', 'Belmopan', 17.250000, -88.766700),
(22, 'Benin', 'Cotonou', 6.365400, 2.418300),
(23, 'Bermuda', 'Hamilton', 32.291500, -64.778000),
(24, 'Bhutan', 'Thimphu', 27.466100, 89.641900),
(25, 'Bolivia (Plurinational State of)', 'La Paz', -16.500000, -68.150000),
(26, 'Bosnia and Herzegovina', 'Sarajevo', 43.848600, 18.356400),
(27, 'Botswana', 'Gaborone', -24.654500, 25.908600),
(28, 'Brazil', 'Brasília', -15.779700, -47.929700),
(29, 'British Virgin Islands', 'Road Town', 18.416700, -64.616700),
(30, 'Brunei Darussalam', 'Bandar Seri Begawan', 4.940300, 114.948100),
(31, 'Bulgaria', 'Sofia', 42.697500, 23.324200),
(32, 'Burkina Faso', 'Ouagadougou', 12.364200, -1.538300),
(33, 'Burundi', 'Bujumbura', -3.382200, 29.364400),
(34, 'Cabo Verde', 'Praia', 14.921500, -23.508700),
(35, 'Cambodia', 'Phnum Pénh (Phnom Penh)', 11.562500, 104.916000),
(36, 'Cameroon', 'Yaoundé', 3.866700, 11.516700),
(37, 'Canada', 'Ottawa-Gatineau', 45.416600, -75.698000),
(38, 'Caribbean Netherlands', 'Kralendijk', 12.150000, -68.266700),
(39, 'Cayman Islands', 'George Town', 19.286600, -81.374400),
(40, 'Central African Republic', 'Bangui', 4.361200, 18.555000),
(41, 'Chad', 'N\'Djaména', 12.106700, 15.044400),
(42, 'Channel Islands', 'St. Helier', 49.188000, -2.104900),
(43, 'Channel Islands', 'St. Peter Port', 49.459800, -2.535300),
(44, 'Chile', 'Santiago', -33.456900, -70.648300),
(45, 'China', 'Beijing', 39.907500, 116.397200),
(46, 'China, Hong Kong SAR', 'Hong Kong', 22.279600, 114.188700),
(47, 'China, Macao SAR', 'Macao', 22.200600, 113.546100),
(48, 'China, Taiwan Province of China', 'Taibei', 25.047000, 121.545700),
(49, 'Colombia', 'Bogotá', 4.609700, -74.081800),
(50, 'Comoros', 'Moroni', -11.702200, 43.255100),
(51, 'Congo', 'Brazzaville', -4.265800, 15.283200),
(52, 'Cook Islands', 'Rarotonga', -21.230000, -159.760000),
(53, 'Costa Rica', 'San José', 9.927800, -84.080700),
(54, 'Côte d\'Ivoire', 'Abidjan', 5.345300, -4.026800),
(55, 'Croatia', 'Zagreb', 45.814400, 15.978000),
(56, 'Cuba', 'La Habana (Havana)', 23.119500, -82.378500),
(57, 'Curaçao', 'Willemstad', 12.108400, -68.933500),
(58, 'Cyprus', 'Lefkosia (Nicosia)', 35.159500, 33.366900),
(59, 'Czechia', 'Praha (Prague)', 50.088000, 14.420800),
(60, 'Dem. People\'s Republic of Korea', 'P\'yongyang', 39.033900, 125.754300),
(61, 'Democratic Republic of the Congo', 'Kinshasa', -4.327600, 15.313600),
(62, 'Denmark', 'København (Copenhagen)', 55.675900, 12.565500),
(63, 'Djibouti', 'Djibouti', 11.587700, 43.144700),
(64, 'Dominica', 'Roseau', 15.301700, -61.388100),
(65, 'Dominican Republic', 'Santo Domingo', 18.489600, -69.901800),
(66, 'Ecuador', 'Quito', -0.229900, -78.525000),
(67, 'Egypt', 'Al-Qahirah (Cairo)', 30.039200, 31.239400),
(68, 'El Salvador', 'San Salvador', 13.689400, -89.187200),
(69, 'Equatorial Guinea', 'Malabo', 3.750000, 8.783300),
(70, 'Eritrea', 'Asmara', 15.333300, 38.933300),
(71, 'Estonia', 'Tallinn', 59.437000, 24.753500),
(72, 'Ethiopia', 'Addis Ababa', 9.025000, 38.746900),
(73, 'Faeroe Islands', 'Tórshavn', 62.009700, -6.771600),
(74, 'Falkland Islands (Malvinas)', 'Stanley', -51.701200, -57.849400),
(75, 'Fiji', 'Suva', -18.141600, 178.441500),
(76, 'Finland', 'Helsinki', 60.169200, 24.940200),
(77, 'France', 'Paris', 48.853400, 2.348800),
(78, 'French Guiana', 'Cayenne', 4.933300, -52.333300),
(79, 'French Polynesia', 'Papeete', -17.533300, -149.566700),
(80, 'Gabon', 'Libreville', 0.392500, 9.453700),
(81, 'Gambia', 'Banjul', 13.453100, -16.679400),
(82, 'Georgia', 'Tbilisi', 41.694100, 44.833700),
(83, 'Germany', 'Berlin', 52.524400, 13.410500),
(84, 'Ghana', 'Accra', 5.556000, -0.196900),
(85, 'Gibraltar', 'Gibraltar', 36.144700, -5.352600),
(86, 'Greece', 'Athínai (Athens)', 37.953400, 23.749000),
(87, 'Greenland', 'Nuuk (Godthåb)', 64.183500, -51.721600),
(88, 'Grenada', 'St.George\'s', 12.056400, -61.748500),
(89, 'Guadeloupe', 'Basse-Terre', 15.998500, -61.725500),
(90, 'Guam', 'Hagåtña', 13.475700, 144.748900),
(91, 'Guatemala', 'Ciudad de Guatemala (Guatemala City)', 14.612700, -90.530700),
(92, 'Guinea', 'Conakry', 9.571600, -13.647600),
(93, 'Guinea-Bissau', 'Bissau', 11.863600, -15.597700),
(94, 'Guyana', 'Georgetown', 6.804500, -58.155300),
(95, 'Haiti', 'Port-au-Prince', 18.539200, -72.335000),
(96, 'Holy See', 'Vatican City', 41.902400, 12.453300),
(97, 'Honduras', 'Tegucigalpa', 14.081800, -87.206800),
(98, 'Hungary', 'Budapest', 47.498000, 19.039900),
(99, 'Iceland', 'Reykjavík', 64.135500, -21.895400),
(100, 'India', 'Delhi', 28.666700, 77.216700),
(101, 'Indonesia', 'Jakarta', -6.211800, 106.841600),
(102, 'Iran (Islamic Republic of)', 'Tehran', 35.694400, 51.421500),
(103, 'Iraq', 'Baghdad', 33.340600, 44.400900),
(104, 'Ireland', 'Dublin', 53.333100, -6.248900),
(105, 'Isle of Man', 'Douglas', 54.150000, -4.483300),
(106, 'Israel', 'Jerusalem', 31.769000, 35.216300),
(107, 'Italy', 'Roma (Rome)', 41.894700, 12.481100),
(108, 'Jamaica', 'Kingston', 17.997000, -76.793600),
(109, 'Japan', 'Tokyo', 35.689500, 139.691700),
(110, 'Jordan', 'Amman', 31.955200, 35.945000),
(111, 'Kazakhstan', 'Astana', 51.180100, 71.446000),
(112, 'Kenya', 'Nairobi', -1.283300, 36.816700),
(113, 'Kiribati', 'Tarawa', 1.327200, 172.981300),
(114, 'Kuwait', 'Al Kuwayt (Kuwait City)', 29.369700, 47.978300),
(115, 'Kyrgyzstan', 'Bishkek', 42.870000, 74.590000),
(116, 'Lao People\'s Democratic Republic', 'Vientiane', 17.966700, 102.600000),
(117, 'Latvia', 'Riga', 56.946000, 24.105900),
(118, 'Lebanon', 'Bayrut (Beirut)', 33.900000, 35.483300),
(119, 'Lesotho', 'Maseru', -29.316700, 27.483300),
(120, 'Liberia', 'Monrovia', 6.300500, -10.796900),
(121, 'Libya', 'Tarabulus (Tripoli)', 32.875200, 13.187500),
(122, 'Liechtenstein', 'Vaduz', 47.141500, 9.521500),
(123, 'Lithuania', 'Vilnius', 54.689200, 25.279800),
(124, 'Luxembourg', 'Luxembourg', 49.611700, 6.130000),
(125, 'Madagascar', 'Antananarivo', -18.913700, 47.536100),
(126, 'Malawi', 'Lilongwe', -13.966900, 33.787300),
(127, 'Malaysia', 'Kuala Lumpur', 3.141200, 101.686500),
(128, 'Maldives', 'Male', 4.174800, 73.508900),
(129, 'Mali', 'Bamako', 12.650000, -8.000000),
(130, 'Malta', 'Valletta', 35.899700, 14.514700),
(131, 'Marshall Islands', 'Majuro', 7.089700, 171.380300),
(132, 'Martinique', 'Fort-de-France', 14.608900, -61.073300),
(133, 'Mauritania', 'Nouakchott', 18.085800, -15.978500),
(134, 'Mauritius', 'Port Louis', -20.161900, 57.498900),
(135, 'Mayotte', 'Mamoudzou', -12.779400, 45.227200),
(136, 'Mexico', 'Ciudad de México (Mexico City)', 19.427300, -99.141900),
(137, 'Micronesia (Fed. States of)', 'Palikir', 6.917400, 158.158800),
(138, 'Monaco', 'Monaco', 43.733300, 7.416700),
(139, 'Mongolia', 'Ulaanbaatar', 47.907700, 106.883200),
(140, 'Montenegro', 'Podgorica', 42.441100, 19.263600),
(141, 'Montserrat', 'Brades Estate', 16.791800, -62.210600),
(142, 'Morocco', 'Rabat', 34.013300, -6.832600),
(143, 'Mozambique', 'Maputo', -25.965300, 32.589200),
(144, 'Myanmar', 'Nay Pyi Taw', 19.745000, 96.129700),
(145, 'Namibia', 'Windhoek', -22.559400, 17.083200),
(146, 'Nauru', 'Nauru', -0.530800, 166.911200),
(147, 'Nepal', 'Kathmandu', 27.701700, 85.320600),
(148, 'Netherlands', 'Amsterdam', 52.374000, 4.889700),
(149, 'New Caledonia', 'Nouméa', -22.276300, 166.457200),
(150, 'New Zealand', 'Wellington', -41.286600, 174.775600),
(151, 'Nicaragua', 'Managua', 12.132800, -86.250400),
(152, 'Niger', 'Niamey', 13.513700, 2.109800),
(153, 'Nigeria', 'Abuja', 9.057400, 7.489800),
(154, 'Niue', 'Alofi', -19.058500, -169.921300),
(155, 'Northern Mariana Islands', 'Saipan', 15.212300, 145.754500),
(156, 'Norway', 'Oslo', 59.912700, 10.746100),
(157, 'Oman', 'Masqat (Muscat)', 23.613900, 58.592200),
(158, 'Pakistan', 'Islamabad', 33.703500, 73.059400),
(159, 'Palau', 'Koror', 7.342600, 134.478900),
(160, 'Panama', 'Ciudad de Panamá (Panama City)', 8.995800, -79.519600),
(161, 'Papua New Guinea', 'Port Moresby', -9.443100, 147.179700),
(162, 'Paraguay', 'Asunción', -25.300700, -57.635900),
(163, 'Peru', 'Lima', -12.043200, -77.028200),
(164, 'Philippines', 'Manila', 14.604200, 120.982200),
(165, 'Poland', 'Warszawa (Warsaw)', 52.229800, 21.011800),
(166, 'Portugal', 'Lisboa (Lisbon)', 38.716900, -9.139900),
(167, 'Puerto Rico', 'San Juan', 18.466300, -66.105700),
(168, 'Qatar', 'Ad-Dawhah (Doha)', 25.274700, 51.524500),
(169, 'Republic of Korea', 'Seoul', 37.568300, 126.977800),
(170, 'Republic of Moldova', 'Chişinău', 47.005600, 28.857500),
(171, 'Réunion', 'Saint-Denis', -20.882300, 55.450400),
(172, 'Romania', 'Bucuresti (Bucharest)', 44.432800, 26.104300),
(173, 'Russian Federation', 'Moskva (Moscow)', 55.755000, 37.621800),
(174, 'Rwanda', 'Kigali', -1.947400, 30.057900),
(175, 'Saint Helena', 'Jamestown', -15.938700, -5.716800),
(176, 'Saint Kitts and Nevis', 'Basseterre', 17.294800, -62.726100),
(177, 'Saint Lucia', 'Castries', 14.006000, -60.991000),
(178, 'Saint Pierre and Miquelon', 'Saint-Pierre', 46.773800, -56.181500),
(179, 'Saint Vincent and the Grenadines', 'Kingstown', 13.158700, -61.224800),
(180, 'Samoa', 'Apia', -13.833300, -171.766700),
(181, 'San Marino', 'San Marino', 43.933300, 12.450000),
(182, 'Sao Tome and Principe', 'São Tomé', 0.336500, 6.727300),
(183, 'Saudi Arabia', 'Ar-Riyadh (Riyadh)', 24.690500, 46.709600),
(184, 'Senegal', 'Dakar', 14.693700, -17.444100),
(185, 'Serbia', 'Beograd (Belgrade)', 44.817600, 20.463300),
(186, 'Seychelles', 'Victoria', -4.616700, 55.450000),
(187, 'Sierra Leone', 'Freetown', 8.484000, -13.229900),
(188, 'Singapore', 'Singapore', 1.289700, 103.850100),
(189, 'Sint Maarten (Dutch part)', 'Philipsburg', 18.026000, -63.045800),
(190, 'Slovakia', 'Bratislava', 48.148200, 17.106700),
(191, 'Slovenia', 'Ljubljana', 46.051100, 14.505100),
(192, 'Solomon Islands', 'Honiara', -9.433300, 159.950000),
(193, 'Somalia', 'Muqdisho (Mogadishu)', 2.041600, 45.343500),
(194, 'South Africa', 'Cape Town', -33.925800, 18.423200),
(195, 'South Sudan', 'Juba', 4.851700, 31.582500),
(196, 'Spain', 'Madrid', 40.416500, -3.702600),
(197, 'Sri Lanka', 'Colombo', 6.931900, 79.847800),
(198, 'State of Palestine', 'Al-Quds[East Jerusalem]', 31.783400, 35.233900),
(199, 'Sudan', 'Al-Khartum (Khartoum)', 15.551800, 32.532400),
(200, 'Suriname', 'Paramaribo', 5.866400, -55.166800),
(201, 'Swaziland', 'Mbabane', -26.316700, 31.133300),
(202, 'Sweden', 'Stockholm', 59.332600, 18.064900),
(203, 'Switzerland', 'Bern', 46.948100, 7.447400),
(204, 'Syrian Arab Republic', 'Dimashq (Damascus)', 33.508600, 36.308400),
(205, 'Tajikistan', 'Dushanbe', 38.535800, 68.779100),
(206, 'TFYR Macedonia', 'Skopje', 42.000000, 21.433300),
(207, 'Thailand', 'Krung Thep (Bangkok)', 13.722000, 100.525200),
(208, 'Timor-Leste', 'Dili', -8.560100, 125.566800),
(209, 'Togo', 'Lomé', 6.137500, 1.212300),
(210, 'Tokelau', 'Tokelau', -9.380000, -171.250000),
(211, 'Tonga', 'Nuku\'alofa', -21.139400, -175.203200),
(212, 'Trinidad and Tobago', 'Port of Spain', 10.666200, -61.516600),
(213, 'Tunisia', 'Tunis', 36.819000, 10.165800),
(214, 'Turkey', 'Ankara', 39.919900, 32.854300),
(215, 'Turkmenistan', 'Ashgabat', 37.950000, 58.383300),
(216, 'Turks and Caicos Islands', 'Cockburn Town', 21.461200, -71.141900),
(217, 'Tuvalu', 'Funafuti', -8.518900, 179.199100),
(218, 'Uganda', 'Kampala', 0.316300, 32.582200),
(219, 'Ukraine', 'Kyiv (Kiev)', 50.445400, 30.518600),
(220, 'United Arab Emirates', 'Abu Zaby (Abu Dhabi)', 24.464800, 54.361800),
(221, 'United Kingdom', 'London', 51.508500, -0.125700),
(222, 'United Republic of Tanzania', 'Dodoma', -6.172200, 35.739500),
(223, 'United States of America', 'Washington, D.C.', 38.895100, -77.036400),
(224, 'United States Virgin Islands', 'Charlotte Amalie', 18.341900, -64.930700),
(225, 'Uruguay', 'Montevideo', -34.833500, -56.167400),
(226, 'Uzbekistan', 'Tashkent', 41.264700, 69.216300),
(227, 'Vanuatu', 'Port Vila', -17.733800, 168.321900),
(228, 'Venezuela (Bolivarian Republic of)', 'Caracas', 10.488000, -66.879200),
(229, 'Viet Nam', 'Hà Noi', 21.024500, 105.841200),
(230, 'Wallis and Futuna Islands', 'Matu-Utu', -13.281600, -176.174500),
(231, 'Western Sahara', 'El Aaiún', 27.153200, -13.201400),
(232, 'Yemen', 'Sana\'a\'', 15.353100, 44.207800),
(233, 'Zambia', 'Lusaka', -15.413400, 28.277100),
(234, 'Zimbabwe', 'Harare', -17.829400, 31.053900);

-- --------------------------------------------------------

--
-- Estrutura da tabela `registos_temperatura`
--

CREATE TABLE `registos_temperatura` (
  `id` int(11) NOT NULL,
  `id_capital` int(11) NOT NULL,
  `temperatura_maxima` decimal(5,2) DEFAULT NULL,
  `temperatura_minima` decimal(5,2) DEFAULT NULL,
  `data_recolha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `registos_temperatura`
--

INSERT INTO `registos_temperatura` (`id`, `id_capital`, `temperatura_maxima`, `temperatura_minima`, `data_recolha`) VALUES
(1, 166, 23.64, 19.92, '2025-05-28 10:51:29'),
(2, 223, 13.60, 10.51, '2025-05-28 10:51:31'),
(3, 37, 11.34, 9.29, '2025-05-28 10:51:34'),
(4, 87, 2.34, 1.60, '2025-05-28 10:51:37'),
(5, 3, 24.90, 23.23, '2025-05-28 10:51:53'),
(6, 77, 18.43, 16.88, '2025-05-28 10:51:55'),
(7, 83, 19.07, 16.01, '2025-05-28 10:51:57'),
(8, 77, 18.43, 16.88, '2025-05-28 10:51:58'),
(9, 165, 23.87, 20.52, '2025-05-28 10:51:59'),
(10, 107, 24.60, 22.79, '2025-05-28 10:52:00'),
(11, 86, 27.49, 24.00, '2025-05-28 10:52:04'),
(12, 214, 19.66, 18.58, '2025-05-28 10:52:05'),
(13, 183, 42.08, 42.08, '2025-05-28 10:52:05'),
(14, 1, 29.13, 29.13, '2025-05-28 10:52:08'),
(15, 158, 36.98, 36.98, '2025-05-28 10:52:28'),
(16, 45, 31.94, 31.94, '2025-05-28 10:52:29'),
(17, 139, 12.07, 12.07, '2025-05-28 10:52:30'),
(18, 87, 2.34, 1.60, '2025-05-28 10:52:36'),
(19, 37, 11.34, 9.29, '2025-05-28 10:52:39'),
(20, 223, 13.60, 10.51, '2025-05-28 10:52:40'),
(21, 37, 11.34, 9.29, '2025-05-28 10:53:17'),
(22, 223, 13.60, 10.51, '2025-05-28 10:53:49'),
(23, 166, 23.53, 19.81, '2025-05-28 10:53:51'),
(24, 196, 27.17, 24.53, '2025-05-28 10:53:53'),
(25, 77, 18.43, 16.88, '2025-05-28 10:53:54'),
(26, 83, 19.07, 16.01, '2025-05-28 10:53:55');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `capitais`
--
ALTER TABLE `capitais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `registos_temperatura`
--
ALTER TABLE `registos_temperatura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_capital` (`id_capital`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `capitais`
--
ALTER TABLE `capitais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT de tabela `registos_temperatura`
--
ALTER TABLE `registos_temperatura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `registos_temperatura`
--
ALTER TABLE `registos_temperatura`
  ADD CONSTRAINT `registos_temperatura_ibfk_1` FOREIGN KEY (`id_capital`) REFERENCES `capitais` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
