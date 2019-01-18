$(".recipe-preview").click(function() {
  if ($(this).attr("id") === "create-recipe") {
    $("#create_recipe_wrapper").show();
  } else {
    location.href = "recipe.php?recipe_id=" + $(this).attr("value");
  }
});

$("#create_recipe_wrapper").click(function(e) {
  if (e.target === this) {
    $("#create_recipe_wrapper").hide();
  }
});

$("#create-recipe-submit-button").click(function(e) {
  e.preventDefault();
  let error = false;
  if ($("#name").val() == null || $("#name").val() == "") {
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
    let url = "lib/create_recipe.php";
    let ingredient = new Array();
    let quantity = new Array();
    let preparation = new Array();
    $(".ingredient th").each(function() {
      ingredient.push($(this).html());
    });
    $(".ingredient td span").each(function() {
      quantity.push($(this).html());
    });
    $(".preparation span").each(function() {
      preparation.push($(this).html());
    });
    let postRequest = $.post(url, {
      name: $("#name").val(),
      url: $("#url").val(),
      cooking_time: $("#cooking-time").val(),
      serving_size: $("#serving-size").val(),
      ingredient: ingredient,
      quantity: quantity,
      preparation: preparation
    });
    postRequest.done(function(error) {
      if (error != " ") {
        console.log(error);
      } else {
        window.location.href = "cookbook.php";
      }
    });
  }
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
    $("#ingredients tbody").append(row);

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
    $("#preparations tbody").append(row);

    $(".fas").click(function() {
      $(this)
        .closest("tr")
        .remove();
    });
    // clear input boxes
    $("#add-preparation-row input").val("");
  }
});
