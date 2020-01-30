<template>
    <div>

        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">Back</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2">
                <a :href="registrationUrl"
                   class="btn btn-lg btn-warning btn-block">Register</a>
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
                                <td class="orders-order text-right"><span class="c24966">Stack Date</span></td>
                                <td>

                                    <div class="input-group">
                                        <input type="date" placeholder="" class="form-control" for="stack_date"
                                               id="week_day" v-model="stack_date"/>
                                    </div>
                                </td>
                                <td class="text-right"><span class="c24966">Shipper</span></td>
                                <td class="orders-order">
                                    <select name="selectedShipper" id="selectedShipper" v-model="shipper_name"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="shipper in shippers" :value="shipper.shipper_name">
                                            {{ shipper.shipper_name }}
                                        </option>
                                    </select>
                                </td>
                                <td class="text-right"><span class="c24966">Status</span></td>
                                <td class="orders-order">
                                    <select name="status" id="status" v-model="status"
                                            class="form-control">
                                        <option value=""></option>
                                        <option value=1>Completed</option>
                                        <option value=0>Incomplete</option>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td class="text-right"><span class="c24966">Stack Point</span></td>
                                <td class="orders-order">
                                    <input type="text" placeholder="" class="form-control" for="stack_point"
                                           v-model="stack_point"
                                           id="stack_point"/>
                                </td>
                                <td class="orders-product text-right"><span
                                        class="c25479 text-right">~  Down Point</span>
                                </td>
                                <td class="orders-date">
                                    <input id="down_point" for="down_point" type="text" placeholder=""
                                           class="form-control"
                                           v-model="down_point"/>
                                </td>
                                <td class="text-right"><span class="c24966">Vehicle No.</span></td>
                                <td class="orders-order">
                                    <select name="vehicleNo" id="vehicle_no" v-model="vehicle_no"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="vehicle in vehicles" :value="vehicle.vehicle_no">
                                            {{ vehicle.vehicle_no }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Clear</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <ejs-grid :dataSource="data" :actionBegin="actionBegin" :allowSelection='true'
                  ref="grid" id="grid" :allowSorting="true" :editSettings='editSettings' :toolbar='toolbar' >
            <e-columns>
                <e-column field='item_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='status' :allowEditing= 'false'  headerText='Status' width="120" textAlign="Center"
                          :template="actionTemplate"></e-column>
                <e-column field='stack_date' :allowEditing= 'false' headerText='Stack date' width="150"></e-column>
                <e-column field='stack_time' :allowEditing= 'false' headerText='Stack Time' width="150"></e-column>
                <e-column field='shipper_name' :allowEditing= 'false' headerText='Shipper name'  width="150"></e-column>
                <e-column field='stack_point' :allowEditing= 'false' textAlign="Stack point" headerText='Stack point' width="150"></e-column>
                <e-column field='down_point' :allowEditing= 'false' headerText='Down point' width="200"></e-column>
                <e-column field='item_price' :allowEditing= 'false' headerText='Item price' width="200"></e-column>
                <e-column field='item_remark' :allowEditing= 'false' headerText='Remarks' width="200"></e-column>
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
            title: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                self: this,
                vehicle_no: '',
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
                            <div v-if="data.status != 0">
                                <ejs-button v-on:click.native='show(data.item_id)' cssClass='e-primary'>Complete
                                </ejs-button>
                            </div>
                            <div v-else>
                                <ejs-button cssClass='e-info' data-toggle="modal" data-target="#updateStatusModal">
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
                                            </div>
                                            <div class="modal-body">
                                                <div class="">
                                                    <br class="form-group text-center d-flex justify-content-around">
                                                    <h3>What is your choice?</h3>
                                                    <div id="radio-group" class="col-md-4">
                                                        <section>
                                                            <input type="radio" v-model="substatus" value="0"> Set the date of
                                                            departure to the date of completion of transportation<br>
                                                            <input type="radio" v-model="substatus" value="1"> Set today as the
                                                            transportation completion date
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-around mt-2">
                                                <button type="button" class="btn btn-danger" @click="statusUpdate">
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
                        `,
                        props: {
                            substatus: '',
                        },
                        data() {
                            return {
                                data:
                                    {

                                        data: {}
                                    }
                            };
                        },
                        methods: {
                            show: function (id) {
                                alert('status of item with id ' + id  + ' will be updated to 0');
                            }
                        }
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
                    window.location.href = `/item/edit?item_id=` + args.rowData['item_id'];
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
                    + '&vehicle_no=' + this.vehicle_no
                    + '&status=' + this.status
                    + '&stack_date=' + this.stack_date
                    + '&stack_point=' + this.stack_point)
            },
            clear(){
                this.stack_date = '';
                this.search();
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
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
