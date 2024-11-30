<?php
if ($_SERVER["SERVER_NAME"] == '172.19.3.23') {
    $dbhost = '172.19.3.23';
    $dbuser = 'ivanova.ya.d';
    $dbpassword = '3227';
    $database = 'ivanova.ya.d';

  } else {
    $dbhost = 'localhost';
    $dbuser = 'demo';
    $dbpassword = 'demo';
    $database = 'demo';
  }
