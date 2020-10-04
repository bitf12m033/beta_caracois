$(document).ready(function() {
    $.ajaxSetup({
	    headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
});

function addToCart(pid) {

    $.ajax({
        url: "/atc",
        data: {productid: pid},
        method: "POST",
        success: function(results){
            
            $("#cart-count").addClass("cart-fill");
            cart_count = Number($("#cart-count span").html())
            cart_count++;
            $("#cart-count span").html(cart_count);
        },
        error : function (e) {
            console.log("error " + e);
        }
    });
    //$('.heart.fa.fav-'+id).toggleClass("fa-heart fa-heart-o");
}

function updateCart() {
	$("#update-cart").submit();
}
function placeOrder() {
	$("#checkout-form").submit();
}