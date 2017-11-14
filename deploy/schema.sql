--
-- Table structure
--
CREATE TABLE `groups` (
  `groups_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`groups_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sub_groups` (
  `sub_groups_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `groups_id` int(10) NOT NULL COMMENT 'Foreign Key to #__groups.groups_id',
  PRIMARY KEY (`sub_groups_id`),
  KEY `groups_id` (`groups_id`),
  FOREIGN KEY (`groups_id`) REFERENCES `groups` (`groups_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `roles_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles_sub_groups_groups_map` (
  `roles_id` int(10) NOT NULL COMMENT 'Foreign Key to #__roles.id ',
  `sub_groups_id` int(10) NOT NULL COMMENT 'Foreign Key to #__sub_groups.id',
  `groups_id` int(10) NOT NULL COMMENT 'Foreign Key to #__groups.id ',
  KEY `roles_id` (`roles_id`),
  KEY `sub_groups_id` (`sub_groups_id`),
  KEY `groups_id` (`groups_id`),
  FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  FOREIGN KEY (`sub_groups_id`) REFERENCES `sub_groups` (`sub_groups_id`),
  FOREIGN KEY (`groups_id`) REFERENCES `groups` (`groups_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `menu` (
  `menu_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'The image of the menu item.',
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sub_menu` (
  `sub_menu_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title_url` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'The image of the menu item.',
  `blocked` int(4) NOT NULL DEFAULT '0',
  `menu_id` int(10) NOT NULL COMMENT 'Foreign Key to #__menu.menu_id',
  PRIMARY KEY (`sub_menu_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `sub_menu_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles_sub_menu_menu_map` (
  `roles_id` int(10) NOT NULL COMMENT 'Foreign Key to #__roles.roles_id ',
  `sub_menu_id` int(10) NOT NULL COMMENT 'Foreign Key to #__sub_menu.sub_menu_id',
  `menu_id` int(10) NOT NULL COMMENT 'Foreign Key to #__menu.menu_id ',
  KEY `roles_id` (`roles_id`),
  KEY `sub_menu_id` (`sub_menu_id`),
  KEY `menu_id` (`menu_id`),
  FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`),
  FOREIGN KEY (`sub_menu_id`) REFERENCES `sub_menu` (`sub_menu_id`),
  FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `users_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Login name for the user',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  `created_user` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_user` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_visit` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users_roles_map` (
  `users_id` int(10) NOT NULL COMMENT 'Foreign Key to #__users.users_id',
  `roles_id` int(10) NOT NULL COMMENT 'Foreign Key to #__roles.roles_id',
  KEY `users_id` (`users_id`),
  KEY `roles_id` (`roles_id`),
  FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`),
  FOREIGN KEY (`roles_id`) REFERENCES `roles` (`roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;