// Example using HTTP POST operation

"use strict";


//Тут объявляю несколько юзерагентов, типа мы под разными браузерами заходим постоянно
var useragent = [];
useragent.push('Opera/9.80 (X11; Linux x86_64; U; fr) Presto/2.9.168 Version/11.50');
useragent.push('Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25');
useragent.push('Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02');

//Здесь находится страничка, которую нужно спарсить
var parseUrl = 'https://m.avito.ru/volgogradskaya_oblast_volzhskiy/kvartiry/prodam/novostroyka?user=1&f=496_5120b5124';
var jobs_list = [];
var page = require('webpage').create();

// Это я передаю заголовки
// Их можно посмотреть в браузере на закладке Network (тыкайте сами, ищите сами)
page.customHeaders = {
    ":host": "m.avito.ru",
    ":method": "GET",
    ":path": "/",
    ":scheme": "https",
    ":version": "HTTP/1.1",
    "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "accept-language": "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
    "cache-control": "max-age=0",
    "upgrade-insecure-requests": "1",
    "user-agent": useragent[Math.floor(Math.random() * useragent.length)]
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
                    return "none";
                }
            });
            job.person_name = page.evaluate(function() {
                var name = document.querySelector('.person-name');
                if (name !== null) {
                    return name.innerText;
                } else {
                    return "none";
                }
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
}

// middle function, click on desired tab
//noinspection JSAnnotator
function click_div( page, job ) {
    var clicked = page.evaluate(
        function ( mouseclick_fn ) {
            // want the div with class "submenu"
            var element = document.querySelector( "a.action-show-number" );
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
        console.log( "Failed to find desired element" );
        phantom.exit( 1 );
        return;
    }
    window.setTimeout(
        function () {
            after_clicked( page, job );
        },
        1500
    );
}

function next_page(i, page, list) {
    if (i <= (list.length - 1)) {
        var current_job = list[i];
        var url = current_job.url;
        page.open("https://m.avito.ru" + url, function (status) {
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
                        job = {title: title.innerText, url: url.getAttribute('href'), phone: "", address: "", city: "", price: "", category: "", title_obj: "", contact_name: "", desc : "", person_name : "", id : ""};
                        jobs.push(job);
                    }
                return jobs;
            });
            // for (var f = 0; f < list.length; f++) {
            //     console.log(JSON.stringify(list[f]));
            // }
            // console.log("");
            var arre = list_jobs.concat(list);
            var next = page.evaluate(function () {
                return document.querySelector(".page-next a");
            });
            if (next !== "") {
                var href = page.evaluate(function () {
                    var next = document.querySelector(".page-next a");
                    return next.getAttribute('href');
                });
                href = "https://m.avito.ru" + href;
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
                }, 2000);
            }
        }
    });
}

doit(page, parseUrl, jobs_list);



