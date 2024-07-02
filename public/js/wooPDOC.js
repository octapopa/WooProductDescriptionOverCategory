jQuery(document).ready(function ($) {
  $(document).on("click", "button.woopdoc_save_to_all_products", function () {
    if (
      confirm(
        "Esti sigur ca vrei sa modifici pe toate produsele descrierea?"
      ) == true
    ) {
      block_woopdoc();
      var data = {};
      data.action = "woopdoc_save_to_all_products";
      data.post_id = $(this).data("post_id");
      data.category_id = $("#wooPDOC").find(":selected").val();
      data.description = $("#content").text();

      $.ajax({
        url: ajax_url,
        data: data,
        type: "POST",
        success: function (response) {
          show_message(response.message);
          console.log(response);
          unblock_woopdoc();
        },
        // dataType: "json",
      });
    }
  });

  /**
   * Block selected tab
   */
  function block_woopdoc() {
    $("#woopdoc_meta_box").block({
      message: null,
      overlayCSS: {
        background: "#fff",
        opacity: 0.6,
      },
    });
  }

  /**
   * Unblock selected tab
   */
  function unblock_woopdoc() {
    $("#woopdoc_meta_box").unblock();
  }

  function show_message(message, type = "success", icon = "🎉") {
    window.wp.data
      .dispatch("core/notices")
      .createSuccessNotice(message, { icon: icon });
  }
});
