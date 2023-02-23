"use strict";

//Datum und Copyright in der Fußzeile
$(".footerbox p:last-of-type").append("<br>&copy; " + (new Date).getFullYear() + " ");

//Portfolio Untermenü in der Nav als Toggle Button bei Click öffnen oder schließen
$(document).ready(function () {
  $(".drop")
    .click(function () {
      $(".dropdown").toggle(300);
    });
});

//Profilbild ist grau und wird bei mouseover farbig
jQuery(document).ready(function ($) {
  $("#imglinda")
    .mouseover(function () {
      $(this).css("filter", "grayscale(0%)");
    });
});
  
//progress-bar Balken sind erst auf 0 und werden beim hinscrollen auf endgültigen Wert gesetzt
jQuery(document).ready(function ($) {
  if (window.matchMedia('(min-width: 950px)').matches) {
    $(window).scroll(function () {
      let position = window.pageYOffset;
      if (position >= 1000) {
        $(".progress-bar").each(function () {
          $(this).css({
            width: $(this).attr('aria-valuenow') + "%"
          }, 500);
        })
      }
      else {
        $(".progress-bar").css('width', '0');
      };
    });
  }
});

/*//scroll-Position bei KLick auf "Skills" abfragen
jQuery(document).ready(function ($) {
  $("div").click(function () {
    window.scrollBy(100, 100);
    console.log("pageXOffset: " + window.pageXOffset + ", pageYOffset: " + window.pageYOffset);
  });
});*/
