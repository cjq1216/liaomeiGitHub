<?php

	class users{

		//获取好友列表
		function getFriendsList($my_id){

			$sql1="SELECT * FROM `friends` WHERE `my_id`='$my_id'";
			$getFriendList=mysql_query($sql1);

			$recentContactFriends = array();
			while($myFriend = mysql_fetch_array($getFriendList)){
				//查找所有消息
				$sql3 = "SELECT *
						FROM  `private_messages`
						WHERE  `sender_id` =  '$my_id'
						AND  `receiver_id` =  '$myFriend[friend_id]'
						OR  `sender_id` =  '$myFriend[friend_id]'
						AND  `receiver_id` =  '$my_id' order by pm_time asc";
				$getAllMessage=mysql_query($sql3);
				$allMessages = array();
				while($myMessage = mysql_fetch_array($getAllMessage)){
					//将消息记录压进数组
					$single_message = array(
					'pm_id'=>(int)$myMessage['pm_id'],
					'pm_time'=>$myMessage['pm_time'],
					'pm_content'=>$myMessage['pm_content'],
					'pm_state'=>$myMessage['pm_state'],
					'receiveORsend'=>$myMessage['sender_id']==$my_id?'send':'receive'
					);
					array_push($allMessages,$single_message);
				}
				//获取好友的资料
				$friend_profile = $this->getProfile($myFriend['friend_id']);
				//压进数组
				$single_record = array(

				'friend_id'=>$myFriend['friend_id'],
				'remark_name'=>$myFriend['remark_name'],

				'friend_name'=>$friend_profile['user_name'],
				'friend_sex'=>$friend_profile['user_sex'],
				'friend_birthday'=>$friend_profile['user_birthday'],
				'friend_head_portrait'=>$friend_profile['user_head_portrait'],
				'friend_signature'=>$friend_profile['user_signature'],

				'all_messages'=>$allMessages
				);
				array_push($recentContactFriends, $single_record);
			}
			return $recentContactFriends;
		}


		//获取用户资料
		function getProfile($user_id){

			$sql1="select * from users where user_id='$user_id'";
			$getUserProfile=mysql_query($sql1);
			if($userProfile=mysql_fetch_array($getUserProfile)){
				$profile = ARRAY(
					'user_id'=>$userProfile['user_id'],
					'user_name'=>$userProfile['user_name'],
					'user_sex'=>$userProfile['user_sex'],
					'user_birthday'=>$userProfile['user_birthday'],
					'user_head_portrait'=>$userProfile['user_head_portrait'],
					'user_signature'=>$userProfile['user_signature']
				);
				return $profile;
			}
			else return 'user does not exist!';
		}
	}

?>
