window.onload = function(){
  

  console.log('curentCart: '+getCookie('cart'));

  //ajax LOGIN
  document.querySelector("#login-button").onclick=function(event){
    event.preventDefault();
    let modalLogin=document.querySelector('#userlogin-modal');
    let modalPassword=document.querySelector('#password-modal');
    let params={
      "function": 'login',
      "login": modalLogin.value,
      "password": modalPassword.value,
    }
    ajax(params);
  }

  //ajax ADD to cart
  // let addCartButtons=document.querySelectorAll('.product .buttons a[href*="cart/?add"], #addToCart'); 
  // for(i=0; i<addCartButtons.length; i++){
  //   addCartButtons[i].addEventListener('click', cartAddClick);
  // }

  let productsBlock=document.querySelector('div.row.products');
  productsBlock.onclick=function(event){
    const target=event.target;
    if (target.tagName=='A' ) {
      if(target.className.indexOf('btn btn-primary')!=-1) {
        event.preventDefault();
        cartAddClick(event); 
      }
    }  
  }

function cartAddClick(event){
  var e = event.target;
  let str='';
  str=e.toString();
  if (~str.indexOf("?add=")) {
    var productId=str.substring(str.indexOf("=")+1);
  }
  if (productId==null) {
    str=e.parentNode.toString();
    if (~str.indexOf("?add=")) {
      var productId=str.substring(str.indexOf("=")+1);
    }
  }

  let params={
    "function": 'cartAdd',
    "productId": productId
  }
  ajax(params);
}


  //DELETE from cart
  let deleteCartButtons=document.querySelectorAll('td a[href*="cart/?delete"]'); 
  for(i=0; i<deleteCartButtons.length; i++){
    deleteCartButtons[i].addEventListener('click', cartDeleteClick);
  }

function cartDeleteClick(event){
  event.preventDefault();
  var e = event.target;
  let str='';
  str=e.toString();
  var activeCell=e.parentNode;
  if (~str.indexOf("?delete=")) {
    var productId=str.substring(str.indexOf("=")+1);
  }
  if (productId==null) {
    str=e.parentNode.toString();
    if (~str.indexOf("?delete=")) {
      var productId=str.substring(str.indexOf("=")+1);
       activeCell=e.parentNode.parentNode;
    }
  }
  
  let activeRow=activeCell.parentNode;
  
  let productCart=JSON.parse(getCookie('cart'));
  delete productCart[productId];
  setCookie('cart', JSON.stringify(productCart), {'expires':24 * 60 * 60 *1000, 'path':'/'});
  
  cartRecalc(activeRow, 'delete');
  activeRow.remove();
  // ajax(params);
}

// Recalc cart after input change 
let cartInputsElements=document.querySelectorAll('td input[type="number"]'); 
  for(i=0; i<cartInputsElements.length; i++){
    let inputValue;
    cartInputsElements[i].addEventListener('focus', function(event){
      inputValue=event.target.value;
    })
    cartInputsElements[i].addEventListener('blur', function(event){
      if (inputValue!=event.target.value) {
        var e = event.target; 
        let activeRow=e.parentNode.parentNode;
        if (event.target.value<=0){ event.target.value=1;}
          else {cartRecalc(activeRow,'change');}
      }
    },true);
  } 


//Filter products
let kitchens=document.querySelectorAll('#kitchenFilter input[type="checkbox"]');
let curentCategory=(~document.location.toString().indexOf('?category='))?document.location.toString().substring(document.location.toString().indexOf('=')+1):'undefined';
let checkedKitchens=new Set();
let categoryMessage='all';
for (let i = 0; i < kitchens.length; i++) {
  kitchens[i].addEventListener('change', function(event){
    if(event.target.checked==true) {checkedKitchens.add(event.target.name);}
      else {checkedKitchens.delete(event.target.name);}
    let params={
      "function": 'getProducts'
    }
    if(checkedKitchens.size>0){params["kitchen"]=[...checkedKitchens].toString();}
    if (curentCategory!='undefined') {params["category"]=curentCategory; categoryMessage=curentCategory;}
    console.log(params, 'category:'+categoryMessage);
    ajax(params);
  })
}

document.getElementById('clearFilter').onclick=function(){
  let curentCategory=(~document.location.toString().indexOf('?category='))?document.location.toString().substring(document.location.toString().indexOf('=')+1):'undefined';
  let params={
    "function": 'getProducts'
  }
  if (curentCategory!='undefined') {params["category"]=curentCategory}
  let kitchens=document.querySelectorAll('#kitchenFilter input[type="checkbox"]');
  for (let i = 0; i < kitchens.length; i++) {
    if(kitchens[i].checked==true) {kitchens[i].checked=false;}
  }  
  ajax(params);
}

}

