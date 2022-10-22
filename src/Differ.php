<?php

namespace Differ\Differ;

use Symfony\Component\Yaml\Yaml;

use function Parser\Parse;
use function BuildTree\buildTree;
use function Differ\Format\formatToString;

function gendiff(string $pathToFile1, string $pathToFile2)
{
    $firstArray = Parse(pathinfo($pathToFile1, PATHINFO_EXTENSION), file_get_contents($pathToFile1));
    $secondArray = Parse(pathinfo($pathToFile2, PATHINFO_EXTENSION), file_get_contents($pathToFile2));

    $tree = buildTree($firstArray, $secondArray);

    $list = formatToString($tree);
    $result = "{" . PHP_EOL . implode(PHP_EOL, $list) . PHP_EOL . "}";

    return $result;
}
