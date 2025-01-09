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

function isValidBladewindColour($colour): bool
{
    return in_array($colour, ACCEPTED_BLADEWIND_COLOURS);
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
    return str_replace('-', '_', $name);
}