  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
  	<i class="fas fa-angle-up"></i>
  </a>



  <!-- Bootstrap core JavaScript-->
  <script src="../admin/vendor/jquery/jquery.min.js"></script>
  <script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
  	$(function() {
  		$('[data-toggle="tooltip"]').tooltip()
  	});
  	$(".delete-item-btn, .warning-btn-circle").remove();
  	$("table thead th:last-child, table tfoot th:last-child").remove();
  	<?php if ($_SERVER['QUERY_STRING'] == "prod&view_prod") {
		?> $("tr td a").removeAttr("data-toggle data-placement data-original-title href");
  	<?php
		} ?>

  	$("button.modify-btn").remove();
  </script>
  <!-- Core plugin JavaScript-->
  <script src="../admin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../admin/js/sb-admin-2.min.js"></script>

  <script>
  	var x = screen.width;
  	var element, name, arr;
  	if (x < 768) {
  		element = document.getElementById("accordionSidebar");
  		name = "toggled";
  		arr = element.className.split(" ");
  		if (arr.indexOf(name) == -1) {
  			element.className += " " + name;
  		}
  	}
  </script>

  <script>
  	// Example starter JavaScript for disabling form submissions if there are invalid fields
  	(function() {
  		'use strict';
  		window.addEventListener('load', function() {
  			// Fetch all the forms we want to apply custom Bootstrap validation styles to
  			var forms = document.getElementsByClassName('needs-validation');
  			// Loop over them and prevent submission
  			var validation = Array.prototype.filter.call(forms, function(form) {
  				form.addEventListener('submit', function(event) {
  					if (form.checkValidity() === false) {
  						event.preventDefault();
  						event.stopPropagation();
  					}
  					form.classList.add('was-validated');
  				}, false);
  			});
  		}, false);
  	})();
  </script>
  <!-- Page level plugins -->
  <script src="../admin/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../admin/js/demo/chart-area-demo.js"></script>
  <script src="../admin/js/demo/chart-pie-demo.js"></script>

  <script src="../admin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../admin/js/demo/datatables-demo.js"></script>

  </body>

  </html>