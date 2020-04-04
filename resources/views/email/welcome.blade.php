<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user['name']}}</h2>
<br/>
Your registered email-id is <b>{{$user['email']}}</b> and the one time password is <b> {{$otp}} </b>  . 
<br>
<b>Please don't share the mail with anyone.</b>
</body>

</html>