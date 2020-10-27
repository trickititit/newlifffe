$(document).ready(function() {
    $('.money-mask-input').mask('000.000.000.000.000', {reverse: true});
    $('.phone-mask-input').mask('(000) 000-0000', {placeholder: "(___) ___-____"});
    $('#us-phone-mask-input').mask('(000) 000-0000', {placeholder: "(___) ___-____"});
    $('.date-mask-input').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.pasport-mask-input').mask('0000-000000', {placeholder: "____-______"});
});
