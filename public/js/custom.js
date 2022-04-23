$("document").ready(function () {
    $(".addtoCartBtn").click(function (e) {
        e.preventDefault();

        var product_id = $(this)
            .closest(".product_data")
            .find(".prod_id")
            .val();
        var product_qty = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var product_size = $(this)
            .closest(".product_data")
            .find(".prod_size")
            .val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: "/add-to-cart",
            data: {
                product_id: product_id,
                product_qty: product_qty,
                product_size: product_size,
            },
            success: function (response) {
                swal("", response.status, "success");
            },
            error: function (response) {
                swal("", "Ukuran Harus Diisi", "error");
            },
        });
    });

    $(".addtoWishlistBtn").click(function (e) {
        e.preventDefault();

        var product_id = $(this)
            .closest(".product_data")
            .find(".prod_id")
            .val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            type: "POST",
            url: "/add-to-wishlist",
            data: {
                product_id: product_id,
            },
            success: function (response) {
                swal("", response.status, "success");
            }
        });
    });

    $(".decrement-btn").click(function (e) {
        e.preventDefault();

        var dec_value = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var value = parseInt(dec_value, 15);
        value = isNaN(value) ? 0 : value;

        if (value > 1) {
            value--;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".increment-btn").click(function (e) {
        e.preventDefault();

        var inc_value = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var value = parseInt(inc_value, 15);
        value = isNaN(value) ? 0 : value;

        if (value < 15) {
            value++;
            $(this).closest(".product_data").find(".qty-input").val(value);
        }
    });

    $(".deleteCartItem").click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest(".product_data").find(".prod_id").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            method: "POST",
            url: "delete-cart-item",
            data: {
                prod_id: prod_id,
            },
            success: function (response) {
                window.location.reload();
                swal("", response.status, "success");
            },
        });
    });

    $('.deleteWishlistItem').click(function (e) { 
        e.preventDefault();
        
        var prod_id = $(this).closest(".product_data").find(".prod_id").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            method: "POST",
            url: "delete-wishlist-item",
            data: {
                prod_id: prod_id,
            },
            success: function (response) {
                window.location.reload();
                swal("", response.status, "success");
            },
        });
    });

    $(".changeQty").click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest(".product_data").find(".prod_id").val();
        var qty = $(this).closest(".product_data").find(".qty-input").val();
        data = {
            prod_id: prod_id,
            prod_qty: qty,
        };

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function (response) {
                window.location.reload();
            },
        });
    });
});
