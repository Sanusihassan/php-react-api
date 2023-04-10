<?php
function send_json($data)
{
    if (isset($data)) {
        header("Content-Type: application/json");
        $res = json_encode($data);
        echo $res;
    }
}
