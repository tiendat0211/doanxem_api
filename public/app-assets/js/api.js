'use strict';

const NOT_FOUND = 404

const FORBIDDEN = 403

const SUCCESS = 200

const ERROR = 400
// thực hiện gọi tới server để xử lý
const callApi = async (api, method = "GET", data = {}, headers = {}) => {
    // để thực hiện cho các route controller lấy dữ liệu
    method === "GET" && (api += "?" + getQuery(data));

    // để thực hiện cho các route controller kiểu dạng store
    let config = {
        method,
        url: api,
        headers: {
            'Content-Type': "application/json",
            ...headers
        },
    };
    data && (config = {...config, data});

    return await axios(config);
};

const getQuery = query => {
    let strQuery = "";
    // nhập input name có value="danh", input name="phone"
    // lúc này query ={name:danh,dthoai:phone}
    for (let q in query) {
        strQuery += q + "=" + query[q] + "&";// name = danh
    }
    return strQuery;
};

//add
const store = async (data, url) => {
    return callApi(url, "POST", data)
};
//update
const update = async (data, url) => {
    return callApi(url, "POST", data)
};
//delete
const remove = async (data, url) => {
    return callApi(url, "POST", data)
};
const editPassword = (data) => {
    return callApi('/admin/edit-password', 'POST', data);
};

const editProfile = (data) => {
    return callApi('/admin/edit-profile', 'POST', data);
};


