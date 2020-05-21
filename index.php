<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
<link rel="stylesheet" href="style.css"> 
</head>
<body>

<div id = "vendors-div">

  <form name ="vendors">
  <lable>Get all vendors: </lable>
  <input type="button" onclick = "getVendors()" value="ОК">
  </form> 
  <table style="border: 1px solid"><tr><th> Film </th></tr>
  <tbody id = "Vendors-table"></tbody>
  </table>
  <table style="border: 1px solid"><tr><th> Last request </th></tr>
  <tbody id = "VendorsRecent-table"></tbody>
  </table>
</div>


<div id ="price-range-div">

  <form name ="price">
    <lable>Get items by price range: </lable>
  <?php 
  $priceArr = range(0, 1000);

  echo "<select id= 'startPrice'><option> Начальная цена </option>";

  foreach ($priceArr as $price) {
    echo '<option '.$price.' value="'.$price.'">'.$price.'</option>';
  }
    echo "</select>";

  echo "<select id='finalPrice'><option> Конечная цена </option>";

    foreach ($priceArr as $price) {
        echo '<option '.$price.' value="'.$price.'">'.$price.'</option>';
    }
    echo "</select>";
  ?>
    <input type="button" onclick = "getItemsByPrice()" value="ОК">
</form> 


<table style="border: 1px solid"><tr><th> Items </th></tr>
  <tbody id = "Price-table"></tbody>
  </table>
  <table style="border: 1px solid"><tr><th> Last request </th></tr>
  <tbody id = "PriceRecent-table"></tbody>
  </table>

</div>

<div id = "unexisted-items-div">

<form name ="unexisted">
    <lable>Get unexisted items: </lable>
    <input type="button" onclick = "getUnexisted()" value="ОК">
</form> 

<table style="border: 1px solid"><tr><th> Items </th></tr>
<tbody id = "Unexisted-table"></tbody>
</table>

<table style="border: 1px solid"><tr><th> Last request </th></tr>
<tbody id = "unexistedResent-table"></tbody>
</table>

</div>


<script>
const ajax = new XMLHttpRequest();

function getVendors(){

    ajax.onreadystatechange = updateVendors;
    ajax.open("GET", "getAllVendors.php");
    ajax.send(null);
}

  function updateVendors(){
    if(ajax.readyState === 4){
      if(ajax.status === 200){
        let text = document.getElementById('Vendors-table');
        let res = ajax.responseText;
        let resHtml ="";
        let newReq = [];
    
        let lastReqHtml ="";
        let lastReq = JSON.parse(localStorage.getItem("vendors"));

        res = JSON.parse(res);
        res.forEach(vendor =>{
         resHtml += "<tr><td style = 'border: 1px solid'>" + vendor +"</td></tr>";
         newReq.push(vendor);
        });

      if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("VendorsRecent-table").innerHTML = lastReqHtml;
      }else{
        lastReq.forEach(vendor =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + vendor +"</td></tr>";
      });
        document.getElementById("VendorsRecent-table").innerHTML = lastReqHtml;
    }   
      localStorage.setItem("vendors", JSON.stringify(newReq)); 
      text.innerHTML = resHtml;
      }
    }
  }

function getItemsByPrice(){
let startPrice = document.getElementById("startPrice").value;
let finalPrice = document.getElementById("finalPrice").value;

ajax.onreadystatechange = updateItems;
ajax.open("GET", "getItemsByPriceRange.php?startPrice="+ startPrice +"&finalPrice=" + finalPrice);
ajax.send(null);
}

function updateItems(){
if(ajax.readyState === 4){
  if(ajax.status === 200){
    let text = document.getElementById('Price-table');
    let res = ajax.responseText;
    let resHtml ="";
    let newReq = [];
    
    let lastReqHtml ="";
    let lastReq = JSON.parse(localStorage.getItem("priceItems"));
    
    res = JSON.parse(res);
    res.forEach(item =>{
    resHtml += "<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
    newReq.push(item);
    });
    
    if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("PriceRecent-table").innerHTML = lastReqHtml;
    }else{
        lastReq.forEach(item =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
     });
        document.getElementById("PriceRecent-table").innerHTML = lastReqHtml;
    }    
    localStorage.setItem("priceItems", JSON.stringify(newReq)); 
    text.innerHTML = resHtml;
  }
}
}

function getUnexisted(){

ajax.onreadystatechange = updateUnexisted;
ajax.open("GET", "getUnexistedItems.php");
ajax.send(null);
}

function updateUnexisted(){
if(ajax.readyState === 4){
  if(ajax.status === 200){
    let text = document.getElementById('Unexisted-table');
    let res = ajax.responseText;
    let newReq = [];
    let lastReqHtml ="";
    let lastReq = JSON.parse(localStorage.getItem("unexistedItems"));
    let resHtml ="";

    res = JSON.parse(res);
    
    res.forEach(item =>{
     resHtml += "<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
     newReq.push(item);
    });

    if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("unexistedResent-table").innerHTML = lastReqHtml;
    }else{
        lastReq.forEach(item =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
     });
        document.getElementById("unexistedResent-table").innerHTML = lastReqHtml;
    }    

  localStorage.setItem("unexistedItems", JSON.stringify(newReq));
  text.innerHTML = resHtml;
  }
}
}
</script>
</body>
</html>
