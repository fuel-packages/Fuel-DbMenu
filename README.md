# DbMenu

A FuelPHP Package to generate named recursively nested menu's from a databse.

### Basic usage example

    // In your template or view
	<?php Fuel::add_package('DbMenu'); ?> // Or add it to the always load package array in config
    <ul id="nav"><?php echo DbMenu::build('main'); ?></ul> // Change 'main' to whatever you want your menu to be known as.
    
    For example: 
    Frontend: DbMenu::build('main')
    Admin area DbMenu::build('admin')
    
    You can have as many menu's as you want.
	
### Install

    Add `http://github.com/Phil-F` to your packages config and run `php oil install DbMenu`.

### Sample DB Structure

    The database table name can be changed in dbconfig.php

    CREATE TABLE IF NOT EXISTS `dbmenu` (
    `id` int(11) NOT NULL,
    `menu_name` varchar(20) NOT NULL,
    `title` varchar(50) NOT NULL,
    `link` text NOT NULL,
    `parent` int(11) NOT NULL,
    `position` int(11) NOT NULL
    );

    --
    -- Dumping data for table `dbmenu`
    --

    INSERT INTO `dbmenu` (`id`, `menu_name`, `title`, `link`, `parent`, `position`) VALUES
    (1, 'main', 'Home', '', 0, 1),
    (2, 'main', 'Website design', '#', 0, 2),
    (3, 'main', 'web', 'web', 2, 2),
    (4, 'main', 'web2', 'web2', 2, 1),
    (5, 'main', 'Contact', 'contact', 0, 4),
    (6, 'main', 'Support', '#', 0, 3),
    (7, 'main', 'home pc', 'home-pc', 6, 1),
    (8, 'main', 'business pc', 'business-pc', 6, 2),
    (9, 'main', 'portfolio', 'portfolio', 2, 4),
    (10, 'main', 'quote', 'quote', 2, 3);