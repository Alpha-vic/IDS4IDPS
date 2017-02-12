/**
 * Project: ids4idps.msc
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    2/12/2017
 * Time:    7:40 AM
 **/

$(function () {
  //list management
  var $listManager = $('#manageList');
  var NP = $('#notify', $listManager);

  $(":submit", $listManager).click(function() {
    $("form").data("submit-action", this.value);
  });

  $listManager.submit(function (e) {
    e.preventDefault();
    $('input[name=action]', $listManager).val(button = $(this).data("submit-action"));
    $('button[type=submit]', $listManager).attr('disabled', true);
    ajaxCall({
      url: $listManager.attr('action'),
      method: "POST",
      data: $listManager.serialize(),
      onSuccess: function (response) {
        notify(NP, response);
        if (response.status == true) {
          setTimeout(function () {
            window.location.reload();
          }, 1000);
        }
      },
      onFailure: function (xhr) {
        handleHttpErrors(xhr, $listManager, '#notify');
      },
      onComplete: function () {
        $('button[type=submit]', $listManager).removeAttr('disabled');
      }
    });
  });
});