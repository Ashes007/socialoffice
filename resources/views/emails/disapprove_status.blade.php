@extends('emails.emailMaster')
@section('content')
<div style="padding:70px 20px 30px 20px; font-family:Arial; font-size:14px; line-height:25px;">
<table>
  <tr>
  	<td>Hello, {{ $name }}</td>
  </tr>
  <tr><td>{{ $content_message }} </td></tr>

   <tr>
    <td>Regards,<br>Team Tawasul</td>
  </tr>
  </table>
@stop