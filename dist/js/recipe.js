$("#rating-button").click(function() {
  $(this).prop("disabled", true);
  let value = parseInt(
    $(".rating-number")
      .html()
      .replace(/,/g, "")
  );
  if ($(this).hasClass("upvoted")) {
    value--;
    updateUpvotes(value, false);
  } else {
    value++;
    updateUpvotes(value, true);
  }
});

function updateUpvotes(value, increment) {
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  url = "lib/update_upvotes.php";
  let postRequest = $.post(url, {
    recipe_id: recipe_id,
    increment: increment
  });

  postRequest.done(function(error) {
    if (error != " ") {
      console.log(error);
    } else {
      value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      $("#rating-button").toggleClass("upvoted");
      if (increment) {
        $("#rating-button").html("Unlike");
      } else {
        $("#rating-button").html("Like");
      }
      $(".rating-number").html(value);
    }
    $("#rating-button").prop("disabled", false);
  });
}

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

$("#delete-button").click(function(e) {
  e.preventDefault();
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  url = "lib/delete_recipe.php";
  let postRequest = $.post(url, {
    recipe_id: recipe_id
  });
  postRequest.done(function(error) {
    if (error) {
      console.log(error);
    } else {
      alert("Deleted recipe");
      window.location.href = "cookbook.php";
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

$("#update-recipe-submit-button").click(function(e) {
  e.preventDefault();
  let error = false;
  if ($("#edit-name").val() == null || $("#edit-name").val() == "") {
    $("#name-error").html("Recipe name cannot be epmty");
    $("#create_recipe_overlay").animate(
      {
        scrollTop: 0
      },
      100
    );
    error = true;
  } else {
    $("#name-error").html("");
  }
  if (!error) {
    let ingredient = new Array();
    let quantity = new Array();
    let preparation = new Array();
    $("#edit-form-ingredients .ingredient th").each(function() {
      ingredient.push($(this).html());
    });
    $("#edit-form-ingredients .ingredient td span").each(function() {
      quantity.push($(this).html());
    });
    $("#edit-preparations .preparation div").each(function() {
      preparation.push($(this).html());
    });
    let url = new URL(window.location.href);
    let recipe_id = url.searchParams.get("recipe_id");
    url = "lib/update_recipe.php";
    let postRequest = $.post(url, {
      recipe_id: recipe_id,
      name: $("#edit-name").val(),
      url: $("#edit-url").val(),
      cooking_time: $("#edit-cooking-time").val(),
      serving_size: $("#edit-serving-size").val(),
      ingredient: ingredient,
      quantity: quantity,
      preparation: preparation
    });
    postRequest.done(function(error) {
      if (error != " ") {
        console.log(error);
        $("#error").html(error);
      } else {
        location.reload();
      }
    });
  }
});
