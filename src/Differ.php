<?php

namespace Differ\Differ;

use function Parser\parse;
use function BuildTree\buildTree;
use function Format\Parser\parseFormat;

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
