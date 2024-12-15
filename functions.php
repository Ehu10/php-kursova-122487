<?php
function debug($data, $exit = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    
    if($exit) {
        exit;
    };

}

function get_user() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    }
    return null;
}

function flash($message, $type = 'success') {
    $_SESSION['flash'] = [
        'message' => [
            'text' => $message,
            'type' => $type
        ]
    ];
}
?>