function ajax(params){
  var xmlhttp = new XMLHttpRequest(); 
  var res='';
  xmlhttp.open("POST", "/includes/ajax.php");
  xmlhttp.setRequestHeader("Content-Type", "application/json");


  document.body.className='loading';
  xmlhttp.send(JSON.stringify(params));
  xmlhttp.onreadystatechange=()=>{
    if(xmlhttp.readyState=='4' && xmlhttp.status=='200'){
      res=xmlhttp.responseText;
      res=JSON.parse(res);
      console.log('Ajax Response:', res);

      switch (params['function']) {
        case 'login':
         let ul=document.querySelectorAll('.menu.list-inline.mb-0 li');
         ul[0].innerHTML=`<li class="list-inline-item"><a href="/acount">${params['login']}</a></li>`;
         ul[1].innerHTML='<li class="list-inline-item"><a href="/logout">Logout</a></li>';
        
          document.querySelector('h2.alert__text.authorization_message').classList.add('d-none');
          function eventFire(el, etype){
            if (el.fireEvent) {
            el.fireEvent('on' + etype);
            } else {
              var evObj = document.createEvent('Events');
              evObj.initEvent(etype, true, false);
              el.dispatchEvent(evObj);}
          }
        eventFire(document.querySelector('#login-modal button[data-dismiss=modal]'), 'click');  
          break;
        case 'cartAdd':
          changeCartText(); 
          break;
        case 'getProducts':
          let products=document.querySelector('.row.products');
          while (products.hasChildNodes()) {
            products.removeChild(products.firstChild);
          }
          for (let i = 0; i < res.length; i++) {
            var div = document.createElement('div');
            div.className = "col-lg-4 col-md-6";
            div.innerHTML = `<div class="product">'
              <div class="flip-container">
                <div class="flipper">
                  <div class="front"><a href="../dish/?id=${res[i]['id']}"><img src="../public/img/${res[i]['image']}" alt="" class="img-fluid"></a></div>
                  <div class="back"><a href="../dish/?id=${res[i]['id']}"><img src="../public/img/${res[i]['image']}" alt="" class="img-fluid"></a></div>
                </div>
              </div><a href="../dish/?id=${res[i]['id']}" "="" class="invisible"><img src="../public/img/${res[i]['image']}" alt="" class="img-fluid"></a>
              <div class="text">
                <h3><a href="../dish/?id=${res[i]['id']}" "="">${res[i]['title']}</a></h3>
                <p class="price"> 
                  $${res[i]['price']}
                </p>
                <p class="buttons"><a href="../dish/?id=${res[i]['id']}" class="btn btn-outline-secondary">View detail</a>
                <a href="../cart/?add=${res[i]['id']}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a></p>
              </div>
            </div>
          </div>`;
            products.appendChild(div);           
          }

        
          break;  
      
        default:
          break;
      }
      
      
    }
    }
    setTimeout(function() { document.body.className=""; }, 500);    
}


function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
  options = options || {};
  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

function getCartCount(){
  let count=0;
  let productCart=JSON.parse(getCookie('cart'));
  for (const key in productCart) {
    if (productCart.hasOwnProperty(key)) {
      count+=+productCart[key];  
    }
  }
  return count;
}

function changeCartText(){
  let cartBasket=document.querySelector('#basket-overview a span');
  let cartCount=getCartCount()
  cartBasket.textContent=cartCount;
  
  let url=document.location.toString();
  if (~url.indexOf("cart")) {
    document.getElementById('cartCount').textContent=cartCount;
  }
}

function cartRecalc(activeRow, action){
  document.body.className='loading';
  const cells=activeRow.querySelectorAll('td');
  let productTotal=cells[5].textContent;
  let cartTotal=document.getElementById('cartTotal');
  switch (action) {
    case 'delete':
       cartTotal.textContent=+cartTotal.textContent-productTotal;
      break;
    case 'change':
      let productId=activeRow.querySelector('input[type="hidden"]');
      productId=productId.value;
      let productCart=JSON.parse(getCookie('cart'));
      const productPrice=cells[3].textContent;
      const productCount=cells[2].querySelector('input').value;
      cells[5].textContent=+productCount*(+productPrice); 
      cartTotal.textContent=+cartTotal.textContent-productTotal+productCount*(+productPrice);    
      productCart[productId]=productCount;
      setCookie('cart', JSON.stringify(productCart), {'expires':24 * 60 * 60 *1000, 'path':'/'});
      break;  
    default:
      break;
  }
  changeCartText();
  setTimeout(function() { document.body.className=""; }, 500);
}