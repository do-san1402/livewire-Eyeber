<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class PostManService
{

    /**
     * send email
     *
     * @param  string $view mail-content
     * @param  string $email 
     * @param  string $to_name
     * @param  string $subject
     * @param  string $html
     * @param  bool $use_bcc
     * @return void
     */
    public static function sendEmail($view, $email, $to_name, $subject, $html, $use_bcc, $cc, $name)
    {
        Mail::send($view, ['html' => $html, 'name' => $name], function ($m) use ($email, $to_name, $subject, $use_bcc, $cc, $name) {
            $m->to($email)->bcc($use_bcc)->cc($cc)->subject($subject);
        });
    }

    /**
     * send email
     *
     * @param  string $view mail-content
     * @param  string $email 
     * @param  string $to_name
     * @param  string $subject
     * @param  bool $use_bcc
     * @return void
     */
    public static function sendEmailGetCode($view, $email, $subject,$code)
    {
        Mail::send($view, ['name' => $email, 'code' => $code], function ($m) use ($email, $subject) {
            $m->to($email)->subject($subject);
        });
    }
}