$(document).ready(function() {
    $('#amount-area_1').click(function () {
        $('#area_1_search').toggle();
    });
    $('#amount-area_2').click(function () {
        $('#area_2_search').toggle();
    });
    $('#amount-floor').click(function () {
       $('#floor_search').toggle();
    });
    $('#amount-floorInObj_1').click(function () {
        $('#floorInObj_1_search').toggle();
    });
    $('#amount-floorInObj_2').click(function () {
        $('#floorInObj_2_search').toggle();
    });
    $('#amount-typeHouse_1').click(function () {
        $('#typeHouse_1_search').toggle();
    });
    $('#amount-typeHouse_2').click(function () {
        $('#typeHouse_2_search').toggle();
    });
    $('#amount-square_1').click(function () {
        $('#square_1_search').toggle();
    });
    $('#amount-square_2').click(function () {
        $('#square_2_search').toggle();
    });
    $('#amount-square_earth').click(function () {
        $('#square_earth_search').toggle();
    });
    $('#amount-price').click(function () {
        $('#price_search').toggle();
    });
    $('#amount-rooms').click(function () {
        $('#rooms_search').toggle();
    });
    $('#amount-formObj_2').click(function () {
        $('#formObj_2_search').toggle();
    });
    $('#amount-distance').click(function () {
        $('#distance_search').toggle();
    });
    
    $('#city').change(function () {
        var myChoise = $ ('#city :selected').val();
        if (myChoise == 1) {
            $('#adr').css('width', '25%');
            $('#amount-area_1').show();
            $('#amount-area_2').hide();
        } else if (myChoise == 2) {
            $('#adr').css('width', '25%');
            $('#amount-area_1').hide();
            $('#amount-area_2').show();
        } else {
            $('#adr').css('width', '45%');
            $('#amount-area_1').hide();
            $('#amount-area_2').hide();
        }

    });

    $('#area_1_search :checkbox').change(function(){
        var checkCount = $ ('#area_1_search :checkbox:checked').length;
        if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Район (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Район";
            } else {
                result_ = $(this).parent("label").text();
            }
            $('#amount-area_1').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Район (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Район";
            } else {
                result_ = $('#area_1_search :checkbox:checked').parent("label").text();
            }
            $('#amount-area_1').val(result_);
        }
    });

    $('#area_2_search :checkbox').change(function(){
        var checkCount = $ ('#area_2_search :checkbox:checked').length;
        if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Район (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Район";
            } else {
                result_ = $(this).parent("label").text();
            }
            $('#amount-area_2').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Район (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Район";
            } else {
                result_ = $ ('#area_2_search :checkbox:checked').parent("label").text();
            }
            $('#amount-area_2').val(result_);
        }
    });
    

    $('#typeHouse_1_search :checkbox').change(function(){
        var checkCount = $ ('#typeHouse_1_search :checkbox:checked').length;
		if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Тип Дома (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Тип дома";
            } else {
                result_ = $(this).val();
            }
            $('#amount-typeHouse_1').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Тип Дома (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Тип дома";
            } else {
                result_ = $ ('#typeHouse_1_search :checkbox:checked').val();
            }
            $('#amount-typeHouse_1').val(result_);
        }
    });

    $('#typeHouse_2_search :checkbox').change(function(){
        var checkCount = $ ('#typeHouse_2_search :checkbox:checked').length;
        if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Материал стен (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Материал стен";
            } else {
                result_ = $(this).val();
            }
            $('#amount-typeHouse_2').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Материал стен (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Материал стен";
            } else {
                result_ = $ ('#typeHouse_2_search :checkbox:checked').val();
            }
            $('#amount-typeHouse_2').val(result_);
        }
    });

    $('#formObj_2_search :checkbox').change(function(){
        var checkCount = $ ('#formObj_2_search :checkbox:checked').length;
        if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Вид объекта (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Вид объекта";
            } else {
                result_ = $(this).val();
            }
            $('#amount-formObj_2').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Вид объекта (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Вид объекта";
            } else {
                result_ = $ ('#formObj_2_search :checkbox:checked').val();
            }
            $('#amount-formObj_2').val(result_);
        }
    });
    
    $('#type').change(function () {
        var myChoise = $ ('#type :selected').val();
        if (myChoise == 2) {
            $('#formObj_3').hide();
            $('#amount-floor').hide();
            $('#amount-typeHouse_1').hide();
            $('#amount-floorInObj_1').hide();
            $('#formObj_1').hide();
            $('#typeHouse_1').hide();
            $('#amount-rooms').hide();
            $('#amount-formObj_2').show();
            $('#amount-typeHouse_2').show();
            $('#amount-square_earth').show();
            $('#amount-floorInObj_2').show();
            $('#typeHouse_2').show();
            $('#amount-square_2').show();
            $('#amount-distance').show();
            $('#amount-square_1').hide();
        } else if (myChoise == 3){
            $('#amount-typeHouse_2').hide();
            $('#amount-floorInObj_1').show();
            $('#formObj_3').show();
            $('#amount-floor').show();
            $('#amount-typeHouse_1').show();
            $('#formObj_1').hide();
            $('#typeHouse_1').show();
            $('#amount-rooms').show();
            $('#amount-formObj_2').hide();
            $('#amount-square_earth').hide();
            $('#amount-floorInObj_2').hide();
            $('#typeHouse_2').hide();
            $('#amount-square_2').hide();
            $('#amount-distance').hide();
            $('#amount-square_1').show();
        } else {
            $('#amount-typeHouse_2').hide();
            $('#amount-typeHouse_1').show();
            $('#formObj_3').hide();
            $('#amount-floor').show();
            $('#amount-floorInObj_1').show();
            $('#formObj_1').show();
            $('#typeHouse_1').show();
            $('#amount-rooms').show();
            $('#amount-formObj_2').hide();
            $('#amount-square_earth').hide();
            $('#amount-floorInObj_2').hide();
            $('#typeHouse_2').hide();
            $('#amount-square_2').hide();
            $('#amount-distance').hide();
            $('#amount-square_1').show();
        }
    });
    
    $('#price_search input[type=number]').change(function () {
        var minPrice = $('#min-price').val();
        var maxPrice = $('#max-price').val();        
        var summ;
        if ((minPrice == "") && (maxPrice == "")) {
            summ = "Цена, руб";
        } else if (minPrice == "" || minPrice == 0) {
            summ = "До " + maxPrice + " руб";
        } else if (maxPrice == "" || maxPrice == 0) {
            summ = "От " + minPrice + " руб";
        } else {
            summ = minPrice + " - " + maxPrice  + " руб";
        }
        $('#amount-price').val(summ);
    });

    var minPrice = $('#min-price').val();
    var maxPrice = $('#max-price').val();
    var summ;
    if ((minPrice == "") && (maxPrice == "")) {
        summ = "Цена, руб";
    } else if (minPrice == "" || minPrice == 0) {
        summ = "До " + maxPrice + " руб";
    } else if (maxPrice == "" || maxPrice == 0) {
        summ = "От " + minPrice + " руб";
    } else {
        summ = minPrice + " - " + maxPrice  + " руб";
    }
    $('#amount-price').val(summ);

    $('#rooms_search :checkbox').change(function () {
        var checkCount = $ ('#rooms_search :checkbox:checked').length;
        if($(this).is(":checked")) {
            if (checkCount > 1) {
                result_ = "Типов кол. комнат (" + checkCount + ")";
            } else if  (checkCount == 0) {
                result_ = "Количество комнат";
            } else {
                result_ = $(this).val();
                if ((result_ == "Студия") || (result_ == "9+")) {
                    result_ = result_;
                }
                else {
                    result_ = result_+ "-к";
                }
            }
            $('#amount-rooms').val(result_);

        } else {
            if (checkCount > 1) {
                result_ = "Типов кол. комнат (" + checkCount + ")";
            } else if  (checkCount == 0) {
                var result_ = "Количество комнат";
            } else {
                result_ = $ ('#rooms_search :checkbox:checked').val();
                if ((result_ == "Студия") || (result_ == "9+")) {
                    result_ = result_;
                } else  {
                    result_ = result_+ "-к";
                }
            }
            $('#amount-rooms').val(result_);
        }
    });


    // Скрыть блоки при нажатии во вне

    $(document).click(function(event) {
            if (!$(event.target).closest("#filter").length) {
                $("#area_1_search, #area_2_search, #floor_search, #floorInObj_1_search, #typeHouse_1_search, #typeHouse_2_search, #square_1_search, #square_2_search, #square_earth_search, #price_search, #rooms_search, #formObj_2_search, #distance_search").hide(1);
            }
        event.stopPropagation();
    });

    $('#price input').keyup(function(){
        var price = $('#price input').val(),
            square = $('#square input').val();
        if ( $('#type_ select :selected').val() == '2' ) {
            square = $('#house_square input').val();
        }
        if ( square.length !== 0 ) {
            pricesquare = price/square;
            $('#price_square input').attr('value', Math.round(pricesquare));
        }
    });

    $('.favor').click( function () {
        if ($(this).hasClass("fa-star-o")) {
            var data = { obj_id : $(this).find('id').text(), addfav : 1};
            $.get("ajax.php", data, addFav);
        } else if ($(this).hasClass("fa-star")) {
            var data = { obj_id : $(this).find('id').text(), delfav : 1};
            $.get("ajax.php", data, delFav);
        }
    });
        function addFav (data) {
            $('id:contains("'+data.id+'")').parent().removeClass("fa-star-o").addClass("fa-star");            
        }

    function delFav (data) {
        $('id:contains("'+data.id+'")').parent().removeClass("fa-star").addClass("fa-star-o");
    }

    setTimeout(function(){$('#box').fadeOut('fast')},3000);
    
});// End ready
