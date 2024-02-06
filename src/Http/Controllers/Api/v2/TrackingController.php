<?php

namespace Helious\SeatTrackingAPI\Http\Controllers\Api\v2;

use Seat\Api\Http\Traits\Filterable;
use Seat\Eveapi\Models\Corporation\CorporationMemberTracking;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function AFK(Request $request)
    {
        $corporation = CorporationMemberTracking::where('corporation_id', 2014367342)->get();

        $afk_characters = [];
        foreach ($corporation as $character) {
            $last_login = $character->logon_date;
            $last_login = new \DateTime($last_login);
            $now = new \DateTime();
            $interval = $last_login->diff($now);
            if ($interval->m >= 3) {
                $location = $this->getLocation($character);
                $afk_characters[] = [
                    "name" => $character->character->name,
                    "last_login" => $last_login->format('Y-m-d H:i:s'),
                    "ship" => $character->ship->typeName,
                    "location" => $location,
                    "afk_time" => $interval->m . " months " . $interval->d . " days " . $interval->h . " hours " . $interval->i . " minutes"
                ];
            }
        }

        return response()->json($afk_characters);
    }

    /**
     * Gets the list of all characters in corp that have no refresh token hence will be called "Orphans".
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function Orphans(Request $request){
        $corporation = CorporationMemberTracking::where('corporation_id', 2014367342)->get();
        $orphans = [];
        foreach ($corporation as $character) {
            if ($character->refresh_token == null) {
                $location = $this->getLocation($character);
                $orphans[] = [
                    "name" => $character->character->name,
                    "ship" => $character->ship->typeName,
                    "location" => $location,
                ];
            }
        }
        return response()->json($orphans);
    }

    /**
     * Gets the location of a character by parsing the location object.
     * 
     * @param $character
     * @return string
     */
    protected function getLocation($character) {
        $location = $character->location;
        if (is_array($location)) {
            $location = (object) $location;
        }

        if (isset($location->system_id)) {
            // system but no station som undocked in space
            return $location->name . " **UNDOCKED**";
        } elseif (isset($location->structure_id)) {
            // system with a played station
            return $location->name;
        } elseif (isset($location->stationName)) {
            // npc station
            return $location->stationName;
        } else {
            // no idea where tf they are
            return "Unknown Station/Structure";
        }
    }

}
