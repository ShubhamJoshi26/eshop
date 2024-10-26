

<!DOCTYPE html>
<html lang="en">
	
<!-- Mirrored from andit.co/projects/html/andshop/andshop-dashboard/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Sep 2024 05:06:01 GMT -->
<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Andshop - Admin Dashboard HTML Template.">

		<title>Andshop - Admin Dashboard HTML Template.</title>
		
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;family=Poppins:wght@300;400;500;600;700;800;900&amp;family=Roboto:wght@400;500;700;900&amp;display=swap" rel="stylesheet">

		<link href="assets/css/materialdesignicons.min.css" rel="stylesheet" />
		
		<!-- custom css -->
		<link id="style.css" rel="stylesheet" href="assets/css/style.css" />
		
		<!-- FAVICON -->
		<link href="assets/img/favicon.png" rel="shortcut icon" />
	</head>
	
	<body class="sign-inup" id="body">
		<div class="container">
			<div class="row g-0"> 
				<div class="col-lg-10 offset-lg-1">
					<div class="row g-0">
						<div class="col-lg-6">
							<div class="login_area_left_wrapper">
								<div class="login_logo_area">
									<img src="assets/img/logo/logo-login.png" alt="">
									<p>Nulla laborum sit voluptate anim in. Nulla ut qui ex 
										ipsum id aliqua amet exercitation. Anim ididunt
										anim anim voluptate enim.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="login_area_right_wrapper">
								<div class="login_area_right_heading">
									<h4>Welcome Back!</h4>
									<p>Sign in to continue to <a href="#!">AndShop</a></p>
								</div>
								<div class="login_form_wrapper">
									<form action="{{route('login')}}" method="POST">
                                        @csrf
										<div class="form-group">
											<label>User name</label>
											<input type="text" class="form-control" name="email" placeholder="Enter username">
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" name="password" placeholder="Enter password">
										</div>
										{{-- <div class="login_form_forget">
											<a href="#!">Forgot password?</a>
										</div> --}}
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary" >Login</button>
                                        </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Javascript -->
		<script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/plugins/jquery-zoom/jquery.zoom.min.js"></script>
		<script src="assets/plugins/slick/slick.min.js"></script>
	
		<!-- custom js -->	
		<script src="assets/js/custom.js"></script>
	</body>


<!-- Mirrored from andit.co/projects/html/andshop/andshop-dashboard/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Sep 2024 05:06:02 GMT -->
</html>