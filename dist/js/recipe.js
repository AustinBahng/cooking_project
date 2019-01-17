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
  url = "add_to_cookbook.php";
  let postRequest = $.post(url, {
    recipe_id: recipe_id
  });

  postRequest.done(function(error) {
    if (error == " ") {
      console.log(error);
    } else {
      console.log("added");
      alert("Added To My Cookbook");
    }
  });
});

$("#edit-button").click(function() {
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  location.href = "edit_recipe.php?recipe_id=" + recipe_id;
});

$("#delete-button").click(function() {
  let url = new URL(window.location.href);
  let recipe_id = url.searchParams.get("recipe_id");
  location.href = "delete_recipe.php?recipe_id=" + recipe_id;
});
