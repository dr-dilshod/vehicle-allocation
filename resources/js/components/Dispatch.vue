<template>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{ title }}</h2>
            </div>
            <div class="col-2">
                <p class="text-right">
                    <button id="registerBtn" @click="register" class="btn btn-lg btn-danger btn-block p-1 pl-2 pr-2">
                        Register
                    </button>
                </p>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-8 offset-2">
                <form action="#">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label for="dispatch_day">Dispatch day</label>
                                <input type="date" name="dispatch_day" id="dispatch_day" required class="p-1"
                                       v-model="dispatch_day">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <button class="btn btn-primary" id="display" @click="display">Display</button>
                                <button class="btn btn-primary" id="nextProduct" @click="nextProduct">Next day</button>
                                <button class="btn btn-primary" id="twoDaysLater" @click="twoDaysLater">Two days later
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <p class="text-right">
                    <button id="printBtn" @click="print" class="btn btn-lg btn-success btn-block p-1 pl-2 pr-2">Print
                    </button>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <h5 class="text-center pt-1">{{ firstList.date }}</h5>
                <draggable v-model="firstList.data" group="elems" @add="noAdd" class="elem-list">
                    <div v-for="item in firstList.data" :key="item.item_id" class="elem">
                        {{ item.shipper_name }} <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.down_point }} - {{ item.stack_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                        Remarks: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-2">
                <h5 class="text-center pt-1">{{ secondList.date }}</h5>
                <draggable v-model="secondList.data" group="elems" @add="noAdd" class="elem-list">
                    <div v-for="item in secondList.data" :key="item.item_id" class="elem">
                        {{ item.shipper_name }} <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.down_point }} - {{ item.stack_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                        Remarks: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-8">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th width="10%" class="text-center">Car No</th>
                        <th width="15%" class="text-center">Driver name</th>
                        <th width="25%" class="text-center">Morning</th>
                        <th width="25%" class="text-center">Noon</th>
                        <th width="25%" class="text-center">Next product</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(elem, idx) in thirdList" :key="elem.vehicle_no">
                        <td width="10%">{{elem.vehicle_no}}</td>
                        <td width="15%">
                            <div class="driver">
                                {{elem.driver_name}}
                                <button type="button" class="close" @click="removeRow(idx, elem)" aria-label="Close">
                                    <span aria-hidden="true" class="text-danger">&times;</span>
                                </button>
                            </div>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.morning" group="elems" @change="addMorning" handle=".none"
                                       style="display: block; min-height: 50px" class="morning" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.morning" :key="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    {{ item.shipper_name }} <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                                    Remarks: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.noon" group="elems" @change="addNoon" handle=".none"
                                       style="display: block; min-height: 50px" class="noon" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.noon" :key="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    {{ item.shipper_name }} <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                                    Remarks: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.nextProduct" group="elems" @change="addNextProduct" handle=".none"
                                       style="display: block; min-height: 50px" class="next-product" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.nextProduct" :key="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    {{ item.shipper_name }} <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                                    Remarks: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot slot="footer">
                    <tr>
                        <td colspan="5">
                            <button data-toggle="modal" data-target="#addDriverModal" class="btn btn-primary">Add
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal" id="addDriverModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">Add Driver</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group text-center d-flex justify-content-around">
                                <label for="driverName" class="pt-2">Driver name</label>
                                <input type="text" id="driverName" v-model="driver_search" class="form-control"
                                       style="width: calc(50%)"/>
                                <button class="btn btn-primary">Search</button>
                            </div>
                            <div class="driver-list">
                                <div class="row">
                                    <div class="col-2"><strong>Check</strong></div>
                                    <div class="col-4"><strong>Car no</strong></div>
                                    <div class="col-6"><strong>Driver name</strong></div>
                                </div>
                                <div class="driver-data">
                                    <div class="row p-1" v-for="driver in filteredDrivers">
                                        <div class="col-2">
                                            <input type="checkbox" v-model="tableDriverList" :value="driver.driver_id">
                                        </div>
                                        <div class="col-4">
                                            {{ driver.vehicle_no3 }}
                                        </div>
                                        <div class="col-6">
                                            {{ driver.driver_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around mt-2">
                            <button type="button" class="btn btn-danger" @click="registerDriver">Register</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import draggable from 'vuedraggable'

    export default{
        name: 'Dispatch',
        components: {
            draggable,
        },
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data(){
            return {
                drivers: [],
                driver_search: '',
                tableDriverList: [],
                firstList: [],
                secondList: [],
                thirdList: [
                    {
                        'driver_id': 11,
                        'vehicle_no': 1111,
                        'driver_name': "Driver A",
                        'morning': [
                            {
                                'item_id': 4,
                                'shipper_name': 'Pet West',
                                'stack_point': 'Nagoya',
                                'down_point': 'Gifu',
                                'down_date': '2019/12/09',
                                'down_time': '12:11',
                                'weight': 100000,
                                'empty_pl': 0,
                                'remarks': 'High-speed fee'
                            },
                        ],
                        'noon': [],
                        'nextProduct': [],
                    },
                    {
                        'driver_id': 12,
                        'vehicle_no': 1112,
                        'driver_name': "Driver B",
                        'morning': [],
                        'noon': [
                            {
                                'item_id': 5,
                                'shipper_name': 'Pet West',
                                'stack_point': 'Nagoya',
                                'down_point': 'Gifu',
                                'down_date': '2019/12/09',
                                'down_time': '12:11',
                                'weight': 100000,
                                'empty_pl': 1,
                                'remarks': 'High-speed fee'
                            },
                        ],
                        'nextProduct': [],
                    },
                    {
                        'driver_id': 14,
                        'vehicle_no': 1114,
                        'driver_name': "Driver C",
                        'morning': [],
                        'noon': [],
                        'nextProduct': [
                            {
                                'item_id': 6,
                                'shipper_name': 'Pet West',
                                'stack_point': 'Nagoya',
                                'down_point': 'Gifu',
                                'down_date': '2019/12/09',
                                'down_time': '12:11',
                                'weight': 100000,
                                'empty_pl': 1,
                                'remarks': 'High-speed fee'
                            },
                        ],
                    }
                ],
                dispatch_day: '',
            };
        },
        methods: {
            addMorning: function (evt) {
                let postData = {
                    timezone: 1,
                    item_id: evt.added.element.item_id,
                    driver_id: evt.added.element.driver_id,
                };
                axios.post('/api/dispatch',postData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                alert('morning');
                console.log(evt);
            },
            addNoon: function (evt) {
                let postData = {
                    timezone: 2,
                    item_id: evt.added.element.item_id,
                    driver_id: evt.added.element.driver_id,
                };
                axios.post('/api/dispatch',postData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                alert('noon');
                console.log(evt);
            },
            addNextProduct: function (evt) {
                let postData = {
                    timezone: 3,
                    item_id: evt.added.element.item_id,
                    driver_id: evt.added.element.driver_id,
                };
                axios.post('/api/dispatch',postData)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                alert('next');
                console.log(evt);
            },
            noAdd(evt){
                evt.preventDefault();
            },
            replace: function () {
                alert('replace');
            },
            register(){
                alert('register');
            },
            registerDriver(){
                let componentInstance = this;
                axios.post('/api/dispatch/third-list',componentInstance.tableDriverList)
                    .then(data => {
                        console.log(data.data);
//                        componentInstance.thirdList = data.data;
                    })
                    .catch(function(error){

                    });
                console.log(this.tableDriverList);
                alert('register driver');
            },
            print(){
                alert('print');
            },
            display(){
                alert('display');
            },
            nextProduct(){
                alert('next day');
            },
            twoDaysLater(){
                alert('Two days later');
            },
            removeRow(id, elem){
                console.log(elem);
                this.thirdList.splice(id, 1);
            },
            removeElem(id){
                alert(id + ' to be deleted');
            },
            fetchLists(){
                let componentInstance = this;
                axios.get(this.fetchUrl)
                    .then(result => {
//                        console.log(result);
                        this.firstList = result.data.first_list;
                        this.secondList = result.data.second_list;
                        this.drivers = result.data.drivers;
                    })
                    .catch(function (error) {
                        componentInstance.$alert(error.response.message);
                    });
                ;
            },
            fetchDriverTable(){
                let componentInstance = this;
                axios.get('/api/dispatch/third-list')
                    .then(data => {
                        componentInstance.thirdList = data.data;
                    })
                    .catch(function (error) {
                        componentInstance.$alert(error.response.message);
                    });
            }
        },
        mounted(){
            this.fetchLists();
        },
        computed: {
            filteredDrivers(){
                return this.drivers.filter((driver) => {
                    return driver.driver_name.match(this.driver_search);
                });
            }
        }
    }
</script>
<style scoped>
    .table {
        background: #fff;
    }

    .fixed-header tbody {
        display: block;
        overflow: auto;
        height: 370px;
        width: 100%;
    }

    .driver-list .driver-data {
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
        height: 150px;
        width: 100%;
    }

    .fixed-header thead tr {
        display: block;
    }

    .table th {
        vertical-align: middle;
    }

    .close {
        display: none;
    }

    .driver:hover .close {
        display: inline;
    }

    .elem:hover .close {
        display: inline;
    }

    .elem {
        background: lightblue;
        border-radius: 5px;
        margin: 4px;
    }

    .new {
        background: lightgreen;
    }

    .elem-list {
        background: #fff;
        height: 450px;
        overflow-y: scroll;
    }

    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: lightblue;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>