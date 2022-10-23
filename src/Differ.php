<?php

namespace Differ\Differ;

use Symfony\Component\Yaml\Yaml;

use function Parser\Parse;
use function BuildTree\buildTree;
use function Differ\Format\formatToString;
use function Format\Parser\parseFormat;

function gendiff(string $pathToFile1, string $pathToFile2, string $format)
{
    $firstArray = Parse(pathinfo($pathToFile1, PATHINFO_EXTENSION), file_get_contents($pathToFile1));
    $secondArray = Parse(pathinfo($pathToFile2, PATHINFO_EXTENSION), file_get_contents($pathToFile2));

    $tree = buildTree($firstArray, $secondArray);

    $formatedTree = parseFormat($format, $tree);

    return $formatedTree;
}
