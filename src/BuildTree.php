<?php

namespace BuildTree;

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
        if ($firstArray[$key] === $secondArray[$key]) {
            return ['key' => $key, 'value' => $firstArray[$key], 'type' => 'unchanged'];
        }
        if (is_array($firstArray[$key]) && is_array($secondArray[$key])) {
            return ['key' => $key, 'type' => 'array', 'child' => buildTree($firstArray[$key], $secondArray[$key])];
        }
        return ['key' => $key, 'oldValue' => $firstArray[$key],
                'newValue' => $secondArray[$key], 'type' => '-+'];
    }, $keys);

    return $map;
}
