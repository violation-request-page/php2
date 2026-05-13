<?php
// Alternet method to find server IP
$ip = file_get_contents('https://api.ipify.org');
echo "My Server IP is: " . $ip;
?>
