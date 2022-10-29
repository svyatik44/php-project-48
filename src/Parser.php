<?php

namespace Parser;

use Symfony\Component\Yaml\Yaml;

function Parse(string $type, string $data): array
{
    switch ($type) {
        case 'json':
            return json_decode($data, true);
        case 'yml':
        case 'yaml':
            return Yaml::parse($data);
        default:
            throw new Exception("Unknown path extension");
    }
}
