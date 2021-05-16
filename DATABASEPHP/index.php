<html>
 <head>
  <title>DatAnimal</title>
 </head>
 <body>
 <h1>Welcome to DatANIMAL</h1>
<br><br/>
 <form name ="formLog" onsubmit="return validateForm()" action = "LoginFiles/login.php" method = "POST">
        <label>User ID</label>
        <input type = "text" name = "username">
        <label>Password</label>
        <input type = "password" name = "password">
        <br><br/>
        <input type="submit" value="Login"> 
</form>
<form name ="formReg" action = "RegisterFiles/register.php" method = "POST">
        <input type="submit" value="Register"> 
</form>
<script>
	function validateForm() 
	{
        if (document.forms["formLog"]["username"].value == ""){
        	alert("UserID and Password can not be empty");
        	return false;
    	} 
        if (document.forms["formLog"]["password"].value == ""){
        	alert("UserID and Password can not be empty");
        	return false;
    	}       
    }
</script>
 </body>
</html>
