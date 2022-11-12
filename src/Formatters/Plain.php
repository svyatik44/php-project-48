<?php

namespace Format\Plain;

function formatToPlain(array $tree, string $path = ''): array
{
    $result = array_map(function ($node) use ($path) {
        $property = "{$path}{$node['key']}";
        switch ($node['type']) {
            case '+':
                $value = showValue($node['value']);
                return "Property '{$property}' was added with value: {$value}";
            case '-':
                return "Property '{$property}' was removed";
            case 'unchanged':
                return '';
            case '-+':
                $oldValue = showValue($node['oldValue']);
                $newValue = showValue($node['newValue']);
                return "Property '{$property}' was updated. From {$oldValue} to {$newValue}";
            case 'array':
                $path2 = "{$path}{$node['key']}.";
                return implode(PHP_EOL, formatToPlain($node['child'], $path2));
            default:
                throw new \Exception("error, default case");
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

function showValue(mixed $value): string
{
    if (is_numeric($value)) {
        return "{$value}";
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_array($value)) {
        return '[complex value]';
    }
    return "'{$value}'";
}
