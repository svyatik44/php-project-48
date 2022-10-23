<?php

namespace Format\Parser;

use Format\Stylish;
use Format\Plain;
use Format\Json;

function parseFormat(string $format, array $tree)
{
    switch ($format) {
        case 'stylish':
            return Stylish\format($tree);
        case 'plain':
            return Plain\format($tree);
        case 'json':
            return Json\format($tree);
        default:
            throw new Exception("Undefined format type");
                break;
    }
}
