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
                                <button class="btn btn-primary" id="nextDay" @click="nextDay">Next day</button>
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
                <draggable v-model="firstList.data" group="elems" class="elem-list">
                    <div v-for="item in firstList.data" :key="item.item_id" class="elem">
                        {{ item.down_point }} <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.stack_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                        Remarks: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-2">
                <h5 class="text-center pt-1">{{ secondList.date }}</h5>
                <draggable v-model="secondList.data" group="elems" class="elem-list">
                    <div v-for="item in secondList.data" :key="item.item_id" class="elem">
                        {{ item.down_point }} <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.stack_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                        Remarks: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-8">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th width="10%">Car No</th>
                        <th width="15%">Driver name</th>
                        <th width="25%">Morning</th>
                        <th width="25%">Noon</th>
                        <th width="25%">Next day</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(elem, idx) in thirdList" :key="elem.vehicle_no">
                        <td width="10%">{{elem.vehicle_no}}</td>
                        <td width="15%">
                            <div class="driver">
                                <i class="fa fa-times close" @click="removeRow(idx)">x</i>
                                {{elem.driver_name}}
                            </div>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.morning" group="elems" @change="add"
                                       style="display: block; min-height: 50px">
                                <div class="elem" v-for="item in elem.morning" :key="item.item_id">
                                    {{ item.shipper }} <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                                    Remarks: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.noon" group="elems" style="display: block; min-height: 50px">
                                <div class="elem" v-for="item in elem.noon" :key="item.item_id">
                                    {{ item.shipper }} <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">PL available</span> <br>
                                    Remarks: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td width="25%">
                            <draggable :list="elem.nextDay" group="elems" style="display: block; min-height: 50px">
                                <div class="elem" v-for="item in elem.nextDay" :key="item.item_id">
                                    {{ item.shipper }} <br>
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
                            <button data-toggle="modal" data-target="#addDriverModal" class="btn btn-primary">Add</button>
                        </td>
                    </tr>
                    </tfoot>
                    </draggable>
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
                                <label for="yearMonth">Driver name</label>
                                <input type="text" v-model="driver_name" class="form-control" style="width: calc(50%)"/>
                                <button class="btn btn-primary">Search</button>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Car no</th>
                                        <th>Driver name</th>
                                    </tr>
                                </thead>
                                <tr v-for="driver in drivers">
                                    <td>{{ driver.car_no3 }}</td>
                                    <td>{{ driver.driver_name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex justify-content-around">
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
            const componentInstance = this;
            return {
                drivers: [
                    {
                        'car_no3': '1234',
                        'driver_name': 'Driver Abdulla',
                    },
                    {
                        'car_no3': '1235',
                        'driver_name': 'Driver Bakturdi',
                    },
                ],
                firstList: {
                    date: '25/01/2020',
                    data: [
                        {
                            'item_id': 1,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                        {
                            'item_id': 11,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                        {
                            'item_id': 12,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                        {
                            'item_id': 12,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                        {
                            'item_id': 14,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                    ]
                },
                secondList: {
                    date: '27/01/2020',
                    data: [
                        {
                            'item_id': 2,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 0,
                            'remarks': 'High-speed fee'
                        },
                        {
                            'item_id': 3,
                            'shipper': 'Pet West',
                            'stack_point': 'Nagoya',
                            'down_point': 'Gifu',
                            'down_date': '2019/12/09',
                            'down_time': '12:11',
                            'weight': 100000,
                            'empty_pl': 1,
                            'remarks': 'High-speed fee'
                        },
                    ]
                },
                thirdList: [
                    {
                        'vehicle_no': 1111,
                        'driver_name': "Driver A",
                        'morning': [
                            {
                                'item_id': 4,
                                'shipper': 'Pet West',
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
                        'nextDay': [],
                    },
                    {
                        'vehicle_no': 1112,
                        'driver_name': "Driver B",
                        'morning': [],
                        'noon': [
                            {
                                'item_id': 5,
                                'shipper': 'Pet West',
                                'stack_point': 'Nagoya',
                                'down_point': 'Gifu',
                                'down_date': '2019/12/09',
                                'down_time': '12:11',
                                'weight': 100000,
                                'empty_pl': 1,
                                'remarks': 'High-speed fee'
                            },
                        ],
                        'nextDay': [],
                    },
                    {
                        'vehicle_no': 1114,
                        'driver_name': "Driver C",
                        'morning': [],
                        'noon': [],
                        'nextDay': [
                            {
                                'item_id': 6,
                                'shipper': 'Pet West',
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
            add: function (evt) {
                alert('addddd');
                console.log(evt);
            },
            replace: function () {
                alert('replace');
            },
            register(){
                alert('register');
            },
            registerDriver(){
                alert('register driver');
            },
            print(){
                alert('print');
            },
            display(){
                alert('display');
            },
            nextDay(){
                alert('next day');
            },
            twoDaysLater(){
                alert('Two days later');
            },
            removeRow(id){
                this.thirdList.splice(id, 1);
            }
        },
        mounted(){

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

    .fixed-header thead tr {
        display: block;
    }

    .table th {
        vertical-align: middle;
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