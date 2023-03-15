
//beim Klick des Resetbuttons soll die Seite ohne die Search- & Sort-Parameter neu geladen werden
function resetPage() {
  let urlObj = new URL(window.location.href); //URL holen
  urlObj.search = ''; //Parameter löschen
  let cleanUrl = urlObj.toString(); //URL in STring umwandeln
  location.replace(cleanUrl);
}