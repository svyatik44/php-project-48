<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGendiffStylish(): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectDifferJsonTree.txt");
        $this->assertEquals($expected, genDiff("tests/fixtures/file1.json", "tests/fixtures/file2.json", "stylish"));
    }

    public function testGendiffYaml(): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectDifferYaml.txt");
        $this->assertEquals($expected, genDiff("tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "stylish"));
    }

    public function testGendiffPlain(): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectDifferPlain.txt");
        $this->assertEquals($expected, genDiff("tests/fixtures/file1.json", "tests/fixtures/file2.json", "plain"));
    }

    public function testGendiffJson(): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectDifferJson.txt");
        $this->assertEquals($expected, genDiff("tests/fixtures/file1.json", "tests/fixtures/file2.json", "json"));
    }
}
