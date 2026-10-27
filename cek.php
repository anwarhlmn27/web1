<?php

echo "<h2>PHP Extension Check</h2>";

echo "PDO: ";
var_dump(extension_loaded('PDO'));

echo "<br>PDO MySQL: ";
var_dump(extension_loaded('pdo_mysql'));

echo "<br>PDO Drivers: ";
print_r(PDO::getAvailableDrivers());