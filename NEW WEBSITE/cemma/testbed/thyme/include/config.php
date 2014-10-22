<?php

error_reporting(E_ALL ^ (E_NOTICE));

######################
#
### SQL
#
#####################

# current drivers are:
#
# MySQL - "mysql"
# PostgreSQL - "pgsql"
# MSSQL Server - "mssql"
#
# PostgreSQL
# ----------
# for most PostgreSQL default installations,
# running on the same host, you may have to
# comment out the DBHOST and DBPORT lines
#
######################

define("_CAL_SQL_DRIVER_", "mysql");

define("_CAL_DBHOST_", "db390863418.db.1and1.com");
define("_CAL_DBPORT_", "3306");

define("_CAL_DBUSER_", "dbo390863418");
define("_CAL_DBPASS_", 'curu11i');
define("_CAL_DBNAME_", "db390863418");

define("_CAL_DBPREFIX_", "");



##########################################
#
### PATHS AND URLS (with trailing slash)
#
#########################################
define("_CAL_BASE_PATH_", "/homepages/40/d209127057/htdocs/cemma/testbed/thyme/");
define("_CAL_BASE_URL_", "http://cemma-usc.net/cemma/testbed/thyme/");


# GLOBAL SETTINGS
####################
require_once(@constant("_CAL_BASE_PATH_") . "include/global_settings.php");



# see include/languages
# for other options
##############################
@define("_CAL_LANG_", "en_US");



##########################
#
### MAP LINK
#
#########################

# Map link for events with an Address. The default goes to mapquest.com
# with a default country of USA. You may create your own by editing
# include/custom_functions.php To disable the map link, set _CAL_NOMAP_ to 1.
#############################################################################33

@define("_CAL_NOMAP_", 0);


#######################################
#
# LEAVE THESE ALONE
#
#######################################
define("_CAL_ADMIN_USER_", "admin");
set_magic_quotes_runtime(0);
require_once(@constant("_CAL_BASE_PATH_") ."include/php-compat.php");

