"use strict";

$(document).ready(function() {
  // DOCUMENT READY -->

  var nameInput = $("#nameInput");
  var emailInput = $("#emailInput");
  var messageInput = $("#messageInput");
  var fileInput = $("#fileInput");
  var submitBtn = $("#submitBtn");

  var nameError = 1;
  var emailError = 1;
  var messageError = 1;

  var typeErrors = 0;
  var allowedExt = ["pdf", "jpg", "jpeg", "png", "dxf"];

  var uploadSize = 0;
  var allowedSize = 10 * 1024 * 1024; // 10 MB

  var errors = 3;

  var modal = $("#modal");
  var modalBtn = $("#modalBtn");
  modalBtn.click(function() {
    modal.removeAttr("style").hide();
  });

  function validate() {
    errors = nameError + emailError + messageError + typeErrors;
    if ( errors !== 0 ) {
      submitBtn.prop("disabled", true);
      submitBtn.removeClass("submit-enabled");
    } else {
      submitBtn.prop("disabled", false);
      submitBtn.addClass("submit-enabled");
    }
  }

  validate();

  // Check inputs
  nameInput.keyup(function() {
    if (this.value === "")
    {nameError = 1}
    else {nameError = 0}
    validate();
  });

  emailInput.keyup(function() {
    if (this.value === "")
    {emailError = 1}
    else {emailError = 0}
    validate();
  });

  messageInput.keyup(function() {
    if (this.value === "")
    {messageError = 1}
    else {messageError = 0}
    validate();
  });

  // Track changes on file input and check file types
  fileInput.change(function() {
    typeErrors = this.files.length;
    
    uploadSize = 0;
    for (let i = 0; i < typeErrors; i++) {
      uploadSize += this.files[i].size;
    }

    if (uploadSize > allowedSize) {
      this.value = null;
      typeErrors = 0;
      uploadSize = 0;
      console.log(
        "Total upload file size too large! (>" + allowedSize + " MB)"
      );
      modal.show();
    } else {
      if (typeErrors !== 0) {
        var iterations = typeErrors;
        for (let i = 0; i < iterations; i++) {
          var fileName = this.files[i].name.split(".");
          var fileExt = fileName[fileName.length - 1];
          if ( jQuery.inArray(fileExt, allowedExt) !== -1 ) {
            typeErrors--;
          }
        }
        if (typeErrors !== 0) {
          this.value = null;
          typeErrors = 0;
          uploadSize = 0;
          console.log(
            "Uploaded files contain disallowed file extension! (allowed: "
            + allowedExt
            + ")"
          );
          modal.show();
        }
      }
    }
    validate();
  });

  // --> DOCUMENT READY
});