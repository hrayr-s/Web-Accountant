---- Create users table
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pages` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `pages`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `pages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `list` (
`id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `income` float NOT NULL,
  `expense` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `list`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;