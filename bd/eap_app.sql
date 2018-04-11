-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2018 a las 02:24:45
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eap_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_foreman_project`
--

CREATE TABLE `log_foreman_project` (
  `id_log_foreman_project` int(10) NOT NULL,
  `fk_id_project` int(10) NOT NULL,
  `fk_id_user_foreman` int(10) NOT NULL,
  `date_issue` datetime NOT NULL,
  `fk_id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log_foreman_project`
--

INSERT INTO `log_foreman_project` (`id_log_foreman_project`, `fk_id_project`, `fk_id_user_foreman`, `date_issue`, `fk_id_user`) VALUES
(1, 2, 3, '2018-04-10 12:39:58', 1),
(2, 2, 4, '2018-04-10 12:47:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_company`
--

CREATE TABLE `param_company` (
  `id_company` int(10) NOT NULL,
  `company_name` varchar(120) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `movil_number` varchar(12) NOT NULL,
  `email` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_company`
--

INSERT INTO `param_company` (`id_company`, `company_name`, `contact`, `movil_number`, `email`) VALUES
(1, 'ABS INC', 'MICHAEL', '4034089921', 'benmotta@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu`
--

CREATE TABLE `param_menu` (
  `id_menu` int(3) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `menu_icono` varchar(50) NOT NULL,
  `orden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu`
--

INSERT INTO `param_menu` (`id_menu`, `menu_name`, `menu_icono`, `orden`) VALUES
(1, 'Report', 'fa-pie-chart', 1),
(2, 'Settings', 'fa-cog', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_menu_links`
--

CREATE TABLE `param_menu_links` (
  `id_link` int(3) NOT NULL,
  `fk_id_menu` int(3) NOT NULL,
  `fk_id_rol` int(1) NOT NULL,
  `link_name` varchar(100) NOT NULL,
  `link_url` varchar(100) NOT NULL,
  `link_icono` varchar(50) NOT NULL,
  `orden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_menu_links`
--

INSERT INTO `param_menu_links` (`id_link`, `fk_id_menu`, `fk_id_rol`, `link_name`, `link_url`, `link_icono`, `orden`) VALUES
(1, 1, 1, 'Payroll report', 'report/search/payrollByAdmin', 'fa-book', 1),
(2, 1, 2, 'Payroll report', 'report/search/payrollByAdmin', 'fa-book', 1),
(3, 2, 1, 'Users', 'admin/usuarios', 'fa-users', 1),
(4, 2, 1, 'Company', 'admin/company', 'fa-building', 2),
(5, 2, 1, 'Projects', 'admin/project', 'fa-road', 3),
(6, 2, 1, 'QR Code', 'codeqr', 'fa-qrcode', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_qr_code`
--

CREATE TABLE `param_qr_code` (
  `id_qr_code` int(10) NOT NULL,
  `value_qr_code` varchar(20) NOT NULL,
  `image_qr_code` varchar(250) NOT NULL,
  `encryption` varchar(100) NOT NULL,
  `qr_code_state` int(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Inactive',
  `fk_id_user` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_qr_code`
--

INSERT INTO `param_qr_code` (`id_qr_code`, `value_qr_code`, `image_qr_code`, `encryption`, `qr_code_state`, `fk_id_user`) VALUES
(1, 'EAP20180001', 'images/qrcode/EAP20180001.png', 'EAP20180001h5p3oSK8VwhfEc9Vw6Mz8RcyjGanGe', 1, 0),
(2, 'EAP20180052', 'images/qrcode/EAP20180052.png', 'EAP20180052RzGiYec2Y37bJ7JA9KLvtgnbvckP58', 1, 2),
(3, 'EAP20180003', 'images/qrcode/EAP20180003.png', 'EAP20180003n6fe3qZB5O8AywAbME3wJTb9QOAgnC', 2, 1),
(4, 'EAP20180004', 'images/qrcode/EAP20180004.png', 'EAP20180004lwopKM96Q2UPRPyyBUCX1iEIl4fynz', 2, 0),
(5, 'EAP20180005', 'images/qrcode/EAP20180005.png', 'EAP20180005vBQSV12N0aAqBNw6SMvnKzFDcET3fa', 2, 0),
(6, 'EAP20180006', 'images/qrcode/EAP20180006.png', 'EAP201800064sU7n7sFUqxxz7KydJ6VGSoGE1cTOw', 1, 0),
(7, 'EAP20180007', 'images/qrcode/EAP20180007.png', 'EAP20180007cY2bGBBqyZtc5BDAPymBKPevgTR5nd', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `param_rol`
--

CREATE TABLE `param_rol` (
  `id_rol` int(1) NOT NULL,
  `rol_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `estilos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `param_rol`
--

INSERT INTO `param_rol` (`id_rol`, `rol_name`, `description`, `estilos`) VALUES
(1, 'SUPER ADMIN', 'Con acceso a todo el sistema', 'text-success'),
(2, 'FOREMAN', 'Encargado de revisar el payroll de los empleados', 'text-danger'),
(3, 'NORMAL USER', 'Empleados sin ningún privilegio', 'text-primary');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payroll`
--

CREATE TABLE `payroll` (
  `id_payroll` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_project` int(10) NOT NULL,
  `start` datetime NOT NULL,
  `finish` datetime NOT NULL,
  `working_time` varchar(30) NOT NULL,
  `working_hours` float NOT NULL,
  `observation` text NOT NULL,
  `activities` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `payroll`
--

INSERT INTO `payroll` (`id_payroll`, `fk_id_user`, `fk_id_project`, `start`, `finish`, `working_time`, `working_hours`, `observation`, `activities`) VALUES
(1, 1, 1, '2018-04-04 06:11:58', '2018-04-05 19:11:40', '+1 days 12:59:42', 37, 'Nuevas cosas<br><br>Observaciones', 'Actividades'),
(2, 1, 2, '2018-04-05 19:11:00', '2018-04-05 22:00:00', '+0 days 02:49:00', 2.75, 'Nuevo proyecto<br>********************<br><strong>Changue hour by SUPER ADMIN.</strong> <br>Before -> Start: 2018-04-05 19:11:58 <br>Before -> Finish: 0000-00-00 00:00:00<br>Pruebas de cambio de hora<br>Date: 2018-04-05 20:25:41<br>********************', ''),
(3, 1, 1, '2018-04-05 21:17:01', '2018-04-05 21:43:45', '+0 days 00:26:44', 0.5, 'Ingreso a un nuevo proyecto<br><br>', ''),
(4, 1, 1, '2018-04-05 07:45:00', '2018-04-05 21:50:00', '+0 days 14:05:00', 14, 'eTOY COMO OPERADOR<br><br><br>********************<br><strong>Changue hour by SUPER ADMIN.</strong> <br>Before -> Start: 2018-04-05 21:45:08 <br>Before -> Finish: 2018-04-05 21:50:44<br>ERROR AL GUARDAAAR<br>Date: 2018-04-05 21:52:18<br>********************', ''),
(5, 1, 1, '2018-04-09 01:37:25', '2018-04-09 05:23:32', '+0 days 03:46:07', 3.75, 'Nuevo ingreso<br><br>', ''),
(6, 1, 3, '2018-04-09 23:15:01', '0000-00-00 00:00:00', '', 0, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `id_project` int(10) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `project_state` tinyint(1) NOT NULL COMMENT '1:Active; 2:inactive',
  `project_number` varchar(50) NOT NULL,
  `fk_id_company` int(10) NOT NULL,
  `fk_id_user_foreman` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`id_project`, `project_name`, `project_state`, `project_number`, `fk_id_company`, `fk_id_user_foreman`) VALUES
(0, 'No project', 2, '', 1, 3),
(1, 'CONTRUCCION DE PUENTE', 1, '1124-2', 1, 3),
(2, ' EDIFICIO CENTRAL', 1, '1125-1', 1, 4),
(3, 'PASO PEATONAL DOWNTOWN', 1, '1230-1', 1, 3),
(6, 'HOME TOWN', 1, '1024-2', 1, 3),
(7, 'WINDOW INSTALATION', 1, '1090-1', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `fk_id_rol` int(1) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `movil` varchar(12) NOT NULL,
  `password` varchar(50) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '0: newUser; 1:active; 2:inactive',
  `photo` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `first_name`, `last_name`, `log_user`, `email`, `fk_id_rol`, `birthdate`, `movil`, `password`, `state`, `photo`, `address`) VALUES
(1, 'BENJAMIN', 'MOTTA', 'bmottag', 'benmotta@gmail.com', 1, '2018-03-19', '4033089921', '25f9e794323b453885f5181f1b624d0b', 1, '', ''),
(2, 'EDUAR', 'ACOSTA', 'eacosta', 'eacosta@eapcontruction.com', 1, '2018-04-05', '4038895044', 'e10adc3949ba59abbe56e057f20f883e', 1, '', ''),
(3, 'JAVIER', 'MOLINA', 'jmolina', 'jmolina@gmail.com', 2, '2018-04-10', '3347766', 'e10adc3949ba59abbe56e057f20f883e', 1, '', ''),
(4, 'ANDRES', 'PALOMARES', 'apalomares', 'apalomares@gmail.com', 2, '2018-04-10', '3347766', 'e10adc3949ba59abbe56e057f20f883e', 1, '', ''),
(5, 'ALEX', 'HERRERA', 'aherrera', 'aherrera@gmail.com', 3, '2018-04-10', '3347766', 'e10adc3949ba59abbe56e057f20f883e', 1, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `log_foreman_project`
--
ALTER TABLE `log_foreman_project`
  ADD PRIMARY KEY (`id_log_foreman_project`),
  ADD KEY `fk_id_project` (`fk_id_project`),
  ADD KEY `fk_id_user_foreman` (`fk_id_user_foreman`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `param_company`
--
ALTER TABLE `param_company`
  ADD PRIMARY KEY (`id_company`);

--
-- Indices de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD PRIMARY KEY (`id_link`),
  ADD KEY `fk_id_menu` (`fk_id_menu`),
  ADD KEY `fk_id_rol` (`fk_id_rol`);

--
-- Indices de la tabla `param_qr_code`
--
ALTER TABLE `param_qr_code`
  ADD PRIMARY KEY (`id_qr_code`),
  ADD UNIQUE KEY `value_qr_code` (`value_qr_code`),
  ADD UNIQUE KEY `encryption` (`encryption`),
  ADD KEY `fk_id_user` (`fk_id_user`);

--
-- Indices de la tabla `param_rol`
--
ALTER TABLE `param_rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id_payroll`),
  ADD KEY `fk_id_user` (`fk_id_user`),
  ADD KEY `fk_id_project_start` (`fk_id_project`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`),
  ADD KEY `fk_id_company` (`fk_id_company`),
  ADD KEY `fk_id_user_foreman` (`fk_id_user_foreman`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `log_user` (`log_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_id_rol` (`fk_id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `log_foreman_project`
--
ALTER TABLE `log_foreman_project`
  MODIFY `id_log_foreman_project` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `param_company`
--
ALTER TABLE `param_company`
  MODIFY `id_company` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `param_menu`
--
ALTER TABLE `param_menu`
  MODIFY `id_menu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  MODIFY `id_link` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `param_qr_code`
--
ALTER TABLE `param_qr_code`
  MODIFY `id_qr_code` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `param_rol`
--
ALTER TABLE `param_rol`
  MODIFY `id_rol` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id_payroll` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `log_foreman_project`
--
ALTER TABLE `log_foreman_project`
  ADD CONSTRAINT `log_foreman_project_ibfk_1` FOREIGN KEY (`fk_id_project`) REFERENCES `project` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `param_menu_links`
--
ALTER TABLE `param_menu_links`
  ADD CONSTRAINT `param_menu_links_ibfk_1` FOREIGN KEY (`fk_id_menu`) REFERENCES `param_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `param_menu_links_ibfk_2` FOREIGN KEY (`fk_id_rol`) REFERENCES `param_rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_3` FOREIGN KEY (`fk_id_project`) REFERENCES `project` (`id_project`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`fk_id_company`) REFERENCES `param_company` (`id_company`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
