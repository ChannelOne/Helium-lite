var itemsCountPerPage = 50;
var pageSplitCount = 4;
var searchCount = 5;

function handleBasicList(_list, currency, search_endpoint, edit_endpoint, 
    csrf_token, csrf_hash) {

    Vue.filter('price', function (value) {
        return parseInt(value).toFixed(2);
    });

    function search(content, list) {
        if (content.length < 4) {
            return [];
        }
        return list.filter(function (value) {
            return value.indexOf(content) >= 0;
        });
    }

    var vm = new Vue({
        el: "#app",
        data: function() {
            return {
                list: _list,
                currency: currency,
                current_page: 0,
                search_options: [],
                search_content: '',
            };
        },
        beforeMount: function () {
            this.$watch('search_content', function (newValue, oldValue) {
                newValue = newValue.toLowerCase();
                var _list = this.list.map(function (value) { 
                    return value.name.toLowerCase();
                });
                this.search_options = search(newValue, _list).slice(0, searchCount);
            }.bind(this));
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
                var obj = this.show_list[index];
                var postData = {
                    software_id: obj.software_id,
                    price: obj.price,
                    currency: obj.currency,
                    min_sale: obj.min_sale,
                };
                postData[csrf_token] = csrf_hash;
                $.ajax({
                    url: edit_endpoint,
                    method: 'POST',
                    data: postData,
                    success: function (data) {
                        this.show_list[index].is_editing = false;
                    }.bind(this),
                    error: function (data) {
                        console.error(data);
                    }.bind(this),
                })
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
            }
        }, 
        computed: {
            show_list: function() {
                let begin = this.current_page * itemsCountPerPage
                var result = this.list.slice(begin, begin + 50);
                result.forEach(function(element, index) {
                    var postData = {
                        'software_id': element.software_id,
                    };
                    postData[csrf_token] = csrf_hash;
                    $.ajax({
                        url: search_endpoint,
                        data: postData,
                        method: 'POST',
                        success: function (data) {
                            if (data['success'] === true) {
                                var obj = data['0'];
                                for (var key in obj) {
                                    this.show_list[index][key] = obj[key];
                                }
                            } else {
                                console.log(data);
                            }
                        }.bind(this),
                    });
                }, this);
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
