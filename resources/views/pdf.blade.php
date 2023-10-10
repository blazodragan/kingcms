<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Detail</title>
    <style>
/*
  Common invoice styles. These styles will work in a browser or using the HTML
  to PDF anvil endpoint.
*/

body {
  font-family:'Dejavu Sans', Arial, Helvetica, sans-serif;
  font-size: 16px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

table tr td {
  padding: 0;
}

table tr td:last-child {
  text-align: right;
}

.bold {
  font-weight: bold;
}

.right {
  text-align: right;
}

.left {
  text-align: left;
}

.large {
  font-size: 1.25em;
  width: 100%;
  text-align: left;
}

.total {
  font-weight: bold;
  color: #2563eb;
}

.total-right {
  text-align: right;
  font-weight: bold;
  color: #2563eb;
}

.logo-container {
  margin: 20px 0 70px 0;
}

.invoice-info-container {
  font-size: 0.875em;
}
.invoice-info-container td {
  padding: 1px 0;
}

.client-name {
  font-size: 1.5em;
  vertical-align: top;
}

.line-items-container {
  margin: 10px 0;
  font-size: 0.875em;
}

.line-items-container th {
  text-align: right;
  color: #999;
  border-bottom: 2px solid #ddd;
  padding: 5px 0 5px 0;
  font-size: 0.75em;
  text-transform: uppercase;
}
.subject {
    color: #2563eb;
    text-transform: uppercase;

}
.line-items-container th:last-child {
  text-align: left;
}

.line-items-container td:last-child {
  text-align: left;
}

.line-items-container td {
  padding: 5px 0;
}

.line-items-container tbody tr:first-child td {
  padding-top: 10px;
}

.line-items-container.has-bottom-border tbody tr:last-child td {
  padding-bottom: 25px;
  border-bottom: 2px solid #ddd;
}

.line-items-container.has-bottom-border {
  margin-bottom: 0;
}

.line-items-container th.heading-quantity {
  width: 50px;
}
.line-items-container th.heading-price {
  text-align: left;
  width: 400px;
}
.line-items-container th.heading-subtotal {
  width: 100px;
}

.payment-info {
  width: 38%;
  font-size: 0.75em;
  line-height: 1.5;
}

.footer {
    position: fixed;
    bottom: 0;
  margin-top: 100px;
  text-align: center;
  width: 100%;
}


.footer-info {
  margin-top: 5px;
  font-size: 0.75em;
  color: #ccc;
}

.footer-info span {
  padding: 0 5px;
  color: black;
}

.footer-info span:last-child {
  padding-right: 0;
}

.page-container {
  display: none;
}
    </style>
</head>
<body>
<div class="page-container">
  Page
  <span class="page"></span>
  of
  <span class="pages"></span>
</div>

<div class="logo-container">
<img src="{{url('BiDiTi.jpg')}}" style="height: 100px" alt="Image"/>
</div>
<table class="invoice-info-container">
  <tr>
    <td rowspan="2" class="client-name">
      Case # : @if( !empty($data['attributes']['case_number'])){{ $data['attributes']['case_number'] }}@endif
    </td>
    <td>
      BIDITI
    </td>
  </tr>
  <tr>
    <td>
    ул. Варшавска бр.4 2-4
    </td>
  </tr>
  <tr>
    <td>
    Created by: <strong>@if( !empty($data['attributes']['account_name'])){{ $data['attributes']['account_name'] }}@endif</strong>
    </td>
    <td>
    Скопје, Македонија 1000
    </td>
  </tr>
  <tr>
    <td>
    Date Created: <strong>@if( !empty($data['attributes']['case_number'])){{ date('d-m-Y h:m', strtotime($data['attributes']['date_entered']));}}@endif</strong>
    </td>
    <td>
    email: support@biditi.com
    </td>
  </tr>
</table>
<br>

<table class="line-items-container">
  <thead>
    <tr>
      <th class=""></th>
      <th class=""></th>
      <th class=""></th>
      <th class=""></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Priority:</td>
      <td><span class="total-right">@if( !empty($data['attributes']['priority'])){{ $data['attributes']['priority'] }}@endif</span></td>
      <td>Status: </td>
      <td><span class="total-right">@if( !empty($data['attributes']['state'])){{ $data['attributes']['state'] }}@endif</span></td>
    </tr>
    <tr>
      <td>Type:</td>
      <td><span class="total-right">@if( !empty($data['attributes']['status'])){{ $data['attributes']['status'] }}@endif</span></td>
      <td>Terminal:</td>
      <td><span class="total-right">@if( !empty($data['attributes']['terminal'])){{ $data['attributes']['terminal'] }}@endif</span></td>
    </tr>
  </tbody>
</table>

<br>
<p class="bold subject">Subject : <span class="bold">@if( !empty($data['attributes']['name'])){{ $data['attributes']['name'] }}@endif</span></p>

<br>
<table class="line-items-container">
  <thead>
    <tr>
      <th>Description:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="large">@if( !empty($data['attributes']['description'])){{ $data['attributes']['description'] }}@endif</td>
    </tr>
  </tbody>
</table>
<br>
<table class="line-items-container">
  <thead>
    <tr>
      <th>Resolution:</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="large">@if( !empty($data['attributes']['resolution'])){{ $data['attributes']['resolution'] }}@endif</td>
    </tr>
  </tbody>
</table>

<div class="footer">
  <div class="footer-info">
    <span>support@biditi.com</span> |
    <span>++38970 333 333</span> |
    <span>biditi.com</span>
  </div>
</div>
      </body>
</html>