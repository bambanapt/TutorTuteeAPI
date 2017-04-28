<?php

/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 04/02/17
 * Time: 7:51 PM
 */
class dbOperation {
    private $conn;

    //Constructor
    function __construct()
    {
        require_once 'constants.php';
        require_once 'dbConnection.php';
        
        // opening db connection
        $db = new dbConnection();
        $this->conn = $db->connect();
    }

    public function createTutee($username, $email, $password, $image)
    {
        if (!$this->isUsernameExist($username)) {
            if (!$this->isTuteeEmailExist($email)) {
                $code = md5(uniqid(rand()));

                $stmt = $this->conn->prepare("INSERT INTO tutees (username, email, password, image, tokenCode) 
                                              VALUES (:username, :email, :password, :image, :code)");
                $stmt->bindparam(":username", $username);
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":password", $password);
                $stmt->bindparam(":image", $image);
                $stmt->bindparam(":code", $code);

                if ($stmt->execute()) {
                    $id = $this->conn->lastInsertId();
                    $key = base64_encode($id);
                    $id = $key;
                    $message =  "Hello Tutee $username,
                                <br /><br />
                                Welcome to TutorTutee!<br/>
                                To complete your registration, please click the following link.<br/>
                                <br /><br />
                                <a href='http://localhost:8888/New/verifyTutee.php?id=$id&code=$code'>Click HERE to activate</a>
                                <br /><br />
                                Thank you,<br/>
                                TutorTutee";
                    $subject = "TutorTutee Confirm Registration";
                    $this->sendMail($email,$message,$subject);
                    return USER_CREATED;
                } else {
                    return USER_NOT_CREATED;
                }
                // $stmt->execute();
                // return USER_CREATED;
            } else {
                return EMAIL_ALREADY_EXIST;  
            }
        } else {
            return USERNAME_ALREADY_EXIST;
        }
    }

    public function createTutor($tutor_Fname, $tutor_Lname, $email, $password, $description, $gender, $age, $image, $subject, $hourly_rate, $location, $faculty, $university,$certificate,$transcript,$phone,$lineID, $account_name, $account_no, $bank_name)
    {
        if (!$this->isTutorEmailExist($email)) {
            $code = md5(uniqid(rand()));

            $stmt = $this->conn->prepare("INSERT INTO tutors (tutor_Fname, tutor_Lname, email, password, description, gender, age, image, subject, hourly_rate, location, faculty, university, certificate, transcript,phone, lineID, account_name, account_no, bank_name, tokenCode) 
                VALUES (:tutor_Fname, :tutor_Lname, :email, :password, :description, :gender, :age, :image, :subject, :hourly_rate, :location, :faculty, :university, :certificate, :transcript, :phone, :lineID, :account_name, :account_no, :bank_name, :code)");
                $stmt->bindparam(":tutor_Fname", $tutor_Fname);
                $stmt->bindparam(":tutor_Lname", $tutor_Lname);
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":password", $password);
                $stmt->bindparam(":description", $description);
                $stmt->bindparam(":gender", $gender);
                $stmt->bindparam(":age", $age);
                $stmt->bindparam(":image", $image);
                $stmt->bindparam(":subject", $subject);
                $stmt->bindparam(":hourly_rate", $hourly_rate);
                $stmt->bindparam(":location", $location);
                $stmt->bindparam(":faculty", $faculty);
                $stmt->bindparam(":university", $university);
                $stmt->bindparam(":certificate", $certificate);
                $stmt->bindparam(":transcript", $transcript);
                $stmt->bindparam(":phone", $phone);
                $stmt->bindparam(":lineID", $lineID);
                $stmt->bindparam(":account_name", $account_name);
                $stmt->bindparam(":account_no", $account_no);
                $stmt->bindparam(":bank_name", $bank_name);
                $stmt->bindparam(":code", $code);

                if ($stmt->execute()) {
                    $id = $this->conn->lastInsertId();
                    $key = base64_encode($id);
                    $id = $key;
                    $message =  "Hello Tutor $tutor_Fname,
                                <br /><br />
                                Welcome to TutorTutee!<br/>
                                To verify your email address, please click the following link.<br/>
                                <br /><br />
                                <a href='http://localhost:8888/New/verifyTutor.php?id=$id&code=$code'>Click HERE to activate</a>
                                <br /><br />
                                Thank you,<br/>
                                TutorTutee";
                    $subject = "TutorTutee Email Activation";
                    $this->sendMail($email,$message,$subject);
                    return USER_CREATED;
                } else {
                    return USER_NOT_CREATED;
                }
                // $stmt->execute();
                // return USER_CREATED;
        } else {
            return EMAIL_ALREADY_EXIST;
        }
    }

