<?php

namespace Eud\ToolBundle\Debug;

/**
 * Just a stupid class for sending or echoing message while debuging
 */
class Message
{
    public static function sendMail($message)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('debug mail')
        ->setFrom('debug@mail.com')
        ->setTo('denis.baudouin@gmail.com')
        ->setBody($message);

        $transport = \Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        $mailer = \Swift_Mailer::newInstance($transport);

        $result = $mailer->send($message);

        if ($result === 0) {
            throw RuntimeException("auristenuaritenuarstie");
        }
    }

    public static function alert($message)
    {
        $str = '<script type="text/javascript">';
        $str .= 'alert("' . $message . '");';
        $str .= '</script>';

        echo $str;
    }

    public static function error($message)
    {
        throw new \Exception($message);
    }
}