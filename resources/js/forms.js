$(document).on("focus", "input:not([type=submit]), textarea", function () {
    $(this).parents('.form-group').addClass('focused');
});
$(document).on("click", "label:not(.form-check-label)", function () {
    $(this).parents('.form-group').addClass('focused');
    $(this).siblings("input, textarea").focus();
});

$(document).on("blur", "input:not([type=submit]), textarea", function () {
    var inputValue = $(this).val();
    //If Invalid input
    if ($(this).is(":invalid") && inputValue !== "") {
        $(this).addClass('invalid');
    } else if (inputValue === "") { //If Empty
        $(this).removeClass('filled invalid');
        $(this).parents('.form-group').removeClass('focused');
    } else {
        $(this).addClass('filled');
        $(this).removeClass('invalid');
    }
});
$("form").submit(e => {
    document.body.classList.add('loading');
});
