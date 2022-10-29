<?php

namespace FileReader;

function readFile(string $path): string
{
    if (0 == filesize($path)) {
        throw new \Exception("empty file");
    }
    if (!file_exists($path)) {
        throw new \Exception("Incorrect path to file: {$path}");
    }
    return file_get_contents($path);
}
