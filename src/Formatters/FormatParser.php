<?php

namespace Format\Parser;

use function Differ\Format\format;
use function Differ\Plain\formats;

function parseFormat(string $format, array $tree)
{
    switch ($format) {
        case 'stylish':
            return format($tree);
                break;
        case 'plain':
            return formats($tree);
                break;
        default:
            throw new Exception("Undefined format type");
                break;
    }
}
