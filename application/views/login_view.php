<!DOCTYPE html> <html> <head> <meta charset="utf-8" /> <title>Đăng Nhập Admin</title> <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!--[if lt IE 9]> <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script> <![endif]--> <style type="text/css"> body{ padding: 0px; margin: 0px; font-family: tahoma,times new roman,arial; font-weight: normal; background: #eef0f7; } a{ cursor: pointer; text-decoration: none; } #body_header{ width: 100%; padding: 15px 0px; background-color: #3B5998; height: 65px; } #header_left{ float: left; color: #FFFFFF; font-size: 25px; margin-top: 20px; } #header{ margin: 0px 25px; } #content{ margin: auto; height: inherit; width: 100%; } .input1{ border: 1px solid #ccc; border-radius: 5px; margin: 3px 0; padding: 5px; width: 90%; } #login{ border-bottom: 2px solid #919191; margin: 50px auto; padding-bottom: 20px; text-align: center; display: none; max-width: 500px; } .b-input{ margin: 2px 0 15px; } #login .text{ } #registerUser2 .title span{ border-bottom: 1px solid; font-size: 20px; padding: 2px 10px; } .button{ box-shadow: 3px 5px 9px -3px #070354; border: 1px solid #dddddd; border-radius: 5px; color: #3b5998; cursor: pointer; font-size: 15px; font-weight: bold; padding: 2px 4px; background: -webkit-linear-gradient(top, #ccc, #F4F4F4,#ccc); /* For Safari 5.1 to 6.0 */ background: -o-linear-gradient(top, #ccc, #F4F4F4,#ccc); /* For Opera 11.1 to 12.0 */ background: -moz-linear-gradient(top, #ccc, #F4F4F4,#ccc); /* For Firefox 3.6 to 15 */ background: linear-gradient(top bottom, #ccc, #F4F4F4,#ccc); /* Standard syntax */ } .alc-box1 input{ border: 1px solid rgb(204, 204, 204); border-radius: 5px; padding: 5px; width: 92%; } .albclf-action input{ background: #4e69a2; border: 0 solid; border-radius: 5px; color: #fff; font-size: 12px; font-weight: bold; padding: 3px; cursor: pointer; margin-right: 5px; } .sendMail input{ margin: 0 0 20px; padding: 8px; } #login{ display: block; } </style> </head> <body> <div id="body_header"> <div id="header"> <div id="header_left"> Admin </div> <div style="clear: both; padding:0px;"></div> </div> </div> <div id="content"> <div id="login"> <form action="/admin/login" name="login" method="POST"> <div class="text">Email</div> <div class="b-input"> <input class="input1" type="email" required="required" value="" name="email"/> </div> <div class="text">Mật Khẩu</div> <div class="b-input"> <input class="input1" type="password" required="required" value="" name="pass"/> </div> <div class="b-input"> <input class="button" type="submit" value="Đăng Nhập" name="submit"/> </div> </form> </div> <div style="clear: both; padding:0px;"></div> </div> </body> </html>