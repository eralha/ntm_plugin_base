<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title></title>
	<style type="text/css">
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */

		/* Some sensible defaults for images
		Bring inline: Yes. */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}

		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 1em 0;}

		/* Hotmail header color reset
		Bring inline: Yes. */
		h1, h2, h3, h4, h5, h6 {}

		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: #000 !important;}

		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: #000 !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: #000 !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
		}

		/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
		table td {border-collapse: collapse;}

		/* Remove spacing around Outlook 07, 10 tables
		Bring inline: Yes */
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }

		/* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
		Bring inline: Yes. */
		a { color: #000; }


		.main__table {
			width: 100%;
			max-width: 600px;
			color: #000;
			font-size: 18px;
			line-height: 22px;
      font-family: Arial, sans-serif;
      text-align: center;
      color: #1d3456;
		}

    .tbl_topo {
      text-align: left;
    }

		.border-bottom {
			border-bottom: solid 2px #bfb8b0;
		}

		.td_top_sep { padding-top: 0px; }

		.title {
			padding: 0;
			margin: 0;
			margin-bottom: 10px;
			color: #39afe6;
			font-size: 25px;
			line-height: 22px;
			text-transform: uppercase;
		}
    .subtitle {
      margin: 0;
      font-weight: normal;
      font-size: 25px;
      color: #1d3456;
    }

		.link-button {
			display: inline-block;
			vertical-align: middle;
			padding: 20px;
			color: #fff;
			font-size: 18px;
			font-family: arial;
			background-color: #ffcd00;
		}
		.link-button a { 
			color: #fff; 
			text-decoration: none;
		}

		.td-label {
            width: 180px;
            font-size: 20px;
            padding-left: 20px;
            padding-bottom: 5px;
            vertical-align: top;
		}
		.td-content {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 20px;
            padding-bottom: 5px;
            vertical-align: top;
		}
		.td-responsive-half {
			width: 300px;
			float: left;
			padding-left: 10px;
			-webkit-box-sizing: border-box;
			  -moz-box-sizing: border-box;
			  box-sizing: border-box; 
		}

		.td-bottom-left {
			width: 50%;
			padding-left: 15px;
			text-align: left;
		}
		.td-bottom-right {
			width: 50%;
			padding-right: 15px;
			text-align: right;
		}
		.td-bottom-text {
			font-size: 13px;
      color: #1d3456;
			line-height: 16px;
			padding-top: 10px;
			padding-bottom: 40px;
      text-align:left;
		}

        .img_full {
            width: 100%;
        }

        .space_td { padding: 20px; }
        .content_title {
            padding: 0px;
            margin: 0px;
            font-weight: bold;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 20px;
            color: #000;
        }
        .content_subtitle {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 18px;
            color: #000;
        }
        .social_td {
			height: 40px;
            font-size: 0px;
            line-height: 0px;
            background-color: #fff;
        }
        .social_td img { margin-right: 5px; }
        .social_icon {
            padding: 0 5px;
        }

        .sep {
          height: 6px;
          background-color: #a7a9ac;
        }
        .sep_height {
          height: 30px;
        }

		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media only screen and (max-device-width: 480px) {

		}

		/* More Specific Targeting */

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		}

		@media only screen and (max-width: 500px) {
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		/* Put your iPhone 4g styles in here */ 
		}

		/* Android targeting */
		@media only screen and (-webkit-device-pixel-ratio:.75){
		/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
		/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
		/* Put CSS for high density (hdpi) Android layouts in here */
		}
		/* end Android targeting */

	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">
	
	</style>
	<![endif]-->   

	<!-- ***********************************************
	****************************************************
	END MOBILE TARGETING
	****************************************************
	************************************************ -->

	<!--[if gte mso 9]>
		<style>
		/* Target Outlook 2007 and 2010 */
		</style>
	<![endif]-->
</head>
<body>
    <p style="margin:1em 0;display:none !important;visibility:hidden;mso-hide:all;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">Actuasys</p>
    <p style="margin:1em 0;display:none !important;visibility:hidden;mso-hide:all;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">human</p>
    <p style="margin:1em 0;display:none !important;visibility:hidden;mso-hide:all;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">technologies</p>

<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
	<tr>
		<td valign="top"> 

	<!--[if gte mso 9]>
		<table cellpadding="0" cellspacing="0" border="0" align="center" width="600"><tr><td>
	<![endif]-->
