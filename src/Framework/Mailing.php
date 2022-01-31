<?php

namespace App\Framework;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class Mailing
{
    const EMAIL_HOST = "smtp.mailtrap.io";
    const EMAIL_PORT = 2525;
    const EMAIL_USERNAME = '74f3b81336c24e';
    const EMAIL_PASSWORD = '16b9b2f1f4e485';

    private $transport;

    public function __construct()
    {
        $this->transport = Transport::fromDsn('smtp://'.self::EMAIL_USERNAME.':'.self::EMAIL_PASSWORD.'@'.self::EMAIL_HOST.':'.self::EMAIL_PORT.'?encryption=tls&auth_mode=login');
    }

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
    
            $mailer = new Mailer($this->transport);
            $newEmail = (new Email())
            ->from($bodyVar['email'])
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

    public function sendEmailForgetPassword($bodyVar)
    {
        $result = '';
    
        $template = file_get_contents(TEMPLATE_DIR . '/' . 'mail/mailforgetpassword.html');

        foreach($bodyVar as $key => $value)
        {
            $template = str_replace("{{". $key ."}}", $value, $template);
        }
    
        try
        {
    
            $mailer = new Mailer($this->transport);
            $newEmail = (new Email())
            ->from($bodyVar['email'])
            ->to($bodyVar['email'])
            ->priority(Email::PRIORITY_HIGHEST)
            ->subject('Demande de réinitialisation de mot de passe')
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
