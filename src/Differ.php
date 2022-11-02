<?php

namespace Differ\Differ;

use function Parser\parse;
use function BuildTree\buildTree;
use function Format\Parser\parseFormat;

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'stylish'): string
{
    $firstCollection = parse($pathToFile1);
    $secondCollection = parse($pathToFile2);

    $tree = buildTree($firstCollection, $secondCollection);

    $formatedTree = parseFormat($format, $tree);

    return $formatedTree;
}
