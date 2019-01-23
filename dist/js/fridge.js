function bindRemove(btn) {
  $(btn).prop("disabled", true);
  let row = $(btn).closest("tr");
  let url = "lib/remove_from_fridge.php";
  let postRequest = $.post(url, {
    index: row.attr("value")
  });
  postRequest.done(function(error) {
    if (error) {
      console.log(error);
    } else {
      row.remove();
    }
    $(btn).prop("disabled", false);
  });
}
$(".remove-ingredient").click(function() {
  bindRemove(this);
});

$("#add-item-button").click(function() {
  $(this).prop("disabled", true);
  let name = $("#add-name").val();
  let quantity = $("#add-quantity").val();
  let expiring = $("#add-expiring").val();
  if (name) {
    let url = "lib/add_to_fridge.php";
    let postRequest = $.post(url, {
      name: name,
      quantity: quantity,
      expiring: expiring
    });
    postRequest.done(function(error) {
      if (error && isNaN(parseInt(error, 10))) {
        console.log(error);
      } else {
        let index = error;
        let row = $("<tr value=" + index + ">");
        let cols = "";
        cols += '<th scope="row">' + name + "</th>";
        cols += '<td><span id="measurement">' + quantity + "</span></td>";
        cols +=
          "<td>" +
          expiring +
          '<button class="remove-ingredient btn">Remove</button></td>';
        cols += "</tr>";
        row.append(cols);
        $(".table tbody").append(row);

        $(".table tbody tr button")
          .last()
          .click(function() {
            bindRemove(this);
          });
        // clear input boxes
        $("#add-row input").val("");
      }
    });
    $(this).prop("disabled", false);
  }
});
