<?php
/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 04/02/17
 * Time: 7:50 PM
 */
 
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_NAME', 'tutortutee');
 
define('USER_CREATED', 0);
define('USERNAME_ALREADY_EXIST', 1);
define('EMAIL_ALREADY_EXIST', 2);
define('USER_NOT_CREATED', 3);

define('EMAIL_SENT', 4);
define('EMAIL_NOT_FOUND', 5);

define('USER_FOUND', 6);
define('USER_NOT_FOUND', 7);
define('INCORRECT_PW', 8);
define('INACTIVATE_USER', 9);
define('USER_NOT_VERIFIED', 10);

define('USER_UPDATED', 11);
define('USER_NOT_UPDATED', 12);

define('SESSION_CREATED', 13);
define('SESSION_NOT_CREATED', 14);
define('SESSION_EXISTED', 15);

define('SESSION_BOOKED', 16);
define('SESSION_NOT_BOOKED', 17);
define('SESSION_NOT_AVAILABLE', 18);
define('SESSION_NOT_FOUND', 19);

define('SESSION_DELETED', 20);
define('SESSION_NOT_EXIST', 21);
?>