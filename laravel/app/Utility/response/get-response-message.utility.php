<?php

use Illuminate\Support\Str;

/**
 * Get a response messages by a keyword
 *
 * @param string $keyword
 * @param array $options (optional parameter) for providing dynamic values
 *
 * @return string response message
 */
if (!function_exists("getResMessage")) {
    function getResMessage(string $keyword, $options = [])
    {
        // Path, value and field can be provided as a dynamic word
        $path = $options["path"] ?? ""; // Example: User, Quiz, Subject
        $value = $options["value"] ?? ""; // Example: Majd, +963935722313, https://...
        $field = $options["field"] ?? ""; // Example: name, createdAt, slug

        switch($keyword){
            case "addContact":
                return ($value ?? "value") . " is added to your contact list";
            case "authenticate":
                return "Unauthenticated to access this route";
            case "creds":
                return "invalid credentials";
            case "deleted":
                return ($path ?? "path") . " is deleted successfully";
            case "notExist":
                return ($value ?? "value") . " does not exist";
            case "notUnique":
                return ($path ?? "path") .
                    " with the same ". ($field ?? "field") ." already exists";
            case "registered":
                return "account is registered successfully";
            case "selfAddContact":
                return "you can't add yourself to your contact list!";
        }
    }
}

?>
