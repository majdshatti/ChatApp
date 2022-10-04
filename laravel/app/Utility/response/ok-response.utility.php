<?php

/**
 * Returns success response with a payload of message and/or data and/or token.
 *
 * @param array $options can contain the keys of message, data and token.
 * @param int   $statusCode status code to be gived to the response.
 *
 * @return Response
 */
if (!function_exists("okResponse")) {
    function okResponse($options, $statusCode = 200)
    {
        $response["success"] = true;

        /** Set response body */
        if (isset($options["data"])) {
            $response["data"] = $options["data"];
        }

        /** Message could by brought from getResMessage utitliy function or manually */
        if (isset($options["keyMessage"])) {
            $response["message"] = getResMessage($options["keyMessage"]);
        } elseif(isset($options["message"])) {
            $response["message"] = $options["message"];
        }

        if (isset($options["token"])) {
            $response["token"] = $options["token"];
        }

        return response($response, $statusCode);
    }
}

?>
