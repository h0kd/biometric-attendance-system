<?php

$texto = "wiwi";

$nombreArchivo = "instructivo.txt";

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

echo $texto;

?>