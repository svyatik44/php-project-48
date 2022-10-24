<?php

namespace Format\Plain;

function formatToPlain($tree, $path = '')
{
    $result = array_map(function ($node) use ($path) {
        $property = "{$path}{$node['key']}";
        switch ($node['type']) {
            case '+':
                $value = showValue($node['value']);
                return "Property '{$property}' was added with value: {$value}";
                break;
            case '-':
                return "Property '{$property}' was removed";
                break;
            case 'unchanged':
                return '';
                break;
            case '-+':
                $oldValue = showValue($node['oldValue']);
                $newValue = showValue($node['newValue']);
                return "Property '{$property}' was updated. From {$oldValue} to {$newValue}";
            case 'array':
                $path2 = "{$path}{$node['key']}.";
                return implode(PHP_EOL, formatToPlain($node['child'], $path2));
                break;
            default:
                print_r("error, default case\n");
                break;
        }
    }, $tree);
    return array_filter($result);
}

function format(array $data): string
{
    $lines = formatToPlain($data);
    $str = implode(PHP_EOL, $lines);
    return $str;
}

function showValue($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    if (is_array($value)) {
        return '[complex value]';
    }
    return "'{$value}'";
}