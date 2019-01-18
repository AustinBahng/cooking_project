$(".recipe-preview").click(function() {
  if ($(this).attr("id") === "add-recipe") {
    // location.href = 'add_recipe.php';
  } else {
    location.href = "recipe.php?recipe_id=" + $(this).attr("value");
  }
});

$("#create_recipe_wrapper").click(function(e) {
  if (e.target === this) {
    console.log("click");
  }
});
