<h1>Email Confirmation</h1>
<hr/>
<p>Please clink the link below and enter this 6-digit number: {{$number}}</p>
<a href="{{URL::to("/api/confirm/$email")}}">Confirm Registration</a>