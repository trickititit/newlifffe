// Example using HTTP POST operation

"use strict";

//Тут объявляю несколько юзерагентов, типа мы под разными браузерами заходим постоянно
var useragent = [];
useragent.push('Opera/9.80 (X11; Linux x86_64; U; fr) Presto/2.9.168 Version/11.50');
useragent.push('Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25');
useragent.push('Opera/12.02 (Android 4.1; Linux; Opera Mobi/ADR-1111101157; U; en-US) Presto/2.9.201 Version/12.02');

//Здесь находится страничка, которую нужно спарсить
var siteUrl = 'https://m.avito.ru/komsomolsk-na-amure/kvartiry/1-k_kvartira_29_m_45_et._665423964';
var page = require('webpage').create();

//Это я передаю заголовки
//Их можно посмотреть в браузере на закладке Network (тыкайте сами, ищите сами)
page.customHeaders = {
    ":host": "m.avito.ru",
    ":method": "GET",
    ":path": "/volgogradskaya_oblast_volzhskiy/kvartiry/prodam?user=1&f=549_5695-5696-5697-5698-5699-5700-11018-11019-11020-11021",
    ":scheme": "https",
    ":version": "HTTP/1.1",
    "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "accept-language": "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
    "cache-control": "max-age=0",
    "upgrade-insecure-requests": "1",
    "user-agent": useragent[Math.floor(Math.random() * useragent.length)]
};

//Здесь я отключаю загрузку сторонних скриптов для ускореняи парсинга
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

//Объявим переменные для инф-и об объекте
var href, json, price, adress, fio, descriptionShort, descriptionFull;

//Здесь мы открываем страничку
page.open(siteUrl, function (status) {
    if (status !== 'success') {
        console.log('Unable to access network');
    } else {
        //Получим ценник квартирки
        var price = page.evaluate(function () {
            return [].map.call(document.querySelectorAll('.price-value'), function (span) {
                return span.innerText;
            });
        });
        //Выведем
        console.log(price);
    }
});