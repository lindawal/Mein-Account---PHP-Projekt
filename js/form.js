"use strict";

jQuery(document).ready(function ($) {
  let $form = $("form"); //Formular finden
    if (!$form) {
        return;
  } //wenn kein Formular vorhanden ist dann abbrechen

  $form.submit(function (event) {
    event.preventDefault(); //beim Klick auf Sumit-Button das Standard-Event (Seite neu laden) unterbinden
    $.post("mailversand.php", $form.serialize(), function (msg) {
      $form[1].reset();
      $form.hide();
      $(".my-content").eq(1).load("ThankYou.html");
      console.log(msg);
    });
  });

//   <body>
//     <div id="demo">
//       <h1>The XMLHttpRequest Object</h1>
//       <button type="button" onclick="loadDoc()">Change Content</button>
//     </div>
    
//     <script>
//       function loadDoc() {
//   var xhttp = new XMLHttpRequest();
//       xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//         document.getElementById("demo").innerHTML =
//         this.responseText;
//     } };
//       xhttp.open("GET", "ajax_info.txt", true);
//       xhttp.send();
// }
//     </script>
//   </body>

  //   event.preventDefault(); //beim Klick auf Sumit-Button das Standard-Event (Seite neu laden) unterbinden


  // $form.submit(function(event) {
  //   event.preventDefault(); //beim Klick auf Sumit-Button das Standard-Event (Seite neu laden) unterbinden
    
  //   function getFormData() {
  //     var unindexed_array = $form.serializeArray(); //ein Array-ähnliches Objekt aus den Formulardaten bilden
  //     var indexed_array = {};

  //     $.map(unindexed_array, function (n, i) {
  //       indexed_array[n['name']] = n['value']; //ein indexierbares Array bilden
  //     });
  //     return indexed_array;
  //   }

  //   var data = getFormData($form);
  //   var json_data = JSON.stringify(data);

  //   /*const data = form.serialize();*/
  //   //const data = $form.serializeObject();     //$("form fieldset input:nth-of-type(1)").val();
  //     //const method = form.serialize();
  //   const url = $form[0].action;
  //   console.log(url);
    
  //   $.ajax({
  //     type: "POST",
  //     url: "mailversand.php",
  //     data: "json_data", //daten,
  //     // Bei erforgreicher Ausführung den Response in den output-Container schreiben
  //     success: function () {
  //       //$("#output").html(data);
  //       console.log("erfolg: " + json_data)
  //     },
  //     // Bei fehlerhafter Ausführung einen Fehler ausgeben
  //     error: function () {
  //       //$("#output").html("Es ist ein Fehler aufgetreten!")
  //       console.log("Fehler: " + json_data)
  //     }
  //   });

  //      /* const response = await fetch(url,
  //   {
  //           method,
  //           body: data,
  //           headers: {
  //       "X-Requested-With": "XMLHttpRequest"
  //     }
  //   });

  //       if (response.ok === false) {
  //     // Something wrong with the request.
  //           return;
  //   }*/
  //   // Do something with the result (in response.json() for JSON responses).
  // });
});