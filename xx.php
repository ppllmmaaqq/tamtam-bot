<?php
// استقبال البيانات القادمة من TamTam أو أي Webhook
$input = file_get_contents("php://input");

// حفظ البيانات داخل ملف log.txt في نفس المجلد
file_put_contents("log.txt", $input . PHP_EOL, FILE_APPEND);

// رد بسيط يرجع للجهة المرسلة
echo "Webhook received";
?>

$API_KEY = 'f9LHodD0cOIFBzgEC4xY0Rfm-QiyiryFpatCq_gnSOpJ34QRtM91AZMQquPizND5oNdMKtv2oSA03OSxnpfU-A';

$tamtam = new tamtam($API_KEY);

class tamtam{
    function __construct($API_KEY)
    {
        $this->token = $API_KEY;
    }
    public function bot($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/messages?access_token=".$this->token."&chat_id=".$method."&disable_link_preview=true";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}
}

  

  public function deleteMessage($method){
    $url = "https://botapi.tamtam.chat/messages?access_token=".$this->token."&message_id=".$method;
          $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        //curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($ch);
            echo $res;
}
  
  public function kickChatMember($user_id, $chat){
$url = "https://botapi.tamtam.chat/chats/".$chat."/members?access_token=".$this->token."&user_id=".$user_id."&block=true";
$content = ['chat_id'=>$chat];
$curl = curl_init();
$content = json_encode($content);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($content))
);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);
return json_decode($result, true);
}

  
  public function bobt($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/messages?access_token=".$this->token."&user_id=".$method."&disable_link_preview=true";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}
} 
}

 function is_bot($user){
global $update_info;
if($user == $update_info){
$is_bot = true;
}else{
$is_bot = false;
}
return $is_bot;
}
 function is_dev($user){
global $as;
if(in_array($user,$as)){
$is_de = true;
}else{
$is_de = false;
}
return $is_de;
}
 function is_deved($user){
global $dev;
if(is_bot($user)){
$is_dfe = true;
}elseif(is_dev($user)){
$is_dfe = true;
}elseif(in_array($user,$dev["dev"])){
$is_dfe = true;
}else{
$is_dfe = false;
}
return $is_dfe;
}
 function is_creator($user, $chat){
global $API_KEY;
$infoad = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chat.'/members?access_token='.$API_KEY.'&user_ids='.$user));
$is_owner = $infoad->members[0]->is_owner; 
$is_admin = $infoad->members[0]->is_admin; 
$is_user_id = $infoad->members[0]->user_id;
if(is_bot($user)){
$is_cr = true;
}elseif(is_deved($user)){
$is_cr = true;
}elseif($is_owner == "true" && $is_admin =="true"){
$is_cr = true;
}else{
$is_cr = false;
}
return $is_cr;
}
 function is_owner($user, $chat){
global $API_KEY;
global $owner;
$infoad = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chat.'/members?access_token='.$API_KEY.'&user_ids='.$user));
$is_owner = $infoad->members[0]->is_owner; 
$is_admin = $infoad->members[0]->is_admin; 
$is_user_id = $infoad->members[0]->user_id;
if(is_bot($user)){
$is_ow = true;
}elseif(is_creator($user, $chat)){
$is_ow = true;
}elseif(!$is_owner == "true" && $is_admin =="true"){
$is_ow = true;
}elseif(in_array($user,$owner[$chat])){
$is_ow = true;
}else{
$is_ow = false;
}
return $is_ow;
}
 function is_admin($user, $chat){
global $Admin;
if(is_bot($user)){
$is_ad = true;
}elseif(is_creator($user, $chat)){
$is_ad = true;
}elseif(is_owner($user, $chat)){
$is_ad = true;
}elseif(in_array($user,$Admin[$chat])){
$is_ad = true;
}else{
$is_ad = false;
}
return $is_ad;
}
 function is_Special($user, $chat){
global $Special;
if(is_dev($user)){
$is_sp = true;
}elseif(is_bot($user)){
$is_sp = true;
}elseif(is_deved($user)){
$is_sp = true;
}elseif(is_creator($user, $chat)){
$is_sp = true;
}elseif(is_owner($user, $chat)){
$is_sp = true;
}elseif(is_admin($user, $chat)){
$is_sp = true;
}elseif(in_array($user,$Special[$chat])){
$is_sp = true;
}else{
$is_sp = false;
}
return $is_sp;
}
  function rank($user, $chat){
if(is_dev($user)){
$is_rank = "المطور الاساسي";
}elseif(is_bot($user)){
$is_rank = "البوت";
}elseif(is_deved($user)){
$is_rank = "المطور";
}elseif(is_creator($user,$chat)){
$is_rank = "منشئ اساسي";
}elseif(is_owner($user,$chat)){
$is_rank = "منشئ";
}elseif(is_admin($user,$chat)){
$is_rank = "ادمن";
}elseif(is_Special($user,$chat)){
$is_rank = "مميز";
}else{
$is_rank = "عضو";
}
return $is_rank;
}



