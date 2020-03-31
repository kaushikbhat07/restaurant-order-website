<?php
include("includes/front/top.php");
?>
<link rel="stylesheet" type="text/css" href="loginpage/css/util.css">
<link rel="stylesheet" type="text/css" href="css/contactform.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/contactregular.css">
<link rel="stylesheet" href="css/index.css">
</head>

<body>

	<?php include("includes/front/header_static.php"); ?>

	<!--==========================
    Intro Section
  ============================-->
	<section id="intro">
		<div class="intro-container">
			<div id="introCarousel" class="carousel slide carousel-fade" data-ride="carousel">

				<div class="carousel-inner" role="listbox">

					<div class="carousel-item active">
						<div class="carousel-background"><img src="img/banner.jpg" alt=""></div>
						<div class="carousel-container">
							<div class="carousel-content">
								<h2>Welcome</h2>
								<p>Hey there! Hungry? You're at the right place. You can choose from various food items from our menu divided into different categories to fulfill all your hunger fetishes. Home delivery available 24x7 throughout Mangalore.</p>
								<a href="#services" class="btn-get-started scrollto">View our menu</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section><!-- #intro -->

	<main id="main">
		<!--==========================
      About Us Section
    ============================-->
		<section id="about">
			<div class="container">

				<header class="section-header">
					<h3>About Us</h3>
					<p>We are one of the best restaurants in Mangalore striving to provide exellence in food. Our chefs are the best in town and the quality is a cut above which makes us stand out from all other places.</p>
				</header>

				<div class="row about-cols">

					<div class="col-md-4 wow fadeInUp">
						<div class="about-col">
							<div class="img">
								<img src="img/about-mission.jpg" alt="" class="img-fluid">
								<div class="icon"><i class="ion-ios-speedometer-outline"></i></div>
							</div>
							<h2 class="title"><a href="#">Our Mission</a></h2>
							<p>
								Striving towards excellent food quality and service, improving quality every single day and making availability of excellent service during any hour.
							</p>
						</div>
					</div>

					<div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
						<div class="about-col">
							<div class="img">
								<img src="img/about-plan.jpg" alt="" class="img-fluid">
								<div class="icon"><i class="ion-ios-list-outline"></i></div>
							</div>
							<h2 class="title"><a href="#">Our Plan</a></h2>
							<p>
								Reach out to youngsters in every corner of Mangalore and provide excellent food quality and services throught social media and online presence.
							</p>
						</div>
					</div>

					<div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
						<div class="about-col">
							<div class="img">
								<img src="img/about-vision.jpg" alt="" class="img-fluid">
								<div class="icon"><i class="ion-ios-eye-outline"></i></div>
							</div>
							<h2 class="title"><a href="#">Our Vision</a></h2>
							<p>
								Extend our brances from Mangalore to other places in the near future. Providing franchises to the ones interested in entrepreneurship and those who are passionate about it.
							</p>
						</div>
					</div>

				</div>

			</div>
		</section><!-- #about -->

		<!--==========================
      Categories Section
    ============================-->
		<section id="services">
			<div class="container">

				<header class="section-header wow fadeInUp">
					<h3>Our Menu</h3>
					<p>Choose from the various food items below which are divided into different categories. </p>
				</header>

				<div class="row">

					<?php $cust->display_categories_homepage(); ?>

				</div>

			</div>
		</section>
		<!--==========================
      Categories Section
    ============================-->

		<!--==========================
      Contact Section
    ============================-->
		<section id="contact" class="section-bg wow fadeInUp">
			<div class="container">

				<div class="section-header">
					<h3>Contact Us</h3>
					<p>Do not hesitate to call us on our contact number or drop us a mail. We would be happy to hear from you !</p>
				</div>

				<div class="row contact-info">

					<div class="col-md-4">
						<div class="contact-address">
							<i class="ion-ios-location-outline"></i>
							<h3>Address</h3>
							<address>Amuruthmahal, Near Checkpost, Vamanjoor, Mangalore, India</address>
						</div>
					</div>

					<div class="col-md-4">
						<div class="contact-phone">
							<i class="ion-ios-telephone-outline"></i>
							<h3>Phone Number</h3>
							<p><a href="tel:+91824 2262593">0824 2262593</a></p>
						</div>
					</div>

					<div class="col-md-4">
						<div class="contact-email">
							<i class="ion-ios-email-outline"></i>
							<h3>Email</h3>
							<p><a href="mailto:info@example.com">swadesh@kproj.me</a></p>
						</div>
					</div>

				</div>
				<div class="limiter">

					<div class="container-login100">
						<div class="wrap-login100">
							<form class="login100-form validate-form" method="post" action="index">
								<div class="row">
									<div class="col-lg-6">

										<div class="wrap-input100 validate-input" data-validate="Do not leave name field blank">
											<input class="input100" type="text" name="fname">
											<span class="focus-input100"></span>
											<span class="label-input100">First Name</span>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
											<input class="input100" type="email" name="email">
											<span class="focus-input100"></span>
											<span class="label-input100">Email</span>
										</div>
									</div>
								</div>

								<div class="wrap-input100 validate-input" data-validate="Do not leave subject field blank">
									<input class="input100" type="text" name="fname">
									<span class="focus-input100"></span>
									<span class="label-input100">Subject</span>
								</div>
								<hr>
								<div class="wrap-input100 input-textarea validate-input" data-validate="Message is required">
									<textarea class="input100"></textarea>
									<span class="focus-input100"></span>
									<span class="label-input100">Message</span>
								</div>

								<div class="flex-sb-m w-full p-t-3 p-b-32">

								</div>


								<div class="container-login100-form-btn">
									<button class="login100-form-btn">
										Send Message
									</button>
								</div>

							</form>
						</div>
					</div>

				</div>
			</div>
		</section><!-- #contact -->

	</main>



	<?php include("includes/front/footer.php"); ?>