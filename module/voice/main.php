<?php
global $Event, $Queue, $Text;

require_once 'AipSpeech.php';
loadModule('credit.tools');

$aid = config('bd_app_id');
$akey = config('bd_api_key');
$atok = config('bd_api_token');
$credit = strlen($Text);
if(getCredit($Event['user_id'])-($credit*0.25)<=0){
	$Queue[]= sendBack("金币不足！请使用%checkin签到获取金币");
}else{

$client = new AipSpeech($aid, $akey, $atok);


$hash = $Event['message_id'];
setCache($hash.'.txt', removeCQCode(removeEmoji($Text)));
$result = $client->synthesis(file_get_contents("C:/BotQQ/kjbot/storage/cache/{$hash}.txt"), 'zh', 1, array(
    'vol' => 5,
	'pit' => 6,
	'spd' => 6,
));
if(!is_array($result)){
    file_put_contents("C:/BotQQ/kjbot/storage/cache/{$hash}.mp3", $result);
}


clearstatcache();
decCredit($Event['user_id'],floor(($credit)*0.25));
$Queue[]= sendBack(sendRec(getCache($hash.'.mp3')));
$Queue[]= sendBack('合成成功！长度'.$credit.'字节，扣取'.floor(($credit)*0.25) .'金币. 你还有'.getCredit($Event['user_id']).'金币');

}
?>