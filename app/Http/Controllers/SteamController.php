<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SteamController extends Controller
{

    
    public function getFriends(string $key, string $username){
        //client setup
        $client = new Client(['base_uri' => ('http://api.steampowered.com'),
            'headers' => [
                
            ]
        ]);
        
        //get ID from username
        $userID = 0;
        try{
            $res = $client->request('GET', '/ISteamUser/ResolveVanityURL/v0001/?key='.$key.'&vanityurl='.$username);
            $userIdObj = json_decode($res->getBody()->getcontents(), true);
            //check to see if user exists
            if(isset($userIdObj['response']['steamid'])){
                $userID = $userIdObj['response']['steamid'];
            }else{
                return null;
            }
        }catch(RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        //get friends from id
        $friendsIdArray;
        try{
            $res = $client->request('GET', '/ISteamUser/GetFriendList/v0001/?key='.$key.'&steamid='.$userID.'&relationship=friend');
            //echo $res->getBody()->getContents();
            $friendsIdArrayObj =  json_decode($res->getBody()->getcontents(), true);
            $friendsIdArray = $friendsIdArrayObj["friendslist"]["friends"];
            //var_dump($friendsIdArray);
        }catch(RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        //group into strings of csvs of 100 for more efficient fetching from steam
        $idListArray = array();
        $count=0;
        $currIdList = "";
        foreach($friendsIdArray as $currentFriend){
            $count++;
            $currIdList = $currIdList."".$currentFriend['steamid'].',';
            if($count == 100){
                $count = 0;
                array_push($idListArray, $currIdList);
                $currIdList="";
            }
        }
        if(sizeof($friendsIdArray) <= 100){
            array_push($idListArray, $currIdList);
        }

        //get friends nicknames and user names from ids
        $friendsArray = array();
        foreach ($idListArray as $friendIdString){
            try{
                $res = $client->request('GET', '/ISteamUser/GetPlayerSummaries/v0002/?key='.$key.'&steamids=friend'.$friendIdString);
                //echo $res->getBody()->getContents();
                $friendsArray +=  json_decode($res->getBody()->getcontents(), true);
            }catch(RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
        }
        return $friendsArray;
    }

    //this just manages the submit from the form on the submit page 76561197997820614
    public function submit(Request $request){
        $this->validate($request, ['username' => 'required|max:255']);
        $friendData = self::getFriends('9409B45C1C332E7BB1E09CA60105DDA5', $request['username']);
        $friendData = $friendData['response']['players'];
        return view('home')->with(['friendsData'=> $friendData]);
    }

}
