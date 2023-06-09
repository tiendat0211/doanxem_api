function delay(fn, ms) {
    let timer = 0
    return function (...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 300)
    }
}

const getDataInForm = (form, ...fields) => {
    // kiểm tra có tồn tại tham số form đc chuyền vào không
    if (!form) {
        return {};
    }
    //... là để có thể chuyền đc nhiều tham số vào nếu có.
    let dataRequest = {};
    //{} là kiểu object là đối tượng, [] kiểu mảng
    // cú pháp foreach của js, arrays.forEach(function(array){ //code })
    // forEach với each khác nhau. forEach là để duyệt các phần tử có trong mảng, còn each để lấy giá trị
    // có trong phần tử mảng. VD: arrays = [0=> ['id'=> 1, 'name=>'acb', 'date'=>'1111] ,......]
    fields.forEach(field => {

        const fieldArray = form.find(field);
        fieldArray.each(function (index, item) {
            // arrary.getAttribute('1 cái đó có trong cái mảng array kia): dùng để lấy giá trị
            let name = item.getAttribute('name');
            dataRequest = { ...dataRequest, [name]: item.value}
            // ... dataRequest để thay cho dấu cộng. Dạng ntn: a = a+b, a+=b; ... thay cho dấu cộng
        })
    })

    return dataRequest;
}

//fill data of form
const fillFormData = (form, data = {}, ...fields) => {
    if (!form) {
        return {};
    }
    fields.forEach(field => {
        const fieldArray = form.find(field);
        fieldArray.each(function (index, item) {
            let name = item.getAttribute('name');
            if (Object.keys(data).includes(name)) {
                item.value = data[name];
            }
        })
    })
    return true;
}

const showErrorInForm = (data = {}, form = 'create-form') => {
    form.find('.invalid-feedback').remove();
    form.find('.is-invalid').removeClass('is-invalid');

    $.each(data, function (index, val) {
        form.find('input[name=' + index + '],select[name=' + index + '],textarea[name=' + index + ']')
            .addClass('is-invalid')
            .parent().append('<div class="invalid-feedback">' +
            '<strong>' + val[0] + '</strong>' +
            '</div>');
    })
    return false;
}

const modalError = message => {
    swal("Thất bại!", message, "error");
}

const modalSuccess = message => {
    swal("Thành công!", message, "success");
}
const strtoi = number => {
    return parseInt(number) || number;
}

const formatNumber = (numbers = 0) => {
    if (typeof (numbers) instanceof Array) {
        for (let [i, money] in numbers.entries()) {
            money = parseInt(money)
            numbers[i] = new Intl.NumberFormat().format(money)
        }
        return numbers
    }
    return new Intl.NumberFormat().format(numbers);
}
// để xóa validate
const hideValidation = (modal, ...args) => {
    if (args.length === 1 && args[0].includes('name=')) {
        modal.find(args[0]).removeClass('is-invalid is-valid').parent().children('.invalid-feedback, .valid-feedback').remove();
    }else {

        //artg.join(,) để chuyển mẩng thành chuỗi, vd nó là mảng [input, 'select], => chuỗi input, select
        modal.find(args.join(',')).removeClass('is-invalid').parent().children('.invalid-feedback, .valid-feedback').remove();
    }
}

const confirmAlert = (message) => {
    return Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Có',
        cancelButtonText: 'Hủy bỏ',
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ms-1'
        },
        buttonsStyling: false
    })
}

const successAlert = (message) => {
    return Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: message,
        customClass: {
            confirmButton: 'btn btn-success'
        }
    });
}

const errorAlert = (message) => {
    return Swal.fire({
        icon: 'error',
        title: 'Thất bại',
        text: message,
        customClass: {
            confirmButton: 'btn btn-danger'
        }
    });
}