function GetChatMembers($chat_id, $API_KEY, $from_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://botapi.tamtam.chat/chats/" . $chat_id . "/members/?access_token=" .$API_KEY. "&user_ids=" . $from_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    return json_decode($res, 1);
}




$update = json_decode(file_get_contents('php://input'));
$update_type = $update ->update_type;
$message = $update->message;
$chatId = $message->recipient->chat_id;
$text = $message->body->text;
$name = $update->message->sender->name;
$user = $update->message->sender->username;
$user_id = $update->message->sender->user_id;
$message_id = $update->message->body->mid;
if($update_type ==  'bot_started'){
$user_id = $update->user_id;
$chatId = $update->chat_id;
$name = $update->user->name;
$user = $update->user->username;
}

if (mb_strtolower($text) == "راتب") {
    $money_file = "money.json";
    if (file_exists($money_file)) {
        $money_data = json_decode(file_get_contents($money_file), true);
    } else {
        $money_data = [];
    }
    $jobs = ["طبيب 🩺", "مهندس 🏗️", "محامي ⚖️", "شرطي 🚓", "مطور 👨‍💻", "تاجر 💼"];
    $random_job = $jobs[array_rand($jobs)];


    $salary = rand(15000, 40000);

    
    if (!isset($money_data[$user_id])) {
        $money_data[$user_id] = 0;
    }

    $money_data[$user_id] += $salary;
    file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));

    
    $tamtam->bot($chatId, [
        'text' => "• اشعار إيداع الاسم : $name .\n".
                  "• المبلغ : $salary دينار 💸\n".
                  "وظيفتك : $random_job\n".
                  "نوع العملية : إضافة راتب 💼\n".
                  "فلوسك صارت : {$money_data[$user_id]} دينار 💰",
        'format' => 'markdown',
        'link' => [
            'type' => 'reply',
            'mid' => $message_id
        ]
    ]);
}

if (mb_strtolower($text) == "بخشيش") {
    $tip_file = "tips.json";          
    $money_file = "money.json";      
    $cooldown_seconds = 600;         

   
    $tip_data = file_exists($tip_file) ? json_decode(file_get_contents($tip_file), true) : [];
    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];

    $now = time();

     
    if (isset($tip_data[$user_id]) && ($now - $tip_data[$user_id]) < $cooldown_seconds) {
        $remaining = $cooldown_seconds - ($now - $tip_data[$user_id]);
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;

        $tamtam->bot($chatId, [
            'text' => "• انتظر $minutes دقيقة و $seconds ثانية قبل ما تاخذ بخشيش ثاني ⏳",
            'format' => 'markdown',
            'link' => [
                'type' => 'reply',
                'mid' => $message_id
            ]
        ]);
        exit;
    }

    
    $tip_amount = rand(5000, 25000);


    if (!isset($money_data[$user_id])) {
        $money_data[$user_id] = 0;
    }

    $money_data[$user_id] += $tip_amount;

  
    $tip_data[$user_id] = $now;
    file_put_contents($tip_file, json_encode($tip_data, JSON_PRETTY_PRINT));
    file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));

    
    $tamtam->bot($chatId, [
        'text' => "• تم إضافة بخشيش لك يا $name 🪙\n".
                  "• المبلغ: $tip_amount دينار 💸\n".
                  "• الرصيد الحالي: {$money_data[$user_id]} دينار 💰",
        'format' => 'markdown',
        'link' => [
            'type' => 'reply',
            'mid' => $message_id
        ]
    ]);
}

