<template>
    <div id="item-list">

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
                   class="btn btn-lg btn-danger btn-block">{{__('common.register')}}</a>
            </div>
        </div>
        <div class="row mt-2">
            <form @submit.prevent="search" role="form" class="ml-2">
                <table class="table table-sm table-borderless">
                    <tbody >
                    <tr>
                        <td class="text-right">{{__('item.stack_date')}}</td>
                        <td>
                            <datepicker v-model="stack_date" :bootstrap-styling="true" id="stack_date" name="stack_date"
                                        :typeable="true" :format="options.weekday" :clear-button="true"
                                        :language="options.language.ja">
                            </datepicker>
                        </td>
                        <td class="text-right"><span class="c24966">{{__('item.shipper')}}</span></td>
                        <td>
                            <select name="selectedShipper" id="selectedShipper" v-model="shipper_name"
                                    class="form-control">
                                <option value=""></option>
                                <option v-for="shipper in shippers" :value="shipper.shipper_name">
                                    {{ shipper.shipper_name }}
                                </option>
                            </select>
                        </td>
                        <td class="text-right"><span class="c24966">{{__('item.status')}}</span></td>
                        <td>
                            <select name="status" id="status" v-model="status"
                                    class="form-control">
                                <option value=""></option>
                                <option value="1">{{__('item.completed')}}</option>
                                <option value="0">{{__('item.incomplete')}}</option>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td class="text-right"><label for="stack_point">{{__('item.stack_point')}}</label></td>
                        <td>
                            <input type="text" class="form-control"
                                   v-model="stack_point"
                                   id="stack_point"/>
                        </td>
                        <td class="text-right"><span class="c25479 text-right">{{__('item.down_point')}}</span> </td>
                        <td>
                            <input id="down_point" type="text" placeholder=""
                                   class="form-control"
                                   v-model="down_point"/>
                        </td>
                        <td class="text-right">{{__('item.vehicle_no')}}</td>
                        <td>
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
                            <input type="text" id="resourceUrl"
                                   :value="resourceUrl" hidden/>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>

        <ejs-grid :dataSource="data" :actionBegin="actionBegin" :allowSelection='true'
                  ref="grid" id="grid" :allowSorting="true" :editSettings='editSettings' :toolbar='toolbar'
                  :height="280">
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
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    Vue.use(ButtonPlugin);
    Vue.use( GridPlugin );
    Vue.use( VueSimpleAlert );
    Vue.use(DialogPlugin);

    export default{
        name: 'ItemList',
        components: {
            Datepicker
        },
        props: {
            itemUrl: {type: String, required: true},
            backUrl: {type: String, required: true},
            shipperUrl: {type: String, required: true},
            vehicleUrl: {type: String, required: true},
            registrationUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true},
            itemEditUrl: {type: String, required: true},
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
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
                actionTemplate:function () {
                return {
                    template: Vue.component('editOption', {
                        template:
                        `
                            <div v-if="data.status === 1">
                                <ejs-button v-on:click.native='toIncomplete(data.item_id,data.stack_date)' cssClass='e-info'>{{__('item.complete')}}
                                </ejs-button>
                            </div>
                            <div v-else>
                                <div v-if="data.stack_date == getDate()">
                                    <ejs-button v-on:click.native='setTodayAsCompletion(data.item_id)' cssClass='e-primary'>{{__('item.incomplete')}}
                                    </ejs-button>
                                </div>
                                <div v-else>
                                    <ejs-button cssClass='e-primary' data-toggle="modal" data-target="#updateStatusModal">
                                        {{__('item.incomplete')}}
                                    </ejs-button>
                                    <div class="modal" id="updateStatusModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title">{{__('item.update_the_status_of_item_transportation')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>
                                                <div class="modal-body">
                                                    <div >
                                                        <br class="form-group text-center d-flex justify-content-around">
                                                        <h3>{{__('item.what_is_your_choice')}}</h3>
                                                        <div id="radio-group" class="col-md-4">
                                                            <form>
                                                                <input type="radio" v-model="stat" name="stat" v-bind:value="data.stack_date"> {{__('item.set_the_date_of_departure_as_the_date_of_completion_of_transportation')}}<br>
                                                                <input type="radio" v-model="stat" name="stat" v-bind:value="getDate()"> {{__('item.set_today_as_the_transportation_completion_date')}}
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-around mt-2">
                                                    <button type="button" class="btn btn-danger" @click="checkStatus(data.item_id)">
                                                        {{__('common.register')}}
                                                    </button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                        {{__('common.cancel')}}
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
                                resourceUrl: document.getElementById('resourceUrl').value,
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
                                    axios.get(this.resourceUrl + '/toIncomplete?id='+id)
                                        .then(response => {
                                            this.showSuccessDialog(this.__('item.status_of_selection_is_changed_to_incomplete_when_stack_and_current_dates_are_not_same'));
                                            this.data.status = 0;
                                            this.data.item_completion_date = null;
                                        })
                                        .catch(error=>{
                                            this.showDialog(error);
                                        });
                                }
                            },
                            setTodayAsCompletion: function (id) {
                                axios.get(this.resourceUrl + '/setTodayAsCompletion?id='+id)
                                    .then(response=>{
                                        this.showSuccessDialog(this.__('item.status_of_selection_is_changed_to_complete_and_today_is_set_as_completion_date'));
                                        $('#updateStatusModal').modal('hide');
                                        this.data.status = 1;
                                        this.data.item_completion_date = this.getDate();
                                    })
                                    .catch(error=>{
                                        this.errorDialog(error);
                                    });
                            },
                            setDeptDateAsCompletion: function (id) {
                                axios.get(this.resourceUrl + '/setDeptDateAsCompletion?id='+id)
                                    .then(response => {
                                        this.showSuccessDialog(this.__('item.status_of_selection_is_changed_to_complete_and_stack_date_is_set_as_completion_date'));
                                        $('#updateStatusModal').modal('hide');
                                        this.data.status = 1;
                                        this.data.item_completion_date = this.data.stack_date;
                                    })
                                    .catch(error=>{
                                        this.errorDialog(error);
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
                                    title: this.__('messages.info_message'),
                                    text: text,
                                    type: "success",
                                    timer: 5000
                                })
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
                    window.location.href = this.itemEditUrl + `?item_id=` + args.rowData['item_id'];
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
                let stack_date = this.stack_date;
                console.log(typeof stack_date);
                let string_stack_date = "";
                if(typeof stack_date === "object" && stack_date !== null)
                    string_stack_date = stack_date.getFullYear()+'/'+(stack_date.getMonth()+1)+'/'+stack_date.getDate();
                return this.fetchItem(this.itemUrl
                    +'?shipper_name=' + this.shipper_name
                    + '&vehicle_no3=' + this.vehicle_no3
                    + '&status=' + this.status
                    + '&stack_date=' + string_stack_date
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
    }
</script>
<style scoped>

</style>
