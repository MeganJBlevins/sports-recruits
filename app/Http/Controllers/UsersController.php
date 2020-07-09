<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller 
{
  public function index() 
  {
    // okay, I'm going to create an array of teams with players in each team.

    //init array
    $teams = [];

    //get all users that are players from the users table
    $users = User::where('user_type' ,'=' ,'player')->get();


    //Split players into an even number of teams
    // each team should have between 18 - 22 players
    //setting team size initial value
    $teamSize = 0;
    // setting number of teams initial value
    $numberOfTeams = 0;
    // setting extra team members initial value (stragglers/remainders)
    $extraTeamMembers = 0;

    $teamsInfo = User::getEvenTeams($users);

    // before I divvy up the teams I'm going to pop out the best goalies to divvy up
    $bestGoalies = User::getBestGoalies($teamsInfo['numberOfTeams']);
    $goalieIds = $bestGoalies->pluck('id');


    $nonGoalies = User::whereNotIn('id', $goalieIds)->where('user_type' ,'=' ,'player')->orderBy('ranking')->get();
    // this splits the players into even teams, but doesn't do anything with remainders
    // $teams = $nonGoalies->split($numberOfTeams);  <- won't sort them into average teams

    // set teams collections to use below
    for($i=1; $i <= $teamsInfo["numberOfTeams"]; $i++){
      $teams[$i] = collect();
    }
    // init faker for fun names
    $faker = \Faker\Factory::create();

    // iterate through the collection and divvy to the teams
    $x = 1;
    $count = $nonGoalies->count();
    for($i=1; $i <= $count; $i++) {
      $lastPlayer = $nonGoalies->pop();
      // add fake name to object
      $lastPlayer->fakeName = $faker->name;
      $teams[$x]->push($lastPlayer);
      if($x < $teamsInfo["numberOfTeams"]){
        $x++;
      }else {
        $x = 1;
      }
    }
    // throw those goalies back in
    for($i=1; $i<=$teamsInfo["numberOfTeams"]; $i++){
      $goalie = $bestGoalies->pop();
      $goalie->fakeName = $faker->name;
      $teams[$i]->push($goalie);
    }



    return view('Users.index', compact('teams', 'teamsInfo'));
  }
}