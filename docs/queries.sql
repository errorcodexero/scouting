SELECT t1.name, t2.salary
  FROM employee AS t1 INNER JOIN info AS t2 ON t1.name = t2.name;

select CompetitionID from competitionteams;

select competitionteams.CompetitionID, teams.Name
from competitionteams
INNER JOIN teams
ON competitionteams.TeamNumber = teams.Number;

select * from teams 
where EXISTS (SELECT * FROM competitionteams
                WHERE TeamNumber = team.Number);

---------------------------------------------------------------------------
select * from teams 
INNER JOIN competitionteams
ON (competitionteams.CompetitionID = 10 and 
    competitionteams.TeamNumber = teams.Number)
order by Number;
---------------------------------------------------------------------------
Select matches

    public $match->Time;
    public $match->Number;
    public $RedAlliance;
    public $BlueAlliance;
    public $match->Round;

$red->
    $red->Color;
    $red->TeamOne;
    $red->TeamTwo;
    $red->TeamThree;

select matches.*, alliances.* from alliances
INNER JOIN matches
ON (matches.CompetitionID = 4 and 
    alliances.MatchID = matches.ID)
order by matches.Number;

---------------------------------------------------------------------------
select count(*) from competitionteams where competitionid = 10;


drop table competitionteams
drop table competition
drop table teams
