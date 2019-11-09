<?php
$start_time = microtime(true);

if(isset($_GET['id']) && $_GET['id'] != ""){
                $video_id = $_GET['id'];
        $result = getcurl(getVideoId($video_id));
}else{
                $result = getcurl('HCqFbvm2n9o');
//die('<h2>video id not provided</h2>');
        }

function getVideoId($videoUrl)
        {
                $videoId = $videoUrl;
                $urlPart = parse_url($videoUrl);
                $path = $urlPart['path'];
                if (isset($urlPart['host']) && strtolower($urlPart['host']) == 'youtu.be') {
                        if (preg_match('/\/([^\/\?]*)/i', $path, $temp))
                                $videoId = $temp[1];
                } else {
                        if (preg_match('/\/embed\/([^\/\?]*)/i', $path, $temp))
                                $videoId = $temp[1];
                        elseif (preg_match('/\/v\/([^\/\?]*)/i', $path, $temp))
                                $videoId = $temp[1];
                        elseif (preg_match('/\/watch/i', $path, $temp) && isset($urlPart['query']))
                        {
                                //$query = $this->decodeString($urlPart['query']);
                                parse_str($urlPart['query'],$query);
                                $videoId = $query['v'];
                        }
                }

                return $videoId;
	}

function getcurl($vid) {
// watch page
if(($vid == '') || ($vid == NULL) || ($vid === false))
die(" no id provided ");
else
{

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.youtube.com/watch?v='.$vid.'&pbj=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'X-Youtube-Sts: 18130';
$headers[] = 'Dnt: 1';
$headers[] = 'X-Youtube-Page-Label: youtube.ytfe.desktop_20190822_3_RC0';
$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux aarch64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/75.0.3770.90 Chrome/75.0.3770.90 Safari/537.36';
$headers[] = 'X-Youtube-Variants-Checksum: 5d6b5504effaaf770b0272e57723851e';
$headers[] = 'X-Youtube-Page-Cl: 264817801';
$headers[] = 'X-Spf-Referer: https://www.youtube.com/feed/trending';
$headers[] = 'X-Youtube-Utc-Offset: 330';
$headers[] = 'X-Youtube-Client-Name: 1';
$headers[] = 'X-Spf-Previous: https://www.youtube.com/feed/trending';
$headers[] = 'Referer: https://www.youtube.com/feed/trending';
$headers[] = 'X-Youtube-Client-Version: 2.20190823.03.00';
$headers[] = 'X-Youtube-Ad-Signals: dt=1566719752217&flash=0&frm&u_tz=330&u_his=4&u_java&u_h=1080&u_w=2440&u_ah=1008&u_aw=2440&u_cd=24&u_nplug=2&u_nmime=2&bc=31&bih=863&biw=1393&brdim=0%2C60%2C0%2C60%2C2440%2C31%2C2440%2C979%2C1408%2C863&vis=1&wgl=true&ca_type=image&bid=ANyPxKrUI2wSwQHx0_UZCAqATsq_VdPJ1daYgDbHnYNRUwEpGuDP5T8fOt6AiORQNquhagYpG5TVhWcV8M_jqbQmMkaxOrPtXg';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
return $result;
}
}


function printArray($a) {
  if(is_array($a)){
    echo '<table border="1">';
    foreach ($a as $key => $value) {
      echo '<tr><td>'.htmlspecialchars(" $key : ").'<td>';
      if (is_array($value)) {
        printArray($value);
      } else {
        echo htmlspecialchars($value) . '<br />';
      }
    }
    echo '</table>';
  }
  else echo ' It is not array ';
}

