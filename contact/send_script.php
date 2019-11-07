<?php

// configure
$from = 'unioneseternas.com@gmail.com';
$sendTo = 'unioneseternas.com@gmail.com';
$fields = array('name' => 'Nombre', 'whatsapp' => 'Whatsapp', 'country' => 'País', 'message' => 'Mensaje'); // array variable name => Text to appear in the email
$okMessage = 'El mensaje se envió correctamente, te contactaré lo mas pronto posible';
$errorMessage = 'Ocurrió un error enviando el mensaje, si lo deseas puedes contactarme directamente';

// let's do the sending

try
{
    $emailText = nl2br("Tienes un nuevo mensaje del formulario de contacto\n");
    $subject = 'Nuevo mensaje de ' + $fields['name'] +  ' en unioneseternas.com';

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= nl2br("$fields[$key]: $value\n");
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage, 'exception' => $e);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
