<?php

// Email address verification
function isEmail($email) {
    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

if($_POST) {
    
    $clientName = trim($_POST['InputName']);
    $clientEmail = trim($_POST['InputEmail']);
    $message = trim($_POST['InputMessage']);

    $array = array('nameMessage' => '', 'emailMessage' => '', 'messageMessage' => '',);

    if($clientName == '') {
        $array['nameMessage'] = 'Digite seu nome.';
    }

    if(!isEmail($clientEmail)) {
        $array['emailMessage'] = 'Por favor insira um endereço de e-mail válido.';
    }

    if($message == '') {
        $array['messageMessage'] = 'Digite sua mensagem';
    }

    if($clientName != '' && isEmail($clientEmail) && $message != '') {
        // Send email
        
        include_once "lib/swift_required.php";

        $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
        $transport->setUsername('azure_7015ba9fc2913232a71ece53502fe839@azure.com');
        $transport->setPassword('c8PV69PvvjtdbtS');
        $swift = Swift_Mailer::newInstance($transport);
        
        $mail = new Swift_Message('Nova mensagem recebida');
        $from = array($clientEmail => 'Rodrigo Kamimura');
        $to = array('Kamimura.mil@gmail.com'=>'Rodrigo Kamimura');

        $body = "<html>
                    <head><meta charset=\"utf-8\"></head>
                <body><div style=\"font-family: 'Helvetica Neue',Helvetica,Arial;font-size: 13px\">
                <h1>Você recebeu uma nova mensagem</h1>
                <b>Nome:</b>&nbsp;" .  $clientName . "<br/>
                <b>Email:</b>&nbsp;" . $clientEmail . "<br/>
                <h3>Mensagem</h3>" . $message . "
                </div></body></html>";
        
        $mail->setFrom($from);
        $mail->setBody($body, 'text/html');
        $mail->setTo($to);
        $swift->send($mail);
    }

    echo json_encode($array);
}

?>
