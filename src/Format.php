<?php

namespace Differ\Format;

function toString(array $arrayValue, int $depth): string
{
    $keys = array_keys($arrayValue);
    $inDepth = $depth + 1;
    $result = array_map(function ($key) use ($arrayValue, $inDepth): string {
        $val = showBool($arrayValue[$key], $inDepth);
        $indent = getIndent($inDepth);
        $result = PHP_EOL . "{$indent}{$key}: {$val}";
        return $result;
    }, $keys);
    return implode('', $result);
}

function showBool($value, $depth)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }

    if (is_array($value)) {
        $result = toString($value, $depth);
        $indent = getIndent($depth);
        $bracketsResult = "{{$result}" . PHP_EOL . "{$indent}}";
        return $bracketsResult;
    }

    return "{$value}";
}

function getIndent($depth)
{
    return str_repeat('    ', $depth);
}

function formatToString($tree, $depth = 0)
{
    $indent = getIndent($depth);
    $nextDepth = $depth + 1;

    $list = array_map(function ($node) use ($indent, $nextDepth) {
        switch ($node['type']) {
            case '+':
                $value = showBool($node['value'], $nextDepth);
                return "{$indent}  + {$node['key']}: {$value}";
                break;
            case '-':
                $value = showBool($node['value'], $nextDepth);
                return "{$indent}  - {$node['key']}: {$value}";
                break;
            case 'unchanged':
                $value = showBool($node['value'], $nextDepth);
                return "{$indent}    {$node['key']}: {$value}";
                break;
            case '-+':
                $newValue = showBool($node['newValue'], $nextDepth);
                $oldValue = showBool($node['oldValue'], $nextDepth);
                return "{$indent}  - {$node['key']}: {$oldValue}" .
                PHP_EOL . "{$indent}  + {$node['key']}: {$newValue}";
            case 'array':
                $stringNested = implode(PHP_EOL, formatToString($node['child'], $nextDepth));
                return "{$indent}    {$node['key']}: {" . PHP_EOL . "{$stringNested}" . PHP_EOL . "{$indent}    }";
                break;
            default:
                print_r("error, default case\n");
                break;
        }
    }, $tree);

    return $list;
}
