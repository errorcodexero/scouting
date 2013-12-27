<?php

// a thin veneer of security...
$users = array('admin' => 'mypass', 'guest' => 'guest');

// print "method = " . $_SERVER['REQUEST_METHOD'] . "\n";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST["username"]) && !empty($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		
        $pwd = $users[$username];

        // echo "pwd = $pwd, password = $password\n";

        if ($password == $pwd) {
            session_start();

            $_SESSION["username"] = $username;
            $_SESSION["authenticated"] = 'true';
            header('Location: index.php');
        }
		else {
			echo "Login failed.";
		}
	}
    else {
        echo "Login failed.";
	}
} 
else {

    include 'header.php';
?>

<h1>Please Log In</h1> 
<form method='post' action='login.php'>
    <p>Username: <input type='text'name='username' required></p>
    <p>Password: <input type='password' name='password' required></p>
    <p><input type='submit' name='submit' value='Log In'></p>
</form>

<?php

include 'footer.php';
}

?>

