<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public static function getEvenTeams($users) {
        $count = count($users);
        // starting with just two teams and going from there
        for ($x = 2; $x < $count; $x += 2) {
            // check what the size is
            $teamSize = $count / $x;
            // check if the teams are less than 22 players and more than 18
            if ($teamSize > 22){
                continue;
            } else if ($teamSize < 22 && $teamSize > 18) {      
                $numberOfTeams = $x;  
                break;
            } else {
            // In this hypothetical world you created, we should never hit this.
                return false;
            }
        }
        return ["teamSize"=>$teamSize, "numberOfTeams"=>$numberOfTeams];
    }

    public static function getBestGoalies($numberOfTeams){
        $bestGoalies = User::all()->where('can_play_goalie', '=', 1)->sortBy('ranking')->take($numberOfTeams);
        return $bestGoalies;
    }
}
