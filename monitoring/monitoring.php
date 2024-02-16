<?php 
function register_shutdown_function_callback() {
    $error = error_get_last();
    var_dump($error);
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $message = "Произошла критическая ошибка:\n";
        $message .= "Сообщение: " . $error['message'] . "\n";
        $message .= "Файл: " . $error['file'] . "\n";
        $message .= "Строка: " . $error['line'] . "\n";

        $toEmail = "***";
        $subject = "Critical Error";

        @mail($toEmail, $subject, $message);
    }
}

register_shutdown_function('register_shutdown_function_callback');

?>