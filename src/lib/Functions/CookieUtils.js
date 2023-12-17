function getCookie(name) {
  const cookies = document.cookie.split(";");

  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].trim();

    if (cookie.startsWith(name + "=")) {
      return cookie.substring(name.length + 1);
    }
  }
  // Return null if the cookie isn't found
  return null;
}

function destroyCookie(name) {
  const cookies = document.cookie.split(";");

  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].trim();

    if (cookie.startsWith(name + "=")) {
      return cookie.substring(name.length + 1);
    }
  }
  // Return null if the cookie isn't found
  return null;
}

function destroyBearer() {
  document.cookie = "Bearer=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}
