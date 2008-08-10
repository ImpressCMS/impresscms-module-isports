<?php
/*
******************************************************************************
TPLLeagueStats is a league stats software designed for football (soccer) team.

Copyright (C) 2003  Timo Lepp�nen / TPL Design
email:     info@tpl-design.com
www:       www.tpl-design.com/tplleaguestats

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2of the License,
or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the;
Free Software Foundation,Inc.,
59 Temple Place - Suite 330,
Boston,
MA  02111-1307,
USA.

******************************************************************************
Ported to xoops by 
Mythrandir http://www.web-udvikling.dk
and 
ralf57 http://www.madeinbanzi.it

Cricket League Version & Modifications

* iCricket League Statistics Module
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package	module
* @since		1.0
* @author		vaughan <vaughan@impresscms.org>
* @version	$Id: season.php 1 2008-08-10 14:00:45Z m0nty_ $
******************************************************************************

This is a code that prints a minileaguetable such as
team1 9
team4 8
team9 8
team2 4

FEEL FREE TO MODIFY!!
*/
function b_minitable_show( ) {
    global $xoopsDB;
    $module_handler =& xoops_gethandler('module');
    $module =& $module_handler->getByDirname('cricketstats');
    //Get config for News module
    $config_handler =& xoops_gethandler('config');
    if ($module) {
        $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
    }
    
    //Season id
    $sql = "SELECT SeasonID, SeasonName FROM ".$xoopsDB->prefix("cricket_seasonnames")." WHERE SeasonDefault=1";
    $cricket_seasonname = $xoopsDB->query($sql);
    $cricket_seasonname = $xoopsDB->fetchArray($cricket_seasonname);
    $cricket_season_id = $cricket_seasonname['SeasonID'];
    $cricket_seasonname = $cricket_seasonname['SeasonName'];    
    
    //League id
    $sql2 = "SELECT LeagueID, LeagueName FROM ".$xoopsDB->prefix("cricket_leaguenames")." WHERE LeagueDefault=1";
    $cricket_leaguename = $xoopsDB->query($sql2);
    $cricket_leaguename = $xoopsDB->fetchArray($cricket_leaguename);
    $cricket_league_id = $cricket_leaguename['LeagueID'];
    $cricket_leaguename = $cricket_leaguename['LeagueName'];    

    //For win, draw and lost?
    $cricket_for_win = $moduleConfig['forwin'];
    $cricket_for_draw = $moduleConfig['fordraw'];
    $cricket_for_lose = $moduleConfig['forloss'];
    
    //Query to get teams from selected season & league
    $cricket_get_teams = $xoopsDB->query("SELECT DISTINCT
                        O.OpponentName AS name,
                        O.OpponentID AS id
                        FROM ".$xoopsDB->prefix("cricket_opponents")." O, ".$xoopsDB->prefix("cricket_leaguematches")." LM
                        WHERE LM.LeagueMatchSeasonID = '$cricket_season_id' AND
						LM.LeagueMatchLeagueID = '$cricket_league_id' AND
                        (O.OpponentID = LM.LeagueMatchHomeID OR
                        O.OpponentID = LM.LeagueMatchAwayID)
                        ORDER BY name");
    
    //Lets read teams into the table
    $i = 0;
    while($cricket_data = $xoopsDB->fetchArray($cricket_get_teams))
    {
        $team[$cricket_data['id']]['name'] = $cricket_data['name'];
        $team[$cricket_data['id']]['homewins'] = 0;
        $team[$cricket_data['id']]['awaywins'] = 0;
        $team[$cricket_data['id']]['homeloss'] = 0;
        $team[$cricket_data['id']]['awayloss'] = 0;
        $team[$cricket_data['id']]['hometie'] = 0;
        $team[$cricket_data['id']]['awaytie'] = 0;
        $team[$cricket_data['id']]['homerunsfor'] = 0;
        $team[$cricket_data['id']]['homerunsagainst'] = 0;
        $team[$cricket_data['id']]['awayrunsfor'] = 0;
        $team[$cricket_data['id']]['awayrunsagainst'] = 0;
        $team[$cricket_data['id']]['matches'] = 0;
    }
    
    //Match data
    $query = $xoopsDB->query("SELECT
                                LM.LeagueMatchID AS mid, 
                                LM.LeagueMatchHomeID as homeid,
                                LM.LeagueMatchAwayID as awayid, 
                                LM.LeagueMatchHomeRuns as homeruns,
                                LM.LeagueMatchAwayRuns as awayruns 
                                FROM
                                ".$xoopsDB->prefix("cricket_leaguematches")." LM
                            	WHERE
                                LM.LeagueMatchSeasonID = '$cricket_season_id' AND LM.LeagueMatchLeagueID = '$cricket_league_id' AND
								LM.LeagueMatchHomeRuns IS NOT NULL");
    while ($cricket_matchdata = $xoopsDB->fetchArray($query)) {
        $cricket_hometeam = $cricket_matchdata['homeid'];
        $cricket_awayteam = $cricket_matchdata['awayid'];
        
        $team[$cricket_hometeam]['matches'] = $team[$cricket_hometeam]['matches'] + 1;
        $team[$cricket_awayteam]['matches'] = $team[$cricket_awayteam]['matches'] + 1;
        
        $team[$cricket_hometeam]['homerunsfor'] = $team[$cricket_hometeam]['homerunsfor'] + $cricket_matchdata['homeruns'];
        $team[$cricket_awayteam]['awayrunsagainst'] = $team[$cricket_awayteam]['awayrunsagainst'] + $cricket_matchdata['homeruns'];
        $team[$cricket_awayteam]['awayrunsfor'] = $team[$cricket_awayteam]['awayrunsfor'] + $cricket_matchdata['awayruns'];
        $team[$cricket_hometeam]['homerunsagainst'] = $team[$cricket_hometeam]['homerunsagainst'] + $cricket_matchdata['awayruns'];
        
        $rundiff = $cricket_matchdata['homeruns'] - $cricket_matchdata['awayruns'];
        if ($rundiff > 0) {
            $team[$cricket_hometeam]['homewins'] = $team[$cricket_hometeam]['homewins'] + 1;
            $team[$cricket_awayteam]['awayloss'] = $team[$cricket_awayteam]['awayloss'] + 1;
        }
        elseif ($rundiff == 0) {
            $team[$cricket_hometeam]['hometie'] = $team[$cricket_hometeam]['hometie'] + 1;
            $team[$cricket_awayteam]['awaytie'] = $team[$cricket_awayteam]['awaytie'] + 1;
        }
        elseif ($rundiff < 0) {
            $team[$cricket_hometeam]['homeloss'] = $team[$cricket_hometeam]['homeloss'] + 1;
            $team[$cricket_awayteam]['awaywins'] = $team[$cricket_awayteam]['awaywins'] + 1;
        }
    }
    $cricket_get_deduct = $xoopsDB->query("SELECT points, teamid FROM ".$xoopsDB->prefix("cricket_deductedpoints")." WHERE seasonid = '$cricket_season_id' AND leagueid = '$cricket_league_id'");
    while ($cricket_d_points = $xoopsDB->fetchArray($cricket_get_deduct)) {
        $team[$cricket_d_points["teamid"]]['d_points'] = $cricket_d_points['points'];
    }
    foreach ($team as $teamid => $thisteam) {
        $temp_points = isset($thisteam['d_points']) ? $thisteam['d_points'] : 0;
        $cricket_points[$teamid] = ($thisteam['homewins'] * $cricket_for_win) + ($thisteam['awaywins'] * $cricket_for_win) + ($thisteam['hometie'] * $cricket_for_draw) + ($thisteam['awaytie'] * $cricket_for_draw) + $temp_points;
        $cricket_runsfor[$teamid] = $thisteam['homerunsfor'] + $thisteam['awayrunsfor'];
        $cricket_runsagainst[$teamid] = $thisteam['homerunsagainst'] + $thisteam['awayrunsagainst'];
    }
    array_multisort($cricket_points, SORT_NUMERIC, SORT_DESC, $cricket_runsfor, SORT_NUMERIC, SORT_DESC, $cricket_runsagainst, SORT_NUMERIC, SORT_DESC, $team, SORT_STRING, SORT_ASC);
    
    //Print the table
    $block['title'] = _BL_CRICK_MINITABLE;
    $block['content'] = "<table width='100%' cellspacing='2' cellpadding='2' border='0'>
     <tr>
     <td width='50%' align='left'><span style='font-size: 10px; font-weight: bold;'><u>"._BL_CRICK_TEAM."</u></span></td>
     <td width='15%' align='center'><span style='font-size: 10px; font-weight: bold;'><u>"._BL_CRICK_POINTS."</u></span></td>
     <td width='35%' align='center'><span style='font-size: 10px; font-weight: bold;'><u>"._BL_CRICK_RUNS."</u></span></td> 
 </tr></table><marquee behavior='scroll' direction='up' width='100%' height='100' scrollamount='1' scrolldelay='60' onmouseover='this.stop()' onmouseout='this.start()'><table width='100%' cellspacing='2' cellpadding='2' border='0'>";
    foreach ($team as $teamid => $thisteam)
    {
        $block['content'] .= "<tr>
        <td width='50%' align='left'><span style='font-size: 10px; font-weight: normal;'>".$thisteam['name']."</span></td>
        <td width='15%' align='center'><span style='font-size: 10px; font-weight: normal;'>".$cricket_points[$teamid]."</span></td>
        <td width='35%' align='center'><span style='font-size: 10px; font-weight: normal;'>".$cricket_runsfor[$teamid]."-".$cricket_runsagainst[$teamid]."</span></td>
        </tr>";
    }
    $block['content'] .= "</table><br><div align=\"center\"><a href=\"".XOOPS_URL."/modules/cricketstats/index.php\">"._BL_CRICK_GOTOMAIN."</a></div></marquee>";
    return $block;
}


?>