<?php
	if(strcmp($runtime_environment, "dev") == 0) {
?>
<!-- Development Environment Bootstrap JS -->
<script src="./js/jquery-3.2.1.js"></script>
<script src="./js/bootstrap.js"></script>

<?php
	} else {
?>
<!-- Production Environment Bootstrap JS -->
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/bootstrap.min.js"></script>

<?php
	}
?>
<script src="js/jquery.form.min.js"></script>
<script src="js/app.js"></script>
