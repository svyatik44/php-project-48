<?php

namespace Parser;

use function FileReader\readFile;

use Symfony\Component\Yaml\Yaml;

function Parse(string $path): array
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = readFile($path);
    switch ($type) {
        case 'json':
            return json_decode($data, true);
        case 'yml':
        case 'yaml':
            return Yaml::parse($data);
        default:
            throw new \Exception("Unknown path extension");
    }
}
