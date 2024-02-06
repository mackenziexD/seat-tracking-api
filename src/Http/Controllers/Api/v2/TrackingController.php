<?php

namespace Helious\SeatTrackingAPI\Http\Controllers\Api\v2;

use Seat\Api\Http\Traits\Filterable;
use Illuminate\Http\Resources\Json\Resource;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TrackingController extends ApiController
{

    use Filterable;

    public function __construct()
    {

    }

    /**
     * Gets the list of all characters  in corp that have been AFK longer than 3 months.
     *
     * @return \Illuminate\Http\Response
     */
    public function AFK(Request $request)
    {
        $corporation = CorporationInfo::where('corporation_id', 2014367342)->get();
        $characters = $corporation->members;

        $afk_characters = [];
        foreach ($characters as $character) {
            $last_login = $character->info->last_login;
            $last_login = new \DateTime($last_login);
            $now = new \DateTime();
            $interval = $last_login->diff($now);
            if ($interval->m >= 3) {
                $afk_characters[] = $character;
            }
        }

        return Resource::collection($afk_characters);
    }

    /**
     * Gets the list of all characters in corp that have no refresh token hence will be called "Orphans".
     *
     * @return \Illuminate\Http\Response
     */
    public function Orphans(Request $request){
        $corporation = CorporationInfo::where('corporation_id', 2014367342)->get();
        $characters = $corporation->characters;

        $orphans = [];
        foreach ($characters as $character) {
            if (is_null($character->refresh_token)) $orphans[] = $character;
        }

        return Resource::collection($orphans);
    }

}
