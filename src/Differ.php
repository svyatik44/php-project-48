<?php

namespace Differ\Differ;

use function Parser\parse;
use function Format\Parser\parseFormat;
use function Functional\sort;

function buildTree(array $firstCollection, array $secondCollection): array
{
    $keys = array_unique(array_merge(array_keys($firstCollection), array_keys($secondCollection)));
    $sortedKeys = sort($keys, fn ($left, $right) => $left <=> $right);

    $map = array_map(function ($key) use ($firstCollection, $secondCollection) {
        if (!array_key_exists($key, $firstCollection)) {
            return ['key' => $key, 'value' => $secondCollection[$key], 'type' => '+'];
        }
        if (!array_key_exists($key, $secondCollection)) {
            return ['key' => $key, 'value' => $firstCollection[$key], 'type' => '-'];
        }
        if ($firstCollection[$key] === $secondCollection[$key]) {
            return ['key' => $key, 'value' => $firstCollection[$key], 'type' => 'unchanged'];
        }
        if (is_array($firstCollection[$key]) && is_array($secondCollection[$key])) {
            return ['key' => $key, 'type' => 'array', 'child' =>
            buildTree($firstCollection[$key], $secondCollection[$key])];
        }
        return ['key' => $key, 'oldValue' => $firstCollection[$key],
                'newValue' => $secondCollection[$key], 'type' => '-+'];
    }, $sortedKeys);

    return $map;
}

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    if (!file_exists($pathToFile1)) {
        throw new \Exception("Incorrect path to file: {$pathToFile1}");
    }

    if (!file_exists($pathToFile2)) {
        throw new \Exception("Incorrect path to file: {$pathToFile2}");
    }

    $pathInfo1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $pathInfo2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $data1 = file_get_contents($pathToFile1);
    $data2 = file_get_contents($pathToFile2);

    $firstCollection = parse($data1, $pathInfo1);
    $secondCollection = parse($data2, $pathInfo2);

    $tree = buildTree($firstCollection, $secondCollection);

    $formatedTree = parseFormat($format, $tree);

    return $formatedTree;
}
