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
            ["tests/fixtures/CorrectDifferJsonToStylish.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json"],
            ["tests/fixtures/CorrectDifferYamlToStylish.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml"],
            ["tests/fixtures/CorrectDifferJsonToStylish.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "stylish"],
            ["tests/fixtures/CorrectDifferYamlToStylish.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "stylish"],
            ["tests/fixtures/CorrectDifferJsonToPlain.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "plain"],
            ["tests/fixtures/CorrectDifferYamlToPlain.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "plain"],
            ["tests/fixtures/CorrectDifferJson.txt", "tests/fixtures/file1.json", "tests/fixtures/file2.json", "json"],
            ["tests/fixtures/CorrectDifferYamlToJson.txt", "tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "json"],
        ];
    }
}
