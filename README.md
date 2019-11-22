**Event Booking System:

you can easily assign events to Employees here via json Data, Filter accross Events, Employees, dates

Programming Langauge: Core PHP 7.2
Tools: Twig via composer 1.9
Database: Mysql  5.7.26
Version Control: GIT (Github)

Database design:
Employee:**

`
CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
 
 ALTER TABLE `employee`
   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
 COMMIT;
`

**Event:**

`
CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);
  
  ALTER TABLE `event`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
  COMMIT;
`

**Participation_Mapping**

`
CREATE TABLE `participation` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `participation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_index` (`employee_id`,`event_id`),
  ADD KEY `participation_event` (`event_id`);
  
  ALTER TABLE `participation`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;


ALTER TABLE `participation`
  ADD CONSTRAINT `participation_employee` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `participation_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);
COMMIT;
`

**To Execute:**

1)Set up a virtual Host:

`
<VirtualHost *:80>To Import json Data from command line: 
         ServerAdmin webmaster@localhost
         DocumentRoot /var/www/html/Event-System/
         <Directory />
                 Options FollowSymLinks
                 AllowOverride None
         </Directory>
         ServerName event.system.local
         <Directory /var/www/html/Event-System/>
                 FallbackResource /index.php
         </Directory>
         ErrorLog ${APACHE_LOG_DIR}/error.log
         # Possible values include: debug, info, notice, warn, error, crit,
         # alert, emerg.
         LogLevel warn
         CustomLog ${APACHE_LOG_DIR}/access.log combined
 </VirtualHost>
 `
 
 2 ) Then in /etc/hosts set localhost mapped with event.system.local.
 
 http://event.system.local/public/list.php
 
 to access via local.
 
 3 ) I have committed the vendor folder for you so no need of doing a composer install.
 
 **To Import json Data from command line:**
 1) Keep the file /var/www/html/Event-System/public/ and name it code.json
 2) Execute the command written in src/commands folder with name importData.php. 
 
 I have zipped the code and database for your reference.