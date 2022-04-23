<?php

use Bungle\Exception\BadConfig;

if ( !is_file($filename="../.env") ) {
    throw new BadConfig("No .env file found!");
}

$contents = file_get_contents($filename);

$lines = preg_split("/\n/", $contents);

foreach ($lines as $line) {
    if ( $line ) {
        putenv($line);
    }
}
