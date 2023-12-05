<?php
function is_formPost($server): bool
{
    // var_dump($server);

    if ($server['REQUEST_METHOD'] === 'POST') {
        if (
            isset($server['HTTP_CONTENT_TYPE']) &&
            ($server['HTTP_CONTENT_TYPE'] === 'application/x-www-form-urlencoded' ||
                $server['HTTP_CONTENT_TYPE'] === 'multipart/form-data')
        ) {
            // Form submission detected
            return true;
        } else {
            // Likely an API request made using Fetch or AJAX
            return false;
        }
    }

    return false;
}
