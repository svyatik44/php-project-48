<?php

namespace Differ\Differ;

function buildTree(array $firstArray, array $secondArray)
{
    $keys = array_unique(array_merge(array_keys($firstArray), array_keys($secondArray)));
    sort($keys);
    $map = array_map(function ($key) use ($firstArray, $secondArray) {
        if (!array_key_exists($key, $firstArray)) {
            return ['key' => $key, 'value' => $secondArray[$key], 'type' => '+'];
        }
        if (!array_key_exists($key, $secondArray)) {
            return ['key' => $key, 'value' => $firstArray[$key], 'type' => '-'];
        }
        if ($firstArray[$key] == $secondArray[$key]) {
            return ['key' => $key, 'value'=> $firstArray[$key], 'type' => 'unchanged'];
        }
        return ['key' => $key, 'oldValue' => $firstArray[$key],
                'newValue' => $secondArray[$key], 'type' => '-+'];
    }, $keys);

    return $map;
}

function toString($array)
{
    $res = "";
    foreach ($array as $value) {
        $res .= $value;
    }
    return $res;
}

function gendiff(string $pathToFile1, string $pathToFile2)
{
    $decode1 = json_decode(file_get_contents($pathToFile1));
    $decode2 = json_decode(file_get_contents($pathToFile2));

    $firstArray = (array)$decode1;
    $secondArray = (array)$decode2;

    $tree = buildTree($firstArray, $secondArray);

    $list = array_map(function($node) {
        switch ($node['type']) {
            case '+':
                return "  + {$node['key']} : {$node['value']}\n";
                break;
            case '-':
                return "  - {$node['key']} : {$node['value']}\n";
                break;
            case 'unchanged':
                return "    {$node['key']} : {$node['value']}\n";
                break;
            case '-+':
                return "  - {$node['key']} : {$node['oldValue']}\n  + {$node['key']} : {$node['newValue']}\n";
            default:
                print_r("error, default case\n");
                break;
        }
    }, $tree);
    $string = toString($list);
    $result = "{\n$string}\n";
    return $result;
}
