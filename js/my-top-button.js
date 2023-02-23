"use strict";

var button = $("#jButton");

jQuery(document).ready(function ($) {
 $(window).scroll(function () {       //scrollen triggert das Erscheinen des Buttons
  let position = window.pageYOffset;
  if (position >= 200) {            //wennn Scrollposition größer als 200, wird der Button sichtbar
    button.css({
    "opacity": "1",
    "visibility": "visible"
    });
  }
  else {
    button.css({                  //ansonsten bleibt der Button unsichtbar
      "opacity": "0",
      "visibility": "hidden"
    });
    }
 });
  button.attr('title', 'Beam me up, Scotty!'); //dem Button ein Title Atribut geben
});

button.click(function () { //bei Klick auf den Button:
  $(this)
    .css({
      "--content": "url(../images/Rakete.svg)", //Bild ändern in fliegende Rakete
      "bottom": "900px"                         //Position bis zu der die Rakte fliegt
    });
  window.scroll(0, 0);                          //Position bis zu der gescrollt wird
  setTimeout(function () {                      /*Zeitverzögerung, um die Rakete erst wieder einzublenden, nachdem sie durch das hochscrollen auf "visibility": "hidden" gesetzt wurde*/
    button.css({
      "--content": "url(../images/Rakete-pfeil2.svg)",
      "bottom": "50px"
    })                                           //Bild und ursprüngliche Position zurück setzen
  }, 2500);
});