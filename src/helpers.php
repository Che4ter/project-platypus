<?php

/**
 * Gets an environment variable (are read by dotenv from the .env file in the root of this project)
 * uses the default on the second parameter if the environment variable doesn't exist.
 * @param varname the name of the environment variable
 * @param default_value the default value if the environment variable doesn't exist.
 * @return the value of the environment variable or the default value
 */

if(!function_exists('env')) {
    function env(string $varname, string $default_value = "") : string {
        $value = getenv($varname);
        return $value === FALSE ? $default_value : $value;
    }
}
