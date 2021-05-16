<html>
 <head>
  <title>DatAnimal</title>
 </head>
 <body>

 <h1>ADMIN PANEL ENTRANCE OF REGISTER SYSTEM</h1>
 <br><br/>
<button onclick='history.go(-1);'>Go Back </button>
<br><br/>
<br><br/>
<form name ="formLog" onsubmit="return validateForm()" action = "registerAdminCheck.php" method = "POST">
        <label>User ID</label>
        <input type = "text" name = "username">
        <label>Password</label>
        <input type = "password" name = "password">
        <br><br/>
        <input type="submit" value="Login"> 
</form>

 </body>
</html>
