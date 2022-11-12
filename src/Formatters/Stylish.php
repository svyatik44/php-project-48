<?php

namespace Format\Stylish;

function toString(array $arrayValue, int $depth): string
{
    $keys = array_keys($arrayValue);
    $inDepth = $depth + 1;
    $result = array_map(function ($key) use ($arrayValue, $inDepth): string {
        $val = showValue($arrayValue[$key], $inDepth);
        $indent = getIndent($inDepth);
        $result = PHP_EOL . "{$indent}{$key}: {$val}";
        return $result;
    }, $keys);
    return implode('', $result);
}

function showValue(mixed $value, int $depth): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
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

function getIndent(int $depth): string
{
    return str_repeat('    ', $depth);
}

function formatToStylish(array $tree, int $depth = 0): array
{
    $indent = getIndent($depth);
    $nextDepth = $depth + 1;

    $list = array_map(function ($node) use ($indent, $nextDepth) {
        switch ($node['type']) {
            case '+':
                $value = showValue($node['value'], $nextDepth);
                return "{$indent}  + {$node['key']}: {$value}";
            case '-':
                $value = showValue($node['value'], $nextDepth);
                return "{$indent}  - {$node['key']}: {$value}";
            case 'unchanged':
                $value = showValue($node['value'], $nextDepth);
                return "{$indent}    {$node['key']}: {$value}";
            case '-+':
                $newValue = showValue($node['newValue'], $nextDepth);
                $oldValue = showValue($node['oldValue'], $nextDepth);
                return "{$indent}  - {$node['key']}: {$oldValue}" .
                PHP_EOL . "{$indent}  + {$node['key']}: {$newValue}";
            case 'array':
                $stringNested = implode(PHP_EOL, formatToStylish($node['child'], $nextDepth));
                return "{$indent}    {$node['key']}: {" . PHP_EOL . "{$stringNested}" . PHP_EOL . "{$indent}    }";
            default:
                throw new \Exception("error, default case");
        }
    }, $tree);
    return $list;
}

function format(array $formatedTree): string
{
    $implodeIndent = implode(PHP_EOL, formatToStylish($formatedTree));
    return "{" . PHP_EOL . $implodeIndent . PHP_EOL . "}";
}
