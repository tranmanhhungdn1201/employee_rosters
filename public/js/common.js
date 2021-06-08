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