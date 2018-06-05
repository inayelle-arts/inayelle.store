$(() => {
	$("#submit-purchase-form").on("submit", () => {
		console.log("SUBMIT");
		globalCart.clear();
	});
});