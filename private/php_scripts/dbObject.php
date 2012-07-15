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
	
    public function addEmail($email)
    {
        $email = addslashes($email);
        
        $to = $email;
        $subject = "Thanks!";
        $body = "Thanks for showing interest in Resumake! \n\n We'll send you new information when we can! \n\n Regards,\n-The Resumake Team";

        mail($to, $subject, $body);
        
        $sql = "INSERT INTO previewregister (email) VALUES ('$email')";
		return mysql_query($sql);
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

	public function addImagePathByUsername($path, $username){
		$imgpath = addslashes($path);
		$mysql = "UPDATE users SET imagepath='$imgpath' WHERE username='$username'";
		return mysql_query($mysql);
	}
	
	public function confirmUser($uid){
		$user = $this->getUserById($uid);
		copy("../private/default/index.php", "../users/" . $user->username . ".php");
	
		$mysql = "UPDATE users SET is_confirmed=1 WHERE uid='$uid'";
		return mysql_query($mysql); 
	}
	
	public function updateUserInfo($uid, $info){
		$mysql = "UPDATE users SET info='$info' WHERE uid='$uid'";
		if($info == -1){
			return -1;
		}
		return mysql_query($mysql);
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
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
		$user->imagepath = stripslashes($row['imagepath']);
	
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
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
		$user->imagepath = stripslashes($row['imagepath']);
	
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
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
		$user->imagepath = stripslashes($row['imagepath']);
		
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
		$user->is_confirmed = stripslashes($row['is_confirmed']);
		$user->confirmation_code = stripslashes($row['confirmation_code']);
		$user->imagepath = stripslashes($row['imagepath']);
	
		return $user;
	}
	
	
	///////////////////////// RESUME ///////////////////////////////////////////
	
	public function getResumesByUid($uid){
		$sql = "SELECT * FROM resume WHERE uid=$uid";
		$result = mysql_query($sql);
        $resumes = array();
		while($row = mysql_fetch_array($result)){
            $resume = new Resume;
            $resume->rid = stripslashes($row['rid']);
            $resume->uid = stripslashes($row['uid']);
            $resume->name = stripslashes($row['name']);
            $resume->date_created = $this->parseTimestamp(stripslashes($row['date_created']));
            $resume->content = stripslashes($row['content']);
            array_push($resumes, $resume);
        }
		return $resumes;
	}
    
    public function getResumeByRid($rid){
        $sql = "SELECT * FROM resume WHERE rid=$rid";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $resume = new Resume;
        $resume->rid = stripslashes($row['rid']);
        $resume->uid = stripslashes($row['uid']);
        $resume->name = stripslashes($row['name']);
        $resume->date_created = $this->parseTimestamp(stripslashes($row['date_created']));
        $resume->content = stripslashes($row['content']);
        return $resume;
    }   
	
	public function addResumeByUid($uid, $content, $name){
		$content = addslashes($content);
		$name = addslashes($name);
	
		$sql = "INSERT INTO resume (uid, content, name) VALUES ('$uid', '$content', '$name')";
		mysql_query($sql);
        return mysql_insert_id();
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
	var $is_confirmed;
	var $confirmation_code;
	var $imagepath;
}

class Resume{
	var $rid;
	var $uid;
	var $name;
	var $date_created;
	var $content;
}
?>
