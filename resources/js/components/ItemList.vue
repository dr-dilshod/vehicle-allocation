<template>
    <div>

        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">{{__('common.back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2">
                <a :href="registrationUrl"
                   class="btn btn-lg btn-warning btn-block">{{__('common.register')}}</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 ">

                <div class="table-responsive">
                    <form action="#" class="form-inline" @submit.prevent="search">
                        <table class="table table-sm table-nowrap card-table">
                            <thead>
                            <tr></tr>
                            </thead>
                            <tbody class="list">
                            <tr>
                                <td class="orders-order text-right"><span class="c24966">{{__('item.stack_date')}}</span></td>
                                <td>

                                    <div class="input-group">
                                        <input type="date" placeholder="" class="form-control" for="stack_date"
                                               id="week_day" v-model="stack_date"/>
                                    </div>
                                </td>
                                <td class="text-right"><span class="c24966">{{__('item.shipper')}}</span></td>
                                <td class="orders-order">
                                    <select name="selectedShipper" id="selectedShipper" v-model="shipper_name"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="shipper in shippers" :value="shipper.shipper_name">
                                            {{ shipper.shipper_name }}
                                        </option>
                                    </select>
                                </td>
                                <td class="text-right"><span class="c24966">{{__('item.status')}}</span></td>
                                <td class="orders-order">
                                    <select name="status" id="status" v-model="status"
                                            class="form-control">
                                        <option value=""></option>
                                        <option value=1>{{__('item.completed')}}</option>
                                        <option value=0>{{__('item.incomplete')}}</option>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td class="text-right"><span class="c24966">{{__('item.stack_point')}}</span></td>
                                <td class="orders-order">
                                    <input type="text" placeholder="" class="form-control" for="stack_point"
                                           v-model="stack_point"
                                           id="stack_point"/>
                                </td>
                                <td class="orders-product text-right"><span
                                        class="c25479 text-right">{{__('item.down_point')}}</span>
                                </td>
                                <td class="orders-date">
                                    <input id="down_point" for="down_point" type="text" placeholder=""
                                           class="form-control"
                                           v-model="down_point"/>
                                </td>
                                <td class="text-right"><span class="c24966">{{__('item.vehicle_no')}}</span></td>
                                <td class="orders-order">
                                    <select name="vehicleNo3" id="vehicle_no3" v-model="vehicle_no3"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="vehicle in vehicles" :value="vehicle.vehicle_no3">
                                            {{ vehicle.vehicle_no3 }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">{{__('common.search')}}</button>
                                </td>
                                <td>
                                    <button type="reset" class="btn btn-primary" @click.prevent="clear">{{__('common.clear')}}</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <ejs-grid :test="search" :dataSource="data" :actionBegin="actionBegin" :allowSelection='true' :recordDoubleClick="redirect"
                  ref="grid" id="grid" :allowSorting="true" :editSettings='editSettings' :toolbar='toolbar' >
            <e-columns>
                <e-column field='item_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='status' :allowEditing= 'false'  :headerText='__("item.status")' width="120" textAlign="Center"
                          :template="actionTemplate"></e-column>
                <e-column field='stack_date' :allowEditing= 'false' :headerText='__("item.stack_date")' width="150"></e-column>
                <e-column field='stack_time' :allowEditing= 'false' :headerText='__("item.stack_time")' width="150"></e-column>
                <e-column field='shipper_name' :allowEditing= 'false' :headerText='__("item.shipper_name")'  width="150"></e-column>
                <e-column field='stack_point' :allowEditing= 'false' textAlign="Stack point" :headerText='__("item.stack_point")' width="150"></e-column>
                <e-column field='down_point' :allowEditing= 'false' :headerText='__("item.down_point")' width="200"></e-column>
                <e-column field='item_price' :allowEditing= 'false' :headerText='__("item.item_price")' width="200"></e-column>
                <e-column field='item_remark' :allowEditing= 'false' :headerText='__("item.remarks")' width="200"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script>
    import Vue from "vue";
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';
    import { ButtonPlugin } from '@syncfusion/ej2-vue-buttons';
    import { DialogPlugin } from '@syncfusion/ej2-vue-popups';
    import {TableUtil} from "../utils/TableUtil";

    Vue.use(ButtonPlugin);
    Vue.use( GridPlugin );
    Vue.use( VueSimpleAlert );
    Vue.use(DialogPlugin);

    export default{
        name: 'ItemList',
        props: {
            itemUrl: {type: String, required: true},
            backUrl: {type: String, required: true},
            shipperUrl: {type: String, required: true},
            vehicleUrl: {type: String, required: true},
            registrationUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                vehicle_no3: '',
                self: this,
                status: '',
                stack_date: '',
                stack_point: '',
                down_point: '',
                shipper_name: '',
                mode: 'normal',
                shippers: [],
                vehicles: [],
                selected: {},
                editSettings: { allowEditing: true, allowAdding: false, allowDeleting: false},
                toolbar: ['Edit'],
                actionTemplate:function () {
                return {
                    template: Vue.component('editOption', {
                        template:
                        `
                            <div v-if="data.status === 1">
                                <ejs-button v-on:click.native='toIncomplete(data.item_id,data.stack_date)' cssClass='e-info'>Complete
                                </ejs-button>
                            </div>
                            <div v-else>
                                <div v-if="data.stack_date == getDate()">
                                    <ejs-button v-on:click.native='setTodayAsCompletion(data.item_id)' cssClass='e-primary'>Incomplete
                                    </ejs-button>
                                </div>
                                <div v-else>
                                    <ejs-button cssClass='e-primary' data-toggle="modal" data-target="#updateStatusModal">
                                        Incomplete
                                    </ejs-button>
                                    <div class="modal" id="updateStatusModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title">Update the status of item transportation</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <input type="text" v-model="this.data" v-bind="data" hidden>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="">
                                                        <br class="form-group text-center d-flex justify-content-around">
                                                        <h3>What is your choice?</h3>
                                                        <div id="radio-group" class="col-md-4">
                                                            <form>
                                                                <input type="radio" v-model="stat" name="stat" v-bind:value="data.stack_date"> Set the date of
                                                                departure as the date of completion of transportation<br>
                                                                <input type="radio" v-model="stat" name="stat" v-bind:value="getDate()"> Set today as the
                                                                transportation completion date
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-around mt-2">
                                                    <button type="button" class="btn btn-danger" @click="checkStatus(data.item_id)">
                                                        Register
                                                    </button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                </div>
                                                 <div class="d-flex justify-content-around mt-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `,
                        data() {
                            return {
                                data:{},
                                stat: '',
                            };
                        },
                        props: {
                            method: {
                                type: Function
                            },
                        },
                        methods: {
                            toIncomplete: function (id,departure_date) {
                                if (departure_date == this.getDate()) {
                                    const itemTable = this;
                                    axios.get('/item/toIncomplete?id='+id)
                                        .then(function(response){
                                            itemTable.showSuccessDialog("Status of Selection is changed to Incomplete when stack and current dates are not same.");
                                        })
                                        .catch(function(error){
                                            itemTable.showDialog(error.response.data);
                                        });
                                }
                            },
                            setTodayAsCompletion: function (id) {
                                const itemTable = this;
                                axios.get('/item/setTodayAsCompletion?id='+id)
                                    .then(function(response){
                                        itemTable.showSuccessDialog("Status of Selection is changed to Complete and Today is set as Completion Date.");
                                        $('#updateStatusModal').modal('hide');
                                    })
                                    .catch(function(error){
                                        itemTable.showDialog(error.response.data);
                                    });
                            },
                            setDeptDateAsCompletion: function (id) {
                                const itemTable = this;
                                axios.get('/item/setDeptDateAsCompletion?id='+id)
                                    .then(function(response){
                                        itemTable.showSuccessDialog("Status of Selection is changed to Complete and Stack Date is set as Completion Date.");
                                        $('#updateStatusModal').modal('hide');
                                    })
                                    .catch(function(error){
                                        itemTable.showDialog(error.response.data);
                                    });
                            },
                            checkStatus: function (id) {
                                if (this.stat == this.getDate()) {
                                    this.setTodayAsCompletion(id);
                                } else {
                                    this.setDeptDateAsCompletion(id);
                                }
                                this.$emit('test');
                            },
                            getDate () {
                                const toTwoDigits = num => num < 10 ? '0' + num : num;
                                let today = new Date();
                                let year = today.getFullYear();
                                let month = toTwoDigits(today.getMonth() + 1);
                                let day = toTwoDigits(today.getDate());
                                return `${year}-${month}-${day}`;
                            },
                            showSuccessDialog(text) {
                                this.$fire({
                                    title: "Info Message",
                                    text: text,
                                    type: "success",
                                    timer: 5000
                                }).then(r => {
                                    this.$parent.$refs.grid.refresh();
                                });
                            },
                            showDialog(response) {
                                let message = response.message + ': ';
                                let errors = response.errors;
                                $.each(errors, function (key, value) {
                                    message += value[0]; //showing only the first error.
                                });
                                this.$alert(message);
                            },
                        },
                    })
                }
            },
            }
        },
        mounted() {
            this.fetchShippers(this.shipperUrl);
            this.fetchVehicles(this.vehicleUrl);
        },
        methods: {
            redirect(e) {
                window.location.href = `/item/edit?item_id=` + e.rowData['item_id'];
            },
            actionBegin(args){
                if(args.requestType === 'beginEdit'){
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: [],
                        editSettings: {
                            allowDeleting: false,
                            allowEditing: false,
                            allowAdding: false,
                        },
                    });
                }
            },
            fetchItem(url) {
                let grid = this.$refs.grid.ej2Instances;
                axios.get(url)
                    .then(response => {
                        this.data = response.data;
                        if(this.data.length > 0)
                            grid.setProperties({
                                frozenColumns: 4
                            });
                        else
                            grid.setProperties({
                                frozenColumns: 0
                            });
                    })
            },
            fetchShippers() {
                axios.get(this.shipperUrl)
                    .then(response => {
                        this.shippers = response.data
                    });
            },
            fetchVehicles() {
                axios.get(this.vehicleUrl)
                    .then(response => {
                        this.vehicles = response.data
                    });
            },
            search(){
                return this.fetchItem(this.itemUrl
                    +'?shipper_name=' + this.shipper_name
                    + '&vehicle_no3=' + this.vehicle_no3
                    + '&status=' + this.status
                    + '&stack_date=' + this.stack_date
                    + '&stack_point=' + this.stack_point)
            },
            clear(){
                this.stack_date = '';
                this.vehicle_no3 = '';
                this.status = '';
                this.stack_date = '';
                this.stack_point = '';
                this.down_point = '';
                this.shipper_name = '';
                this.search();
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar],
        },
        name: 'ItemTable'
    }
</script>
<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import '../../../node_modules/@syncfusion/ej2-base/styles/material.css';
    @import '../../../node_modules/@syncfusion/ej2-buttons/styles/material.css';

</style>
