<?php

function parseSyntax($syntax) {
    // Initialize an empty array to hold the parsed instructions
    $instructions = array();

    // Split the syntax into an array of tokens
    $tokens = preg_split('/[\s,()]+/', $syntax, -1, PREG_SPLIT_NO_EMPTY);

    // Get the type of instruction
    $type = array_shift($tokens);
    $instructions['type'] = $type;

    // Initialize an empty array to hold the instruction parameters
    $params = array();

    // Loop through the tokens
    while (!empty($tokens)) {
        // Get the next token
        $token = array_shift($tokens);

// Check if the token is a key
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $token) && !empty($tokens) && $tokens[0] == ':') {
            // Remove the colon
            array_shift($tokens);

            // Get the value of the key-value pair
            $value = array_shift($tokens);

            // Check if the value is a string
            if (preg_match('/^["\'].*["\']$/', $value)) {
                // Strip the quotes from the string value
                $value = substr($value, 1, -1);
            }

            // Add the key-value pair to the instruction parameters
            $params[$token] = $value;
        } else {
            // The token is not a key-value pair.
            // Check if the token is a value for the previous key.
            $last_key = array_key_last($params);
            if ($last_key !== NULL) {
                // The token is a value for the previous key.
                // Add it to the instruction parameters as an array.
                $params[$last_key] = array($params[$last_key], $token);
            } else {
                // The token is not a value for the previous key.
                // Add it as a separate element to the instruction parameters.
                $params[] = $token;
            }
        }

    }

    // Add the instruction parameters to the instructions array
    $instructions['_'] = $params;

    // Return the parsed instructions
    return $instructions;
}

$syntax = 'equals(1, 2)';
$instructions = parseSyntax($syntax);
print_r($instructions);

$syntax = 'equals(1, get("foo"))';
$instructions = parseSyntax($syntax);
print_r($instructions);

$syntax = 'invoke(namespace: "std", method: "print", continue_on_error: false, params: {"value":"Hello World","second_value":{"type":"get","_":"foo"}})';
$instructions = parseSyntax($syntax);
print_r($instructions);
