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
        var note = $(this).closest(".product_data").find(".note").val();

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
                note: note,
            },
            success: function (response) {
                swal("", response.status, "success");
            },
            error: function (response) {
                swal("", "Ukuran dan Jumlah Harus Diisi", "error");
                console.log(product_size);
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
            },
        });
    });

    $(".decrement-btn").click(function (e) {
        e.preventDefault();

        var dec_value = $(this)
            .closest(".product_data")
            .find(".qty-input")
            .val();
        var value = parseInt(dec_value);
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
        var value = parseInt(inc_value);
        value = isNaN(value) ? 0 : value;

        if (value < 15) {
            value++;
            $(this).closest(".product_data").find(".qty-input").val(value);
        } else {
            $(this).closest(".product_data").find(".qty-input").val(15);
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

    $(".deleteWishlistItem").click(function (e) {
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

    $(".changeNote").change(function (e) {
        e.preventDefault();
        var note = $(this).closest(".product_data").find(".changeNote").val();
        var prod_id = $(this).closest(".product_data").find(".prod_id").val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            method: "POST",
            url: "cart/change-note",
            data: {
                note: note,
                prod_id: prod_id,
            },
            success: function (response) {
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

    $(".hoverDiv").hover(
        function () {
            $(this).css("background", "#f5f5f5");
        },
        function () {
            $(this).css("background", "#fff");
        }
    );
});
