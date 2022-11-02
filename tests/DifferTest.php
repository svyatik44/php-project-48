<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGendiff($correct, $file1, $file2, $type = 'stylish'): void
    {
        $expected = file_get_contents($correct);
        $this->assertEquals($expected, genDiff($file1, $file2, $type));
    }

    public function dataProvider(): array
    {
        $path = "tests/fixtures/";
        return [
            ["{$path}CorrectJsonStylish.txt", "{$path}file1.json", "{$path}file2.json"],
            ["{$path}CorrectYamlStylish.txt", "{$path}file1.yml", "{$path}file2.yml"],
            ["{$path}CorrectJsonStylish.txt", "{$path}file1.json", "{$path}file2.json", "stylish"],
            ["{$path}CorrectYamlStylish.txt", "{$path}file1.yml", "{$path}file2.yml", "stylish"],
            ["{$path}CorrectJsonPlain.txt", "{$path}file1.json", "{$path}file2.json", "plain"],
            ["{$path}CorrectYamlPlain.txt", "{$path}file1.yml", "{$path}file2.yml", "plain"],
            ["{$path}CorrectJson.txt", "{$path}file1.json", "{$path}file2.json", "json"],
            ["{$path}CorrectYamlJson.txt", "{$path}file1.yml", "{$path}file2.yml", "json"]
        ];
    }
}
