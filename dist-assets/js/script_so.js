$(document).ready(function() {
    $("body").on("keyup", "input", function(event) {
        $(this).closest(".line").find(".tot_price").val($(this).closest(".line").find(".qty").val() * $(this).closest(".line").find(".value").val());
        $(this).closest(".line").find(".total_price").val($(this).closest(".line").find(".tot_price").val() * 1 - $(this).closest(".line").find(".discount").val());
        var sum = 0;
        $('.total_price').each(function() {
            sum += Number($(this).val());
        });
        $(".grand_total").val(sum);
    });
});