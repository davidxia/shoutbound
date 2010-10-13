<?php

function json_error($message) {
    echo json_encode(array('success' => 0, 'message' => $message));
}

function json_success($array) {
    echo json_encode(array_merge(array('success' => 1), $array));
}

