<?php

namespace Differ\Differ;

use Symfony\Component\Yaml\Yaml;

use function Parser\Parse;
use function BuildTree\buildTree;

function toString($array)
{
    $res = "";
    foreach ($array as $value) {
        $res .= $value;
    }
    return "{\n$res}";
}

function showBool($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } else {
        return $value;
    }
}

function gendiff(string $pathToFile1, string $pathToFile2)
{
    $firstArray = Parse(pathinfo($pathToFile1, PATHINFO_EXTENSION), file_get_contents($pathToFile1));
    $secondArray = Parse(pathinfo($pathToFile2, PATHINFO_EXTENSION), file_get_contents($pathToFile2));

    $tree = buildTree($firstArray, $secondArray);

    $list = array_map(function ($node) {
        switch ($node['type']) {
            case '+':
                $value = showBool($node['value']);
                return "  + {$node['key']}: {$value}\n";
                break;
            case '-':
                $value = showBool($node['value']);
                return "  - {$node['key']}: {$value}\n";
                break;
            case 'unchanged':
                $value = showBool($node['value']);
                return "    {$node['key']}: {$value}\n";
                break;
            case '-+':
                $newValue = showBool($node['newValue']);
                $oldValue = showBool($node['oldValue']);
                return "  - {$node['key']}: {$oldValue}\n  + {$node['key']}: {$newValue}\n";
            default:
                print_r("error, default case\n");
                break;
        }
    }, $tree);

    $result = toString($list);
    return $result;
}
