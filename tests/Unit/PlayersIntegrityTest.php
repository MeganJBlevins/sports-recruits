<?php

namespace Tests\Unit;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use App\User;

class PlayersIntegrityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGoaliePlayersExist () 
    {
/*
		Check there are players that have can_play_goalie set as 1   
*/
		$result = User::where('user_type', 'player')->where('can_play_goalie', 1)->count();
        $this->assertTrue($result > 1);
	
    }

    public function testAtLeastOneGoaliePlayerPerTeam () 
    {
        //get the players
        $players = User::where('user_type' ,'=' ,'player')->get();
        //get the teams info 
        $teamsGroups = User::getEvenTeams($players);
        // set number of teams variable becdause we'll use it more than once and it's long... and I don't want to type it out that many times.
        $numberOfTeams = $teamsGroups["numberOfTeams"];
        // get the goalies
        $bestGoalies = User::getBestGoalies($numberOfTeams);
        // best goalies returns the same number of goalies as teams even if there are more. But never less. 
        $this->assertTrue($bestGoalies->count() == $numberOfTeams);
/*
	    calculate how many teams can be made so that there is an even number of teams and they each have between 18-22 players.
	    Then check that there are at least as many players who can play goalie as there are teams
*/

    }
}
