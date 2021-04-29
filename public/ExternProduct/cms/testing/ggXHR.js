var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
var result={};
var XMLReq = new XMLHttpRequest();

function GetData(){
 XMLReq.open( "GET", "https://iss.shopimind.com/procedural_api/pages_views.php", false )
 XMLReq.onreadystatechange = function() {
    if(XMLReq.readyState == 4 && XMLReq.status == 200) { 
  //  result = JSON.parse(XMLReq.responseText);   
    console.log( XMLReq.responseText);   
    }
  }
  XMLReq.send(); 
}
//function updateData(json){
//json.item_count =2;
// open request
//XMLReq.open('POST', 'https://partakefoods.com/cart/update.js');

// set `Content-Type` header
//XMLReq.setRequestHeader('Content-Type', 'application/json');

// send rquest with JSON payload
//XMLReq.send(JSON.stringify(json));
//console.log(result)
//}

//console.log("/////////////// CArt DAta before /////////");
GetData()
//console.log(result);

//updateData(result);

//console.log("/////////////// CArt DAta after/////////");
//GetData()
//console.log(result);



