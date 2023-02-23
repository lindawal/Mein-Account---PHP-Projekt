"use strict";

function MobileMenu() {
  var mobileNav = document.getElementById("navi-line");
  if (mobileNav.style.display === "block") {
    mobileNav.style.display = "none";
  } else {
    mobileNav.style.display = "block";
  }
}

