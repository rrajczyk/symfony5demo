<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('userAvatar', [$this, 'userAvatar']),
            new TwigFunction('eventPhoto1', [$this, 'eventPhoto1']),
            new TwigFunction('eventLastCommentUser', [$this, 'eventLastCommentUser']),
            new TwigFunction('eventCommentUser', [$this, 'eventCommentUser']),
            new TwigFunction('eventCommentPhoto', [$this, 'eventCommentPhoto']),
            new TwigFunction('logLink', [$this, 'logLink']),
            new TwigFunction('eventPhone', [$this, 'eventPhone']),
        ];
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function userAvatar($user)
    {
        $imagePath = '/images/avatar.jpg';

        if ($user->getAvatarFilename()) {
            $imagePath = '/uploads/photos/' . $user->getAvatarFilename();
        }

        return $imagePath;
    }

    public function eventPhoto1($event)
    {
        $imagePath = '/images/nophoto.png';

        if ($event->getPhoto1Filename()) {
            $imagePath = '/uploads/photos/' . $event->getPhoto1Filename();
        }

        return $imagePath;
    }

    public function eventLastCommentUser($event)
    {
        $imagePath = '/images/avatar.jpg';

        if ($event->getLastCommentUser()) {
            if ($event->getLastCommentUser()->getAvatarFilename()) {
                $imagePath = '/uploads/photos/' . $event->getLastCommentUser()->getAvatarFilename();
            }
        }

        return $imagePath;
    }

    public function eventCommentUser($eventComment)
    {
        $imagePath = '/images/avatar.jpg';

        if ($eventComment->getUser()) {
            if ($eventComment->getUser()->getAvatarFilename()) {
                $imagePath = '/uploads/photos/' . $eventComment->getUser()->getAvatarFilename();
            }
        }

        return $imagePath;
    }

    public function eventCommentPhoto($eventComment)
    {
        $imagePath = '/images/nophoto.png';

        if ($eventComment->getPhoto1Filename()) {
            $imagePath = '/uploads/photos/' . $eventComment->getPhoto1Filename();
        }

        return $imagePath;
    }

    public function logLink($actionName, $actionValue, $actionTitle)
    {
        $link = $actionTitle;

        if ($actionName != 'login') {
            $link = '<a href="';

            if ($actionName == 'superadmin') {
                $link .= '/superadmin/home';
                $link .= '" class="nodecoration"><span class="btn btn-dark ">';
            } elseif ($actionName == 'admin') {
                $link .= '/admin/home';
                $link .= '" class="nodecoration"><span class="btn btn-dark ">';
            } elseif ($actionName == 'conservator') {
                $link .= '/superadmin/conservators/conservatordetails/'. $actionValue;
                $link .= '" class="nodecoration"><span class="btn btn-dark ">';
            } elseif ($actionName == 'event') {
                $link .= '/event/event/'.$actionValue.'/main';
                $link .= '" class="nodecoration"><span class="btn btn-dark ">';
            }


            $link .= $actionTitle;

            $link .= '</span></a>';

        }

        return $link;
    }

    public function eventPhone($event)
    {
       $phoneStr = '';

        if ($event->getUser()->getPhone()) {
            $phoneStr = $event->getUser()->getPhone();
        }

        if ($event->getPhone()) {
            $phoneStr = $event->getPhone();
        }

        return $phoneStr;
    }
}