    public function forgetTuteePW($email)
    {
        $stmt = $this->conn->prepare("SELECT tutee_ID FROM tutees WHERE email=:email LIMIT 1");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($stmt->rowCount() == 1) {
            $id = base64_encode($row['tutee_ID']);
            $code = md5(uniqid(rand()));
      
            $stmt = $this->conn->prepare("UPDATE tutees SET tokenCode=:code WHERE email=:email");
            $stmt->execute(array(":code"=>$code,"email"=>$email));
      
            $message= "
               Hello Tutee,
               <br /><br />
               We got request to reset your password. <br />
               If you do this, please click the following link to reset your password. <br />
               if not, please ignore this email.
               <br /><br />
               <a href='http://localhost:8888/New/resetTuteePW.php?id=$id&code=$code'>Click HERE to reset your password</a>
               <br /><br />
               Thank you,<br />
               TutorTutee
               ";
            $subject = "TutorTutee Password Reset";
      
            $this->sendMail($email,$message,$subject);
            return EMAIL_SENT;
        } else {
            return EMAIL_NOT_FOUND;
        }
    }

    public function forgetTutorPW($email)
    {
        $stmt = $this->conn->prepare("SELECT tutor_ID FROM tutors WHERE email=:email LIMIT 1");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($stmt->rowCount() == 1) {
            $id = base64_encode($row['tutor_ID']);
            $code = md5(uniqid(rand()));
      
            $stmt = $this->conn->prepare("UPDATE tutors SET tokenCode=:code WHERE email=:email");
            $stmt->execute(array(":code"=>$code,"email"=>$email));
      
            $message= "
               Hello Tutor,
               <br /><br />
               We got request to reset your password. <br />
               If you do this, please click the following link to reset your password. <br />
               if not, please ignore this email.
               <br /><br />
               <a href='http://localhost:8888/New/resetTutorPW.php?id=$id&code=$code'>Click HERE to reset your password</a>
               <br /><br />
               Thank you,<br />
               TutorTutee
               ";
            $subject = "TutorTutee Password Reset";
      
            $this->sendMail($email,$message,$subject);
            return EMAIL_SENT;
        } else {
            return EMAIL_NOT_FOUND;
        }
    }

