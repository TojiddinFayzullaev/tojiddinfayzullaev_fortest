<?php
define('API_KEY', "1988608445:AAFcWpxul1ybcmzkOOAcKcrdDEf2aLFxd14");
function bot($metod, $data = []){
	$url = "https://api.telegram.org/bot".API_KEY."/".$metod;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		var_dump(curl_error($ch));
	}else{
		return json_encode($res);
	}
}
function sendMessage($chat_id, $text, $reply_markup){
	bot('sendMessage',['chat_id' => $chat_id, 'text' => $text, 'reply_markup' => json_encode($reply_markup), 'parse_mode' => "html"]);
}
function editMesssage($chat_id, $message_id, $text, $reply_markup){
	bot('editMesssageText',['chat_id' => $chat_id, 'message_id' => $message_id, 'text' => $text, 'reply_markup' => $reply_markup, 'parse_mode' => "html"]);
}
function deleteMessage($chat_id, $message_id){
	bot('deleteMessage',['chat_id' => $chat_id, 'message_id' => $message_id]);
}
function step($chat_id, $text){
	file_put_contents("bot/".$chat_id."/step.temp", $text);
}
function deleteFolder($path){
	array_map('unlink', glob($path, "/*"));
	rmdir($path);
}
function deleteFile($path){
	unlink($path);
}
$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
mkdir("bot");
mkdir("bot/userfiles");
mkdir("bot/userfiles/".$chat_id);
if(!file_get_contents("bot/userfiles/".$chat_id."/stols.txt")){
	file_put_contents("bot/userfiles/".$chat_id."/stols.txt", "Orqaga\nStol qo'shish");
}
$stol_array = ['resize_keyboard' => true, 'keyboard' => []];
$keyb_list_temp = file_get_contents("bot/userfiles/".$chat_id."/stols.txt");
$keyb_list_name = explode("\n", $keyb_list_temp);
for($i = 0; $i <= count($keyb_list_name) - 1; $i++){
	$keyb_list_name_2 = $keyb_list_name[$i];
	$stol_array['keyboard'][] = ['text' => $keyb_list_name_2];
}
$menu = [
	'resize_keyboard' => true,
	'keyboard' => [
		[[
			'text' => "📂 Hostingga joylash ➕"
		]]
	]
];


if($text == "/start"){
	sendMessage($chat_id, "Salom. Ushbu botda sizni ko'rib turganimdan xursandman", $menu);
}
if($text == "📂 Hostingga joylash ➕"){
	if(file_exists("bot/userfiles/".$chat_id."/files")){
		sendMessage($chat_id, "Fayllaringiz mavjud");
	}else{
		sendMessage($chat_id, "Marhamat kerakli stolni tanlang.", $menu);
	}
}
?>