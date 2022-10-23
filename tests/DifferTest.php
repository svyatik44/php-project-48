<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\gendiff;

class DifferTest extends TestCase
{
    public function testGendiff(): void
    {
        $expected = file_get_contents("tests/fixtures/CorrectDiffer.txt");
        $this->assertEquals($expected, gendiff("tests/fixtures/file1.json", "tests/fixtures/file2.json", "stylish"));

        $expected2 = file_get_contents("tests/fixtures/CorrectDifferYaml.txt");
        $this->assertEquals($expected2, gendiff("tests/fixtures/file1.yml", "tests/fixtures/file2.yml", "stylish"));

        $expected3 = file_get_contents("tests/fixtures/CorrectDifferPlain.txt");
        $this->assertEquals($expected3, gendiff("tests/fixtures/file1.json", "tests/fixtures/file2.json", "plain"));
    }
}
