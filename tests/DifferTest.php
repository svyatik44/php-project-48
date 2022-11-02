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
        return [
            ["tests/fixtures/CorrectJsonStylish.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json"],
            ["tests/fixtures/CorrectYamlStylish.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml"],
            ["tests/fixtures/CorrectJsonStylish.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "stylish"],
            ["tests/fixtures/CorrectYamlStylish.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "stylish"],
            ["tests/fixtures/CorrectJsonPlain.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "plain"],
            ["tests/fixtures/CorrectYamlPlain.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "plain"],
            ["tests/fixtures/CorrectJson.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "json"],
            ["tests/fixtures/CorrectYamlJson.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "json"],
        ];
    }
}
