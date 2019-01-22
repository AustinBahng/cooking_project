$("#rating-button").click(function() {
  let value = parseInt(
    $(".rating-number")
      .html()
      .replace(/,/g, "")
  );
  if ($(this).hasClass("upvoted")) {
    $(this).toggleClass("upvoted");
    $(this).html("Like");
    value--;
  } else {
    $(this).toggleClass("upvoted");
    $(this).html("Unlike");
    value++;
  }
  value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  $(".rating-number").html(value);
});

$("#add-button").click(function() {
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  url = "lib/add_to_cookbook.php";
  let postRequest = $.post(url, {
    recipe_id: recipe_id
  });

  postRequest.done(function(error) {
    console.log(error);
    if (error == " ") {
      console.log(error);
    } else {
      $("#add-button").prop("disabled", true);
    }
  });
});

$("#edit-button").click(function() {
  $("#edit_recipe_wrapper").show();
  $("html").css({ overflow: "hidden" });
});

$(".overlay-wrapper").click(function(e) {
  if (e.target === this) {
    $(".overlay-wrapper").hide();
    $("html").css({ overflow: "auto" });
  }
});

$("#delete-button").click(function() {
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  location.href = "lib/delete_recipe.php?recipe_id=" + recipe_id;
  let getRequest = $.get(url);
  getRequest.done(function(error) {
    if (error == " ") {
      console.log(error);
    } else {
      alert("Deleted recipe");
      location.href = "index.php";
    }
  });
});

$(".fas").click(function() {
  $(this)
    .closest("tr")
    .remove();
});

$("#add-ingredient-button").click(function() {
  let name = $("#add-name").val();
  let quantity = $("#add-quantity").val();
  if (name) {
    let row = $('<tr class="ingredient">');
    let cols = "";
    cols += '<th scope="row">' + name + "</th>";
    cols +=
      "<td><span>" +
      quantity +
      '</span><i class="fas fa-times-circle"></i></td>';
    cols += "</tr>";
    row.append(cols);
    $("#edit-form-ingredients tbody").append(row);

    $(".fas").click(function() {
      $(this)
        .closest("tr")
        .remove();
    });
    // clear input boxes
    $("#add-ingredient-row input").val("");
  }
});
$("#add-preparation-button").click(function() {
  let preparation = $("#add-preparation").val();
  if (preparation) {
    let row = $('<tr class="preparation">');
    let cols = "";
    cols +=
      '<td scope="row"><span>' +
      preparation +
      '</span><i class="fas fa-times-circle"></i></td>';
    cols += "</tr>";
    row.append(cols);
    $("#edit-preparations tbody").append(row);

    $(".fas").click(function() {
      $(this)
        .closest("tr")
        .remove();
    });
    // clear input boxes
    $("#add-preparation-row input").val("");
  }
});
