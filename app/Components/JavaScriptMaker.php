<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 15.05.2017
 * Time: 22:43
 */

namespace App\Components;
use Storage;

class JavaScriptMaker
{

    protected $content;
    protected $typeScript;
    protected $script_js;
    protected $sliders;
    protected $cat_script_js;
    protected $specOffer_js;

    public function setJs($type, $request = "", $static = true, $token = "", $randStr, $specOffer = false)
    {

        $this->sliders = "
        function initSlider(slider) {
        switch (slider) {
            case (\"square_1\"):
            var min = 10;
            var max = 200;
                $( \"#slider-range-square_1\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_min\" ).val(lastVar1);
                        $( \"#amount-square_max\" ).val(lastVar2);
                        if (lastVar1 == 200) {
                            lastVar1 = \"200+\";
                        }
                        if (lastVar2 == 200) {
                            lastVar2 = \"200+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" м²\";
                        } else if ( (lastVar1 == 10) && (lastVar2 == \"200+\")) {
                            resultat = \"Площадь, м²\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
                        }
                        $( \"#amount-square_1\" ).val(resultat);
                        $(\"#slider-range-square_1 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_1 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_1 .ui-slider-handle\").first().text(min);
                $(\"#slider-range-square_1 .ui-slider-handle\").last().text(max);
                break;
            case (\"floor\"):
            var min = 1;
            var max = 31;
                $( \"#slider-range-floor\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floor_min\").val(lastVar1);
                        $(\"#amount-floor_max\").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = \"31+\";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = \"31+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этаж\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                            resultat = \"Этаж\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этаж\";
                        }
                        $(\"#amount-floor\").val(resultat);
                        $(\"#slider-range-floor .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floor .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floor .ui-slider-handle\").first().text(min);
                $(\"#slider-range-floor .ui-slider-handle\").last().text(max);
                break;
            case (\"floorInObj_1\"):
            var min = 1;
            var max = 31;
                $( \"#slider-range-floorInObj_1\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floorInObj_1_min\").val(lastVar1);
                        $(\"#amount-floorInObj_1_max\").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = \"31+\";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = \"31+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этажей\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                            resultat = \"Этажей в доме\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
                        }
                        $(\"#amount-floorInObj_1\").val(resultat);
                        $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text(min);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text(max);
                break
            case (\"floorInObj_2\"):
            var min = 1;
            var max = 5;
                $( \"#slider-range-floorInObj_2\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floorInObj_2_min\").val(lastVar1);
                        $(\"#amount-floorInObj_2_max\").val(lastVar2);
                        if (lastVar1 == 5) {
                            lastVar1 = \"5+\";
                        }
                        if (lastVar2 == 5) {
                            lastVar2 = \"5+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этажей\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"5+\")) {
                            resultat = \"Этажей в доме\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
                        }
                        $(\"#amount-floorInObj_2\").val(resultat);
                        $(\"#slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floorInObj_2 .ui-slider-handle\").first().text(min);
                $(\"#slider-range-floorInObj_2 .ui-slider-handle\").last().text(max);
                break;
            case (\"square_2\"):
            var min = 10;
            var max = 500;
                $( \"#slider-range-square_2\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_2_min\" ).val(lastVar1);
                        $( \"#amount-square_2_max\" ).val(lastVar2);
                        if (lastVar1 == 500) {
                            lastVar1 = \"500+\";
                        }
                        if (lastVar2 == 500) {
                            lastVar2 = \"500+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" м²\";
                        } else if ( (lastVar1 == 10) && (lastVar2 == \"500+\")) {
                            resultat = \"Площадь дома, м²\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
                        }
                        $( \"#amount-square_2\" ).val(resultat);
                        $(\"#slider-range-square_2 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_2 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_2 .ui-slider-handle\").first().text(min);
                $(\"#slider-range-square_2 .ui-slider-handle\").last().text(max);
                break;
            case (\"square_earth\"):
            var min = 1;
            var max = 100;
                $( \"#slider-range-square_earth\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_earth_min\" ).val(lastVar1);
                        $( \"#amount-square_earth_max\" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = \"100+\";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = \"100+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" сот.\";
                        } else if ( (lastVar1 == 1) && (lastVar2 == \"100+\")) {
                            resultat = \"Площадь участка, сот.\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" сот.\";
                        }
                        $( \"#amount-square_earth\" ).val(resultat);
                        $(\"#slider-range-square_earth .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_earth .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_earth .ui-slider-handle\").first().text(min);
                $(\"#slider-range-square_earth .ui-slider-handle\").last().text(max);
                break;
            case (\"distance\"):
            var min = 0;
            var max = 100;
                $( \"#slider-range-distance\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-distance_min\" ).val(lastVar1);
                        $( \"#amount-distance_max\" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = \"100+\";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = \"100+\";
                        }
                        if (lastVar1 == 0 && lastVar2 == 0) {
                            lastVar1 = \"В черте города\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" км.\";
                        } else if ( (lastVar1 == 0) && (lastVar2 == \"100+\")) {
                            resultat = \"Расстояние до города, км.\";
                        } else if (lastVar1 == \"В черте города\") {
                            resultat = \"В черте города\";
                            lastVar1 = 0;
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" км.\";
                        }
                        $( \"#amount-distance\" ).val(resultat);
                        $(\"#slider-range-distance .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-distance .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-distance .ui-slider-handle\").first().text(min);
                $(\"#slider-range-distance .ui-slider-handle\").last().text(max);
                break;
            case (\"room\"):
                $( function() {
                    $( \".rooms_search :checkbox\" ).checkboxradio({
                        icon: false
                    });
                });
                break;
            case (\"init\"):
                var lastVar1_1 = 10;
                var lastVar2_1 = 200;
                $( \"#amount-square_min\" ).val(lastVar1_1);
                $( \"#amount-square_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 200) {
                    lastVar1_1 = \"200+\";
                }
                if (lastVar2_1 == 200) {
                    lastVar2_1 = \"200+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" м²\";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"200+\")) {
                    resultat2 = \"Площадь, м²\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
                }
                $( \"#amount-square_1\" ).val(resultat2);
                

                var lastVar1_1 = 1;
                var lastVar2_1 = 31;
                $( \"#amount-floor_min\" ).val(lastVar1_1);
                $( \"#amount-floor_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = \"31+\";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = \"31+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этаж\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
                    resultat2 = \"Этаж\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этаж\";
                }
                $( \"#amount-floor\" ).val(resultat2);


                var lastVar1_1 = 1;
                var lastVar2_1 = 31;
                $( \"#amount-floorInObj_1_min\" ).val(lastVar1_1);
                $( \"#amount-floorInObj_1_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = \"31+\";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = \"31+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этажей\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
                    resultat2 = \"Этажей в доме\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
                }
                $( \"#amount-floorInObj_1\" ).val(resultat2);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1_1);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2_1);
                

                var lastVar1_1 = 1;
                var lastVar2_1 = 5;
                $( \"#amount-floorInObj_2_min\" ).val(lastVar1_1);
                $( \"#amount-floorInObj_2_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 5) {
                    lastVar1_1 = \"5+\";
                }
                if (lastVar2_1 == 5) {
                    lastVar2_1 = \"5+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этажей\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"5+\")) {
                    resultat2 = \"Этажей в доме\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
                }
                $( \"#amount-floorInObj_2\" ).val(resultat2);


                var lastVar1_1 = 10;
                var lastVar2_1 = 500;
                $( \"#amount-square_2_min\" ).val(lastVar1_1);
                $( \"#amount-square_2_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 500) {
                    lastVar1_1 = \"500+\";
                }
                if (lastVar2_1 == 500) {
                    lastVar2_1 = \"500+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" м²\";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"500+\")) {
                    resultat2 = \"Площадь дома, м²\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
                }
                $( \"#amount-square_2\" ).val(resultat2);


                var lastVar1_1 = 1;
                var lastVar2_1 = 100;
                $( \"#amount-square_earth_min\" ).val(lastVar1_1);
                $( \"#amount-square_earth_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = \"100+\";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = \"100+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" сот.\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"100+\")) {
                    resultat2 = \"Площадь участка, сот.\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" сот.\";
                }
                $( \"#amount-square_earth\" ).val(resultat2);


                var lastVar1_1 = 0;
                var lastVar2_1 = 100;
                $( \"#amount-distance_min\" ).val(lastVar1_1);
                $( \"#amount-distance_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = \"100+\";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = \"100+\";
                }
                if (lastVar1_1 == 0 && lastVar2_1 == 0) {
                    lastVar1_1 = \"В черте города\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" км.\";
                } else if ((lastVar1_1 == 0) && (lastVar2_1 == \"100+\")) {
                    resultat2 = \"Расстояние до города, км.\";
                } else if (lastVar1_1 == \"В черте города\") {
                    resultat2 = \"В черте города\";
                    lastVar1_1 = 0;
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" км.\";
                }
                $( \"#amount-distance\" ).val(resultat2);
                break;
            default:
                break;
            }
    };
        ";

        $this->specOffer_js = "
        $('.slider4').bxSlider({
                        slideWidth: 200,
                        minSlides: 5,
                        maxSlides: 5,
                        moveSlides: 1,
                        slideMargin: 10,
                        pager: false
                    });
        ";
        $this->script_js = "

        
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
        $('.area_1_search :checkbox').change(function(){
            var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('.area_1_search [value=' + value + ']').prop( \"checked\", true );
            } else {
                $('.area_1_search [value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.area_1_search :checkbox:checked').length / 2;
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Район (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Район\";
                } else {
                    result_ = $(this).parent(\"label\").text();
                }
                $('#amount-area_1').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Район (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Район\";
                } else {
                    result_ = $('.area_1_search :checkbox:checked').parent(\"label\").text();
                }
                $('#amount-area_1').val(result_);
            }
        });
    
        $('.area_2_search :checkbox').change(function(){
                    var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('.area_2_search [value=' + value + ']').prop( \"checked\", true );
            } else {
                $('.area_2_search [value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.area_2_search :checkbox:checked').length / 2;
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Район (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Район\";
                } else {
                    result_ = $(this).parent(\"label\").text();
                }
                $('#amount-area_2').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Район (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Район\";
                } else {
                    result_ = $ ('.area_2_search :checkbox:checked').parent(\"label\").text();
                }
                $('#amount-area_2').val(result_);
            }
        });
        
    
        $('.typeHouse_1_search :checkbox').change(function(){
            var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('[value=' + value + ']').prop( \"checked\", true );
            } else {
                $('[value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.typeHouse_1_search :checkbox:checked').length / 2;
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Тип Дома (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Тип дома\";
                } else {
                    result_ = $(this).val();
                }
                $('#amount-typeHouse_1').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Тип Дома (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Тип дома\";
                } else {
                    result_ = $ ('.typeHouse_1_search :checkbox:checked').val();
                }
                $('#amount-typeHouse_1').val(result_);
            }
        });
    
        $('.typeHouse_2_search :checkbox').change(function(){
            var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('[value=' + value + ']').prop( \"checked\", true );
            } else {
                $('[value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.typeHouse_2_search :checkbox:checked').length / 2;
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Материал стен (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Материал стен\";
                } else {
                    result_ = $(this).val();
                }
                $('#amount-typeHouse_2').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Материал стен (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Материал стен\";
                } else {
                    result_ = $ ('.typeHouse_2_search :checkbox:checked').val();
                }
                $('#amount-typeHouse_2').val(result_);
            }
        });
    
        $('.formObj_2_search :checkbox').change(function(){
            var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('[value=' + value + ']').prop( \"checked\", true );
            } else {
                $('[value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.formObj_2_search :checkbox:checked').length / 2;          
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Вид объекта (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Вид объекта\";
                } else {
                    result_ = $(this).val();
                }
                $('#amount-formObj_2').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Вид объекта (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Вид объекта\";
                } else {
                    result_ = $ ('.formObj_2_search :checkbox:checked').val();
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
        
        $('.price_search input[type=number]').change(function () {
            var block = $(this).parent();
            var minPrice = block.find('.min-price').val();
            var maxPrice = block.find('.max-price').val();
            $('.price_search .min-price').val(minPrice);       
            $('.price_search .max-price').val(maxPrice);
            if (minPrice != '' && minPrice != 0) {
                if ( minPrice >= 1000 && minPrice < 1000000) {
                  minPrice = (minPrice / 1000) + ' т.';
                } else if (minPrice >= 1000000 && minPrice < 1000000000) {
                    minPrice = (minPrice / 1000000) + ' млн.';
                }
            }
            if (maxPrice != '' && maxPrice != 0) {
                if ( maxPrice >= 1000 && maxPrice < 1000000) {
                  maxPrice = (maxPrice / 1000) + ' т.';
                } else if (maxPrice >= 1000000 && maxPrice < 1000000000) {
                    maxPrice = (maxPrice / 1000000) + ' млн.';
                }
            }                   
            var summ;
            if ((minPrice == \"\") && (maxPrice == \"\")) {
                summ = \"Цена, руб\";
            } else if (minPrice == \"\" || minPrice == 0) {
                summ = \"До \" + maxPrice + \" руб\";
            } else if (maxPrice == \"\" || maxPrice == 0) {
                summ = \"От \" + minPrice + \" руб\";
            } else {
                summ = minPrice + \" - \" + maxPrice  + \" руб\";
            }
            $('#amount-price').val(summ);
        });
    
        var minPrice = $('.min-price').val();
        var maxPrice = $('.max-price').val();
        if (minPrice != '' && minPrice != 0) {
            if ( minPrice >= 1000 && minPrice < 1000000) {
              minPrice = (minPrice / 1000) + ' т.';
            } else if (minPrice >= 1000000 && minPrice < 1000000000) {
                minPrice = (minPrice / 1000000) + ' млн.';
            }
        }
        if (maxPrice != '' && maxPrice != 0) {
            if ( maxPrice >= 1000 && maxPrice < 1000000) {
              maxPrice = (maxPrice / 1000) + ' т.';
            } else if (maxPrice >= 1000000 && maxPrice < 1000000000) {
                maxPrice = (maxPrice / 1000000) + ' млн.';
            }
        }  
        var summ;
        if ((minPrice == \"\") && (maxPrice == \"\")) {
            summ = \"Цена, руб\";
        } else if (minPrice == \"\" || minPrice == 0) {
            summ = \"До \" + maxPrice + \" руб\";
        } else if (maxPrice == \"\" || maxPrice == 0) {
            summ = \"От \" + minPrice + \" руб\";
        } else {
            summ = minPrice + \" - \" + maxPrice  + \" руб\";
        }
        $('#amount-price').val(summ);
    
        $('.rooms_search :checkbox').change(function () {
            var value = $(this).val();
            if($(this).is(\":checked\")) {
                $('.rooms_search [value=' + value + ']').prop( \"checked\", true );
            } else {
                $('.rooms_search [value=' + value + ']').prop( \"checked\", false );
            }
            var checkCount = $ ('.rooms_search :checkbox:checked').length / 2;
            if($(this).is(\":checked\")) {
                if (checkCount > 1) {
                    result_ = \"Типов кол. комнат (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    result_ = \"Количество комнат\";
                } else {
                    result_ = $(this).val();
                    if ((result_ == \"Студия\") || (result_ == \"9+\")) {
                        result_ = result_;
                    }
                    else {
                        result_ = result_+ \"-к\";
                    }
                }
                $('#amount-rooms').val(result_);
    
            } else {
                if (checkCount > 1) {
                    result_ = \"Типов кол. комнат (\" + checkCount + \")\";
                } else if  (checkCount == 0) {
                    var result_ = \"Количество комнат\";
                } else {
                    result_ = $ ('.rooms_search :checkbox:checked').val();
                    if ((result_ == \"Студия\") || (result_ == \"9+\")) {
                        result_ = result_;
                    } else  {
                        result_ = result_+ \"-к\";
                    }
                }
                $('#amount-rooms').val(result_);
            }
        });
        
//            $('.favor').click( function () {
//        if ($(this).hasClass(\"fa-star-o\")) {
//            var data = { obj_id : $(this).find('id').text(), addfav : 1};
//            $.get(\"\admin\\action\\favorite\\\"+, data, addFav);
//        } else if ($(this).hasClass(\"fa-star\")) {
//            var data = { obj_id : $(this).find('id').text(), delfav : 1};
//            $.get(\"ajax.php\", data, delFav);
//        }
//        });
        $('form.favor').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serializeArray();
            var i = $(this).find('i');
            if(i.hasClass(\"fa-star-o\")) {
                $.ajax({
                type: \"POST\",
                url: url,
                data: data,
                success: addFav
                });
            } else {
                $.ajax({
                type: \"POST\",
                url: url,
                data: data,
                success: delFav
                });
            }        
            });
            
        function addFav (data) {
                $('#favor-'+data.id).removeClass(\"fa-star-o\").addClass(\"fa-star\");
                var count = $('.fav-count').text();
                $('.fav-count').text(+ count + 1);            
            }
        
        function delFav (data) {
            $('#favor-'+data.id).removeClass(\"fa-star\").addClass(\"fa-star-o\");
            var count = $('.fav-count').text();
            $('.fav-count').text(count - 1);    
        }
    
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
        ";
        $this->cat_script_js = "
            $(document).ready(function() {
                $('#cat_amount-area_1').click(function () {
                    $('#cat_area_1_search').toggle(1);
                });
                $('#cat_amount-area_2').click(function () {
                    $('#cat_area_2_search').toggle(1);
                });
                $('#cat_amount-floor').click(function () {
                    $('#cat_floor_search').toggle(1);
                });
                $('#cat_amount-floorInObj_1').click(function () {
                    $('#cat_floorInObj_1_search').toggle(1);
                });
                $('#cat_amount-floorInObj_2').click(function () {
                    $('#cat_floorInObj_2_search').toggle(1);
                });
                $('#cat_amount-typeHouse_1').click(function () {
                    $('#cat_typeHouse_1_search').toggle(1);
                });
                $('#cat_amount-typeHouse_2').click(function () {
                    $('#cat_typeHouse_2_search').toggle(1);
                });
                $('#cat_amount-square_1').click(function () {
                    $('#cat_square_1_search').toggle(1);
                });
                $('#cat_amount-square_2').click(function () {
                    $('#cat_square_2_search').toggle(1);
                });
                $('#cat_amount-square_earth').click(function () {
                    $('#cat_square_earth_search').toggle(1);
                });
                $('#cat_amount-price').click(function () {
                    $('#cat_price_search').toggle(1);
                });
                $('#cat_amount-rooms').click(function () {
                    $('#cat_rooms_search').toggle(1);
                });
                $('#cat_amount-formObj_2').click(function () {
                    $('#cat_formObj_2_search').toggle(1);
                });
                $('#cat_amount-distance').click(function () {
                    $('#cat_distance_search').toggle(1);
                });
            
                $('#cat_city').change(function () {
                    var myChoise = $ ('#cat_city :selected').val();
                    if (myChoise == 1) {
                        $('#cat_amount-area_1').show();
                        $('#cat_amount-area_2').hide();
                    } else if (myChoise == 2) {
                        $('#cat_amount-area_1').hide();
                        $('#cat_amount-area_2').show();
                    } else {
                        $('#cat_amount-area_1').hide();
                        $('#cat_amount-area_2').hide();
                    }
            
                });
            
                $('#cat_area_1_search :checkbox').change(function(){
                    var checkCount = $ ('#cat_area_1_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Район (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Район\";
                        } else {
                            result_ = $(this).val();
                        }
                        $('#cat_amount-area_1').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Район (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Район\";
                        } else {
                            result_ = $ ('#cat_area_1_search :checkbox:checked').val();
                        }
                        $('#cat_amount-area_1').val(result_);
                    }
                });
            
                $('#cat_area_2_search :checkbox').change(function(){
                    var checkCount = $ ('#cat_area_2_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Район (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Район\";
                        } else {
                            result_ = $(this).val();
                        }
                        $('#cat_amount-area_2').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Район (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Район\";
                        } else {
                            result_ = $ ('#cat_area_2_search :checkbox:checked').val();
                        }
                        $('#cat_amount-area_2').val(result_);
                    }
                });
            
            
                $('#cat_typeHouse_1_search :checkbox').change(function(){
                    var checkCount = $ ('#cat_typeHouse_1_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Тип Дома (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Тип дома\";
                        } else {
                            result_ = $(this).val();
                        }
                        $('#cat_amount-typeHouse_1').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Тип Дома (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Тип дома\";
                        } else {
                            result_ = $ ('#cat_typeHouse_1_search :checkbox:checked').val();
                        }
                        $('#cat_amount-typeHouse_1').val(result_);
                    }
                });
            
                $('#cat_typeHouse_2_search :checkbox').change(function(){
                    var checkCount = $ ('#cat_typeHouse_2_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Материал стен (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Материал стен\";
                        } else {
                            result_ = $(this).val();
                        }
                        $('#cat_amount-typeHouse_2').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Материал стен (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Материал стен\";
                        } else {
                            result_ = $ ('#cat_typeHouse_2_search :checkbox:checked').val();
                        }
                        $('#cat_amount-typeHouse_2').val(result_);
                    }
                });
            
                $('#cat_formObj_2_search :checkbox').change(function(){
                    var checkCount = $ ('#cat_formObj_2_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Вид объекта (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Вид объекта\";
                        } else {
                            result_ = $(this).val();
                        }
                        $('#cat_amount-formObj_2').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Вид объекта (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Вид объекта\";
                        } else {
                            result_ = $ ('#cat_formObj_2_search :checkbox:checked').val();
                        }
                        $('#cat_amount-formObj_2').val(result_);
                    }
                });
            
                $('#cat_type').change(function () {
                    var myChoise = $ ('#cat_type :selected').val();
                    if (myChoise == 2) {
                        $('#cat_formObj_3').hide();
                        $('#cat_amount-floor').hide();
                        $('#cat_amount-typeHouse_1').hide();
                        $('#cat_amount-floorInObj_1').hide();
                        $('#cat_formObj_1').hide();
                        $('#cat_typeHouse_1').hide();
                        $('#cat_amount-rooms').hide();
                        $('#cat_amount-formObj_2').show();
                        $('#cat_amount-typeHouse_2').show();
                        $('#cat_amount-square_earth').show();
                        $('#cat_amount-floorInObj_2').show();
                        $('#cat_typeHouse_2').show();
                        $('#cat_amount-square_2').show();
                        $('#cat_amount-distance').show();
                        $('#cat_amount-square_1').hide();
                    } else if (myChoise == 3){
                        $('#cat_amount-typeHouse_2').hide();
                        $('#cat_amount-floorInObj_1').show();
                        $('#cat_formObj_3').show();
                        $('#cat_amount-floor').show();
                        $('#cat_amount-typeHouse_1').show();
                        $('#cat_formObj_1').hide();
                        $('#cat_typeHouse_1').show();
                        $('#cat_amount-rooms').show();
                        $('#cat_amount-formObj_2').hide();
                        $('#cat_amount-square_earth').hide();
                        $('#cat_amount-floorInObj_2').hide();
                        $('#cat_typeHouse_2').hide();
                        $('#cat_amount-square_2').hide();
                        $('#cat_amount-distance').hide();
                        $('#cat_amount-square_1').show();
                    } else {
                        $('#cat_amount-typeHouse_2').hide();
                        $('#cat_amount-typeHouse_1').show();
                        $('#cat_formObj_3').hide();
                        $('#cat_amount-floor').show();
                        $('#cat_amount-floorInObj_1').show();
                        $('#cat_formObj_1').show();
                        $('#cat_typeHouse_1').show();
                        $('#cat_amount-rooms').show();
                        $('#cat_amount-formObj_2').hide();
                        $('#cat_amount-square_earth').hide();
                        $('#cat_amount-floorInObj_2').hide();
                        $('#cat_typeHouse_2').hide();
                        $('#cat_amount-square_2').hide();
                        $('#cat_amount-distance').hide();
                        $('#cat_amount-square_1').show();
                    }
                });
            
                $('#cat_price_search input[type=number]').change(function () {
                    var minPrice = $('#cat_min-price').val();
                    var maxPrice = $('#cat_max-price').val();
                    var summ;
                    if ((minPrice == \"\") && (maxPrice == \"\")) {
                        summ = \"Цена, руб\";
                    } else if (minPrice == \"\" || minPrice == 0) {
                        summ = \"До \" + maxPrice + \" руб\";
                    } else if (maxPrice == \"\" || maxPrice == 0) {
                        summ = \"От \" + minPrice + \" руб\";
                    } else {
                        summ = minPrice + \" - \" + maxPrice  + \" руб\";
                    }
                    $('#cat_amount-price').val(summ);
                });
            
                var minPrice = $('#cat_min-price').val();
                var maxPrice = $('#cat_max-price').val();
                var summ;
                if ((minPrice == \"\") && (maxPrice == \"\")) {
                    summ = \"Цена, руб\";
                } else if (minPrice == \"\" || minPrice == 0) {
                    summ = \"До \" + maxPrice + \" руб\";
                } else if (maxPrice == \"\" || maxPrice == 0) {
                    summ = \"От \" + minPrice + \" руб\";
                } else {
                    summ = minPrice + \" - \" + maxPrice  + \" руб\";
                }
                $('#cat_amount-price').val(summ);
            
                $('#cat_rooms_search :checkbox').change(function () {
                    var checkCount = $ ('#cat_rooms_search :checkbox:checked').length;
                    if($(this).is(\":checked\")) {
                        if (checkCount > 1) {
                            result_ = \"Типов кол. комнат (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            result_ = \"Количество комнат\";
                        } else {
                            result_ = $(this).val();
                            if ((result_ == \"Студия\") || (result_ == \"9+\")) {
                                result_ = result_;
                            }
                            else {
                                result_ = result_+ \"-к\";
                            }
                        }
                        $('#cat_amount-rooms').val(result_);
            
                    } else {
                        if (checkCount > 1) {
                            result_ = \"Типов кол. комнат (\" + checkCount + \")\";
                        } else if  (checkCount == 0) {
                            var result_ = \"Количество комнат\";
                        } else {
                            result_ = $ ('#cat_rooms_search :checkbox:checked').val();
                            if ((result_ == \"Студия\") || (result_ == \"9+\")) {
                                result_ = result_;
                            } else  {
                                result_ = result_+ \"-к\";
                            }
                        }
                        $('#cat_amount-rooms').val(result_);
                    }
                });
            
            
                // Скрыть блоки при нажатии во вне
            
                $(document).click(function(event) {
                    if (!$(event.target).closest(\"#catalog_filter\").length) {
                        $(\"#cat_area_1_search, #cat_area_2_search, #cat_floor_search, #cat_floorInObj_1_search, #cat_typeHouse_1_search, #cat_typeHouse_2_search, #cat_square_1_search, #cat_square_2_search, #cat_square_earth_search, #cat_price_search, #cat_rooms_search, #cat_formObj_2_search, #cat_distance_search\").hide(1);
                    }
                    event.stopPropagation();
                });
                    $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });
            
            
            });// End ready
        ";

        switch ($type) {
            case "filter":
                if ($static) {
                    $this->content = "
                        $(document).ready(function() {
                            $this->script_js
                        });
                        $this->sliders
                        ";
                } else {
                    $floor_min = $request->input("floor_min");
                    $floor_max = $request->input("floor_max");
                    $floorInObj_2_min = $request->input("floorInObj_2_min");
                    $floorInObj_2_max = $request->input("floorInObj_2_max");
                    $floorInObj_1_min = $request->input("floorInObj_1_min");
                    $floorInObj_1_max = $request->input("floorInObj_1_max");
                    $square_1_min = $request->input("square_1_min");
                    $square_1_max = $request->input("square_1_max");
                    $square_2_min = $request->input("square_2_min");
                    $square_2_max = $request->input("square_2_max");
                    $square_earth_min = $request->input("square_earth_min");
                    $square_earth_max = $request->input("square_earth_max");
                    $distance_min = $request->input("distance_min");
                    $distance_max = $request->input("distance_max");
                    $this->content = "
                    $(document).ready(function() {
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
                        $this->script_js
                    });
                    
                    // function
                    function initSlider(slider) {
        switch (slider) {
            case (\"square_1\"):
            var min = 10;
            var max = 200;
                $( \"#slider-range-square_1\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $square_1_min, $square_1_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_min\" ).val(lastVar1);
                        $( \"#amount-square_max\" ).val(lastVar2);
                        if (lastVar1 == 200) {
                            lastVar1 = \"200+\";
                        }
                        if (lastVar2 == 200) {
                            lastVar2 = \"200+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" м²\";
                        } else if ( (lastVar1 == 10) && (lastVar2 == \"200+\")) {
                            resultat = \"Площадь, м²\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
                        }
                        $( \"#amount-square_1\" ).val(resultat);
                        $(\"#slider-range-square_1 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_1 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_1 .ui-slider-handle\").first().text($square_1_min);
                $(\"#slider-range-square_1 .ui-slider-handle\").last().text($square_1_max);
                break;
            case (\"floor\"):
            var min = 1;
            var max = 31;
                $( \"#slider-range-floor\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $floor_min, $floor_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floor_min\").val(lastVar1);
                        $(\"#amount-floor_max\").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = \"31+\";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = \"31+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этаж\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                            resultat = \"Этаж\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этаж\";
                        }
                        $(\"#amount-floor\").val(resultat);
                        $(\"#slider-range-floor .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floor .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floor .ui-slider-handle\").first().text($floor_min);
                $(\"#slider-range-floor .ui-slider-handle\").last().text($floor_max);
                break;
            case (\"floorInObj_1\"):
            var min = 1;
            var max = 31;
                $( \"#slider-range-floorInObj_1\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $floorInObj_1_min, $floorInObj_1_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floorInObj_1_min\").val(lastVar1);
                        $(\"#amount-floorInObj_1_max\").val(lastVar2);
                        if (lastVar1 == 31) {
                            lastVar1 = \"31+\";
                        }
                        if (lastVar2 == 31) {
                            lastVar2 = \"31+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этажей\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                            resultat = \"Этажей в доме\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
                        }
                        $(\"#amount-floorInObj_1\").val(resultat);
                        $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text($floorInObj_1_min);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text($floorInObj_1_max);
                break
            case (\"floorInObj_2\"):
            var min = 1;
            var max = 5;
                $( \"#slider-range-floorInObj_2\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $floorInObj_2_min, $floorInObj_2_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[0];
                        var lastVar2 = ui.values[1];
                        $(\"#amount-floorInObj_2_min\").val(lastVar1);
                        $(\"#amount-floorInObj_2_max\").val(lastVar2);
                        if (lastVar1 == 5) {
                            lastVar1 = \"5+\";
                        }
                        if (lastVar2 == 5) {
                            lastVar2 = \"5+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" этажей\";
                        } else if ((lastVar1 == 1) && (lastVar2 == \"5+\")) {
                            resultat = \"Этажей в доме\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
                        }
                        $(\"#amount-floorInObj_2\").val(resultat);
                        $(\"#slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-floorInObj_2 .ui-slider-handle\").first().text($floorInObj_2_min);
                $(\"#slider-range-floorInObj_2 .ui-slider-handle\").last().text($floorInObj_2_max);
                break;
            case (\"square_2\"):
            var min = 10;
            var max = 500;
                $( \"#slider-range-square_2\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $square_2_min, $square_2_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_2_min\" ).val(lastVar1);
                        $( \"#amount-square_2_max\" ).val(lastVar2);
                        if (lastVar1 == 500) {
                            lastVar1 = \"500+\";
                        }
                        if (lastVar2 == 500) {
                            lastVar2 = \"500+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" м²\";
                        } else if ( (lastVar1 == 10) && (lastVar2 == \"500+\")) {
                            resultat = \"Площадь дома, м²\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
                        }
                        $( \"#amount-square_2\" ).val(resultat);
                        $(\"#slider-range-square_2 .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_2 .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_2 .ui-slider-handle\").first().text($square_2_min);
                $(\"#slider-range-square_2 .ui-slider-handle\").last().text($square_2_max);
                break;
            case (\"square_earth\"):
            var min = 1;
            var max = 100;
                $( \"#slider-range-square_earth\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $square_earth_min, $square_earth_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-square_earth_min\" ).val(lastVar1);
                        $( \"#amount-square_earth_max\" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = \"100+\";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = \"100+\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" сот.\";
                        } else if ( (lastVar1 == 1) && (lastVar2 == \"100+\")) {
                            resultat = \"Площадь участка, сот.\";
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" сот.\";
                        }
                        $( \"#amount-square_earth\" ).val(resultat);
                        $(\"#slider-range-square_earth .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-square_earth .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-square_earth .ui-slider-handle\").first().text($square_earth_min);
                $(\"#slider-range-square_earth .ui-slider-handle\").last().text($square_earth_max);
                break;
            case (\"distance\"):
            var min = 0;
            var max = 100;
                $( \"#slider-range-distance\" ).slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ $distance_min, $distance_max ],
                    slide: function( event, ui ) {
                        var lastVar1 = ui.values[ 0 ];
                        var lastVar2 = ui.values[ 1 ];
                        $( \"#amount-distance_min\" ).val(lastVar1);
                        $( \"#amount-distance_max\" ).val(lastVar2);
                        if (lastVar1 == 100) {
                            lastVar1 = \"100+\";
                        }
                        if (lastVar2 == 100) {
                            lastVar2 = \"100+\";
                        }
                        if (lastVar1 == 0 && lastVar2 == 0) {
                            lastVar1 = \"В черте города\";
                        }
                        var resultat = \"\";
                        if (lastVar1 == lastVar2) {
                            resultat = lastVar2 + \" км.\";
                        } else if ( (lastVar1 == 0) && (lastVar2 == \"100+\")) {
                            resultat = \"Расстояние до города, км.\";
                        } else if (lastVar1 == \"В черте города\") {
                            resultat = \"В черте города\";
                            lastVar1 = 0;
                        } else {
                            resultat = lastVar1 + \" - \" + lastVar2 + \" км.\";
                        }
                        $( \"#amount-distance\" ).val(resultat);
                        $(\"#slider-range-distance .ui-slider-handle\").first().text(lastVar1);
                        $(\"#slider-range-distance .ui-slider-handle\").last().text(lastVar2);
                    }
                });
                $(\"#slider-range-distance .ui-slider-handle\").first().text($distance_min);
                $(\"#slider-range-distance .ui-slider-handle\").last().text($distance_max);
                break;
            case (\"room\"):
                $( function() {
                    $( \".rooms_search :checkbox\" ).checkboxradio({
                        icon: false
                    });
                });
                break;
            case (\"init\"):
                var lastVar1_1 = $square_1_min;
                var lastVar2_1 = $square_1_max;
                $( \"#amount-square_min\" ).val(lastVar1_1);
                $( \"#amount-square_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 200) {
                    lastVar1_1 = \"200+\";
                }
                if (lastVar2_1 == 200) {
                    lastVar2_1 = \"200+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" м²\";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"200+\")) {
                    resultat2 = \"Площадь, м²\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
                }
                $( \"#amount-square_1\" ).val(resultat2);
                

                var lastVar1_1 = $floor_min;
                var lastVar2_1 = $floor_max;
                $( \"#amount-floor_min\" ).val(lastVar1_1);
                $( \"#amount-floor_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = \"31+\";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = \"31+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этаж\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
                    resultat2 = \"Этаж\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этаж\";
                }
                $( \"#amount-floor\" ).val(resultat2);


                var lastVar1_1 = $floorInObj_1_min;
                var lastVar2_1 = $floorInObj_1_max;
                $( \"#amount-floorInObj_1_min\" ).val(lastVar1_1);
                $( \"#amount-floorInObj_1_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 31) {
                    lastVar1_1 = \"31+\";
                }
                if (lastVar2_1 == 31) {
                    lastVar2_1 = \"31+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этажей\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
                    resultat2 = \"Этажей в доме\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
                }
                $( \"#amount-floorInObj_1\" ).val(resultat2);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1_1);
                $(\"#slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2_1);
                

                var lastVar1_1 = $floorInObj_2_min;
                var lastVar2_1 = $floorInObj_2_max;
                $( \"#amount-floorInObj_2_min\" ).val(lastVar1_1);
                $( \"#amount-floorInObj_2_max\" ).val(lastVar2_1);

                if (lastVar1_1 == 5) {
                    lastVar1_1 = \"5+\";
                }
                if (lastVar2_1 == 5) {
                    lastVar2_1 = \"5+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" этажей\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"5+\")) {
                    resultat2 = \"Этажей в доме\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
                }
                $( \"#amount-floorInObj_2\" ).val(resultat2);


                var lastVar1_1 = $square_2_min;
                var lastVar2_1 = $square_2_max;
                $( \"#amount-square_2_min\" ).val(lastVar1_1);
                $( \"#amount-square_2_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 500) {
                    lastVar1_1 = \"500+\";
                }
                if (lastVar2_1 == 500) {
                    lastVar2_1 = \"500+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" м²\";
                } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"500+\")) {
                    resultat2 = \"Площадь дома, м²\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
                }
                $( \"#amount-square_2\" ).val(resultat2);


                var lastVar1_1 = $square_earth_min;
                var lastVar2_1 = $square_earth_max;
                $( \"#amount-square_earth_min\" ).val(lastVar1_1);
                $( \"#amount-square_earth_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = \"100+\";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = \"100+\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" сот.\";
                } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"100+\")) {
                    resultat2 = \"Площадь участка, сот.\";
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" сот.\";
                }
                $( \"#amount-square_earth\" ).val(resultat2);


                var lastVar1_1 = $distance_min;
                var lastVar2_1 = $distance_max;
                $( \"#amount-distance_min\" ).val(lastVar1_1);
                $( \"#amount-distance_max\" ).val(lastVar2_1);
                if (lastVar1_1 == 100) {
                    lastVar1_1 = \"100+\";
                }
                if (lastVar2_1 == 100) {
                    lastVar2_1 = \"100+\";
                }
                if (lastVar1_1 == 0 && lastVar2_1 == 0) {
                    lastVar1_1 = \"В черте города\";
                }
                var resultat2 = \"\";
                if (lastVar1_1 == lastVar2_1) {
                    resultat2 = lastVar2_1 + \" км.\";
                } else if ((lastVar1_1 == 0) && (lastVar2_1 == \"100+\")) {
                    resultat2 = \"Расстояние до города, км.\";
                } else if (lastVar1_1 == \"В черте города\") {
                    resultat2 = \"В черте города\";
                    lastVar1_1 = 0;
                } else {
                    resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" км.\";
                }
                $( \"#amount-distance\" ).val(resultat2);
                break;
            default:
                break;
            }
    };                   
                 ";
                }
                break;
            case "obj-view":
                if ($static) {
                    $this->content = "
                        $(document).ready(function() {
                            $('#imageGallery').lightSlider({
                                gallery:true,
                                item:1,
                                loop:true,
                                controls: false,
                                auto:true,
                                pauseOnHover: true,
                                vertical:true,
                                verticalHeight:550,
                                vThumbWidth:100,
                                thumbItem:8,
                                thumbMargin:4,
                                slideMargin:0,
                                currentPagerPosition:'left',
                                onSliderLoad: function(el) {
                                    el.lightGallery({
                                        selector: '#imageGallery .lslide'
                                    });
                                }
                            });
                            $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });         
                        });
                        ymaps.ready(function () {
                                var myMap = window.map = new ymaps.Map('YMapsID', {
                                        center: [$request->geo],
                                        zoom: 16,
                                        behaviors: ['default']
                    
                                            }),
                                                                        
                                         _point = new ymaps.Placemark([$request->geo], {
                                        balloonContentBody: \"$request->address\"                            
                                        });
                                        myMap.controls.add(
                                    new ymaps.control.ZoomControl()
                            );
                            myMap.controls.add('typeSelector')
                            myMap.geoObjects.add(_point);});
                   ";
                } else {
                    $this->content = "
                $(document).ready(function() {
                    $('#imageGallery').lightSlider({
                        gallery:true,
                        item:1,
                        loop:true,
                        controls: false,
                        auto:true,
                        pauseOnHover: true,
                        vertical:true,
                        verticalHeight:550,
                        vThumbWidth:100,
                        thumbItem:8,
                        thumbMargin:4,
                        slideMargin:0,
                        currentPagerPosition:'left',
                        onSliderLoad: function(el) {
                            el.lightGallery({
                                selector: '#imageGallery .lslide'
                            });
                        }
                    });
                        $('.slider4').bxSlider({
                            slideWidth: 200,
                            minSlides: 5,
                            maxSlides: 5,
                            moveSlides: 1,
                            slideMargin: 10,
                            pager: false
                        });
                                           $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });
                });
                ymaps.ready(function () {
                        var myMap = window.map = new ymaps.Map('YMapsID', {
                                center: [$request->geo],
                                zoom: 16,
                                behaviors: ['default']
            
                                    }),
                                                                
                                 _point = new ymaps.Placemark([$request->geo], {
                                balloonContentBody: \"$request->address\"                            
                                });
                                myMap.controls.add(
                            new ymaps.control.ZoomControl()
                    );
                    myMap.controls.add('typeSelector')
                    myMap.geoObjects.add(_point);});
                    ";
                }
                break;
            case "post-view":
                if ($static) {
                    $this->content = "
                        $(document).ready(function() {
                            $('#imageGallery').lightSlider({
                                gallery:true,
                                item:1,
                                loop:true,
                                controls: false,
                                auto:true,
                                pauseOnHover: true,
                                vertical:true,
                                verticalHeight:550,
                                vThumbWidth:100,
                                thumbItem:8,
                                thumbMargin:4,
                                slideMargin:0,
                                currentPagerPosition:'left',
                                onSliderLoad: function(el) {
                                    el.lightGallery({
                                        selector: '#imageGallery .lslide'
                                    });
                                }
                            });
                            $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });         
                        });                  
                   ";
                } else {
                    $this->content = "
                $(document).ready(function() {
                        $('.slider4').bxSlider({
                            slideWidth: 200,
                            minSlides: 5,
                            maxSlides: 5,
                            moveSlides: 1,
                            slideMargin: 10,
                            pager: false
                        });
                                           $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"http://обменжилья.рф/catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });
                });                
                    ";
                }
                break;
            case "obj-create":
                $this->content = "
                $(function() {
                        var form = $(\"#objCreate\");
                        form.validate({                           
                            rules: {                               
                                obj_address: {
                                    required: true,
                                },
                            },
                            messages: {
                                obj_address: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_price: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_doplata: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_house_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_earth_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_phone: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_name: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_mail: {
                                email: \"Введите корректный Email\",
                                },
                            },
                            errorPlacement: function errorPlacement(error, element) { element.closest('.form-group').find('.form-control').after(error); },
                            highlight: function(element) {
                                $(element).closest('.form-group').addClass('has-error');
                            },
                            unhighlight: function(element) {
                                $(element).closest('.form-group').removeClass('has-error');
                            }
                        });

                    });
                    Dropzone.options.myDropzone = {
                            paramName: \"image\",
                            acceptedFiles: \"image/*\",
                            maxFilesize: 100,
                            addRemoveLinks: true,
                            maxFiles: 20,
                            removedfile: function(file) {
                                var id = $('#obj-id').val();
                                var name = file.name;
                                var tmp_img = $('#tmp-img').val();
                                var token = \"$token\";
                                $.ajax({
                                    type: 'POST',
                                    url: '" . route('adminObjDelImg') . "',
                                    data: \"file=\"+name+\"&obj_id=\"+id+\"&tmp_img=\"+tmp_img+\"&_token=\"+token,
                                    dataType: 'html'
                                });
                                var _ref;
                                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                            }
                        };
                        $(function() {
                            $(\"#comforts-no-border\").multiPicker({
                                selector    : \"checkbox\",
                                cssOptions : {
                                size      :  \"large\"
                                }
                               });
                            });
                        $(document).ready(function ()
                        { $('#spec_offer').on(
                                'change',
                                function()
                                {
                                    var 
                                        active = 'hide',
                                        obj    = $('#spec_offer_input');
                                    if (  $('#spec_offer').is(\":checked\")  ) active = 'show';
                                    obj[ active ]();
                                }
                            );     
                        
                            $('#obj_city select') . change(function () {
                                var
                                myChoise = $(this) . val();
                                $('#obj_city select option') . each(function () {
                                    var
                                    myChoise2 = $(this) . val();
                                    if (myChoise2 == myChoise) {
                                        $('#obj_area' + myChoise) . show();
                                    } else {
                                        $('#obj_area' + myChoise2) . hide();
                                    }
                                });
                            });
                        
                            $('#price input') . keyup(function () {
                                var price = $('#price input') . val(), square = $('#square_general') . val();
                                        if ($('#obj_type[name=\"obj_type\"]').val() == '2') {
                                            square = $('#house_square input[name=\"obj_house_square\"]') . val();
                                        }
                                        if (square . length !== 0) {
                                            price =  price.replace(/\\./g, '');
                                            square =  square.replace(/\\./g, '');
                                            pricesquare = Math . round(price / square);
                                            pricesquare = (pricesquare + '');
                                            pricesquare = pricesquare . replace(/(\\d)(?=(\\d\\d\\d)+([^\\d]|$))/g, '$1\\.');
                                            $('#price_square input') . attr('value', pricesquare);
                                        }
                                    });
                           $(\"#square_general_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_general').val(my);
                                    });
                           $(\"#square_kitchen_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_kitchen').val(my);
                                    });  
                           $(\"#square_life_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_life').val(my);
                                    });
                                    $(\".chosen-select\").chosen();  
                        });
                ";
                break;
            case "obj-edit":
                $this->content = "
                    $(function() {
                        var form = $(\"#objCreate\");
                        form.validate({                           
                            rules: {                               
                                obj_address: {
                                    required: true,
                                },
                            },
                            messages: {
                                obj_address: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_price: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_doplata: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_house_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                obj_earth_square: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_phone: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_name: {
                                required: \"Это поле обязательно для заполнения\",
                                },
                                client_mail: {
                                email: \"Введите корректный Email\",
                                },
                            },
                            errorPlacement: function errorPlacement(error, element) { element.closest('.form-group').find('.form-control').after(error); },
                            highlight: function(element) {
                                $(element).closest('.form-group').addClass('has-error');
                            },
                            unhighlight: function(element) {
                                $(element).closest('.form-group').removeClass('has-error');
                            }
                        });
                    });
                    Dropzone.options.myDropzone = {
                            paramName: \"image\",
                            acceptedFiles: \"image/*\",
                            maxFilesize: 100,
                            addRemoveLinks: true,
                            maxFiles: 20,
                            removedfile: function(file) {
                                var id = $('#obj-id').val();
                                var name = file.name;
                                var token = \"$token\";
                                $.ajax({
                                    type: 'POST',
                                    url: '" . route('adminObjDelImg') . "',
                                    data: \"file=\"+name+\"&obj_id=\"+id+\"&_token=\"+token,
                                    dataType: 'html'
                                });
                                var _ref;
                                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                            },
                            init: function () {
                                thisDropzone = this;                               
                                var id = $('#obj-id').val();
                                <!-- 4 -->
                                $.get('" . route('adminObjGetImg') . "',{ objid: id}).done( function (data) {
                                    $.each(data, function (index, item) {
                                        //// Create the mock file:
                                        var mockFile = {
                                            name: item.name,
                                            size: item.size,
                                            status: Dropzone.ADDED,
                                            accepted: true
                                        };
                    
                                        // Call the default addedfile event handler
                                        thisDropzone.emit(\"addedfile\", mockFile);
                    
                                        // And optionally show the thumbnail of the file:
                                        //thisDropzone.emit(\"thumbnail\", mockFile, \"uploads / \"+item.name);
                    
                                        thisDropzone.createThumbnailFromUrl(mockFile, \"" . asset(config('settings.theme')) . "/uploads/images/" . $request->id . "/\" + item . name);

                                        thisDropzone . emit(\"complete\", mockFile);

                                        thisDropzone . files . push(mockFile);
                                        });
                                    });
                                }
                            };
    $(function () {
    $(\"#comforts-no-border\").multiPicker({
                                selector	: \"checkbox\",
                                prePopulate : ['" . $this->getEditComforts($request) . "'],
                                cssOptions : {
                                size    : \"large\"
                                }
                            });
                        });
    $(document) . ready(function () {
        $('#spec_offer').on(
                                'change',
                                function()
                                {
                                    var 
                                        active = 'hide',
                                        obj    = $('#spec_offer_input');
                                    if (  $('#spec_offer').is(\":checked\")  ) active = 'show';
                                    obj[ active ]();
                                }
                            );
        " . $this->getEditScript($request) . "
    
        $('#obj_city select').change(function () {
            var myChoise = $(this).val();
            $('#obj_city select option').each(function () {
                    var myChoise2 = $(this).val();
                    if (myChoise2 == myChoise) {
                        $('#obj_area'+myChoise).show();
                    } else {
                        $('#obj_area'+myChoise2).hide();
                    }
                });
            });
    
                $('#price input') . keyup(function () {
                                var price = $('#price input') . val(), square = $('#square_general') . val();
                                        if ($('#obj_type[name=\"obj_type\"]').val() == '2') {
                                            square = $('#house_square input[name=\"obj_house_square\"]') . val();
                                        }
                                        if (square . length !== 0) {
                                            price =  price.replace(/\\./g, '');
                                            square =  square.replace(/\\./g, '');
                                            pricesquare = Math . round(price / square);
                                            pricesquare = (pricesquare + '');
                                            pricesquare = pricesquare . replace(/(\\d)(?=(\\d\\d\\d)+([^\\d]|$))/g, '$1\\.');
                                            $('#price_square input') . attr('value', pricesquare);
                                        }
                                    });
                           $(\"#square_general_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_general').val(my);
                                    });
                           $(\"#square_kitchen_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_kitchen').val(my);
                                    });  
                           $(\"#square_life_radio label\").click(function() {
                               var my = $(this).find('input').attr('value');
                               $('#square_life').val(my);
                                    });
                            $(\".chosen-select\").chosen();  
            });
                ";
                break;
            case "front":
                if ($static) {
                    $this->content = "
                $(document).ready(function () {
                    $(function() {
                        $('#da-slider').cslider({
                            autoplay	: true,
                            bgincrement	: 450
                        });
                    });
                    
                    $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });
                    
                });";
                } else {
                    $this->content = "
                $(document).ready(function () {
                        $('#da-slider').cslider({
                            autoplay	: true,
                            bgincrement	: 450
                    });
                    $('.slider4').bxSlider({
                            slideWidth: 200,
                            minSlides: 5,
                            maxSlides: 5,
                            moveSlides: 1,
                            slideMargin: 10,
                            pager: false
                        });
                        
                     $('#cat-kvart, #cat-house, #cat-komn').click(function(){
                        var show = $('#cat-sdelka').show(0);
                        $('#menu-cat-3 .menu-block').each(function () {
                            var show = $(this).css(\"display\");
                            if (show == \"block\") {
                                $(this).hide(0);
                            }
                        });
                    });
                    $('#cat-sdelka .elem-nav-cat').click(function(){
                         var id_target = $('#category .elem-nav-cat-active').attr('data-show');
                        $('#menu-cat-3 .menu-block').each(function () {
                            if ($(this).attr('id') == id_target) {
                                $(this).show(0);
                            } else {
                                $(this).hide(0);
                            }
                        });
            88172        });
                
                    $('.elem-nav-cat').click(function () {
                        $(this).parent().find('.elem-nav-cat-active').removeClass('elem-nav-cat-active');
                        $(this).addClass('elem-nav-cat-active');
                    });
            
            
                    $('#cat-sdelka .elem-nav-cat').click(function () {
                       var type = $('#category .elem-nav-cat-active').attr('data-type');
                        var deal = $(this).text();
                        var site_address = \"rieltor\";
                        $('#kvart-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#kvart-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Новостройка&formObj_3=&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дом&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Дача&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Коттедж&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#house-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=&typeObj_2[]=Таунхаус&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-1').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Гостиничного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-2').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коридорного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-3').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Секционного&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
                        $('#comnt-2-4').attr(\"href\", \"\\catalog?category=\"+ type +\"&city=2&deal=\"+ deal +\"&address=&search=Найти&formObj_1=Вторичка&formObj_3=Коммунальная&square_2_min=10&square_2_max=500&square_1_min=10&square_1_max=200&square_earth_min=1&square_earth_max=100&floor_min=1&floor_max=31&floorInObj_2_min=1&floorInObj_2_max=5&floorInObj_1_min=1&floorInObj_1_max=31&distance_min=0&distance_max=100&price_min=&price_max=\")
            
                    });
                        
                });";

                }
                break;
            case "catalog-filter":
                if ($static) {
                    $this->content = "
               $this->cat_script_js
               $(document).ready(function() {
               " . ($specOffer ? $this->specOffer_js : "") . "
        $( \"#cat_slider-range-floor\" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                values: [ 1, 31 ],
                slide: function( event, ui ) {

            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floor_min\").val(lastVar1);
            $(\"#cat_amount-floor_max\").val(lastVar2);
            if (lastVar1 == 31) {
                lastVar1 = \"31+\";
            }
            if (lastVar2 == 31) {
                lastVar2 = \"31+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этаж\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                resultat = \"Этаж\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этаж\";
            }
            $(\"#cat_amount-floor\").val(resultat);
            $(\"#cat_slider-range-floor .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floor .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floor\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floor\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floor_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floor_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 31) {
            lastVar1_1 = \"31+\";
        }
        if (lastVar2_1 == 31) {
            lastVar2_1 = \"31+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этаж\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
            resultat2 = \"Этаж\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этаж\";
        }
        $( \"#cat_amount-floor\" ).val(resultat2);
        $(\"#cat_slider-range-floor .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floor .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-floorInObj_1\" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                values: [ 1, 31 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floorInObj_1_min\").val(lastVar1);
            $(\"#cat_amount-floorInObj_1_max\").val(lastVar2);
            if (lastVar1 == 31) {
                lastVar1 = \"31+\";
            }
            if (lastVar2 == 31) {
                lastVar2 = \"31+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этажей\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                resultat = \"Этажей в доме\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
            }
            $(\"#cat_amount-floorInObj_1\").val(resultat);
            $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floorInObj_1\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floorInObj_1\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floorInObj_1_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floorInObj_1_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 31) {
            lastVar1_1 = \"31+\";
        }
        if (lastVar2_1 == 31) {
            lastVar2_1 = \"31+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этажей\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
            resultat2 = \"Этажей в доме\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
        }
        $( \"#cat_amount-floorInObj_1\" ).val(resultat2);
        $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2_1);


        $( \"#cat_slider-range-floorInObj_2\" ).slider({
                    range: true,
                    min: 1,
                    max: 5,
                values: [ 1, 5 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floorInObj_2_min\").val(lastVar1);
            $(\"#cat_amount-floorInObj_2_max\").val(lastVar2);
            if (lastVar1 == 5) {
                lastVar1 = \"5+\";
            }
            if (lastVar2 == 5) {
                lastVar2 = \"5+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этажей\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"5+\")) {
                resultat = \"Этажей в доме\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
            }
            $(\"#cat_amount-floorInObj_2\").val(resultat);
            $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floorInObj_2\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floorInObj_2\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floorInObj_2_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floorInObj_2_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 5) {
            lastVar1_1 = \"5+\";
        }
        if (lastVar2_1 == 5) {
            lastVar2_1 = \"5+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этажей\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"5+\")) {
            resultat2 = \"Этажей в доме\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
        }
        $( \"#cat_amount-floorInObj_2\" ).val(resultat2);
        $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_1\" ).slider({
                    range: true,
                    min: 10,
                    max: 200,
                values: [ 10, 200 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_min\" ).val(lastVar1);
            $( \"#cat_amount-square_max\" ).val(lastVar2);
            if (lastVar1 == 200) {
                lastVar1 = \"200+\";
            }
            if (lastVar2 == 200) {
                lastVar2 = \"200+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" м²\";
            } else if ( (lastVar1 == 10) && (lastVar2 == \"200+\")) {
                resultat = \"Площадь, м²\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
            }
            $( \"#cat_amount-square_1\" ).val(resultat);
            $(\"#cat_slider-range-square_1 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_1 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_1\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_1\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 200) {
            lastVar1_1 = \"200+\";
        }
        if (lastVar2_1 == 200) {
            lastVar2_1 = \"200+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" м²\";
        } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"200+\")) {
            resultat2 = \"Площадь, м²\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
        }
        $( \"#cat_amount-square_1\" ).val(resultat2);
        $(\"#cat_slider-range-square_1 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_1 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_2\" ).slider({
                    range: true,
                    min: 10,
                    max: 500,
                values: [ 10, 500 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_2_min\" ).val(lastVar1);
            $( \"#cat_amount-square_2_max\" ).val(lastVar2);
            if (lastVar1 == 500) {
                lastVar1 = \"500+\";
            }
            if (lastVar2 == 500) {
                lastVar2 = \"500+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" м²\";
            } else if ( (lastVar1 == 10) && (lastVar2 == \"500+\")) {
                resultat = \"Площадь дома, м²\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
            }
            $( \"#cat_amount-square_2\" ).val(resultat);
            $(\"#cat_slider-range-square_2 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_2 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_2\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_2\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_2_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_2_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 500) {
            lastVar1_1 = \"500+\";
        }
        if (lastVar2_1 == 500) {
            lastVar2_1 = \"500+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" м²\";
        } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"500+\")) {
            resultat2 = \"Площадь дома, м²\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
        }
        $( \"#cat_amount-square_2\" ).val(resultat2);
        $(\"#cat_slider-range-square_2 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_2 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_earth\" ).slider({
                    range: true,
                    min: 1,
                    max: 100,
                values: [ 1, 100 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_earth_min\" ).val(lastVar1);
            $( \"#cat_amount-square_earth_max\" ).val(lastVar2);
            if (lastVar1 == 100) {
                lastVar1 = \"100+\";
            }
            if (lastVar2 == 100) {
                lastVar2 = \"100+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" сот.\";
            } else if ( (lastVar1 == 1) && (lastVar2 == \"100+\")) {
                resultat = \"Площадь участка, сот.\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" сот.\";
            }
            $( \"#cat_amount-square_earth\" ).val(resultat);
            $(\"#cat_slider-range-square_earth .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_earth .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_earth\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_earth\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_earth_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_earth_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 100) {
            lastVar1_1 = \"100+\";
        }
        if (lastVar2_1 == 100) {
            lastVar2_1 = \"100+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" сот.\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"100+\")) {
            resultat2 = \"Площадь участка, сот.\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" сот.\";
        }
        $( \"#cat_amount-square_earth\" ).val(resultat2);
        $(\"#cat_slider-range-square_earth .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_earth .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-distance\" ).slider({
                    range: true,
                    min: 0,
                    max: 100,
                values: [ 0, 100 ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-distance_min\" ).val(lastVar1);
            $( \"#cat_amount-distance_max\" ).val(lastVar2);
            if (lastVar1 == 100) {
                lastVar1 = \"100+\";
            }
            if (lastVar2 == 100) {
                lastVar2 = \"100+\";
            }
            if (lastVar1 == 0 && lastVar2 == 0) {
                lastVar1 = \"В черте города\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" км.\";
            } else if ( (lastVar1 == 0) && (lastVar2 == \"100+\")) {
                resultat = \"Расстояние до города, км.\";
            } else if (lastVar1 == \"В черте города\") {
                resultat = \"В черте города\";
                lastVar1 = 0;
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" км.\";
            }
            $( \"#cat_amount-distance\" ).val(resultat);
            $(\"#cat_slider-range-distance .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-distance .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-distance\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-distance\" ).slider( \"values\", 1 );
        $( \"#cat_amount-distance_min\" ).val(lastVar1_1);
        $( \"#cat_amount-distance_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 100) {
            lastVar1_1 = \"100+\";
        }
        if (lastVar2_1 == 100) {
            lastVar2_1 = \"100+\";
        }
        if (lastVar1_1 == 0 && lastVar2_1 == 0) {
            lastVar1_1 = \"В черте города\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" км.\";
        } else if ((lastVar1_1 == 0) && (lastVar2_1 == \"100+\")) {
            resultat2 = \"Расстояние до города, км.\";
        } else if (lastVar1_1 == \"В черте города\") {
            resultat2 = \"В черте города\";
            lastVar1_1 = 0;
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" км.\";
        }
        $( \"#cat_amount-distance\" ).val(resultat2);
        $(\"#cat_slider-range-distance .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-distance .ui-slider-handle\").last().text(lastVar2_1);


        $('.cat_slide').click(function(){
            var show = $(this).attr('show');
            if(show == 1){
                $(this).attr('show', 0);
                $(this).html(\"Подробный поиск\");
                $('#dop_cat_filter').slideUp();
            }else{
                $(this).attr('show', 1);
                $(this).html(\"Свернуть\");
                $('#dop_cat_filter').slideDown();
            }
        });
        $( function() {
            $( \"#cat_rooms_search :checkbox\" ).checkboxradio({
                icon: false
            });
        });
       
    });
               ";
                } else {
                    $floor_min = $request->input("floor_min");
                    $floor_max = $request->input("floor_max");
                    $floorInObj_2_min = $request->input("floorInObj_2_min");
                    $floorInObj_2_max = $request->input("floorInObj_2_max");
                    $floorInObj_1_min = $request->input("floorInObj_1_min");
                    $floorInObj_1_max = $request->input("floorInObj_1_max");
                    $square_1_min = $request->input("square_1_min");
                    $square_1_max = $request->input("square_1_max");
                    $square_2_min = $request->input("square_2_min");
                    $square_2_max = $request->input("square_2_max");
                    $square_earth_min = $request->input("square_earth_min");
                    $square_earth_max = $request->input("square_earth_max");
                    $distance_min = $request->input("distance_min");
                    $distance_max = $request->input("distance_max");
                    $this->content = "
               $this->cat_script_js
               $(document).ready(function() {
               " . ($specOffer ? $this->specOffer_js : "") . "
        $( \"#cat_slider-range-floor\" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                values: [ $floor_min, $floor_max ],
                slide: function( event, ui ) {

            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floor_min\").val(lastVar1);
            $(\"#cat_amount-floor_max\").val(lastVar2);
            if (lastVar1 == 31) {
                lastVar1 = \"31+\";
            }
            if (lastVar2 == 31) {
                lastVar2 = \"31+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этаж\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                resultat = \"Этаж\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этаж\";
            }
            $(\"#cat_amount-floor\").val(resultat);
            $(\"#cat_slider-range-floor .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floor .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floor\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floor\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floor_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floor_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 31) {
            lastVar1_1 = \"31+\";
        }
        if (lastVar2_1 == 31) {
            lastVar2_1 = \"31+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этаж\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
            resultat2 = \"Этаж\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этаж\";
        }
        $( \"#cat_amount-floor\" ).val(resultat2);
        $(\"#cat_slider-range-floor .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floor .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-floorInObj_1\" ).slider({
                    range: true,
                    min: 1,
                    max: 31,
                values: [ $floorInObj_1_min, $floorInObj_1_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floorInObj_1_min\").val(lastVar1);
            $(\"#cat_amount-floorInObj_1_max\").val(lastVar2);
            if (lastVar1 == 31) {
                lastVar1 = \"31+\";
            }
            if (lastVar2 == 31) {
                lastVar2 = \"31+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этажей\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"31+\")) {
                resultat = \"Этажей в доме\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
            }
            $(\"#cat_amount-floorInObj_1\").val(resultat);
            $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floorInObj_1\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floorInObj_1\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floorInObj_1_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floorInObj_1_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 31) {
            lastVar1_1 = \"31+\";
        }
        if (lastVar2_1 == 31) {
            lastVar2_1 = \"31+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этажей\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"31+\")) {
            resultat2 = \"Этажей в доме\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
        }
        $( \"#cat_amount-floorInObj_1\" ).val(resultat2);
        $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floorInObj_1 .ui-slider-handle\").last().text(lastVar2_1);


        $( \"#cat_slider-range-floorInObj_2\" ).slider({
                    range: true,
                    min: 1,
                    max: 5,
                values: [ $floorInObj_2_min, $floorInObj_2_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[0];
            var lastVar2 = ui.values[1];
            $(\"#cat_amount-floorInObj_2_min\").val(lastVar1);
            $(\"#cat_amount-floorInObj_2_max\").val(lastVar2);
            if (lastVar1 == 5) {
                lastVar1 = \"5+\";
            }
            if (lastVar2 == 5) {
                lastVar2 = \"5+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" этажей\";
            } else if ((lastVar1 == 1) && (lastVar2 == \"5+\")) {
                resultat = \"Этажей в доме\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" этажей\";
            }
            $(\"#cat_amount-floorInObj_2\").val(resultat);
            $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-floorInObj_2\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-floorInObj_2\" ).slider( \"values\", 1 );
        $( \"#cat_amount-floorInObj_2_min\" ).val(lastVar1_1);
        $( \"#cat_amount-floorInObj_2_max\" ).val(lastVar2_1);

        if (lastVar1_1 == 5) {
            lastVar1_1 = \"5+\";
        }
        if (lastVar2_1 == 5) {
            lastVar2_1 = \"5+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" этажей\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"5+\")) {
            resultat2 = \"Этажей в доме\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" этажей\";
        }
        $( \"#cat_amount-floorInObj_2\" ).val(resultat2);
        $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-floorInObj_2 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_1\" ).slider({
                    range: true,
                    min: 10,
                    max: 200,
                values: [ $square_1_min, $square_1_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_min\" ).val(lastVar1);
            $( \"#cat_amount-square_max\" ).val(lastVar2);
            if (lastVar1 == 200) {
                lastVar1 = \"200+\";
            }
            if (lastVar2 == 200) {
                lastVar2 = \"200+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" м²\";
            } else if ( (lastVar1 == 10) && (lastVar2 == \"200+\")) {
                resultat = \"Площадь, м²\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
            }
            $( \"#cat_amount-square_1\" ).val(resultat);
            $(\"#cat_slider-range-square_1 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_1 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_1\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_1\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 200) {
            lastVar1_1 = \"200+\";
        }
        if (lastVar2_1 == 200) {
            lastVar2_1 = \"200+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" м²\";
        } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"200+\")) {
            resultat2 = \"Площадь, м²\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
        }
        $( \"#cat_amount-square_1\" ).val(resultat2);
        $(\"#cat_slider-range-square_1 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_1 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_2\" ).slider({
                    range: true,
                    min: 10,
                    max: 500,
                values: [ $square_2_min, $square_2_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_2_min\" ).val(lastVar1);
            $( \"#cat_amount-square_2_max\" ).val(lastVar2);
            if (lastVar1 == 500) {
                lastVar1 = \"500+\";
            }
            if (lastVar2 == 500) {
                lastVar2 = \"500+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" м²\";
            } else if ( (lastVar1 == 10) && (lastVar2 == \"500+\")) {
                resultat = \"Площадь дома, м²\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" м²\";
            }
            $( \"#cat_amount-square_2\" ).val(resultat);
            $(\"#cat_slider-range-square_2 .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_2 .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_2\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_2\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_2_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_2_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 500) {
            lastVar1_1 = \"500+\";
        }
        if (lastVar2_1 == 500) {
            lastVar2_1 = \"500+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" м²\";
        } else if ((lastVar1_1 == 10) && (lastVar2_1 == \"500+\")) {
            resultat2 = \"Площадь дома, м²\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" м²\";
        }
        $( \"#cat_amount-square_2\" ).val(resultat2);
        $(\"#cat_slider-range-square_2 .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_2 .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-square_earth\" ).slider({
                    range: true,
                    min: 1,
                    max: 100,
                values: [ $square_earth_min, $square_earth_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-square_earth_min\" ).val(lastVar1);
            $( \"#cat_amount-square_earth_max\" ).val(lastVar2);
            if (lastVar1 == 100) {
                lastVar1 = \"100+\";
            }
            if (lastVar2 == 100) {
                lastVar2 = \"100+\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" сот.\";
            } else if ( (lastVar1 == 1) && (lastVar2 == \"100+\")) {
                resultat = \"Площадь участка, сот.\";
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" сот.\";
            }
            $( \"#cat_amount-square_earth\" ).val(resultat);
            $(\"#cat_slider-range-square_earth .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-square_earth .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-square_earth\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-square_earth\" ).slider( \"values\", 1 );
        $( \"#cat_amount-square_earth_min\" ).val(lastVar1_1);
        $( \"#cat_amount-square_earth_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 100) {
            lastVar1_1 = \"100+\";
        }
        if (lastVar2_1 == 100) {
            lastVar2_1 = \"100+\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" сот.\";
        } else if ((lastVar1_1 == 1) && (lastVar2_1 == \"100+\")) {
            resultat2 = \"Площадь участка, сот.\";
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" сот.\";
        }
        $( \"#cat_amount-square_earth\" ).val(resultat2);
        $(\"#cat_slider-range-square_earth .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-square_earth .ui-slider-handle\").last().text(lastVar2_1);

        $( \"#cat_slider-range-distance\" ).slider({
                    range: true,
                    min: 0,
                    max: 100,
                values: [ $distance_min, $distance_max ],
                slide: function( event, ui ) {
            var lastVar1 = ui.values[ 0 ];
            var lastVar2 = ui.values[ 1 ];
            $( \"#cat_amount-distance_min\" ).val(lastVar1);
            $( \"#cat_amount-distance_max\" ).val(lastVar2);
            if (lastVar1 == 100) {
                lastVar1 = \"100+\";
            }
            if (lastVar2 == 100) {
                lastVar2 = \"100+\";
            }
            if (lastVar1 == 0 && lastVar2 == 0) {
                lastVar1 = \"В черте города\";
            }
            var resultat = \"\";
            if (lastVar1 == lastVar2) {
                resultat = lastVar2 + \" км.\";
            } else if ( (lastVar1 == 0) && (lastVar2 == \"100+\")) {
                resultat = \"Расстояние до города, км.\";
            } else if (lastVar1 == \"В черте города\") {
                resultat = \"В черте города\";
                lastVar1 = 0;
            } else {
                resultat = lastVar1 + \" - \" + lastVar2 + \" км.\";
            }
            $( \"#cat_amount-distance\" ).val(resultat);
            $(\"#cat_slider-range-distance .ui-slider-handle\").first().text(lastVar1);
            $(\"#cat_slider-range-distance .ui-slider-handle\").last().text(lastVar2);
        }
    });
        var lastVar1_1 = $( \"#cat_slider-range-distance\" ).slider( \"values\", 0 );
        var lastVar2_1 = $( \"#cat_slider-range-distance\" ).slider( \"values\", 1 );
        $( \"#cat_amount-distance_min\" ).val(lastVar1_1);
        $( \"#cat_amount-distance_max\" ).val(lastVar2_1);
        if (lastVar1_1 == 100) {
            lastVar1_1 = \"100+\";
        }
        if (lastVar2_1 == 100) {
            lastVar2_1 = \"100+\";
        }
        if (lastVar1_1 == 0 && lastVar2_1 == 0) {
            lastVar1_1 = \"В черте города\";
        }
        var resultat2 = \"\";
        if (lastVar1_1 == lastVar2_1) {
            resultat2 = lastVar2_1 + \" км.\";
        } else if ((lastVar1_1 == 0) && (lastVar2_1 == \"100+\")) {
            resultat2 = \"Расстояние до города, км.\";
        } else if (lastVar1_1 == \"В черте города\") {
            resultat2 = \"В черте города\";
            lastVar1_1 = 0;
        } else {
            resultat2 = lastVar1_1 + \" - \" + lastVar2_1 + \" км.\";
        }
        $( \"#cat_amount-distance\" ).val(resultat2);
        $(\"#cat_slider-range-distance .ui-slider-handle\").first().text(lastVar1_1);
        $(\"#cat_slider-range-distance .ui-slider-handle\").last().text(lastVar2_1);
        
        var myChoise = $ ('#cat_city :selected').val();
                            if (myChoise == 1) {
                                $('#cat_amount-area_1').show();
                                $('#cat_amount-area_2').hide();
                            } else if (myChoise == 2) {
                                $('#cat_amount-area_1').hide();
                                $('#cat_amount-area_2').show();
                            } else {
                                $('#cat_amount-area_1').hide();
                                $('#cat_amount-area_2').hide();
                            }
        
        var myChoise = $ ('#cat_type :selected').val();
                            if (myChoise == 2) {
                                $('#cat_formObj_3').hide();
                                $('#cat_amount-floor').hide();
                                $('#cat_amount-typeHouse_1').hide();
                                $('#cat_amount-floorInObj_1').hide();
                                $('#cat_formObj_1').hide();
                                $('#cat_typeHouse_1').hide();
                                $('#cat_amount-rooms').hide();
                                $('#cat_amount-formObj_2').show();
                                $('#cat_amount-typeHouse_2').show();
                                $('#cat_amount-square_earth').show();
                                $('#cat_amount-floorInObj_2').show();
                                $('#cat_typeHouse_2').show();
                                $('#cat_amount-square_2').show();
                                $('#cat_amount-distance').show();
                                $('#cat_amount-square_1').hide();
                            } else if (myChoise == 3){
                               $('#cat_amount-typeHouse_2').hide();
                                $('#cat_amount-floorInObj_1').show();
                                $('#cat_formObj_3').show();
                                $('#cat_amount-floor').show();
                                $('#cat_amount-typeHouse_1').show();
                                $('#cat_formObj_1').hide();
                                $('#cat_typeHouse_1').show();
                                $('#cat_amount-rooms').show();
                                $('#cat_amount-formObj_2').hide();
                                $('#cat_amount-square_earth').hide();
                                $('#cat_amount-floorInObj_2').hide();
                                $('#cat_typeHouse_2').hide();
                                $('#cat_amount-square_2').hide();
                                $('#cat_amount-distance').hide();
                                $('#cat_amount-square_1').show();
                            } else {
                                $('#cat_amount-typeHouse_2').hide();
                                $('#cat_amount-typeHouse_1').show();
                                $('#cat_formObj_3').hide();
                                $('#cat_amount-floor').show();
                                $('#cat_amount-floorInObj_1').show();
                                $('#cat_formObj_1').show();
                                $('#cat_typeHouse_1').show();
                                $('#cat_amount-rooms').show();
                                $('#cat_amount-formObj_2').hide();
                                $('#cat_amount-square_earth').hide();
                                $('#cat_amount-floorInObj_2').hide();
                                $('#cat_typeHouse_2').hide();
                                $('#cat_amount-square_2').hide();
                                $('#cat_amount-distance').hide();
                                $('#cat_amount-square_1').show();
                            }                                         

        $('.cat_slide').click(function(){
            var show = $(this).attr('show');
            if(show == 1){
                $(this).attr('show', 0);
                $(this).html(\"Подробный поиск\");
                $('#dop_cat_filter').slideUp();
            }else{
                $(this).attr('show', 1);
                $(this).html(\"Свернуть\");
                $('#dop_cat_filter').slideDown();
            }
        });
        $( function() {
            $( \"#cat_rooms_search :checkbox\" ).checkboxradio({
                icon: false
            });
        });
       
    });
               ";
                }
                break;
            case "post-create":
                $this->content = "
                    $(document).ready(function() {
                        CKEDITOR.replace('text');
                        $('#on_main').on(
                            'change',
                            function () {
                                var
                                    active = 'hide',
                                    obj = $('#on_main_image');
                                if ($('#on_main').is(\":checked\")) active = 'show';
                                obj[active]();
                            }
                        );
                    });
                ";
                break;
            case "parse-avito":
                $this->content = "
                    // Example using HTTP POST operation

\"use strict\";


//Тут объявляю несколько юзерагентов, типа мы под разными браузерами заходим постоянно
var useragent = [];
useragent.push('Opera/9.80 (X11; Linux x86_64; U; fr) Presto/2.9.168 Version/11.50');
useragent.push('Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25');
useragent.push('Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02');

//Здесь находится страничка, которую нужно спарсить
var parseUrl = '".$request."';
var jobs_list = [];
var page = require('webpage').create();

// Это я передаю заголовки
// Их можно посмотреть в браузере на закладке Network (тыкайте сами, ищите сами)
page.customHeaders = {
    \":host\": \"m.avito.ru\",
    \":method\": \"GET\",
    \":path\": \"/\",
    \":scheme\": \"https\",
    \":version\": \"HTTP/1.1\",
    \"accept\": \"text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\",
    \"accept-language\": \"ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4\",
    \"cache-control\": \"max-age=0\",
    \"upgrade-insecure-requests\": \"1\",
    \"user-agent\": useragent[Math.floor(Math.random() * useragent.length)]
};

//// Здесь я отключаю загрузку сторонних скриптов для ускореняи парсинга
page.onResourceRequested = function (requestData, request) {
    if ((/http:\/\/.+?\.css$/gi).test(requestData['url'])) {
        request.abort();
    }
    if (
        (/\.doubleclick\./gi.test(requestData['url'])) ||
        (/\.pubmatic\.com$/gi.test(requestData['url'])) ||
        (/yandex/gi.test(requestData['url'])) ||
        (/google/gi.test(requestData['url'])) ||
        (/gstatic/gi.test(requestData['url']))
    ) {
        request.abort();
        return;
    }
};


//Этот код выводит ошибки, дебаг так сказать
page.onError = function (msg, trace) {
    console.log(msg);
    trace.forEach(function (item) {
//        console.log('  ', item.file, ':', item.line);
    });
};

String.prototype.stripTags = function() {
    return this.replace(/<\/?[^>]+>/g, '');
};

function mouseclick( element ) {
    // create a mouse click event
    var event = document.createEvent( 'MouseEvents' );
    event.initMouseEvent( 'click', true, true, window, 1, 0, 0 );
    // send click to element
    element.dispatchEvent( event );
}

// final function called, output screenshot, exit
//noinspection JSAnnotator
function after_clicked( page, job ) {
            job.title_obj = page.evaluate(function() {
                return [].map.call(document.querySelectorAll('.semantic-text'), function (span) {
                    return span.innerText;
                });
            });
            job.desc = page.evaluate(function() {
                return document.querySelector('.description-preview-wrapper').innerText;
            });
            job.id = page.evaluate(function() {
                return document.querySelector('.item-id').innerText;
            });
            job.contact_name = page.evaluate(function() {
                var name = document.querySelector('.person-contact-name');
                if (name !== null) {
                    return name.innerText;
                } else {
                    return \"none\";
                }
            });
            job.person_name = page.evaluate(function() {
                var name = document.querySelector('.person-name');
                if (name !== null) {
                    return name.innerText;
                } else {
                    return \"none\";
                }
            });
            job.date = page.evaluate(function() {
                return document.querySelector('.item-add-date').innerText;
            });
            job.city = page.evaluate(function() {
                return document.querySelector('.avito-address-text').innerText;
            });
            job.category = page.evaluate(function() {
                return document.querySelector('.param-last').innerText;
            });
            job.address = page.evaluate(function() {
                return document.querySelector('.user-address-text').innerText;
            });
            job.phone = page.evaluate(function () {
                return document.querySelector('.action-show-number span').innerText;
            });
            job.price = page.evaluate(function () {
                return document.querySelector('.price-value').innerText;
            });
            console.log(JSON.stringify(job));
           

            return true;
}

// middle function, click on desired tab
//noinspection JSAnnotator
function click_div( page, job ) {
    var clicked = page.evaluate(
        function ( mouseclick_fn ) {
            // want the div with class \"submenu\"
            var element = document.querySelector( \"a.action-show-number\" );
            if ( ! element ) {
                return false;
            }
            // click on this inner div
            mouseclick_fn( element );
            return true;
        }, mouseclick
    );

    if ( ! clicked ) {
        console.log( job.url);
        console.log( \"Failed to find desired element\" );
        phantom.exit( 1 );
        return;
    } else {
        window.setTimeout(
            function () {
                return after_clicked( page, job );
            },
            1500);
        }
}

function next_page(i, page, list) {
    if (i <= (list.length - 1)) {
        var current_job = list[i];
        var url = current_job.url;
        page.open(\"https://m.avito.ru\" + url, function (status) {
            if (status !== 'success') {
                console.log('Unable to access network');
            } else {
                window.setTimeout(function () {
                        click_div( page, current_job );
                    },
                    500
                );
                window.setTimeout(function () {
                    next_page(++i, page, list);
                }, 3000);
            }
        });
    } else {
        phantom.exit();
    }
}


function doit(page, link, list_jobs, pagenumber) {
   //console.log( link );
    page.open(link, function (status) {
        if (status !== 'success') {
            console.log('Unable to access network');
        } else {           
            var list = page.evaluate(function () {
                var job;
                var jobs = [];
                var objs = document.querySelectorAll('article.b-item:not(.item-vip)');
                    for (var i = 0; i < objs.length; i++) {
                        var id_ = objs[i].getAttribute('data-item-id');
                        var title = objs[i].querySelector('h3');
                        var url = objs[i].querySelector('a');
                        job = {title: title.innerText, url: url.getAttribute('href'), id: id_};
                        jobs.push(job);
                    }
                return jobs;
            });
//             for (var f = 0; f < list.length; f++) {
//                 console.log(JSON.stringify(list[f]));
//             }
            var arre = list_jobs.concat(list);
            var allpages = page.evaluate(function () {
                var inner = document.querySelector('.nav-helper-content.nav-helper-text');
                if (inner != null) {
                    return inner.innerText;
                } else {
                    return 1;
                }                
            });
            var maxpages = (Math.ceil(allpages / 20)) + 1;
            if (pagenumber < maxpages) {
                pagenumber++;
                var href = parseUrl + \"&p=\" + pagenumber;
//                console.log(href);
                window.setTimeout(function () {
                    doit(page, href, arre, pagenumber);
                }, 2000);              
            } else {
                for (var f = 0; f < arre.length; f++) {
                    console.log(JSON.stringify(arre[f]));
                }
                phantom.exit( 1 );
            }
        }
    });
}

doit(page, parseUrl, jobs_list, 1);
                ";
                $this->storageJs($randStr, true);
                return;
                break;
                case "parse-avito-page":
                $this->content = "
                // Example using HTTP POST operation

\"use strict\";


//Тут объявляю несколько юзерагентов, типа мы под разными браузерами заходим постоянно
var useragent = [];
useragent.push('Opera/9.80 (X11; Linux x86_64; U; fr) Presto/2.9.168 Version/11.50');
useragent.push('Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25');
useragent.push('Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02');

//Здесь находится страничка, которую нужно спарсить
var parseUrl = '".$request[1]."';
var title = '".$request[0]."';
var job = {title: title, url: parseUrl, phone: \"\", address: \"\", city: \"\", price: \"\", category: \"\", title_obj: \"\", contact_name: \"\", desc : \"\", person_name : \"\", id : \"\", date: \"\", material_h: \"\", material_k: \"\", material_c: \"\", floor_in: \"\", distance: \"\", deal: \"\", geo: \"none\"};                               
var jobs_list = [];
var debug = false;
var click_count = 0;
var arr_debug = [];
var click = false;
var page = require('webpage').create();

// Это я передаю заголовки
// Их можно посмотреть в браузере на закладке Network (тыкайте сами, ищите сами)
page.customHeaders = {
    \":host\": \"m.avito.ru\",
    \":method\": \"GET\",
    \":path\": \"/\",
    \":scheme\": \"https\",
    \":version\": \"HTTP/1.1\",
    \"accept\": \"text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\",
    \"accept-language\": \"ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4\",
    \"cache-control\": \"max-age=0\",
    \"upgrade-insecure-requests\": \"1\",
    \"user-agent\": useragent[Math.floor(Math.random() * useragent.length)]
};

// Здесь я отключаю загрузку сторонних скриптов для ускореняи парсинга
page.onResourceRequested = function (requestData, request) {
    if ((/http:\/\/.+?\.css$/gi).test(requestData['url'])) {
        request.abort();
    }
    if (
        (/\.doubleclick\./gi.test(requestData['url'])) ||
        (/\.pubmatic\.com$/gi.test(requestData['url'])) ||
        (/yandex/gi.test(requestData['url'])) ||
        (/google/gi.test(requestData['url'])) ||
        (/gstatic/gi.test(requestData['url']))
    ) {
        request.abort();
        return;
    }
};


//Этот код выводит ошибки, дебаг так сказать
page.onError = function (msg, trace) {
    console.log(msg);
    trace.forEach(function (item) {
        console.log('  ', item.file, ':', item.line);
    });
};

String.prototype.stripTags = function() {
    return this.replace(/<\/?[^>]+>/g, '');
};

function mouseclick( element ) {
    // create a mouse click event
    var event = document.createEvent( 'MouseEvents' );
    event.initMouseEvent( 'click', true, true, window, 1, 0, 0 );
    // send click to element
    element.dispatchEvent( event );
}

// final function called, output screenshot, exit
//noinspection JSAnnotator
function after_clicked( page, job ) {
        if (debug) {  
           arr_debug.push((new Date().getTime() - arr_debug[0]) + \" late ms. this after\");  
        }
            job.title_obj = page.evaluate(function() {
                return document.querySelector('[data-marker=\"item-description/title\"]').innerText;
            });
            job.desc = page.evaluate(function() {
                return document.querySelector('._1jdV1').innerText;
            });
            job.id = page.evaluate(function() {
                return document.querySelector('[data-marker=\"item-stats/timestamp\"]').innerText;
            });
//            job.geo = page.evaluate(function() {
//                var div_geo = document.querySelector('#item-map');
//                if (div_geo !== null) {
//                    var attr_1 = div_geo.getAttribute('data-coords-lat');
//                    var attr_2 = div_geo.getAttribute('data-coords-lng');
//                    return attr_1 + \",\" + attr_2;
//                } else {
//                    return \"none\";
//                }
//            });
            job.contact_name = page.evaluate(function() {
                var name = document.querySelector('[data-marker=\"seller-info/name\"]');
                if (name !== null) {
                    return name.innerText;
                } else {
                    return \"none\";
                }
            });
            job.person_name = page.evaluate(function() {
                var name = document.querySelector('[data-marker=\"seller-info/name\"]');
                if (name !== null) {
                    return name.innerText;
                } else {
                    return \"none\";
                }
            });
            job.date = page.evaluate(function() {
                return document.querySelector('[data-marker=\"item-stats/timestamp\"] span').innerText;
            });
            job.category = page.evaluate(function() {
                return document.querySelector('[data-marker=\"item-properties-item(0)/description\"]').innerText;
            });
            job.address = page.evaluate(function() {
                return document.querySelector('[data-marker=\"delivery/location\"]').innerText;
            });
            job.phone = page.evaluate(function () {
                return document.querySelector( '[data-marker=\"item-contact-bar/call\"]' ).getAttribute('href'); 
            });
            job.price = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-description/price\"]').innerText;
            });
            job.material_h = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(3)/description\"]').innerText;
            });
            job.material_c = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(3)/description\"]').innerText;
            });
            job.material_k = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(4)/description\"]').innerText;
            });
            job.floor_in = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(5)/description\"]').innerText;
            });
            job.distance = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(2)/description\"]').innerText;
            });
            job.deal = page.evaluate(function () {
                return document.querySelector('[data-marker=\"item-properties-item(1)/description\"]').innerText;
            });
            console.log(JSON.stringify(job));
            if (debug) {
              for (var f = 0; f < arr_debug.length; f++) {
                    console.log(JSON.stringify(arr_debug[f]));
                }
            }
            phantom.exit( 1 );
}

function checkClick (page) {
    if(debug) {
       arr_debug.push((new Date().getTime() - arr_debug[0]) + \" late ms. this check click\");
    }
    click_count++;
     if (!click || click_count > 4) {
            var clicked = page.evaluate(
        function ( mouseclick_fn ) {
            // want the div with class \"submenu\"
            var element = document.querySelector( \"[data-marker = item-contact-bar/call]\" );
            if ( ! element ) {
                return false;
            }
            // click on this inner div
            mouseclick_fn( element );
            return true;
        }, mouseclick
    );
    click = clicked;
     }
    if ( ! click ) {
        console.log( job.url);
        console.log( \"Failed to find desired element\" );
        phantom.exit( 1 );
        return;
        } else {
            var result =  page.evaluate(function() {
                var txt = document.querySelector( \"a.action-show-number .js-phone-number\" ).innerText;               
                if (!txt.indexOf('XX-XX') + 1) {
                    return true;
                } else {
                    return false;
                }
            });
            return result;
    }
}

// middle function, click on desired tab
//noinspection JSAnnotator
function click_div( page, job ) {
        if (debug) {  
           arr_debug.push((new Date().getTime() - arr_debug[0]) + \" late ms. this div click\");  
        }
        waitFor(  function () {
                    return checkClick( page);
                },
                function () {
                    after_clicked( page, job );
                }, 7000);
}


function next_page(page, job) {
        if (debug) {
            arr_debug.push(new Date().getTime());  
           arr_debug.push(new Date().getTime() + \" start parse ms.\");  
        }
       page.open(\"https://m.avito.ru\" + job.url, function (status) {
            if (status !== 'success') {
                console.log('Unable to access network');
            } else {
               after_clicked( page, job );
            }
        });
}


function doit(page, link, list_jobs) {
    // console.log( link );
    page.open(link, function (status) {
        if (status !== 'success') {
            console.log('Unable to access network');
        } else {
            var list = page.evaluate(function () {
                var job;
                var jobs = [];
                var objs = document.querySelectorAll('article.b-item');
                    for (var i = 0; i < objs.length; i++) {
                        var title = objs[i].querySelector('h3');
                        var url = objs[i].querySelector('a');
                        job = {title: title.innerText, url: url.getAttribute('href'), phone: \"\", address: \"\", city: \"\", price: \"\", category: \"\", title_obj: \"\", contact_name: \"\", desc : \"\", person_name : \"\", id : \"\", date : \"\", geo : \"\"};
                        jobs.push(job);
                    }
                return jobs;
            });
            // for (var f = 0; f < list.length; f++) {
            //     console.log(JSON.stringify(list[f]));
            // }
            // console.log(\"\");
            var arre = list_jobs.concat(list);
            var next = page.evaluate(function () {
                return document.querySelector(\".page-next a\");
            });
            if (next !== \"\") {
                var href = page.evaluate(function () {
                    var next = document.querySelector(\".page-next a\");
                    return next.getAttribute('href');
                });
                href = \"https://m.avito.ru\" + href;
                window.setTimeout(
                    function () {
                        doit(page, href, arre);
                    },
                    1000
                );
            } else {
                var i = 0;
                window.setTimeout(function () {
                    next_page(i, page, arre);
                }, 3000);
            }
        }
    });
}

function waitFor(testFx, onReady, timeOutMillis) {
    var maxtimeOutMillis = timeOutMillis ? timeOutMillis : 3000, //< Default Max Timout is 3s
        start = new Date().getTime(),
        condition = false,
        interval = setInterval(function() {
            if ( (new Date().getTime() - start < maxtimeOutMillis) && !condition ) {
                // If not time-out yet and condition not yet fulfilled
                condition = (typeof(testFx) === \"string\" ? eval(testFx) : testFx()); //< defensive code
            } else {
                if(!condition) {
                    // If condition still not fulfilled (timeout but condition is 'false')
                    //console.log(\"'waitFor()' timeout\");
                    phantom.exit(1);
                } else {
                    // Condition fulfilled (timeout and/or condition is 'true')
                    //console.log(\"'waitFor()' finished in \" + (new Date().getTime() - start) + \"ms.\");
                    typeof(onReady) === \"string\" ? eval(onReady) : onReady(); //< Do what it's supposed to do once the condition is fulfilled
                    clearInterval(interval); //< Stop this interval
                }
            }
        }, 1500); //< repeat check every 250ms
};


next_page(page, job);
                ";
                $this->storageJs($randStr, true);
                return;
                break;
            case "favor-page":
                $this->content = "
                        $('form.favor').submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serializeArray();
            var i = $(this).find('i');
            if(i.hasClass(\"fa-star-o\")) {
                $.ajax({
                type: \"POST\",
                url: url,
                data: data,
                success: addFav
                });
            } else {
                $.ajax({
                type: \"POST\",
                url: url,
                data: data,
                success: delFav
                });
            }        
            });
            
        function addFav (data) {
                $('#favor-'+data.id).removeClass(\"fa-star-o\").addClass(\"fa-star\");
                var count = $('.fav-count').text();
                $('.fav-count').text(+ count + 1);            
            }
        
        function delFav (data) {
            $('#favor-'+data.id).removeClass(\"fa-star\").addClass(\"fa-star-o\");
            var count = $('.fav-count').text();
            $('.fav-count').text(count - 1);    
        }
                ";
                $this->storageJs($randStr, true);
                break;
            default:
                break;
        }
        $this->storageJs($randStr);
    }

    private function getEditScript($object)
    {
        $geo = explode(',', $object->geo);
        if ($object->geo == "none") {
            $geo = ["48.7979", "44.7462"];
        }
        $text = "
            marker = new H.map.Marker({lat:". $geo[0] .", lng:". $geo[1] ."});
            marker.label = '" . $object->address . "';
            map.addObject(marker);
            map.setCenter({lat:". $geo[0] .", lng:". $geo[1] ."});         

            var myChoise = $('#obj_city select').val();
            $('#obj_city select option').each(function () {
                    var myChoise2 = $(this).val();
                    if (myChoise2 == myChoise) {
                        $('#obj_area'+myChoise).show();
                    } else {
                        $('#obj_area'+myChoise2).hide();
                    }
                });
                    ";

        return $text;
    }

    private function getEditComforts($object)
    {
        if (isset($object->comforts)) {
        $comforts_id = array();
        if (!$object->comforts->isEmpty()) {
            foreach ($object->comforts as $comfort) {
                $comforts_id[] = $comfort->title;
            }
        }
        return implode("','", $comforts_id);
        }
    }

    private function storageJs($str, $phm = false)
    {
        if ($phm) {
            Storage::disk('phantom')->put('avito.js', $this->content);
        } else {
            Storage::disk('js')->put('script-' . $str . '.js', $this->content);
        }
    }


}