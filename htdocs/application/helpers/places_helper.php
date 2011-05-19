<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function query_places($q=NULL)
{
    if ( ! $q)
    {
        return FALSE;
    }
    
    require ('sphinxapi.php');
    
    $cl = new SphinxClient();
    $mode = SPH_MATCH_PHRASE;
    $host = 'localhost';
    $port = 9312;
    $index = '*';
    $sortby = '@weight DESC, area_rank DESC';
    $limit = 10;
    $ranker = SPH_RANK_PROXIMITY_BM25;
    
    
    ////////////
    // do query
    ////////////
    
    $cl->SetServer($host, $port);
    $cl->SetConnectTimeout(1);
    $cl->SetArrayResult(TRUE);
    $cl->SetWeights(array(100, 1));
    $cl->SetMatchMode($mode);
    if ($sortby)
    {
        $cl->SetSortMode(SPH_SORT_EXTENDED, $sortby);
    }
    if ($limit)
    {
        $cl->SetLimits(0, $limit, ( $limit>1000 ) ? $limit : 1000);
    }
    $cl->SetRankingMode($ranker);
    $res = $cl->Query($q, $index);
    
    
    //////////////////
    // return results
    //////////////////
    $places = array();
    
    if ($res===FALSE)
    {
        $places[] = 'Query failed: ' . $cl->GetLastError() . ".\n";
    }
    else
    {  
      	if (isset($res['matches']))
      	{
            foreach ($res['matches'] as $docinfo)
            {
              	$places[$docinfo['id']] = $docinfo['attrs']['name'];
              	if ($docinfo['attrs']['admin1'])
              	{
                    $places[$docinfo['id']] .= ', '.$docinfo['attrs']['admin1'];
              	}
              	if ($docinfo['attrs']['country'])
              	{
                    $places[$docinfo['id']] .= ', '.$docinfo['attrs']['country'];
              	}
            }
        }
      	return $places;
    }
}