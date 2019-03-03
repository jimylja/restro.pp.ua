window.onload = function(){
  document.querySelector("#login-button").onclick=function(event){
    event.preventDefault();
    let modalLogin=document.querySelector('#userlogin-modal');
    let modalPassword=document.querySelector('#password-modal');
    let params={
      "function": 'login',
      "login": modalLogin.value,
      "password": modalPassword.value,
    }
    console.log('params: ', params);
    ajax(params);
  }
}

function ajax(params){
  var xmlhttp = new XMLHttpRequest(); 
  var res='';
  xmlhttp.open("POST", "/includes/ajax.php");
  xmlhttp.setRequestHeader("Content-Type", "application/json");
  xmlhttp.send(JSON.stringify(params));
  xmlhttp.onreadystatechange=()=>{
    if(xmlhttp.readyState=='4' && xmlhttp.status=='200'){
      res=xmlhttp.responseText;
      res=JSON.parse(res);
      console.log(res);

      let ul=document.querySelectorAll('.menu.list-inline.mb-0 li');
      ul[0].innerHTML=`<li class="list-inline-item"><a href="/acount">${params['login']}</a></li>`;
      ul[1].innerHTML='<li class="list-inline-item"><a href="/logout">Logout</a></li>';
      
      document.querySelector('h2.alert__text.authorization_message').classList.add('d-none');

      // el.className += ' new_class';

      function eventFire(el, etype){
        if (el.fireEvent) {
          el.fireEvent('on' + etype);
        } else {
          var evObj = document.createEvent('Events');
          evObj.initEvent(etype, true, false);
          el.dispatchEvent(evObj);
        }
      }
      eventFire(document.querySelector('#login-modal button[data-dismiss=modal]'), 'click');
    }
    }
}