@extends('emails.emailMaster')
@section('content')
<div style="padding:70px 20px 30px 20px; font-family:Arial; font-size:14px; line-height:25px;">
<table>
  <tr>
  	<td>Hello, Admin</td>
  </tr>
  <tr><td>There is a new moderator request. Please change the role of the following user : </td></tr>
  <tr><td>Name : {{$name}}</td></tr>
  <tr><td>Email : {{$email}}</td></tr>
   <tr>
    <td>Regards,<br>Team Tawasul</td>
  </tr>
  </table>
@stop