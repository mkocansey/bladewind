<?php

const DEFAULT_BLADEWIND_COLOUR = 'primary';
const ACCEPTED_BLADEWIND_COLOURS = [
    'primary',
    'blue',
    'red',
    'yellow',
    'green',
    'orange',
    'purple',
    'cyan',
    'pink',
    'gray',
    'black',
    'violet',
    'indigo',
    'fuchsia'
];
const ACCEPTED_BLADEWIND_ASPECT_RATIOS = [
    'null',
    'NaN',
    '16:9',
    '4:3',
    '2:3',
    '1:1',
];

function isValidBladewindColour($colour): bool
{
    return in_array($colour, ACCEPTED_BLADEWIND_COLOURS);
}

function isValidAspectRatio($ratio): bool
{
    return in_array($ratio, ACCEPTED_BLADEWIND_ASPECT_RATIOS);
}

function defaultBladewindColour($colour, $default = DEFAULT_BLADEWIND_COLOUR): string
{
    if (!isValidBladewindColour($colour)) {
        return $default;
    }
    return $colour;
}

function parseBladewindVariable($variable, $parse_as = 'bool')
{
    switch ($parse_as) {
        case 'str':
        case 'string':
            return filter_var($variable, FILTER_SANITIZE_STRING);
        case 'int':
            return filter_var($variable, FILTER_VALIDATE_INT);
        case 'bool':
        case 'boolean':
            return filter_var($variable, FILTER_VALIDATE_BOOLEAN);
        default:
            return $variable;
    }
}

function defaultBladewindName($prefix = 'blwd_'): string
{
    return parseBladewindName(uniqid($prefix));
}

function parseBladewindName($name): string
{
    return preg_replace('/[\s-]/', '_', $name);
}

function formatJsonForChart($json): string
{
    $output = json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return preg_replace_callback('/"JS::(.*?)"/s', fn($m) => $m[1], $output);
}

function paginationRow($row_number, $pageSize = 25, $defaultPage = 1): string
{
    $row_id = uniqid();
    $row_page = ($row_number < $pageSize) ? 1 : ceil($row_number / $pageSize);
    return sprintf("data-id=%s data-page=%s class=%s", $row_id, $row_page, ($row_page != $defaultPage ? 'hidden' : ''));
}

function pagination_row($row_number, $pageSize = 25, $defaultPage = 1): string
{
    return paginationRow($row_number, $pageSize, $defaultPage);
}