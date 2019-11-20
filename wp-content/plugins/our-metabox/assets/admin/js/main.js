let frame; // for image
let gframe; // for gallery image
;(function ($) {
	$(document).ready(function () {
		$(".omb_dp").datepicker({
			changeMonth: true,
			changeYear: true
		});

		// image save and display
		let image_url = $("#omb_image_url").val();
		if(image_url){
			$("#image_container").html(`<img src='${image_url}'>`);
		}

		// insert image
		$("#upload_image").on("click",function () {

			// remove multiple event create
			if (frame){
				frame.open();
				return false;
			}

			// Open media
			frame = wp.media({
				title:"Select Image",
				button: {
					text:"Insert Image"
				},
				multiple:false
			});

			// select image and show image
			frame.on('select', function () {
				let  attachment = frame.state().get('selection').first().toJSON();
				console.log(attachment);
				$("#omb_image_id").val(attachment.id);
				$("#omb_image_url").val(attachment.sizes.thumbnail.url);
				$("#image_container").html(`<img src='${attachment.sizes.thumbnail.url}'>`);
			});

			// fix open
			frame.open();
			return false;
		});


		// gallery image save and display
		let images_url = $("#omb_images_url").val();
		images_url = images_url ? images_url.split(";"): [];
		for (i in images_url){
			let _image_url = images_url[i];
			$("#images_container").append(`<img style="margin-right: 10px" src='${_image_url}'>`);
		}

		// gallery image insert
		$("#upload_images").on("click",function () {

			// remove multiple event create
			if (gframe){
				gframe.open();
				return false;
			}

			// Open media
			gframe = wp.media({
				title:"Select Image",
				button: {
					text:"Insert Image"
				},
				multiple:true
			});

			// select image and show image
			gframe.on('select', function () {
				let image_ids = [];
				let image_urls = [];
				let  attachments = gframe.state().get('selection').toJSON(); // not use first

				console.log(attachments);

				$("#images_container").html(''); // fix same multi image

				for (i in attachments){
					let attachment = attachments[i];
					// console.log(attachment);

					// save ids and urls
					image_ids.push(attachment.id);
					image_urls.push(attachment.sizes.thumbnail.url);

					// append images
					$("#images_container").append(`<img src='${attachment.sizes.thumbnail.url}'>`);
				}

				// save id and url separate by ;
				$("#omb_images_id").val(image_ids.join(";"));
				$("#omb_images_url").val(image_urls.join(";"));



				// console.log(image_ids,image_urls);
			});

			// fix open
			gframe.open();
			return false;
		});
	});
})(jQuery);