<div id="app">

    <form class="form-inline">
        <input 
            v-model="search_content"
            type="text" 
            class="form-control" 
            v-on:input="handleSearchInput"
            placeholder="Search"/>
        <span class="search-box-close" 
            v-show="search_content.length !== 0"
            v-on:click="clearSearchInput"><i class="fa fa-close"></i></span>
        <ul v-show="show_search_options" class="search-list">
            <li v-for="(item, index) in search_options" 
                v-on:click="handleSearchOptionClicked(index, $event)">
                {{ item }}
            </li>
        </ul>
        <button class="btn btn-primary"
            v-bind:class="{'disabled': !search_button_enable}" 
            v-on:click="handleSearchButtonClicked($event)"
            role="button">Search</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Software</th>
                <th>Price</th>
                <th>Currency</th>
                <th>Min Sale</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in show_list">
                <th>{{ item.name }}</th>

                <td align="right" v-if="!item.is_editing">{{ item.price | price }}</td>
                <td v-else><input type="number" v-model="item.price" /></td>

                <td v-if="!item.is_editing">{{ item.currency }}</td>
                <td v-else>
                    <select v-model="item.currency">
                        <option v-for="item in currency">{{ item }}</option>
                    </select>
                </td>

                <td align="right" v-if="!item.is_editing">{{ item.min_sale | price }}</td>
                <td v-else><input type="number" v-model="item.min_sale" /></td>

                <td>
                    <a v-if="!item.is_editing" v-on:click="editItem(index, $event)" href="#">Edit</a>
                    <a v-else v-on:click="saveItem(index, $event)" href="#">Save</a>
                </td>
            </tr>
        </tbody>
    </table>

    <nav id="navbar" aria-label="Page navigation">
    <ul class="pagination">
        <li v-if="show_first_btn">
            <a href="#" v-on:click="handleFirstClicked">First</a>
        </li>

        <li>
        <a v-if="show_left_arrow" v-on:click="handlePreviousClicked" 
            href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
        </a>

        <li v-for="number in number_list" v-bind:class="{ active : number == current_page }">
            <a v-on:click="turnToPage(number, $event)" href="#">{{ number + 1 }}</a>
        </li>

        <li>
        <a v-if="show_right_arrow" v-on:click="handleNextClicked" 
            href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
        </a>
        </li>

        <li v-if="show_last_btn">
            <a href="#" v-on:click="handleLastClicked">Last</a>
        <li>
    </ul>
    </nav>

</div>

<script>

function turnToList(software_map) {
    let result = [];
    for (var key in software_map) {
        let value = software_map[key];
        value['id'] = key;
        value['price'] = 0;
        value['currency'] = 'CNY';
        value['min_sale'] = 0;
        value['is_editing'] = false;
        result.push(value);
    }
    return result;
}

var currency = <?php echo json_encode($currency); ?>;
var privilege = <?php echo json_encode($privilege); ?>;
var a = <?php echo $software_id_json ?>;
a = turnToList(a);
var search_endpoint = "<?php echo $search_endpoint; ?>",
    edit_endpoint= "<?php echo $edit_endpoint ?>";
var csrf_token = "<?php echo $csrf_token ?>",
    csrf_hash = "<?php echo $csrf_hash ?>";

document.addEventListener("DOMContentLoaded", function(event) { 
    handleBasicList(a, currency, search_endpoint, edit_endpoint, privilege, csrf_token, csrf_hash);
});
</script>
