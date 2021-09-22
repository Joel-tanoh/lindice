<?php

namespace App\Communication\Notify;

use App\Communication\MailSender;
use App\Model\User\Administrator;

/**
 * Permet de faire des notifications au utilisateurs par email.
 */
class NotifyByMail extends Notify
{
    /**
     * Permet de notifier les administrateurs d'une information.
     * 
     * @param string $subject Le sujet du mail.
     * @param string $content Le contenu du mail.
     * 
     * @param string 
     */
    public static function administrators(string $subject, string $content)
    {
        if ((new MailSender(
                Administrator::getEmailAddresses(),
                $subject,
                $content
            )
        )->send()) {
            return true;
        }
    }

    /**
     * Envoie un mail à tous les inscrits.
     * 
     * @return bool
     */
    public static function registered($emailAddresses, string $subject, string $content)
    {
        self::users($emailAddresses, $subject, $content);
    }

    /**
     * Permet de notifier plusieurs utilisateurs.
     * 
     * @param array|string $emailAddresses La liste des adresses email en chaîne de caractère
     *                                     ou en tableau.
     * @param string $subject              Le sujet du mail.
     * @param string $content              Le contenu du mail.
     */
    public static function users($emailAddresses, string $subject, string $content)
    {
        if ((new MailSender($emailAddresses, $subject, $content))->send()) {
            return true;
        }
    }

    /**
     * Permet de notifier un utilisateur précis.
     * 
     * @param string $emailAddress L'adresse email de l'utilisateur qui doit recevoir
     *                             la notification.
     * @param string $subject      Le sujet du mail.
     * @param string $content      Le contenu du mail.
     * 
     * @return bool
     */
    public static function user(string $emailAddress, string $subject, string $content)
    {
        if ((new MailSender($emailAddress, $subject, $content))->send()) {
            return true;
        }
    }
}