<?php

namespace Differ\Differ;

use function Parser\Parse;
use function BuildTree\buildTree;
use function Format\Parser\parseFormat;

function gendiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $firstArray = Parse(pathinfo($pathToFile1, PATHINFO_EXTENSION), file_get_contents($pathToFile1));
    $secondArray = Parse(pathinfo($pathToFile2, PATHINFO_EXTENSION), file_get_contents($pathToFile2));

    $tree = buildTree($firstArray, $secondArray);

    $formatedTree = parseFormat($format, $tree);

    return $formatedTree;
}
