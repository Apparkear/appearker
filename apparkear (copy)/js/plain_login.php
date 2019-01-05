
<!DOCTYPE HTML>
<html>
<head>
<title>Roomerate</title>
<meta charset="UTF-8">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- Add custom CSS here -->
<link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">  
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="css/ionicons.css" rel="stylesheet">
<link href="css/jquery.bxslider.css" rel="stylesheet">
</head>
<body>
<!--<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="navbar-brand" href="index.html"><img src="images/logo.png"></a>
        </div>showUser()

       
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right nav-part">
            <li><a href="#" class="profilePart">Publish your property</a></li>
            <li><a href="#">How it works</a></li>        
            <li> 
            <div class="form-group">
			  <select class="form-control selectPart" id="sel1">
			    <option>English</option>
			    <option>Bengali</option>
			    <option>Hindi</option>
			    <option>English</option>
			  </select>
			</div></li>
          </ul>
        </div>
      </div>
	</nav>-->


		<section class="login_plane">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-4 col-md-4">
					 <div class="log_in_full">
						<div class="logo_login text-center">
							<img src="images/logo.png" style="margin: 15px auto;"/>
						</div>
						<div class="login_box">
							<form method="post" action="">
							  <div class="form-group">
							  <div id="txtHint"></div>
							    <label style="font-weight:500;" for="exampleInputEmail1">Email address</label>
							    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="un">
							  
							  </div>
							  <div class="form-group">
							    <label style="font-weight:500;" for="exampleInputPassword1">Password</label>
							    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pass">
							  </div>
							   <div class="form-group text-center" style="padding-top: 15px;margin-bottom: 15px;">
							  <button type="submit" name="submit" style="margin: 0 auto; padding: 7px 30px;" class="btn btn-primary" onclick="showUser()">Submit</button>
							  </div>
						   </form>
						   <div class="forgot_pass text-center">
						   	<a href="#">I forgot my password. Help!</a>
						   </div>
						</div>
					 </div>
					</div>
				</div>
			</div>
		</section>



	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.bxslider.js"></script>
	<script>
		$('.bxslider').bxSlider({
		  
		});
		$(window).scroll(function(){
		    if ($(window).scrollTop() >= 100) {
		       $('.navbar-fixed-top').css('background','rgba(0,0,0,.8)');
		    }
		    else {
		       $('.navbar-fixed-top').css('background','none');
		    }
		});
	</script>
	
    <script>
function showUser() {
	var un=document.getElementById("exampleInputEmail1").value;
	
	var pass=document.getElementById("exampleInputPassword1").value;
		alert(un+pass);
   
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajax_plain_login.php");
        xmlhttp.send();
    }

</script>
</body>

</html>