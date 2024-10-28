jQuery(document).ready(function ($) {
	// Listen for variation changes
	$("form.variations_form").on("change", ".variations select", function () {
		// Get form data and selected variation attributes
		var form = $("form.variations_form");
		var product_id = form.data("product_id");
		var selected_options = form.serialize();

		// Make AJAX call to update product details
		$.ajax({
			url: mpv_variation_params.ajax_url,
			type: "POST",
			data: {
				action: "mpv_update_product_variation_data",
				product_id: product_id,
				selected_options: selected_options,
				nonce: mpv_variation_params.nonce,
			},
			success: function (response) {
				if (response.success) {
					// Update product price, stock, etc.
					$(".woocommerce-variation-price .price").html(response.data.price);
					$(".stock").html(response.data.stock_status);
				}
			},
		});
	});
});
