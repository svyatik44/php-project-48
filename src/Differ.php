<?php

namespace Differ\Differ;

use function Parser\Parse;
use function BuildTree\buildTree;
use function Format\Parser\parseFormat;

function gendiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $firstArray = Parse($pathToFile1);
    $secondArray = Parse($pathToFile2);

    $tree = buildTree($firstArray, $secondArray);

    $formatedTree = parseFormat($format, $tree);

    return $formatedTree;
}
