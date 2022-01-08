<?php

namespace App\Framework;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class Mailing
{
    public function sendEmailtoAdmin($bodyVar)
    {

        $result = '';
    
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mail/mailadmin.html');

        foreach($bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
    
        try
        {
            $transport = Transport::fromDsn('smtp://74f3b81336c24e:16b9b2f1f4e485@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login');
    
            $mailer = new Mailer($transport);
            $newEmail = (new Email())
            ->from('coucou@gmail.com')
            ->to('nico13sanna@gmail.com')
            ->priority(Email::PRIORITY_HIGHEST)
            ->subject('Demande de validation de compte utilisateur')
            ->html($template);
    
            $mailer->send($newEmail);
        }
    
        catch(\Exception $e)
        {
                $result = 'Erreur d\'envoi du message';
        }
        return $result;
    }
}
