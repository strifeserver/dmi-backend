<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
</head>
<style type="text/css">
.container {
  text-align: center;
}
.box {
  border: 1px solid #000;
  border-radius: 5px;
  padding: 50px;
  width: 50%;
  display: inline-block;
}
.code{
  background-color: rgb(51, 122, 183);
  width: 200px;
  border-radius: 5px;
  display: inline-block;
}
p{
 display: inline-block;
}

</style>
<body>
	<div class="container" style="text-align: center;">
	  <div class="box" style="border: 1px solid #000;
  border-radius: 5px;
  padding: 50px;
  width: 50%;
  display: inline-block;">
	    <h1>RESET PASSWORD</h1>
	     <hr>
	    <h3>You're receiving this e-mail because you requested a password reset for your account.</h3>
	    <br>
	    <div class="code" style="background-color: rgb(51, 122, 183);
  width: 200px;
  border-radius: 5px;
  display: inline-block;">
	      <p style="display: inline-block; font-weight: bold; font-size: 20px;">{{ $temp_pass }}</p>
	    </div>
	    
	    <br>
	    
	    <h3>Note:Use this code to login to reset your password.</h3>
	  </div>
	  
	</div>
</body>
</html>