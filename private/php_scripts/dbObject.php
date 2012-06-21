<?php

class dbObject {
	var $host = 'mysql.resumake.thegbclub.com';
    var $username = 'thegbclub';
    var $password = 'thegingerbreadclub';
    var $schema = 'resumake';
		
	//////////////////// Control ///////////////////////////////
    /*
     connect connects to a database; the instance variables of the
     database class must be initialized
    */
    public function connect() {
        mysql_connect($this->host,$this->username,$this->password)
            or die("Could not connect. " . mysql_error());
        mysql_select_db($this->schema)
            or die("Could not select database. " . mysql_error());
    }
	
	
	///////////////////////// USERS ///////////////////////////////////////////
	
	public function addUser($name, $email, $password, $username, $confirmation)
	{	
		if ($this->getUserByEmail($email))
			return FALSE;
		
		$name = addslashes($name);
		$email = addslashes($email);
		$password = addslashes($password);
		$username = addslashes($username);
		
		$sql = "INSERT INTO users (name, password, email, username, confirmation_code) VALUES ('$name', '$password', '$email', '$username', '$confirmation')";
		return mysql_query($sql);
	}
	
	public function confirmUser($uid){
		$user = $this->getUserById($uid);
		copy('../default/index.php', '../../' . $user->username . '.php');
	
		$mysql = "UPDATE users SET is_confirmed=1 WHERE uid='$uid'";
		return mysql_query($mysql); 
	}
	
	public function updateUser($uid, $info, $quote){
		if($info == -1){
		}
		if($quote == -1){
		}
	}
	
	public function getUserByConfirmationCode($confirmation){
		$sql = "SELECT * FROM users WHERE confirmation_code='$confirmation'";
		$result = mysql_query($sql);
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$user = new user;
		$user->uid = stripslashes($row['uid']);
		$user->password = stripslashes($row['password']);
		$user->email = stripslashes($row['email']);
		$user->date_joined = $this->parseTimestamp(stripslashes($row['date_reg']));
		$user->name = stripslashes($row['name']);
		$user->username = stripslashes($row['username']);
		$user->info = stripslashes($row['info']);
		$user->quote = stripslashes($row['quote']);
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
	
		return $user;
	}
	
	public function getUserByUsername($username){
		$sql = "SELECT * FROM users WHERE username='$username'";
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$user = new user;
		$user->uid = stripslashes($row['uid']);
		$user->password = stripslashes($row['password']);
		$user->email = stripslashes($row['email']);
		$user->date_joined = $this->parseTimestamp(stripslashes($row['date_reg']));
		$user->name = stripslashes($row['name']);
		$user->username = stripslashes($row['username']);
		$user->info = stripslashes($row['info']);
		$user->quote = stripslashes($row['quote']);
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
	
		return $user;
	}
	
	public function getUserById($uid)
	{
		$sql = "SELECT * FROM users WHERE uid=$uid";
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$user = new user;
		$user->uid = stripslashes($row['uid']);
		$user->password = stripslashes($row['password']);
		$user->email = stripslashes($row['email']);
		$user->date_joined = $this->parseTimestamp(stripslashes($row['date_reg']));
		$user->name = stripslashes($row['name']);
		$user->username = stripslashes($row['username']);
		$user->info = stripslashes($row['info']);
		$user->quote = stripslashes($row['quote']);
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
		
		return $user;
	}
	
	public function getUserByEmail($email)
	{
		$sql = "SELECT * FROM users WHERE email='$email'";
		
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$user = new user;
		$user->uid = stripslashes($row['uid']);
		$user->password = stripslashes($row['password']);
		$user->email = stripslashes($row['email']);
		$user->date_joined = $this->parseTimestamp(stripslashes($row['date_reg']));
		$user->name = stripslashes($row['name']);
		$user->username = stripslashes($row['username']);
		$user->info = stripslashes($row['info']);
		$user->quote = stripslashes($row['quote']);
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
	
		return $user;
	}
	
	
	///////////////////////// FORMAT ///////////////////////////////////////////
	
	public function addFormat($uid, $content, $name){
		$name = addslashes($name);
		$content = addslashes($content);
		$uid = addslashes($uid);
		
		$sql = "INSERT INTO formats (uid, content, name) VALUES ('$uid', '$content', '$name')";
		return mysql_query($sql);
	}
	
	public function getFormatByUid($uid){
		$sql = "SELECT * FROM formats WHERE uid=$uid";
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$format = new format;	
		$format->fid = stripslashes($row['fid']);
		$format->name = stripslashes($row['name']);
		$format->content = stripslashes($row['content']);
		$format->date_created = stripslashes($row['date_created']);
		$format->popularity = stripslashes($row['popularity']);
	
		return $user;
	}
	
	public function getFormatByName($name){
		$name = addslashes($name);
		$sql = "SELECT * FROM formats WHERE name=$name";
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$format = new format;	
		$format->fid = stripslashes($row['fid']);
		$format->name = stripslashes($row['name']);
		$format->content = stripslashes($row['content']);
		$format->date_created = stripslashes($row['date_created']);
		$format->popularity = stripslashes($row['popularity']);
	
		return $user;
	}
	
	public function getFormatByFid($fid){
		$sql = "SELECT * FROM formats WHERE fid=$fid";
		
		$result = mysql_query($sql);
		
		if ($result == FALSE || mysql_num_rows($result) < 1)
			return FALSE;
			
		$row = mysql_fetch_array($result);
		
		$format = new format;	
		$format->fid = stripslashes($row['fid']);
		$format->name = stripslashes($row['name']);
		$format->content = stripslashes($row['content']);
		$format->date_created = stripslashes($row['date_created']);
		$format->popularity = stripslashes($row['popularity']);
	
		return $user;
	}
	
	private function parseTimestamp($timestamp) {
		return strtotime($timestamp);	
    } 
}

class user{
	var $uid;
	var $email;
	var $password;
	var $date_joined;
	var $username;
	var $name;
	var $info;
	var $quote;
	var $is_confirmed;
	var $confirmation_code;
}

class resume{
	var $rid;
	var $uid;
	var $fid;
	var $date_created;
	var $content;
}

class format{
	var $fid;
	var $uid;
	var $name;
	var $content;
	var $date_created;
	var $popularity;
}
?>