if (mb_strtolower($text) == "ترند") {
    $money_file = "money.json";
    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];

    if (empty($money_data)) {
        $tamtam->bot($chatId, [
            'text' => "• لا توجد بيانات بعد 😅",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        exit;
    }


    $user_data_file = "usernames.json";
    $user_data = file_exists($user_data_file) ? json_decode(file_get_contents($user_data_file), true) : [];

  
    $user_data[$user_id] = [
        'name' => $name,
        'username' => $user
    ];
    file_put_contents($user_data_file, json_encode($user_data, JSON_PRETTY_PRINT));

    arsort($money_data);   

    $ranks = ["🎖️", "🏅", "🥇", "🥈", "🥉"];
    $list = "⌁︙الترتيب - الفلوس - المستخدمين\n\n";

    $i = 1;
    foreach ($money_data as $id => $amount) {
        if ($i > 20) break;

        $rank_icon = $i <= 5 ? $ranks[$i - 1] : "🏆";
        $formatted_money = formatMoney($amount);

        $user_name = isset($user_data[$id]['name']) ? $user_data[$id]['name'] : "مجهول";
        $username = isset($user_data[$id]['username']) ? $user_data[$id]['username'] : null;
        if ($username) {
            $linked_name = "[$user_name](https://tt.me/$username)";
        } else {
            $linked_name = "[$user_name](tg://user?id=$id)";
        }

        $list .= "$rank_icon $i l $formatted_money l $linked_name\n";
        $i++;
    }

    $tamtam->bot($chatId, [
        'text' => $list,
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

function formatMoney($num) {
    if ($num >= 1_000_000_000_000) {
        return round($num / 1_000_000_000_000, 1) . 'T';
    } elseif ($num >= 1_000_000_000) {
        return round($num / 1_000_000_000, 1) . 'B';
    } elseif ($num >= 1_000_000) {
        return round($num / 1_000_000, 1) . 'M';
    } elseif ($num >= 1_000) {
        return round($num / 1_000, 1) . 'K';
    } else {
        return $num;
    }
}

if (mb_strtolower(explode(" ", $text)[0]) == "حظ") {
    $parts = explode(" ", $text);
    if (!isset($parts[1]) || !is_numeric($parts[1])) {
        $tamtam->bot($chatId, [
            'text' => "• استخدم الأمر هكذا: حظ 1000",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        exit;
    }

    $bet = (int)$parts[1];
    if ($bet <= 0) {
        $tamtam->bot($chatId, [
            'text' => "• المبلغ يجب أن يكون أكبر من 0",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        exit;
    }

    
    $cooldown_file = "luck_times.json";
    $cooldowns = file_exists($cooldown_file) ? json_decode(file_get_contents($cooldown_file), true) : [];
    $now = time();
    $cooldown_period = 600; 

    if (isset($cooldowns[$user_id]) && ($now - $cooldowns[$user_id]) < $cooldown_period) {
        $remaining = $cooldown_period - ($now - $cooldowns[$user_id]);
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;

        $tamtam->bot($chatId, [
            'text' => "• يجب الانتظار قبل استخدام الحظ مجددًا ⏳\nالوقت المتبقي: {$minutes} دقيقة و {$seconds} ثانية.",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        exit;
    }

  
    $money_file = "money.json";
    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];
    if (!isset($money_data[$user_id])) {
        $money_data[$user_id] = 0;
    }

    if ($money_data[$user_id] < $bet) {
        $tamtam->bot($chatId, [
            'text' => "• رصيدك غير كافي للمراهنة 😅\nرصيدك الحالي: {$money_data[$user_id]} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        exit;
    }

   
    $old_balance = $money_data[$user_id];
    $win = rand(0, 1);

    if ($win == 1) {
        $money_data[$user_id] += $bet;
        $message = "• 🎉 مبروك فزت بالحظ\n".
                   "• فلوسك قبل : $old_balance دينار 💸\n".
                   "• فلوسك هسه : {$money_data[$user_id]} دينار 💸";
    } else {
        $money_data[$user_id] -= $bet;
        $message = "• للاسف خسرت بالحظ 😢\n".
                   "• فلوسك قبل : $old_balance دينار 💸\n".
                   "• فلوسك هسه : {$money_data[$user_id]} دينار 💸";
    }

    
    file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));
    $cooldowns[$user_id] = $now;
    file_put_contents($cooldown_file, json_encode($cooldowns, JSON_PRETTY_PRINT));

    
    $tamtam->bot($chatId, [
        'text' => $message,
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

if (preg_match('/^تحويل\s+(\d+)/u', $text, $match) && isset($message->body->reply_to->mid)) {
    $amount = intval($match[1]);
    $reply_to_user = $message->body->reply_to->sender->user_id;
    $reply_to_name = $message->body->reply_to->sender->name;
    $reply_to_username = $message->body->reply_to->sender->username;

    if ($amount <= 0) {
        $tamtam->bot($chatId, [
            'text' => "❌ المبلغ غير صالح.",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }


    $transfer_file = "transfer_time.json";
    $last_transfers = file_exists($transfer_file) ? json_decode(file_get_contents($transfer_file), true) : [];
    $now = time();

    if (isset($last_transfers[$user_id]) && ($now - $last_transfers[$user_id]) < 600) {
        $wait = 600 - ($now - $last_transfers[$user_id]);
        $tamtam->bot($chatId, [
            'text' => "❌ يجب الانتظار $wait ثانية قبل إجراء تحويل جديد.",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    $last_transfers[$user_id] = $now;
    file_put_contents($transfer_file, json_encode($last_transfers, JSON_PRETTY_PRINT));

  
    $money_file = "money.json";
    $money = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];

    if (!isset($money[$user_id])) $money[$user_id] = 0;
    if (!isset($money[$reply_to_user])) $money[$reply_to_user] = 0;

    $tax = floor($amount * 0.02); 
    $total = $amount + $tax;

    if ($money[$user_id] < $total) {
        $tamtam->bot($chatId, [
            'text' => "❌ رصيدك غير كافي لإجراء هذا التحويل.\n• المطلوب: $total دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    $before = $money[$user_id];
    $money[$user_id] -= $total;
    $money[$reply_to_user] += $amount;
    file_put_contents($money_file, json_encode($money, JSON_PRETTY_PRINT));

    $tamtam->bot($chatId, [
        'text' => "✅ تم تحويل $amount دينار إلى . " . ($reply_to_username ? "[$reply_to_name](https://t.me/$reply_to_username)" : $reply_to_name) . " ..\n".
                 "• مبلغ الضريبة: $tax دينار 💰\n".
                 "• فلوسك قبل: $before دينار 💸\n".
                 "• فلوسك الحالية هي: {$money[$user_id]} دينار 💸",
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}


$money_file = "money.json";
$money = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];

if (!isset($money[$user_id])) $money[$user_id] = 0; 


if (mb_strtolower($text) == "فلوسي") {
    $tamtam->bot($chatId, [
        'text' => "• فلوسك {$money[$user_id]} دينار 💸",
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

   
if (isset($message->body->reply_to->sender->user_id)) {
    $target_id = $message->body->reply_to->sender->user_id;

    if (!isset($money[$target_id])) $money[$target_id] = 0;

    if (mb_strtolower($text) == "فلوسه") {
        $tamtam->bot($chatId, [
            'text' => "• فلوسه {$money[$target_id]} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
    }
}

if (preg_match('/^جولة\s+(\d+)/u', $text, $match)) {
    $amount = intval($match[1]);
    $money_file = "money.json";
    $money = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];

    if (!isset($money[$user_id])) $money[$user_id] = 0;

    if ($amount < 5000) {
        $tamtam->bot($chatId, [
            'text' => "• الجولة لازم تكون أكثر من ^^5^^ آلف دينار تشارك بيها 👾.",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    if ($money[$user_id] < $amount) {
        $tamtam->bot($chatId, [
            'text' => "❌ رصيدك غير كافي للمشاركة في الجولة.\n• رصيدك الحالي: {$money[$user_id]} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }


    $players = array_filter(array_keys($money), fn($id) => $id != $user_id && $money[$id] >= 5000);

    if (empty($players)) {
        $tamtam->bot($chatId, [
            'text' => "• ماكو لاعبين حالياً للمشاركة بالجولة 💤",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }


    $all_participants = array_merge([$user_id], $players);
    $winner_id = $all_participants[array_rand($all_participants)];

    $before = $money[$user_id];
    $winner_name = $user_id == $winner_id ? $name : "[$winner_id](https://tt.me/$winner_id)";

    if ($winner_id == $user_id) {
        $money[$user_id] += $amount;
        $msg = "• مبروك فزت 🙈 الفائز هو $name\n".
               "• فلوسك قبل: $before دينار 💸\n".
               "• فلوسك الآن: {$money[$user_id]} دينار 💰";
    } else {
        $money[$user_id] -= $amount;
        $msg = "• للاسف خسرت 😞 الفائز هو $winner_name\n".
               "• فلوسك قبل: $before دينار 💸\n".
               "• فلوسك الآن: {$money[$user_id]} دينار 💸";
    }

    file_put_contents($money_file, json_encode($money, JSON_PRETTY_PRINT));

    $tamtam->bot($chatId, [
        'text' => $msg,
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

if (mb_strtolower($text) == "كنز") {
    $money_file = "money.json";
    $time_file = "kenz_time.json";

    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];
    $time_data = file_exists($time_file) ? json_decode(file_get_contents($time_file), true) : [];

    $now = time();
    $cooldown = 10 * 60;  

    $last_try = isset($time_data[$user_id]) ? $time_data[$user_id] : 0;

    if (($now - $last_try) < $cooldown) {
        $remaining = $cooldown - ($now - $last_try);
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;

        $tamtam->bot($chatId, [
            'text' => "• فرصة ايجاد كنز ثاني بعد " . sprintf("%02d:%02d", $minutes, $seconds) . " دقيقة 🕒",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    $time_data[$user_id] = $now;
    file_put_contents($time_file, json_encode($time_data, JSON_PRETTY_PRINT));

  
    $found = rand(1, 2) === 1;

    if ($found) {
        
        $prizes = [
            ["💎 الماس نادر", rand(80000, 150000)],
            ["🚗 سيارة رياضية", rand(50000, 100000)],
            ["✈️ طيارة خاصة", rand(120000, 180000)],
            ["🏡 بيت راقي", rand(60000, 90000)],
            ["🏢 شركة ناشئة", rand(100000, 160000)],
            ["🏰 قصر ملكي", rand(200000, 300000)],
            ["🌍 قطعة أرض ضخمة", rand(90000, 140000)],
        ];

        $chosen = $prizes[array_rand($prizes)];
        $item = $chosen[0];
        $amount = $chosen[1];

        if (!isset($money_data[$user_id])) $money_data[$user_id] = 0;
        $money_data[$user_id] += $amount;
        file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));

        $tamtam->bot($chatId, [
            'text' => "🎉 مبروك! لكيت كنز يحتوي على: *$item*!\n".
                     "• قيمته: $amount دينار 💰\n".
                     "• فلوسك الآن: {$money_data[$user_id]} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
    } else {
        $tamtam->bot($chatId, [
            'text' => "للأسف، ما لكيت كنز هالمره 😞\nجرب حظك مره ثانيه بعد 10 دقايق.",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
    }
}

if (mb_strtolower($text) == "زرف" && isset($message->body->reply_to)) {
    $money_file = "money.json";
    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];
    $target_id = $message->body->reply_to->sender->user_id;
    $target_name = $message->body->reply_to->sender->name;
    $target_money = isset($money_data[$target_id]) ? $money_data[$target_id] : 0;

    if ($target_money <= 0) {
        $tamtam->bot($chatId, [
            'text' => "• ماعنده فلوس مايصير تزرف !!",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

 
    $stolen = rand(500, min(5000, $target_money));
    
    $money_data[$target_id] -= $stolen;
    if (!isset($money_data[$user_id])) $money_data[$user_id] = 0;
    $money_data[$user_id] += $stolen;
    file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));
    $tamtam->bot($chatId, [
        'text' => "• تم زرف $stolen دينار 💸 من [$target_name](tt.me/$user)\n".
                  "• فلوسك حالياً: {$money_data[$user_id]} دينار 💰",
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

if (preg_match("/^استثمار (.*)/u", $text, $match)) {
    $invest = (int)trim($match[1]);
    $money_file = "money.json";
    $cooldown_file = "invest_cooldown.json";

    $money_data = file_exists($money_file) ? json_decode(file_get_contents($money_file), true) : [];
    $cooldown_data = file_exists($cooldown_file) ? json_decode(file_get_contents($cooldown_file), true) : [];

    if (!isset($money_data[$user_id])) $money_data[$user_id] = 0;
    if (!isset($cooldown_data[$user_id])) $cooldown_data[$user_id] = 0;

    $current_money = $money_data[$user_id];
    $last_invest_time = $cooldown_data[$user_id];
    $current_time = time();

    $cooldown_seconds = 12 * 60;
    if (($current_time - $last_invest_time) < $cooldown_seconds) {
        $remaining = $cooldown_seconds - ($current_time - $last_invest_time);
        $minutes = floor($remaining / 60);
        $seconds = $remaining % 60;
        $time_left = sprintf('%02d:%02d', $minutes, $seconds);

        $tamtam->bot($chatId, [
            'text' => "• مايصير تستثمر هسة\n• تعال بعد {$time_left} دقيقة",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    if ($invest > 20000) {
        $tamtam->bot($chatId, [
            'text' => "• مايصير تستثمر أكثر من 20,000 دينار.\nانت طاك فلوسك: {$current_money} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    if ($invest < 5000) {
        $tamtam->bot($chatId, [
            'text' => "• اقل مبلغ للاستثمار هو 5,000 دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }

    if ($current_money < $invest) {
        $tamtam->bot($chatId, [
            'text' => "• ماعندك فلوس كافية للاستثمار.\nفلوسك الحالية: {$current_money} دينار 💸",
            'format' => 'markdown',
            'link' => ['type' => 'reply', 'mid' => $message_id]
        ]);
        return;
    }
    $money_data[$user_id] -= $invest;
    $profit_percent = rand(80, 150);
    $profit = intval($invest * ($profit_percent / 100));
    $money_data[$user_id] += $profit;
    $cooldown_data[$user_id] = $current_time;
    file_put_contents($money_file, json_encode($money_data, JSON_PRETTY_PRINT));
    file_put_contents($cooldown_file, json_encode($cooldown_data, JSON_PRETTY_PRINT));

    $new_balance = $money_data[$user_id];

    $tamtam->bot($chatId, [
        'text' => "• استثمار ناجح ✅\n".
                  "• نسبة الربح : $profit_percent%\n".
                  "• مبلغ الربح : $profit دينار 💸\n".
                  "• فلوسك صارت : {$new_balance} دينار 💸",
        'format' => 'markdown',
        'link' => ['type' => 'reply', 'mid' => $message_id]
    ]);
}

if($update_type == "bot_started"){

$tamtam->bot($chatId,[
'text'=>"Click here to get started :- /start",
]);
}
 


  
