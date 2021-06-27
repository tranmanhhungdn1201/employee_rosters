// dataTable
const LANGUAGE = {
  "sProcessing":   "Đang xử lý...",
  "sLengthMenu":   "Xem _MENU_ mục",
  "sZeroRecords":  "Không tìm thấy dữ liệu",
  "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
  "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
  "sInfoFiltered": "(được lọc từ _MAX_ mục)",
  "sInfoPostFix":  "",
  "sSearch":       "Tìm:",
  "sUrl":          "",
  "oPaginate": {
    "sFirst":    "Đầu",
    "sPrevious": "Trước",
    "sNext":     "Tiếp",
    "sLast":     "Cuối"
  }
};

function arrDataToObject(arr) {
    return arr.reduce((a, b) => {
        let {name, value} = b;
        return {
                ...a,
                [name]: value
            };
    }, {});
}

function loading(status) {
    if (status == 'hide') {
      $('.overlay').addClass('hidden');
      $('.loader').addClass('hidden');
    } else {
      $('.overlay').removeClass('hidden');
      $('.loader').removeClass('hidden');
    }
}

function debounce(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

function checkValidateHTML(formID) {
  return document.getElementById(formID).checkValidity();
}