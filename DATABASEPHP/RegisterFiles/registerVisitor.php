<html>
 <head>
  <title>DatAnimal</title>
 </head>
 <body>

 <h1>VISITOR REGISTER SYSTEM</h1>
<br><br/>
<button onclick='history.go(-1);'>Go Back </button>
<br><br/>
<form name ="formLog" onsubmit="return validateForm()" action = "registerVisitorMethod.php" method = "POST">
        <label>User ID</label>
        <input type = "number" name = "userid">
		<br><br/>
        <label>Password</label>
        <input type = "text" name = "password">
        <br><br/>
		<label>Email</label>
        <input type = "text" name = "email">
        <br><br/>
		<label>PhoneNo</label>
        <input type = "number" name = "phoneno">
        <br><br/>
		<label>Birthdate</label>
        <input type = "date" name = "birthyear">
        <br><br/>
		<label>Name</label>
        <input type = "text" name = "name">
        <br><br/>
		<label>Address</label>
        <input type = "text" name = "address">
        <br><br/>
		<label>Gender</label>
        <input type = "text" name = "gender">
        <br><br/>
		<label>Occupation</label>
        <input type = "text" name = "occupation">
        <br><br/>
        <input type="submit" value="Submit"> 
</form>

 </body>
</html>
