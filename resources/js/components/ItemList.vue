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
                                    <select name="selectedShipper" id="selectedShipper" v-model="shipper_id"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                            {{ shipper.shipper_name1 }}
                                        </option>
                                    </select>
                                </td>
                                <td class="text-right"><span class="c24966">Status</span></td>
                                <td class="orders-order">
                                    <select name="status" id="status" v-model="status"
                                            class="form-control">
                                        <option value=""></option>
                                        <option value="complete">Completed</option>
                                        <option value="incomplete">Incomplete</option>
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
        <ejs-grid :dataSource="data" :enableHover='false' :allowSelection='false'
                  :queryCellInfo='customiseCell' ref="grid" id="grid">
            <e-columns>
                <e-column field='item_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='status' headerText='Status' width="100"></e-column>
                <e-column field='stack_date' headerText='Stack date' width="150"></e-column>
                <e-column field='stack_time' headerText='Stack Time' width="150"></e-column>
                <e-column field='shipper_name' headerText='Shipper name'  width="150"></e-column>
                <e-column field='stack_point' textAlign="Stack point" headerText='Stack point' width="150"></e-column>
                <e-column field='down_point' headerText='Down point' width="200"></e-column>
                <e-column field='item_price' headerText='Item price' width="200"></e-column>
                <e-column field='item_remark' headerText='Remarks' width="200"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>
<script>
    import Vue from "vue";
    import { VueSimpleAlert } from "vue-simple-alert";
    import { GridPlugin, Sort, Freeze, Toolbar, Edit } from '@syncfusion/ej2-vue-grids';

    Vue.use( GridPlugin );
    Vue.use( VueSimpleAlert );

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
                vehicle_no: '',
                status: '',
                stack_date: '',
                stack_point: '',
                down_point: '',
                shipper_id: '',
                mode: 'normal',
                shippers: [],
                vehicles: [],
            }
        },
        mounted() {
            this.fetchShippers(this.shipperUrl);
            this.fetchVehicles(this.vehicleUrl);
        },
        methods: {
            actionBegin(args){
                if(args.requestType == 'edit'){
                    this.editVehicle(args.data);
                }
            },
            customiseCell: function(args) {
                if (args.column.field == 'status') {
                    if (args.data['status'] === 1) {
                        args.cell.classList.add('complete');
                        args.data['status'] = 'Complete';
                    } else if (args.data['status'] === 0) {
                        args.cell.classList.add('incomplete');
                        args.data['status'] = 'Incomplete';
                    }
                }
            },
            editVehicle(vehicle){
                // redirect to edit.blade.php
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
            edit(){
                this.setEditMode('editing');
                this.$refs.grid.refresh();
            },
            search(){
                return this.fetchItem(this.itemUrl
                    +'?shipper_id=' + this.shipper_id
                    + '&vehicle_no=' + this.vehicle_no
                    + '&status=' + this.status
                    + '&stack_date=' + this.stack_date
                    + '&stack_point=' + this.stack_point)
            },
            clear(){
                this.stack_date = '';
                this.search();
            },
            setEditMode(editMode){
                if(editMode === 'normal'){
                    this.$refs.grid.ej2Instances.setProperties({
                        toolbar: null,
                        editSettings: {
                            allowDeleting: false,
                            allowEditing: false,
                            allowAdding: false,
                        },
                    });
                }
                let toolbarBtns = ['Edit','Delete','Update','Cancel'];
                this.$refs.grid.ej2Instances.setProperties({
                    toolbar: toolbarBtns,
                    editSettings: {
                        allowDeleting: true,
                        allowEditing: true,
                        allowAdding: true,
                        showDeleteConfirmDialog: true,
                    },
                });
                this.$refs.grid.refresh();
                this.mode = editMode;
            },
        },
        provide: {
            grid: [Sort,Freeze,Edit,Toolbar]
        },
        name: 'ItemTable'
    }
</script>
<style>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/material.css";
    .complete {
        background-color: CornflowerBlue;
    }
    .incomplete {
        background-color: firebrick;
    }
</style>
