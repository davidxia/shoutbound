<?php

function json_error($message) {
    echo json_encode(array('success' => 0, 'message' => $message));
}
