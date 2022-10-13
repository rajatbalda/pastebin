<?php

$botToken = "5792176518:AAF0NqO2sSiHOnUBmAStW4O7lBtrXWrumvE";
$website = "https://api.telegram.org/bot".$botToken;

$request = file_get_contents( 'php://input' );

$request = json_decode( $request, TRUE );

if( !$request )
{
    file_get_contents($website."/sendmessage?chat_id=id&text=novalidjson");
}
elseif( !isset($request['update_id']) || !isset($request['message']) )
{
    file_get_contents($website."/sendmessage?chat_id=id&text=nochat");
}
else
{

    $update_id = $request['update_id'];
		$chat_id = $request['message']['from']['id'];
		$first_name = $request['message']['from']['first_name'];
		$username = $request['message']['from']['username'];
		$text = ucwords($request['message']['text']);
		
if($text == '/start')
		{
			$msg = "Hi ".$first_name."\n\nThis bot will keep you updated with Corona Virus Cases in World\n\n Below commands on how to use bot\nCount - Get Total Count of Cases Globally.\nCountry Name (eg : India) - Get Total Count of Cases of Particular Country.\n\n Follow all Precautionary Measures and Stay Safe";

			file_get_contents($website."/sendmessage?chat_id=".$chat_id."&text=".urlencode($msg));
		}
		elseif($text == "count" || $text == "All" || $text == "all" ||  $text == "COUNT" || $text == "Count" || $text == "Global" || $text == "global" || $text == "World" || $text == "world")
		{
			$countval = file_get_contents('https://api.covid19api.com/summary');
	      		  $indiavalue = json_decode($countval, 1);
	     		  $NewConfirmed = $indiavalue['Global']['NewConfirmed'];
		          $TotalConfirmed = $indiavalue['Global']['TotalConfirmed'];
		          $NewDeaths = $indiavalue['Global']['NewDeaths'];
		          $TotalDeaths = $indiavalue['Global']['TotalDeaths'];
		          $NewRecovered = $indiavalue['Global']['NewRecovered'];
		          $TotalRecovered = $indiavalue['Global']['TotalRecovered'];

		          $creply = "New Confirmed : ".$NewConfirmed."\n";
		          $creply .= "Total Confirmed : ".$TotalConfirmed."\n";
		          $creply .= "New Deaths : ".$NewDeaths."\n";
		          $creply .= "Total Deaths : ".$TotalDeaths."\n";
		          $creply .= "New Recovered : ".$NewRecovered."\n";
		          $creply .= "Total Recovered : ".$TotalRecovered; 
				file_get_contents($website."/sendmessage?chat_id=".$chat_id."&text=".urlencode($creply));
		}
		else
		{
				  $countval = file_get_contents('https://api.covid19api.com/summary');
	      		  $indiavalue = json_decode($countval, TRUE);
	     		 
	      		  if($text == 'USA' || $text == 'Usa' || $text == 'America') { $text = "United States of America"; }
	      		  if($text == 'UK' || $text == 'Uk') { $text = "United Kingdom"; }
	      		  if($text == 'UAE' || $text == 'Uae') { $text = "United Arab Emirates"; }
	      		  if($text == 'UAE' || $text == 'Uae') { $text = "Russian Federation"; }
	      		  
	     		  foreach ($indiavalue['Countries'] as $item) {

	     		 
	     		  	
	     		  	if ($item['Country'] == $text) {

	     		  	

	     		  	$NewConfirmed = $item['NewConfirmed'];
		          $TotalConfirmed = $item['TotalConfirmed'];
		          $NewDeaths = $item['NewDeaths'];
		          $TotalDeaths = $item['TotalDeaths'];
		          $NewRecovered = $item['NewRecovered'];
		          $TotalRecovered = $item['TotalRecovered'];
		          $Date = $item['Date'];

		          $creply = "Below are count of ".$item['Country']."\n\n";
		          $creply .= "New Confirmed : ".$NewConfirmed."\n";
		          $creply .= "Total Confirmed : ".$TotalConfirmed."\n";
		          $creply .= "New Deaths : ".$NewDeaths."\n";
		          $creply .= "Total Deaths : ".$TotalDeaths."\n";
		          $creply .= "New Recovered : ".$NewRecovered."\n";
		          $creply .= "Total Recovered : ".$TotalRecovered."\n\n";
		          $creply .= "Last Updated : ".$Date; 


				file_get_contents($website."/sendmessage?chat_id=".$chat_id."&text=".urlencode($creply));
	     		}  }
		}

}

?>