function response($array){
if(($data == NULL) || ($data === NULL))
	{
		die(' Invalid data supplied ');
	}
	else
	{
		if(is_array($data))
		{

$response = $array[3]['response'];

$response_contents = $response['contents']['twoColumnWatchNextResults'];
/*
* results
/	results
/		contents
/			* 0 + videoPrimaryInfoRenderer
/			* 1 + videoSecondaryInfoRenderer 
/			* 2 + itemSectionRenderer + continuations + 0 + nextContinuationData *1 continuation *2 clickTrackingParams *3 label + runs + 0 + text
* secondaryResults 
/	secondaryResults
/		* results
/		* continuations + 0 + 0 + nextContinuationData *1 continuation *2 clickTrackingParams *3 label+runs+0+text
		
*/
$result = $response_contents['results']['results']['contents'];
echo '<img src="https://i.ytimg.com/vi/'.$_GET['id'].'/maxresdefault.jpg">';
$videoprimaryinfo = $result[0]['videoPrimaryInfoRenderer'];

if(array_key_exists('superTitleLink',$videoprimaryinfo)){
	$titletag = $videoprimaryinfo['superTitleLink']['runs'];
	for($i = 0;$i<count($titletag);$i++){
		if(array_key_exists('navigationEndpoint',$titletag[$i])){
			echo '<a href="'.$titletag[$i]['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'];
			echo '">';	//.$titletag[$i]['navigationEndpoint']['searchEndpoint']['query'];
			echo $titletag[$i]['text'].'</a>';
		}
		else
		echo $titletag[$i]['text'];
	}
}

echo '<br>'.$videoprimaryinfo['title']['runs'][0]['text'];
echo '<br>'.$videoprimaryinfo['viewCount']['videoViewCountRenderer']['shortViewCount']['simpleText'];
echo '<hr>'.$videoprimaryinfo['viewCount']['videoViewCountRenderer']['viewCount']['simpleText'];
echo '<br>'.$videoprimaryinfo['dateText']['simpleText'];
echo '<br>'.$videoprimaryinfo['sentimentBar']['sentimentBarRenderer']['tooltip'];
echo '<br>';


$menu = $videoprimaryinfo['videoActions']['menuRenderer'];
$toplbtn = $menu['topLevelButtons'];
for($i=0;$i<count($toplbtn);$i++){
if(array_key_exists('toggleButtonRenderer',$toplbtn[$i])){
echo $toplbtn[$i]['toggleButtonRenderer']['defaultText']['simpleText'].'<br>'; // like & dislike
}
else
echo $toplbtn[$i]['buttonRenderer']['text']['runs'][0]['text'].'<br>';
}
echo $menu['items'][0]['menuNavigationItemRenderer']['text']['runs'][0]['text'];

if(array_key_exists('badges',$videoprimaryinfo)){
$badges = $videoprimaryinfo['badges'];
for($i = 0;$i<count($badges);$i++){
echo $badges[$i]['metadataBadgeRenderer']['label'];
}       }
echo '<hr>';

$videosecondaryinfo = $result[1]['videoSecondaryInfoRenderer'];
$channel = $videosecondaryinfo['owner']['videoOwnerRenderer'];
echo '<br><img src="'.$channel['thumbnail']['thumbnails'][1]['url'].'"/>';
echo '<a href="'.$channel['title']['runs'][0]['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'].'">';
echo $channel['title']['runs'][0]['text'].'</a><br>';
echo $channel['subscriberCountText']['runs'][0]['text'];
echo '<br>';
if(array_key_exists('badges',$channel)){
	$badges = $channel['badges'];
	for($i = 0;$i<count($badges);$i++){
		echo $badges[$i]['metadataBadgeRenderer']['tooltip'];
		echo '<br>';
	}
}
echo '<hr>';

$description = $videosecondaryinfo['description']['runs'];
for($i = 0;$i<count($description);$i++){
	if(array_key_exists('navigationEndpoint',$description[$i])){
		echo '<a href="'.$description[$i]['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'];
		echo '">'.$description[$i]['text'].'</a><br>';
	}
	else
	echo $description[$i]['text'].'<br>';
}
echo '<hr>';

$metadata = $videosecondaryinfo['metadataRowContainer']['metadataRowContainerRenderer']['rows'];
for($i=0;$i<count($metadata);$i++){
	if(array_key_exists('metadataRowRenderer',$metadata[$i])){
		echo '<br>'.$metadata[$i]['metadataRowRenderer']['title']['simpleText'];
		if(array_key_exists('runs',$metadata[$i]['metadataRowRenderer']['contents'][0])){
			echo '<br><a href="'.$metadata[$i]['metadataRowRenderer']['contents'][0]['runs'][0]['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'];
			echo '">'.$metadata[$i]['metadataRowRenderer']['contents'][0]['runs'][0]['text'];
			echo '</a><br>'.$metadata[$i]['metadataRowRenderer']['hasDividerLine'];
		}
		else
		echo '<br>'.$metadata[$i]['metadataRowRenderer']['contents'][0]['simpleText'];
	}
	else
	{
		if(array_key_exists('runs',$metadata[$i]['metadataRowHeaderRenderer']['content'])){
			echo '<a href="'.$metadata[$i]['metadataRowHeaderRenderer']['content']['runs'][0]['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'];
			echo '">'.$metadata[$i]['metadataRowHeaderRenderer']['content']['runs'][0]['text'];
			echo '</a>';
		}
		else
		echo '<br>'.$metadata[$i]['metadataRowHeaderRenderer']['content']['simpleText'];
		echo '<br>'.$metadata[$i]['metadataRowHeaderRenderer']['hasDividerLine'];
	}
}

function comment_continue($array){
$result = $array[2]['itemSectionRenderer']['continuations'][0]['nextContinuationData'];
return $result['continuation'];
return $result['clickTrackingParams'];
return $result['label'];
}
echo '<hr>';

$secondaryresult = $response_contents['secondaryResults']['secondaryResults'];
$secondaryresult = $secondaryresult['results'];
for($i=0;$i<count($secondaryresult);$i++){
	if(array_key_exists('compactAutoplayRenderer', $secondaryresult[$i])){
		$videorenderer = $secondaryresult[$i]['compactAutoplayRenderer']['contents'][0]['compactVideoRenderer'];
		echo '<br>'.$videorenderer['videoId'];
		echo '<br><img src="'.$videorenderer['thumbnail']['thumbnails'][1]['url'].'"/>';
		echo '<br>'.$videorenderer['title']['simpleText'];
		echo '<br>'.$videorenderer['viewCountText']['simpleText'];
		echo '<br>'.$videorenderer['lengthText']['simpleText'];
		echo '<br><a href="'.$videorenderer['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'].'">';
		echo $videorenderer['shortBylineText']['runs'][0]['text'];
		echo '</a><br>'.$videorenderer['badges'][0]['metadataBadgeRenderer']['label'];
		if(array_key_exists('runs',$videorenderer['shortViewCountText'])){
			echo '<br>'.$videorenderer['shortViewCountText']['runs'][0]['text'];
			echo $videorenderer['shortViewCountText']['runs'][1]['text'];
		}
		else
		echo '<br>'.$videorenderer['shortViewCountText']['simpleText'];
		if(array_key_exists('movingThumbnailDetails', $videorenderer['richThumbnail']['movingThumbnailRenderer'])){
			echo '<br><img src="'.$videorenderer['richThumbnail']['movingThumbnailRenderer']['movingThumbnailDetails']['thumbnails'][0]['url'].'"/>';
		}
		echo '<hr>';
	}
	else
	{
		$videorenderer = $secondaryresult[$i]['compactVideoRenderer'];
		echo '<br>'.$videorenderer['videoId'];
		echo '<br><img src="'.$videorenderer['thumbnail']['thumbnails'][1]['url'].'"/>';
		echo '<br>'.$videorenderer['title']['simpleText'];
		echo '<br>'.$videorenderer['viewCountText']['simpleText'];
		echo '<br>'.$videorenderer['lengthText']['simpleText'];
		echo '<br><a href="'.$videorenderer['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'].'">';
		echo $videorenderer['shortBylineText']['runs'][0]['text'];
		echo '</a><br>'.$videorenderer['badges'][0]['metadataBadgeRenderer']['label'];
		if(array_key_exists('runs',$videorenderer['shortViewCountText'])){
			echo '<br>'.$videorenderer['shortViewCountText']['runs'][0]['text'];
			echo $videorenderer['shortViewCountText']['runs'][1]['text'];
		}
		else
		echo '<br>'.$videorenderer['shortViewCountText']['simpleText'];
		if(array_key_exists('movingThumbnailDetails', $videorenderer['richThumbnail']['movingThumbnailRenderer'])){
			echo '<br><img src="'.$videorenderer['richThumbnail']['movingThumbnailRenderer']['movingThumbnailDetails']['thumbnails'][0]['url'].'"/>';
		}
		echo '<hr>';
	}
}

$result = $array[3]['response'];
echo '<br>'.$result['playerOverlays']['playerOverlayRenderer']['endScreen']['watchNextEndScreenRenderer']['title']['runs'][0]['text'];
$endScreenVideo = $result['playerOverlays']['playerOverlayRenderer']['endScreen']['watchNextEndScreenRenderer']['results']; // & title
for($i=0;$i<count($endScreenVideo);$i++){
$endscr = $endScreenVideo[$i]['endScreenVideoRenderer'];
echo '<div><br>'.$endscr['videoId'];
echo '<br><img src="'.$endscr['thumbnail']['thumbnails'][1]['url'];
echo '"/><br>'.$endscr['title']['simpleText'];
echo '<br>'.$endscr['shortBylineText']['runs'][0]['text'];
echo '<br>'.$endscr['lengthText']['simpleText'];
echo '<br><a href="'.$endscr['navigationEndpoint']['commandMetadata']['webCommandMetadata']['url'].'"> '.$endscr['videoId'].'</a>';
echo '<br>'.$endscr['shortViewCountText']['simpleText'];
echo '<br>'.$endscr['publishedTimeText']['simpleText'];
echo '</div><hr>';
}

return $result;
}
}
}

printArray(response(json_decode($result, true)));
//print_r($result);
//print_r(get_defined_functions());
$end_time = microtime(true);

echo 'Execution time (ms) : ';
echo $end_time - $start_time;
?>
