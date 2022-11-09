<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGendiffDefault($file1, $file2): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectStylish.txt");
        $this->assertEquals($expected, genDiff($file1, $file2));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGendiffStylish($file1, $file2): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectStylish.txt");
        $this->assertEquals($expected, genDiff($file1, $file2, "stylish"));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGendiffPlain($file1, $file2): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectPlain.txt");
        $this->assertEquals($expected, genDiff($file1, $file2, "plain"));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGendiffJson($file1, $file2): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectJson.txt");
        $this->assertEquals($expected, genDiff($file1, $file2, "json"));
    }

    public function dataProvider(): array
    {
        return [
            ["tests/fixtures/file1.json", "tests/fixtures/file2.json"],
            ["tests/fixtures/file1.yml", "tests/fixtures/file2.yml"],
        ];
    }
}
