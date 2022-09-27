<?php

namespace Parser;

use Symfony\Component\Yaml\Yaml;

function Parse(string $type, string $data)
{
    switch ($type) {
        case 'yaml' || 'yml':
            return Yaml::parse($data);
                break;
    
        case 'json':
            return (array)json_decode($data);
                break;
    
        default:
            throw new Exception("Unknown path extension");
                break;
    }
}