    public function tuteeLogin($email,$password)
    {
    	$result = array();
        $stmt = $this->conn->prepare("SELECT * FROM tutees WHERE email=:email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            if($row['activated']=='Y') {
                if($row['password']== $password) {
                	$result['data'] = $row;
                	$result['constant'] = USER_FOUND;
                    return $result;
                } else {
                	$result['constant'] = INCORRECT_PW;
                	return $result;
                }  
            } else {
            	$result['constant'] = INACTIVATE_USER;
                return $result;
            }  
        } else {
        	$result['constant'] = USER_NOT_FOUND;
            return $result;
        }    
    }

    public function tutorLogin($email,$password)
    {
    	$result = array();
        $stmt = $this->conn->prepare("SELECT * FROM tutors WHERE email=:email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            if($row['activated']=='Y') {
                if($row['verify']=='Y') {
                    if($row['password']== $password) {
                    	$result['data'] = $row;
                		$result['constant'] = USER_FOUND;
                        return $result;
                    } else {
                        $result['constant'] = INCORRECT_PW;
                        return $result;
                    }
                } else {
                    $result['constant'] = USER_NOT_VERIFIED;
                    return $result;
                }
            } else {
                $result['constant'] = INACTIVATE_USER;
                return $result;
            }    
        } else {
            $result['constant'] = USER_NOT_FOUND;
            return $result;
        }    
    }

    public function editTuteeProfile($id,$password,$image)
    {
    	$result = array();
        $stmt = $this->conn->prepare("SELECT * FROM tutees WHERE tutee_ID=:id LIMIT 1");
        $stmt->execute(array(":id"=>$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            if ($password == null) $password = $row['password'];
            if ($image == null) $image = $row['image'];
            $stmt = $this->conn->prepare("UPDATE tutees SET password=:password, image=:image WHERE tutee_ID=:id");
            $stmt->execute(array(":password"=>$password, ":image"=>$image, ":id"=>$row['tutee_ID']));

            $stmt1 = $this->conn->prepare("SELECT * FROM tutees WHERE tutee_ID=:id");
        	$stmt1->execute(array(":id"=>$id));
        	$data = $stmt1->fetch(PDO::FETCH_ASSOC);

            $result['data'] = $data;
            $result['constant'] = USER_UPDATED;
            return $result;
        } elseif ($stmt->rowCount() == 0) {
            $result['constant'] = USER_NOT_FOUND;
            return $result;
        } else {
            $result['constant'] = USER_NOT_UPDATED; 
            return $result;
        }
    }

    public function editTutorProfile($id,$password,$description,$gender,$age,$image,$subject,$hourly_rate,$location,$phone,$lineID,$account_name,$account_no,$bank_name)
    {
    	$result = array();
        $stmt = $this->conn->prepare("SELECT * FROM tutors WHERE tutor_ID=:id LIMIT 1");
        $stmt->execute(array(":id"=>$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt->rowCount() == 1) {
            if ($password == null) $password = $row['password'];
            if ($description == null) $description = $row['description'];
            if ($gender == null) $gender = $row['gender'];
            if ($age == null) $age = $row['age'];
            if ($image == null) $image = $row['image'];
            if ($subject == null) $subject = $row['subject'];
            if ($hourly_rate == null) $hourly_rate = $row['hourly_rate'];
            if ($location == null) $location = $row['location'];
            if ($phone == null) $phone = $row['phone'];
            if ($lineID == null) $lineID = $row['lineID'];
            if ($account_name == null) $account_name = $row['account_name'];
            if ($account_no == null) $account_no = $row['account_no'];
            if ($bank_name == null) $bank_name = $row['bank_name'];

            $stmt = $this->conn->prepare("UPDATE tutors SET password=:password, description=:description, gender=:gender, age=:age, image=:image, subject=:subject, hourly_rate=:hourly_rate, location=:location, phone=:phone, lineID=:lineID, account_name=:account_name, account_no=:account_no, bank_name=:bank_name WHERE tutor_ID=:id");
            $stmt->execute(array(":password"=>$password, ":description"=>$description, ":gender"=>$gender, ":age"=>$age, ":image"=>$image, ":subject"=>$subject, ":hourly_rate"=>$hourly_rate, ":location"=>$location, ":phone"=>$phone, ":lineID"=>$lineID, ":account_name"=>$account_name, ":account_no"=>$account_no, ":bank_name"=>$bank_name, ":id"=>$row['tutor_ID']));

            $stmt1 = $this->conn->prepare("SELECT * FROM tutors WHERE tutor_ID=:id");
        	$stmt1->execute(array(":id"=>$id));
        	$data = $stmt1->fetch(PDO::FETCH_ASSOC);

            $result['data'] = $data;
            $result['constant'] = USER_UPDATED;
            return $result;
        } elseif ($stmt->rowCount() == 0) {
            $result['constant'] = USER_NOT_FOUND;
            return $result;
        } else {
           $result['constant'] = USER_NOT_UPDATED;
           return $result; 
        }
    }

    public function createSession($tutor_ID, $date, $start_time, $finish_time, $duration, $subject, $location)
    {
    	$result = array();
        if (!$this->isSameStart($tutor_ID,$date,$start_time) && !$this->isSameFinish($tutor_ID,$date,$finish_time) && 
            !$this->isOtherCase($tutor_ID,$date,$start_time,$finish_time)) {
            $stmt = $this->conn->prepare("INSERT INTO sessions (tutor_ID, date, start_time, finish_time, duration, subject, location) VALUES (:tutor_ID, :date, :start_time, :finish_time, :duration, :subject, :location)");

            $stmt->bindparam(":tutor_ID", $tutor_ID);
            $stmt->bindparam(":date", $date);
            $stmt->bindparam(":start_time", $start_time);
            $stmt->bindparam(":finish_time", $finish_time);
            $stmt->bindparam(":duration", $duration);
            $stmt->bindparam(":subject", $subject);
            $stmt->bindparam(":location", $location);

            if ($stmt->execute()) {
            	$id = $this->conn->lastInsertId();
                $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE session_ID=:id");
        		$stmt->execute(array(":id"=>$id));
        		$session = $stmt->fetch(PDO::FETCH_ASSOC);

            	$result['data'] = $session;
            	$result['constant'] = SESSION_CREATED;
                return $result;
            } else {
            	$result['constant'] = SESSION_NOT_CREATED;
                return $result;
            }
                // $stmt->execute();
                // return USER_CREATED;
        } else {
        	$result['constant'] = SESSION_EXISTED;
            return $result;
        }
    }

    public function getTuteeBookedSessions($id)
    {
    	$status = 'booked';
        $stmt = $this->conn->prepare("SELECT s.session_ID, t.tutor_Fname, t.tutor_Lname, s.date, s.start_time, s.finish_time, s.duration, s.subject, s.location, s.status
                                    FROM sessions s, tutors t
                                    WHERE s.tutee_ID = :id AND s.tutor_ID = t.tutor_ID AND s.status = :status
                                    ORDER BY s.date, s.start_time ASC");
        $stmt->execute(array(":id"=>$id,":status"=>$status));
        $sessions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $sessions;
    }

    public function getAllAvailableSessions()
    {
        $status = 'vacant';
        $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE status=:status ORDER BY date, start_time ASC");
        $stmt->execute(array(":status"=>$status));
        $sessions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $sessions;
    }

    public function getTutorBookedSessions($id)
    {
        $status = 'booked';
        $stmt = $this->conn->prepare("SELECT s.session_ID, t.username, s.date, s.start_time, s.finish_time, s.duration, s.subject, s.location, s.status
                                    FROM sessions s, tutees t
                                    WHERE s.tutor_ID = :id AND s.tutee_ID = t.tutee_ID AND s.status = :status
                                    ORDER BY s.date, s.start_time ASC");
        $stmt->execute(array(":id"=>$id,":status"=>$status));
        $sessions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $sessions;
    }

    public function getTutorCreatedSessions($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM sessions s WHERE s.tutor_ID = :id ORDER BY s.date, s.start_time ASC");
        $stmt->execute(array(":id"=>$id));
        $sessions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $sessions;
    }

    public function getTutorAvailableSessions($id)
    {
        $status = 'vacant';
        $stmt = $this->conn->prepare("SELECT s.session_ID, s.tutor_ID, s.date, s.start_time, s.finish_time, s.duration, s.subject, s.location, s.status
                                    FROM sessions s
                                    WHERE s.tutor_ID = :id AND s.tutee_ID IS NULL AND s.status = :status
                                    ORDER BY s.date, s.start_time ASC");
        $stmt->execute(array(":id"=>$id,":status"=>$status));
        $sessions = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $sessions;
    }

    public function sortAndSearchTutors($sort,$search,$value)
    {
        $verify = 'Y';
        $name = 'name';
        $subject = 'subject';
        $location = 'location';
        $rating = 'rating';
        $price = 'price';
        $orderBy = "ORDER BY tutor_Fname ASC";

        if($sort == $rating) {
            $orderBy = "ORDER BY rating DESC";
        } elseif($sort == $price) {
            $orderBy = "ORDER BY hourly_rate ASC";
        }

        if($search == $name) {
            $tutor_Fname = $value . '%';
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND tutor_Fname LIKE :tutor_Fname ";
            $sql = $sql . $orderBy;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify, ":tutor_Fname"=>$tutor_Fname));
        } elseif ($search == $subject) {
            $subject1 = $value . '%';
        	$subject2 = '%,' . $value . '%';
	        $subject3 = '%, ' . $value . '%';
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND (subject LIKE :subject1 OR subject LIKE :subject2 OR subject LIKE :subject3) ";
            $sql = $sql . $orderBy;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify, ":subject1"=>$subject1, ":subject2"=>$subject2, ":subject3"=>$subject3));
        } elseif ($search == $location) {
        	$location1 = $value . '%';
        	$location2 = '%,' . $value . '%';
	        $location3 = '%, ' . $value . '%';

            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND (location LIKE :location1 OR location LIKE :location2 OR location LIKE :location3) ";
            $sql = $sql . $orderBy;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify, ":location1"=>$location1, ":location2"=>$location2, ":location3"=>$location3));
        } else {
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify ";
            $sql = $sql . $orderBy;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify));
        }

        $tutors = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $tutors;
    }

    public function sortTutors($sort)
    {
        $verify = 'Y';
        $rating = 'rating';
        $price = 'price';
        if($sort == $rating) {
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify ORDER BY rating DESC";
        } elseif ($sort == $price) {
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify ORDER BY hourly_rate ASC";
        } else {
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify ORDER BY tutor_Fname ASC";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(":verify"=>$verify));
        $tutors = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $tutors;
    }

    public function searchTutors($search,$value)
    {
        $verify = 'Y';
        $name = 'name';
        $subject = 'subject';
        $location = 'location';

        if($search == $name) {
            $tutor_Fname = $value . '%';
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND tutor_Fname LIKE :tutor_Fname ORDER BY tutor_Fname ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify, ":tutor_Fname"=>$tutor_Fname));
        } elseif ($search == $subject) {
        	$subject1 = $value . '%';
        	$subject2 = '%,' . $value . '%';
	        $subject3 = '%, ' . $value . '%';

	        $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND (subject LIKE :subject1 OR subject LIKE :subject2 OR subject LIKE :subject3) ORDER BY tutor_Fname ASC";
	        $stmt = $this->conn->prepare($sql);
	        $stmt->execute(array(":verify"=>$verify, ":subject1"=>$subject1, ":subject2"=>$subject2, ":subject3"=>$subject3));
        } elseif ($search == $location) {
        	$location1 = $value . '%';
        	$location2 = '%,' . $value . '%';
	        $location3 = '%, ' . $value . '%';
	       	
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify AND (location LIKE :location1 OR location LIKE :location2 OR location LIKE :location3) ORDER BY tutor_Fname ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify, ":location1"=>$location1, ":location2"=>$location2, ":location3"=>$location3));
        } else {
            $sql = "SELECT tutor_ID, tutor_Fname, tutor_Lname, description, gender, age, subject, hourly_rate, location, faculty, university, rating FROM tutors WHERE verify=:verify ORDER BY tutor_Fname ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":verify"=>$verify));
        }
        
        $tutors = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $tutors;
    }

     public function getTutors()
    {
        $verify = 'Y';
        $stmt = $this->conn->prepare("SELECT * FROM tutors WHERE verify=:verify ORDER BY tutor_Fname ASC");
        $stmt->execute(array(":verify"=>$verify));
        $tutors = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $tutors;
    }

    public function getTutor($id)
    {
        $verify = 'Y';
        $stmt = $this->conn->prepare("SELECT * FROM tutors WHERE tutor_ID=:id AND verify=:verify");
        $stmt->execute(array(":id"=>$id,":verify"=>$verify));
        $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tutor;
    }

     public function getTutee($id)
    {
        $activated = 'Y';
        $stmt = $this->conn->prepare("SELECT * FROM tutees WHERE tutee_ID=:id AND activated=:activated");
        $stmt->execute(array(":id"=>$id,":activated"=>$activated));
        $tutee = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tutee;
    }

    public function bookSession($session_ID, $tutee_ID)
    {
        if (!$this->isSessionBooked($session_ID)) {
            $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE session_ID=:session_ID LIMIT 1");
            $stmt->execute(array(":session_ID"=>$session_ID));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1) {
            	$result = array();
                $status = 'booked';
                $stmt = $this->conn->prepare("UPDATE sessions SET tutee_ID=:tutee_ID, status=:status WHERE session_ID=:session_ID");
                $stmt->execute(array(":tutee_ID"=>$tutee_ID, ":status"=>$status, ":session_ID"=>$row['session_ID']));

                $tutor = $this->conn->prepare("SELECT * FROM tutors WHERE tutor_ID=:tutor_ID");
            	$tutor->execute(array(":tutor_ID"=>$row['tutor_ID']));
            	$tutorRow = $tutor->fetch(PDO::FETCH_ASSOC);

            	$tutee = $this->conn->prepare("SELECT * FROM tutees WHERE tutee_ID=:tutee_ID");
            	$tutee->execute(array(":tutee_ID"=>$tutee_ID));
            	$tuteeRow = $tutee->fetch(PDO::FETCH_ASSOC);

            	$tutorName = $tutorRow['tutor_Fname'] . " " . $tutorRow['tutor_Lname'];
            	$tuteeUsername = $tuteeRow['username'];
            	$subject = $row['subject'];
            	$date = $row['date'];
            	$time = $row['start_time'] . " - " . $row['finish_time'];
            	$duration = $row['duration'];
            	$location = $row['location'];
            	
            	$title = "TutorTutee Session Confirmation";
            	
	            $tutorMsg = "
		               Hello Tutor $tutorName,
		               <br /><br />
		               Your session has been booked.
		               <br /><br />
		               ----------Session Details----------<br /> 
		               Session ID: $session_ID<br /> 
		               Tutee: $tuteeUsername<br />
		               Subject: $subject<br />
		               Date: $date<br />
		               Time: $time<br />
		               Duration: $duration hrs<br />
		               Location: $location<br />
		               <br /><br />
		               Thank you,<br />
		               TutorTutee";
	      		
	            $this->sendMail($tutorRow['email'],$tutorMsg,$title);
	           
	            $tuteeMsg = "
		               Hello Tutee $tuteeUsername,
		               <br /><br />
		               You have booked a session. <br />
		               <br /><br />
		               ----------Session Details----------<br /> 
		               Session Details<br /> 
		               Session ID: $session_ID<br /> 
		               Tutor: $tutorName<br />
		               Subject: $subject<br />
		               Date: $date<br />
		               Time: $time<br />
		               Duration: $duration hrs<br />
		               Location: $location<br />
		               <br /><br />
		               Thank you,<br />
		               TutorTutee";
	      
	            $this->sendMail($tuteeRow['email'],$tuteeMsg,$title);

	            $session = $this->conn->prepare("SELECT s.session_ID, te.username, t.tutor_Fname, t.tutor_Lname, s.date, s.start_time, s.finish_time, s.duration, s.subject, s.location, s.status
                                    FROM sessions s, tutors t, tutees te
                                    WHERE s.session_ID = :id AND s.tutor_ID = t.tutor_ID AND s.tutee_ID = te.tutee_ID
                                    ORDER BY s.date ASC");
            	$session->execute(array(":id"=>$session_ID));
            	$data = $session->fetch(PDO::FETCH_ASSOC);
	            
	            $result['data'] = $data;
	            $result['constant'] = SESSION_BOOKED;
                return $result;
            } elseif ($stmt->rowCount() == 0) {
                $result['constant'] = SESSION_NOT_FOUND;
                return $result;
            } else {
            	$result['constant'] = SESSION_NOT_BOOKED;
                return $result;
            }
        } else {
        	$result['constant'] = SESSION_NOT_AVAILABLE;
            return $result;
        }
    }

    public function deleteSession($id)
    {
    	if ($this->isSessionExist($id)) {
            if(!$this->isSessionBooked($id)){
    	    	$stmt = $this->conn->prepare("DELETE FROM sessions WHERE session_ID = :id");
    	    	$stmt->execute(array(":id"=>$id));
    	        return SESSION_DELETED;
            } else {
                return SESSION_NOT_AVAILABLE; 
            }
    	} else {
    		return SESSION_NOT_EXIST;
    	}
    }

    private function isUsernameExist($username)
    {
        $stmt = $this->conn->prepare("SELECT tutee_ID FROM tutees WHERE username = :username");
        $stmt->execute(array(":username"=>$username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isTuteeEmailExist($email)
    {
        $stmt = $this->conn->prepare("SELECT tutee_ID FROM tutees WHERE email = :email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isTutorEmailExist($email)
    {
        $stmt = $this->conn->prepare("SELECT tutor_ID FROM tutors WHERE email = :email");
        $stmt->execute(array(":email"=>$email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }
    
    private function isSameStart($tutor_ID,$date,$start_time)
    {
        $stmt = $this->conn->prepare("SELECT tutor_ID FROM sessions WHERE tutor_ID = :tutor_ID AND date = :date AND start_time = :start_time");
        $stmt->execute(array(":tutor_ID"=>$tutor_ID, ":date"=>$date, ":start_time"=>$start_time));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isSameFinish($tutor_ID,$date,$finish_time)
    {
        $stmt = $this->conn->prepare("SELECT tutor_ID FROM sessions WHERE tutor_ID = :tutor_ID AND date = :date AND finish_time = :finish_time");
        $stmt->execute(array(":tutor_ID"=>$tutor_ID, ":date"=>$date, ":finish_time"=>$finish_time));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isOtherCase($tutor_ID,$date,$start_time,$finish_time)
    {
        $stmt = $this->conn->prepare("SELECT tutor_ID FROM sessions WHERE tutor_ID = :tutor_ID AND date = :date 
            AND ((start_time < :start_time AND finish_time > :finish_time) 
            OR (start_time > :start_time AND finish_time < :finish_time) 
            OR (start_time < :start_time AND finish_time > :start_time AND finish_time < :finish_time)
            OR (start_time > :start_time AND start_time < :finish_time AND finish_time > :finish_time ))");
        $stmt->execute(array(":tutor_ID"=>$tutor_ID, ":date"=>$date, ":start_time"=>$start_time, ":finish_time"=>$finish_time));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isSessionExist($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE session_ID = :id");
        $stmt->execute(array(":id"=>$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    private function isSessionBooked($session_ID)
    {
        $status = 'booked';
        $stmt = $this->conn->prepare("SELECT session_ID FROM sessions WHERE session_ID = :session_ID AND status = :status");
        $stmt->execute(array(":session_ID"=>$session_ID, ":status" => $status));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->rowCount() > 0;
    }

    function sendMail($email,$message,$subject)
    {
        require_once('class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->CharSet    = 'utf-8';
        $mail->SMTPDebug  = 1;                     
        $mail->SMTPAuth   = true;                  
        $mail->SMTPSecure = "ssl";                 
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 465;             
        $mail->AddAddress($email);
        $mail->Username = "tutortutee.matchingservice@gmail.com";  
        $mail->Password = "tutortuteematchingservice";            
        //$mail->From('sekthakarn.s@gmail.com','TutorTutee');
        $mail->AddReplyTo("tutortutee.matchingservice@gmail.com","TutorTutee");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        if($mail->Send()) {
            echo "Message was successfully sent.";
        } else {
            echo "Mail Error - >".$mail->ErrorInfo;
        }
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
}
?>