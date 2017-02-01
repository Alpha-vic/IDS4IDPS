function previewImage(input, image) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      image.prop('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function initButtons(previewer, prefWidth, prefHeight, saveHandler, modalWindow, input) {
  $('#zoom-in', modalWindow).click(function () {
    previewer.cropper('zoom', +0.1);
  });

  $('#zoom-out', modalWindow).click(function () {
    previewer.cropper('zoom', -0.1);
  });

  $('#reset', modalWindow).click(function () {
    previewer.cropper('reset');
  });

  $('#ml', modalWindow).click(function () {
    previewer.cropper('move', -10, 0);
  });
  $('#mr', modalWindow).click(function () {
    previewer.cropper('move', +10, 0);
  });
  $('#mu', modalWindow).click(function () {
    previewer.cropper('move', 0, -10);
  });
  $('#md', modalWindow).click(function () {
    previewer.cropper('move', 0, 10);
  });

  var msgTimer;
  $('#save', modalWindow).click(function () {
    var button = $(this).attr('disabled', true);
    $('#up-loader').slideDown();
    msgTimer = setTimeout(function () {
      $('#up-loader .msg').slideDown();
    }, 7000);

    var formData = new FormData();
    //Check if HTMLCanvasElement.toBlob is supported
    if (isCanvasSupported('toBlob')) {
      //Client side cropping
      var canvas = previewer.cropper('getCroppedCanvas', {width: prefWidth, height: prefHeight});
      canvas.toBlob(function (blob) {
        formData.append('image', blob);
        saveImage(previewer, saveHandler, modalWindow, formData, button);
      });
    } else {
      //Server side cropping
      var image = $(input)[0].files[0];
      formData.append('image', image);
      var data = previewer.cropper('getData');
      formData.append('crop', JSON.stringify(data));
      saveImage(previewer, saveHandler, modalWindow, formData, button);
    }
  });

  function saveImage(previewer, saveHandler, modalWindow, formData, button) {
    if (typeof saveHandler === 'function') {
      saveHandler(previewer, modalWindow, formData);
      button.removeAttr('disabled');
      clearMessage();
    } else {
      ajaxCall({
        url: saveHandler,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        onSuccess: function (response) {
          if (response.status) {
            previewer.cropper('destroy');
            notify($('#notify'), response);
            $('#x').toggleClass('grey', 'blue');
            previewer.prop('src', response.data.url);
            $('.btn', modalWindow).prop('disabled', true);
            $('#user-image').prop('src', response.data.url);
            setTimeout(function () {
              modalWindow.modal('close');
            }, 2000);
          } else {
            notify($('#notify'), response);
          }
        },
        onFailure: function () {
          notify($('#notify'), {'message': 'Upload Failed', 'status': false});
        },
        onComplete: function () {
          button.removeAttr('disabled');
          clearMessage();
        }
      });
    }
  }

  function clearMessage() {
    clearTimeout(msgTimer);
    $('#up-loader, #up-loader .msg').slideUp();
  }

  modalWindow.on('hidden.bs.modal', function () {
    clearMessage();
    previewer.cropper('destroy');
  });
}
