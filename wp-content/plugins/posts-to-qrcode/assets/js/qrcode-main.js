;(function ($) {
	$(document).ready(function () {
		$('#toggle').minitoggle();

		// fix css
		var current_value = $("#qrcode_toogle").val();
		if(current_value == 1){
			$('#toggle .minitoggle').addClass('active');
			$('#toggle .toggle-handle').attr('style','transform: translate3d(36px, 0px, 0px)');
		}

		$('#toggle').on("toggle", function (e) {
			if (e.isActive)
				$("#qrcode_toogle").val(1);
			else
				$("#qrcode_toogle").val(0);
		});
	});
})(jQuery);