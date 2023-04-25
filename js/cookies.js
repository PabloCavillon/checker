function readCookie(name) {

    return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + name.replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
}
  
function eraseCookie(name) {
  
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
  