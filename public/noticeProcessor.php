<?php

global $Event, $Queue;
use kjBot\SDK\CQCode;

switch($Event['notice_type']){
    case 'group_increase':
        if($Event['user_id'] != config('bot')){
            $Queue[]= sendBack(CQCode::At($Event['user_id']).' 欢迎加入本群，希望可以在这里玩的开心！');
        }else{
            $Queue[]= sendBack('何小綾(YeziiBot) 已入驻本群，发送 '.config('prefix', '!').'help 查看帮助');
        }
        break;
    default:
        
}

?>