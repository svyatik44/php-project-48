<?php

namespace Parser;

use Symfony\Component\Yaml\Yaml;

use function FileReader\readFile;

function parse(string $data, string $type): array
{
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
