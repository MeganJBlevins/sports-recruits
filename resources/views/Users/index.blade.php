@if (!empty($errorMessage))
  <error>{{ $errorMessage }}</error>
@else
<h2>There are {{ $teamsInfo["numberOfTeams"] }} teams in this group.</h2>
</hr>
<div class="container">
  @foreach( $teams as $index=>$team)
    <div class="team">
      <h2>Team {{ $index }} List</h2>
      <h3>Total Player Ranking: {{ $team->sum('ranking') }}</h3>
      <p>{{ $team->count()}} players on the team. </p>
      <ul>
        @foreach($team as $player)
          <li class="{{ $player->can_play_goalie ==  '1' ? 'goalie' : ''  }}">{{ $player->fakeName }}</li>
        @endforeach
      </ul>
    </div>
  @endforeach
</div>
@endif
<style>
.container {
  display: flex;
  flex-direction: row;
}
.team {
  flex-basis: 25%;
  max-width: 300px;
  margin: 0 auto;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  padding: 20px 40px;
}
.goalie {
  color: red;
}

</style>
