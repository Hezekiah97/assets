// --- Delete action (bootbox) ---
yii.confirm = function (message, ok, cancel) {
  bootbox.confirm({
    message: message,
    size: "small",
    buttons: {
      confirm: {
        label: "<i class='mdi mdi-check'></i> OK",
        className: "btn btn-primary btn-sm",
      },
      cancel: {
        label: "<i class='mdi mdi-close'></i> Cancel",
        className: "btn btn-danger btn-sm",
      },
    },
    callback: function (confirmed) {
      if (confirmed) {
        !ok || ok();
      } else {
        !cancel || cancel();
      }
    },
  });
  // confirm will always return false on the first call
  // to cancel click handler
  return false;
};
