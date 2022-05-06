"use strict";

$(document).ready(function() {
// DOCUMENT READY -->





// REMOVE ANIMATION

var headerLogo = $(".header-logo");
var menuBtnI = $(".menu-btn-i");

setTimeout(function() {
  headerLogo.addClass("logo-color-change");
  menuBtnI.addClass("logo-color-change");
}, 500);





// HEADER

var header = $(".header");

$(window).scroll(function() {
  var scrollTop = $(document).scrollTop();

  if (scrollTop > 0) {
    header.addClass("header-active");
  } else {
    header.removeClass("header-active");
  }
});





// MOBILE MENU

var menuBtn = $(".menu-btn");
var menuBtnIcon = $(".menu-btn i");
var navigation = $(".navigation");

menuBtn.on(
  "click",
  function toggleMenu() {
    if (menuBtnIcon.html() === "menu") {
      menuBtnIcon.html("close");
      header.addClass("fit-header");
    } else {
      menuBtnIcon.html("menu");
      header.removeClass("fit-header");
    };
    navigation.toggleClass("navigation-open");
  }
);

function closeMenu() {
  menuBtnIcon.html("menu");
  navigation.removeClass("navigation-open");
  header.removeClass("fit-header");
}





// LINKS

headerLogo.on(
  "click",
  function() {
    closeMenu()

    window.scroll({
      top: 0,
      behavior: 'smooth'
    });
  }
);


var aboutBtn = $(".aboutBtn");
var about = $(".about");

aboutBtn.on(
  "click",
  function() {
    closeMenu()

    if (window.innerHeight > window.innerWidth) {
      var jumpCorrection = 82;
    } else {
      var jumpCorrection = 100;
    }

    var jumpHeight = about.offset().top - jumpCorrection;
    // minus header height

    window.scroll({
      top: jumpHeight,
      behavior: 'smooth'
    });
  }
);


var cncCuttingBtn = $(".cncCuttingBtn");
var cncCutting = $(".cnc-cutting");

cncCuttingBtn.on(
  "click",
  function() {
    closeMenu()

    if (window.innerHeight > window.innerWidth) {
      var jumpCorrection = 82;
    } else {
      var jumpCorrection = 100;
    }

    var jumpHeight = cncCutting.offset().top - jumpCorrection;
    // minus header height

    window.scroll({
      top: jumpHeight,
      behavior: 'smooth'
    });
  }
);


var cncMillingBtn = $(".cncMillingBtn");
var cncMilling = $(".cnc-milling");

cncMillingBtn.on(
  "click",
  function() {
    closeMenu()

    if (window.innerHeight > window.innerWidth) {
      var jumpCorrection = 82;
    } else {
      var jumpCorrection = 100;
    }

    var jumpHeight = cncMilling.offset().top - jumpCorrection;
    // minus header height

    window.scroll({
      top: jumpHeight,
      behavior: 'smooth'
    });
  }
);


var cncEngravingBtn = $(".cncEngravingBtn");
var cncEngraving = $(".cnc-engraving");

cncEngravingBtn.on(
  "click",
  function() {
    closeMenu()

    if (window.innerHeight > window.innerWidth) {
      var jumpCorrection = 82;
    } else {
      var jumpCorrection = 100;
    }

    var jumpHeight = cncEngraving.offset().top - jumpCorrection;
    // minus header height

    window.scroll({
      top: jumpHeight,
      behavior: 'smooth'
    });
  }
);


var contactBtn = $(".contactBtn");
var contact = $(".contact");

contactBtn.on(
  "click",
  function() {
    closeMenu()

    if (window.innerHeight > window.innerWidth) {
      var jumpCorrection = 82;
    } else {
      var jumpCorrection = 100;
    }

    var jumpHeight = contact.offset().top - jumpCorrection;
    // minus header height

    window.scroll({
      top: jumpHeight,
      behavior: 'smooth'
    });
  }
);





// --> DOCUMENT READY
});
