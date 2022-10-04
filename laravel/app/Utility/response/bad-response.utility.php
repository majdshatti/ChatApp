<?php

/**
 * Returns failure response.
 *
 * @param array $options can contain failure message and errors list.
 * @param int   $statusCode status code to be gived to the response.
 *
 * @return Response
 */
if (!function_exists("badResponse")) {
    function badResponse(string $message, $errors = [], $statusCode = 400)
    {
        $response["success"] = false;
        $response["message"] = $message;

        /** Check if a list of errors is passed */
        if(count($errors) > 0)
            $response["errors"] = $errors;

        return response($response, $statusCode);
    }
}

?>
