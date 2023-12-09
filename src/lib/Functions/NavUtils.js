async function getUsername() {
  let headersList = {
    Accept: "*/*",
    Authorization: `Bearer ${getCookie("Bearer")}`,
  };

  const response = await fetch("/api/user", {
    method: "GET",
    headers: headersList,
  });

  const result = await response.json();

  return result;
}
