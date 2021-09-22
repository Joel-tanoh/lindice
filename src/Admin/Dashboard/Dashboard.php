<?php

namespace App\Admin\Dashboard;

use App\Model\Post\Announce;
use App\Model\User\Visitor;

/**
 * Classe de gestion du dashboard.
 */
class Dashboard
{
    public static function visitorsOnline() : int
    {
        return Visitor::onlineNumber();
    }

    public static function getCurrentDayVisitorsNumber() : int
    {
        return Visitor::getCurrentDayVisitorsNumber();
    }

    public static function getAllVisitorsNumber() : int
    {
        return Visitor::getAllNumber();
    }

    public static function getAllPostsNumber() : int
    {
        return count(Announce::getAll());
    }

    public static function getPublishedPostsNumber() : int
    {
        return count(Announce::getValidated());
    }

    public static function getPendingPostsNumber() : int
    {
        return count(Announce::getPending());
    }

    public static function getSuspendedPostsNumber() : int
    {
        return count(Announce::getSuspended());
    }

    public static function getCurrentDayPostsNumber() : int
    {
        return count(Announce::getCurrentDayPosts());
    }

}