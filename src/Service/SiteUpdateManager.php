<?php

// src/Service/SiteUpdateManager.php
namespace App\Service;

class SiteUpdateManager
{
    private $adminEmail;
    private $swiftmailer;
    private $twig;

    public function __construct( \Swift_Mailer $swiftmailer, \Twig\Environment $twig, $adminEmail)
    {
        $this->swiftmailer = $swiftmailer;
        $this->adminEmail = $adminEmail;
        $this->twig = $twig;
    }

   public function notifyOfSiteUpdate($info)
    {
        try {

        $message = (new \Swift_Message('Info Email'))
        ->setFrom('rajczyk@gmail.com')
        ->setTo($this->adminEmail)
        ->setBody(
                $this->twig->render(
                'emails/superadmininfo.html.twig',
                ['info' => $info]
            ),
            'text/html'
        );

        $result = $this->swiftmailer->send($message);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}