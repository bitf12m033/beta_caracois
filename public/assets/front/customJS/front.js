$(document).ready(function() {
    $.ajaxSetup({
	    headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
    });
});

function addToCart(pid) {

    $.ajax({
        url: "/add-to-cart",
        data: {productid: pid},
        method: "POST",
        success: function(results){
            $('#'+obj.id).addClass('cart-added');
            $('#'+obj.id).text('Remove from cart');
            $('#'+obj.id).attr("onClick","removeFromCart(this,"+id+",\'"+type+"\')");
            $("#cart-count").addClass("cart-fill");
            cart_count = Number($("#cart-count span").text())
            cart_count++;
            $("#cart-count span").text(cart_count);
            if(type === 'post')
                window.location.href = "templates.php?pid="+id+"&type="+type;
            else if(type === 'email')
                window.location.href = "email-templates.php?pid="+id+"&type="+type;
        },
        error : function (e) {
            console.log("error " + e);
        }
    });
    //$('.heart.fa.fav-'+id).toggleClass("fa-heart fa-heart-o");
}