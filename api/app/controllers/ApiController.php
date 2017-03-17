<?php

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ApiController extends ControllerBase
{
    public $qiniuAccessKey = 'F2uQBFs5CZGqThIchwWmN6JfmAdq88aQnNV4GmOl';
    public $qiniuSecretKey = 'jpGMJCXq-pfI_TO9hCrWbgfoPLd-qt9kb_zii3wy';
    private $appId = 'wx59927c8be8811abb';
    private $appSecret = 'a53e1d32323695e9f2b69093a53094e2';

    public $login_user_id = 0;

    protected function initialize()
    {
        parent::initialize();
    }


    /**
     * 用户登录接口
     */
    public function userLoginAction()
    {
        $code = $this->request->get("code");
        $encryptedData = $this->request->get('encryptedData');
        $iv = $this->request->get("iv");
        $device = $this->request->get("device");
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appId."&secret=".$this->appSecret."&js_code=".$code."&grant_type=authorization_code";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        $content = json_decode($file_contents,true);
        if(isset($content['session_key'])){
            $sessionKey = $content['session_key'];
            //解密
            include_once "../app/vendor/ase/wxBizDataCrypt.php";
            $pc = new WXBizDataCrypt($this->appId, $sessionKey);
            $errCode = $pc->decryptData($encryptedData, $iv, $data );
            if ($errCode == 0) {
                $userInfo = json_decode($data,true);

                //var_dump($userInfo);die();
                $openid = $userInfo['openId'];

                $user = User::findFirst("openid = '$openid' AND status >= 0");
                if(empty($user)){
                    $user = new User();
                    $user->openid = $openid;
                    $user->nickname = $userInfo['nickName'];
                    $user->sex = $userInfo['gender'];
                    $user->province = $userInfo['province'];
                    $user->city = $userInfo['city'];
                    $user->country = $userInfo['country'];
                    $user->headimgurl = $userInfo['avatarUrl'];
                    $user->ip = $this->request->getClientAddress();
                    $user->agent = $this->request->getUserAgent();
                    $user->device = $device;
                    $user->ctime = date('Y-m-d H:i:s',time());
                    $user->lastLoginTime = date('Y-m-d H:i:s',time());
                    $user->status = 1;
                }else{
                    //距离最后一次更新时间超过10天，更新数据
                    if(time()-strtotime($user->lastUpdateTime) > 60*60*24*10){
                        $user->nickname = $userInfo['nickName'];
                        $user->province = $userInfo['province'];
                        $user->city = $userInfo['city'];
                        $user->lastLoginTime = date('Y-m-d H:i:s',time());
                        $user->lastUpdateTime = date('Y-m-d H:i:s',time());
                        $user->headimgurl = $userInfo['avatarUrl'];
                    }else{
                        $user->lastLoginTime = date('Y-m-d H:i:s',time());
                    }
                }

                if($user->save()){
                    echo $user->id;die();
                    //$this->jsonResponse(200,'',$user->id);
                }

            } else {
                print($errCode . "\n");
            }
        }
        die();
    }

    /**
     * 浏览赛事
     * 赛事报名接口
     */

    public function browseApplyAction()
    {

        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }
        $mobile='';
        $event_id = $this->request->get('event_id');
        $type = $this->request->get('type');
        $value =$this->request->get('value');
        if(!empty($value)){
            $value=json_decode($value,true);
            $mobile = $value['mobile'];
            $remark=$value['remark'];
        }



        $event = Event::findFirst($event_id);
        if(empty($event)){
            $this->jsonResponse(404,'赛事不存在');
        }

        $recode = Recode::findFirst("event_id = '$event_id' AND uid = '{$uid}' AND type = '$type' AND status>=0");

        if (empty($recode)){
            $recode = new Recode();
            $recode->uid = $uid;
            $recode->type = $type;
            if($type=='join'){
                $recode->remark=$remark;
            }
            $recode->event_id = $event_id;
            $recode->mobile = $mobile;
            $recode->ctime = date("Y-m-d H:i:s",time());
            $recode->status = 1;

            if($recode->save()){
                $this->jsonResponse(200,"");
            }else{
                $this->jsonResponse(404,"保存失败");
            }
        }else{
            $this->jsonResponse(404,'已保存过');
        }
    }


    /**
     * 获取赛事列表接口
     */

    public function getEventsListAction()
    {

        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }

        $user = User::findFirst($uid);
        if(empty($user)){
            die("405");
        }

        $page = $this->request->has('page') ? $this->getPost('page','int') : 1 ;
        $pageSize = 1000;

        $limit = $pageSize;
        $offset = $limit * ($page - 1);

        $history_events = array();  //历史赛事
        $current_events = array();  //当前赛事
        $future_events = array();   //将来赛事

        $records = Recode::find("uid = '{$uid}' AND type='look' AND status >= 0 LIMIT $offset ,$limit");
        $now = date('Y-m-d 00:00:00',time());

        foreach ( $records as $record ){
            $over=date('Y-m-d 23:59:59',strtotime($record->event->over_time));
            $began=date('Y-m-d 00:00:00',strtotime($record->event->began_time));
//            echo $over,$began,$now;die();

            if($now > $over){
                $began_time=date('m.d',strtotime($record->event->began_time));
                $over_time=date('m.d',strtotime($record->event->over_time));
                $history_events[] = array(
                    'id' =>$record->event_id,
                    'uid' => $uid,
                    //todo
                    //uid 待定。。。。。。。。。。。。。。
                    'event_name' => $record->event->event_name,
                    'image_url'=>$record->event->image_url,
                    'event_description' => $record->event->event_description,
                    'event_place' => $record->event->event_place,
                    'began_time' => $began_time,
                    'over_time' => $over_time,
                    'ctime' => $record->event->ctime
                );
            }
            if($now >= $began && $over>$now ){
                $began_time=date('m.d',strtotime($record->event->began_time));
                $over_time=date('m.d',strtotime($record->event->over_time));
                $current_events[] = array(
                    'id' => $record->event_id,
                    'uid' => $uid,
                    //todo
                    'event_name' => $record->event->event_name,
                    'image_url'=>$record->event->image_url,
                    'event_description' => $record->event->event_description,
                    'event_place' => $record->event->event_place,
                    'began_time' => $began_time,
                    'over_time' => $over_time,
                    'ctime' => $record->event->ctime
                );
            }
            if($now < $began){
                $began_time=date('m.d',strtotime($record->event->began_time));
                $over_time=date('m.d',strtotime($record->event->over_time));
                $future_events[] = array(
                    'id' => $record->event_id,
                    'uid' => $uid,
                    //todo
                    'event_name' => $record->event->event_name,
                    'event_description' => $record->event->event_description,
                    'image_url'=>$record->event->image_url,
                    'event_place' => $record->event->event_place,
                    'began_time' => $began_time,
                    'over_time' => $over_time,
                    'ctime' => $record->event->ctime
                );
            }
        }

        $result['history_events'] = $history_events;
        $result['current_events'] = $current_events;
        $result['future_events'] = $future_events;

        $this->jsonResponse(200,'',$result);

        die();
    }




    /**
     * 获取我相关赛事列表接口
     */

    public function getMyEventsListAction()
    {
        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }


        $result=array();
        $type=$this->request->get('type');

        if($type=='look'|| $type=='join'){
            $myLjEvents=Recode::find("type='{$type}' and uid='{$uid}' and status>=0");

            foreach ( $myLjEvents as $myLjEvent ){
                $began_time=date('m.d',strtotime($myLjEvent->event->began_time));
                $over_time=date('m.d',strtotime($myLjEvent->event->over_time));

                $result[] = array(
                    'id' => $myLjEvent->event_id,
                    'uid' => $myLjEvent->uid,
                    'image_url'=>$myLjEvent->event->image_url,
                    'event_name' => $myLjEvent->event->event_name,
                    'event_description' => $myLjEvent->event->event_description,
                    'event_place' => $myLjEvent->event->event_place,
                    'began_time' => $began_time,
                    'over_time' => $over_time,
                    'ctime' => $myLjEvent->event->ctime
                );
            }

        }elseif($type=='create'){
            $myCreateEvents=Event::find("uid={$uid} and status>=0");
            foreach ( $myCreateEvents as $myCreateEvent ){
                $began_time=date('m.d',strtotime($myCreateEvent->began_time));
                $over_time=date('m.d',strtotime($myCreateEvent->over_time));
                $result[] = array(
                    'id' => $myCreateEvent->id,
                    'uid' => $myCreateEvent->uid,
                    'event_name' => $myCreateEvent->event_name,
                    'image_url'=>$myCreateEvent->image_url,
                    'event_description' => $myCreateEvent->event_description,
                    'event_place' => $myCreateEvent->event_place,
                    'began_time' => $began_time,
                    'over_time' => $over_time,
                    'ctime' => $myCreateEvent->ctime
                );
            }


        }else{
            $this->jsonResponse(400,'错误');

        }

        $this->jsonResponse(200,'',$result);

        //$this->jsonResponse(200,'',$result);

        die();
    }



    /**
     * 获取赛事详情接口
     */
    public function getEventDetailAction()
    {
        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }

        $uid = $this->request->get('uid');
        $event_id = $this->request->get("event_id");

        $event = Event::findFirst($event_id);
        if(empty($event)){
            $this->jsonResponse(404,"赛事不存在");
        }
        $detail = array();
        $apply_people = array();

        $began_time=date('Y-m-d',strtotime($event->began_time));
        $over_time=date('Y-m-d',strtotime($event->over_time));
        $detail = array(
            "id" => $event_id,
            "uid" => $event->uid,
            "event_name" => $event->event_name,
            'image_url'=>$event->image_url,
            "event_description" => $event->event_description,
            'event_place' => $event->event_place,
            'event_reward'=>$event->event_reward,
            "began_time" => $began_time,
            "over_time" => $over_time,
            "ctime" => $event->ctime,
        );


        $user=User::findFirst("id='{$uid}'");
        if(empty($user)){
            echo 405;
            die();
        }
        //如果是自己发起的赛事，显示报名人员
        if($uid == $event->uid){
            $apply_recodes = Recode::find("type = 'join' AND event_id = '$event_id' AND status >= 0");
            $result['join']='create';
            foreach ($apply_recodes as $apply_recode){
                $apply_people[] = array(
                    'uid' => $apply_recode->uid,
                    'mobile'=>$apply_recode->mobile,
                    'nickname' => $apply_recode->User->nickname,
                    'headimgurl' => $apply_recode->User->headimgurl,
                );
            }
        }else{
            $myjoin=Recode::findFirst("uid='{$uid}' AND type='join' AND event_id='$event_id' AND status >= 0");
            if(empty($myjoin))
            {
                $result['join']='unjoin';
            }else{
                $result['join']='join';
            }

        }

        $result['detail'] = $detail;
        $result['apply_people'] = $apply_people;
        $this->jsonResponse(200,"",$result);

    }

    /**
     * 发起赛事 接口
     */

    public function createEventAction()
    {
        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }

        $value = $this->request->get('value');
        if(!empty($value)){
            $value=json_decode($value,true);
            $event_name = $value['event_name'];
            $event_reward= $value['event_reward'];
            $event_description=$value['event_description'];
            $event_place=$value['event_place'];
            $began_time=$value['began_time'];
            $over_time=$value['over_time'];
            $event_img=$value['event_uploader_img'];
        }else{
            $this->jsonResponse(404,"创建失败1");
        }
            if($event_img==''){
                $event_img='http://img.25xyx.com/2814f8d29ccbd406a792358aab4a5eae.png';
            }
        $event = new Event();
        $event->uid = $uid;
        $event->event_name = $event_name;
        $event->event_reward=$event_reward;
        $event->event_description = $event_description;
        $event->image_url = $event_img;
        $event->event_place = $event_place;
        $event->began_time = $began_time;
        $event->over_time = $over_time;
        $event->ctime = date("Y-m-d H:i:s",time());

        if($event->save()){
            $data['uid']=$uid;
            $data['id']=$event->id;
            $recode = new Recode();
            $recode->uid = $uid;
            $recode->type = 'look';
            $recode->event_id = $event->id;
            $recode->ctime = date("Y-m-d H:i:s",time());
            $recode->status = 1;
            $recode->save();
            $recode2 = new Recode();
            $recode2->uid = $uid;
            $recode2->type = 'join';
            $recode2->mobile='创建者';
            $recode2->event_id = $event->id;
            $recode2->ctime = date("Y-m-d H:i:s",time());
            $recode2->status = 1;
            $recode2->save();
            $this->jsonResponse(200,'创建成功',$data);
        }else{
            $this->jsonResponse(404,"创建失败");
        }


    }

    public function uploadQiniuAction()
    {

        $auth = new Auth($this->qiniuAccessKey, $this->qiniuSecretKey);
        // 要上传的空间
        $bucket = 'xiaoyouxi';
        // 生成上传 Token
        $token = $auth -> uploadToken($bucket);

        $files = $this->request->getUploadedFiles();
        if(!empty($files)){
            foreach ($files as $file) {
                $tmp_path = $file->getTempName();
                $file_name = md5(file_get_contents($tmp_path)).".".$file->getExtension();

                $uploadMgr = new UploadManager();
                list($ret, $err) = $uploadMgr->putFile($token, $file_name, $tmp_path);
                if($err !== null) {
                    error_log($err);
                }
            }
            //$return['file_path'] =$file_name;
        }

        echo 'http://img.25xyx.com/'.$file_name;
        die();
    }


    public function delEventAction(){
        $uid=intval($this->request->get('uid','int'));
        if($uid<=0){
            die("未登录");
        }

        $event_id=$this->request->get('event_id');
        if($event_id>0){
            $event=Event::findFirst("id={$event_id} and uid='$uid'");
            if(!empty($event)){
                $records = "UPDATE Recode set status = -1 WHERE event_id = '{$event_id}'";
                $this->modelsManager->executeQuery($records);
                $event->status=-1;
                if($event->save()){
                    $this->jsonResponse(200,"删除成功");
                }else {
                    $this->jsonResponse(400,"删除失败0");
                }
            }else{
                $this->jsonResponse(400,"删除失败1");
            }
        }

    }
    public function unjoinAction(){
        $uid=intval($this->request->get('uid','int'));
        $event_id=intval($this->request->get('event_id','int'));
        if($uid<=0){
            die("未登录");
        }

        if($event_id>0){
            $recode=Recode::findFirst("event_id={$event_id} AND uid='{$uid}' AND type='join'AND status>=0");
            if(!(empty($recode))){
                $recode->status=-1;
                if($recode->save()){
                    $this->jsonResponse(200,"取消成功");
                }else {
                    $this->jsonResponse(401,"取消失败");
                }
            }else{
                $this->jsonResponse(400,"取消失败");
            }
        }

    }


    public function checkUidAction()
    {
        $uid = $this->request->get('uid');
        if($uid <= 0 || $uid == null){
            die("405");
        }
        $user = User::findFirst($uid);
        if(empty($user)){
            die("405");
        }
    }

}
