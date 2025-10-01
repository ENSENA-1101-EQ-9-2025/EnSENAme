
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
	<title>Chat | Mantis Bootstrap 5 Admin Template</title>
	<!-- [Meta] -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
	<meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
	<meta name="author" content="CodedThemes">
	<!-- [Favicon] icon -->
	<link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon"> <!-- [Google Font] Family -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
	<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
	<link rel="stylesheet" href="../assets/fonts/feather.css" >
	<link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
	<link rel="stylesheet" href="../assets/fonts/material.css" >
	<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
	<link rel="stylesheet" href="../assets/css/style-preset.css" >
</head>
<body>
	<!-- Aquí va el contenido del chat, puedes copiar la estructura de chat.html -->
	<footer class="pc-footer">
		<div class="footer-wrapper container-fluid">
			<div class="row">
				<div class="col-sm my-1">
					<p class="m-0">Mantis &#9829; crafted by Team <a href="https://themeforest.net/user/codedthemes" target="_blank">Codedthemes</a></p>
				</div>
				<div class="col-auto my-1">
					<ul class="list-inline footer-link mb-0">
						<li class="list-inline-item"><a href="../index.html">Home</a></li>
						<li class="list-inline-item"><a href="https://codedthemes.gitbook.io/mantis-bootstrap" target="_blank">Documentation</a></li>
						<li class="list-inline-item"><a href="https://codedthemes.authordesk.app/" target="_blank">Support</a></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!-- Required Js -->
	<script src="../assets/js/plugins/popper.min.js"></script>
	<script src="../assets/js/plugins/simplebar.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../assets/js/fonts/custom-font.js"></script>
	<script src="../assets/js/pcoded.js"></script>
	<script src="../assets/js/plugins/feather.min.js"></script>
	<script>layout_change('light');</script>
	<script>change_box_container('false');</script>
	<script>layout_rtl_change('false');</script>
	<script>preset_change("preset-1");</script>
	<script>font_change("Public-Sans");</script>
	<!-- [Page Specific JS] start -->
	<script>
		// scroll-block
		var tc = document.querySelectorAll('.scroll-block');
		for (var t = 0; t < tc.length; t++) {
			new SimpleBar(tc[t]);
		}
		setTimeout(function () {
			var element = document.querySelector('.chat-content .scroll-block .simplebar-content-wrapper');
			var elementheight = document.querySelector('.chat-content .scroll-block .simplebar-content');
			var off = elementheight.getBoundingClientRect();
			var h = off.height;
			element.scrollTop += h;
		}, 100)
	</script>
	<!-- [Page Specific JS] end -->
</body>
</html>
