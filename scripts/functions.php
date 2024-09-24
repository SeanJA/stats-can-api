<?php


function stripAccents($str)
{
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function normalizeDescription(?string $description): string
{
    if (empty($description)) {
        $description = 'NONE';
    }
    $description = stripAccents($description);
    $description = strtoupper(str_replace('=', ' equals ', $description));
    $description = strtoupper(str_replace([' ', '.', '/', '-'], '_', $description));

    $description = preg_replace('/[^A-Z\d_]/', '', $description);
    if (is_numeric($description[0])) {
        $description = '_' . $description;
    }

    $description = preg_replace('/(_{2,})/', '_', $description);

    return $description;
}

function buildCase($input, $value): string
{
    return '    case ' . $input . ' = ' . $value . ';' . PHP_EOL;
}