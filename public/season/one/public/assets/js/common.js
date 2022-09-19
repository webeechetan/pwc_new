function snackbar(t) {
    var x = document.getElementById("snackbar");
    x.innerHTML = t || '';
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}


const commonAjax = (o) => {

const { page, params, type, header, addonUrl } = o;

const customHeader = new Headers();
// customHeader.append("Content-Type", "application/json");
customHeader.append("Accept", "application/json");
customHeader.append("Access-Control-Allow-Origin", "*")
customHeader.append('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))

const method = type || 'POST';
let url = addonUrl || 'http://localhost/pwc_new/public/season/one/public/';
let request = url+page;
const raw = params || '';
const myHeaders = header || customHeader;
request = request.replace(/&amp;/g, '&')
var requestOptions = {
  method: method,
  headers: myHeaders,
  body: raw,
};

if(method === 'GET') {delete requestOptions['body'];}

const myPromise = new Promise(function(myResolve, myReject) {
  fetch(request, requestOptions)
  .then(response => response.json())
  .then(response => myResolve(response))
  .catch(error => {
    console.log(error);
    return myReject({"success": false});
  });
});
return myPromise;
}

const fileUpload = (e) => {
  const reader = new FileReader();
  reader.readAsDataURL(e);
  return new Promise((resolve, reject) => {
      reader.onerror = () => {
          reject(0);
      }
      reader.onload = function() {
          resolve(reader.result);
      }
  });
}