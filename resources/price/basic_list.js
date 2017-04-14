var itemsCountPerPage = 50;
var pageSplitCount = 4;
var searchCount = 5;

function handleBasicList(_list, currency, search_endpoint, edit_endpoint, 
    privilege, csrf_token, csrf_hash) {

    Vue.filter('price', function (value) {
        return parseFloat(value).toFixed(2);
    });

    var vm = new Vue({
        el: "#app",
        data: function() {
            return {
                list: _list,
                currency: currency,
                current_page: 0,
                search_options: [],
                search_content: '',
                show_search_options: false,
                search_button_enable: true,
            };
        },
        methods: {
            turnToPage: function (pageNmber, event) {
                event.preventDefault();
                this.current_page = pageNmber;
            },
            editItem: function (index, event) {
                event.preventDefault();
                this.show_list[index].is_editing = true;
            },
            saveItem: function (index, event) {
                event.preventDefault()
                if (privilege['price_basic_edit'] !== true) return;

                var obj = this.show_list[index];
                var postData = {
                    software_id: obj.software_id,
                    price: parseInt(obj.price * 100),
                    currency: obj.currency,
                    min_sale: parseInt(obj.min_sale * 100),
                };
                postData[csrf_token] = csrf_hash;
                $.ajax({
                    url: edit_endpoint,
                    method: 'POST',
                    data: postData,
                    success: function (data) {
                        if (data.success === true) {
                            this.show_list[index].is_editing = false;
                            toastr.info("Edtit success");
                        } else {
                            toastr.warning(data.message);
                        }
                    }.bind(this),
                    error: function (data) {
                        toastr.error(data);
                    }.bind(this),
                })
            },
            handleSearchInput: function (event) {
                if (this.search_content.length == 0) {
                    this.search_button_enable = true;
                    this.show_search_options = false;
                    return;
                }
                this.show_search_options = true;
                var newValue = this.search_content.toLowerCase();
                var _list = this.list.map(function (value) { 
                    return value.name.toLowerCase();
                });
                var options = [];

                this.search_button_enable = false;
                function find(content, list) {
                    var result = [];
                    if (content.length < 4) {
                        return result;
                    }
                    list.forEach(function (value, index) {
                        if (value.indexOf(content) >= 0) {
                            result.push(index);
                        }
                        if (value == content) {
                            this.search_button_enable = true;
                        }
                    }.bind(this));
                    return result;
                };
                var indexes = find.call(this, newValue, _list).slice(0, 5);
                indexes.forEach(function (index) {
                    options.push(this.list[index].name);
                }.bind(this));
                this.search_options = options;
            },
            handleSearchOptionClicked: function (index, event) {
                event.preventDefault();
                this.search_content = this.search_options[index];
                this.show_search_options = false;
                this.search_button_enable = true;
            },
            handleSearchButtonClicked: function (event) {
                event.preventDefault();
                if (this.search_content.length === 0) {
                    this.list = _list;
                } else {
                    var resultArr = _list.filter(function (obj) {
                        return obj.name == this.search_content;
                    }.bind(this));
                    this.list = resultArr;
                }
                this.$forceUpdate();
            },
            handlePreviousClicked: function (event) {
                event.preventDefault();
                if (this.current_page > 0) this.current_page--;
            },
            handleNextClicked: function (event) {
                event.preventDefault();
                if (this.current_page < this.list.length - 1) this.current_page++;
            },
            handleFirstClicked: function (event) {
                event.preventDefault();
                this.current_page = 0;
            },
            handleLastClicked: function (event) {
                event.preventDefault();
                this.current_page = this.page_count - 1;
            },
            clearSearchInput: function () {
                this.search_content = '';
            },
        }, 
        computed: {
            show_list: function() {
                let begin = this.current_page * itemsCountPerPage
                var result = this.list.slice(begin, begin + 50);

                var postData = {
                    'software_id': JSON.stringify(result.map(function (value) {
                        return value.software_id;
                    })),
                }
                postData[csrf_token] = csrf_hash;

                $.ajax({
                    url: search_endpoint,
                    data: postData,
                    method: 'POST',
                    success: function (data) {
                        if (data['success'] === true) {
                            for (var i = 0; i < this.show_list.length; ++i) {
                                var obj = data[i];

                                this.show_list[i].currency = obj.currency;
                                this.show_list[i].price = obj.price / 100;
                                this.show_list[i].min_sale = obj.min_sale / 100;
                            }
                        } else {
                            console.log(data.message);
                        }
                    }.bind(this)
                });
                return result;
            },
            page_count: function() {
                return this.list.length / itemsCountPerPage;
            },
            number_list: function() {
                var tmp = this.current_page;
                var result = [tmp - 2, tmp - 1, tmp, tmp + 1, tmp + 2];
                result = result.filter(function (value) {
                    return value >= 0 && value < this.page_count;
                }.bind(this));
                return result;
            },
            show_left_arrow: function () {
                return this.current_page > 0;
            },
            show_right_arrow: function () {
                return this.current_page < this.page_count - 1;
            },
            show_first_btn: function () {
                return this.current_page >= 3;
            },
            show_last_btn: function () {
                return this.current_page < this.page_count - 3;
            },
        }
    });
}
