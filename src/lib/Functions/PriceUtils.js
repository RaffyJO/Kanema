function formatToIDR(number) {
  // Format the number to IDR currency
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  })
    .format(number)
    .replaceAll(",00", "");
}

function parseIDRToNumber(idrString) {
  // Remove non-numeric characters (including currency symbol 'IDR', 'Rp', and commas)
  let numericString = idrString.replaceAll(",00", "");

  numericString = numericString.replace("Rp", "");
  // numericString = idrString.replace(/[^\d.,]/g, '');

  // Replace comma (,) with empty string for proper parsing
  numericString = numericString.replace(/,/g, "");
  numericString = numericString.replaceAll(".", "");
  console.log(numericString);

  // Parse the string to a number
  let numberValue = Number.parseInt(numericString);

  return isNaN(numberValue) ? 0 : numberValue; // Return 0 if parsing fails
}
