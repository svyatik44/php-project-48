<?php

namespace Parser;

use Symfony\Component\Yaml\Yaml;

function Parse(string $type, string $data): array
{
    switch ($type) {
        case 'json':
            return (array)json_decode($data);
        case 'yml':
        case 'yaml':
            return Yaml::parse($data);
        default:
            print_r("Unknown path extension");
            break;
    }
}
