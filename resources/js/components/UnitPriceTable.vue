<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" v-if="this.mode === 'editing'">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register"
                        :disabled="this.mode !== 'editing'">Register
                </button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-md-9 offset-1">
                <div class="form-row form-horizontal">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="shipperSelect" class="col-4 col-form-label ">Shipper</label>
                            <div class="col-8">
                                <select name="shipper" id="shipperSelect" class="form-control">
                                    <option value="0">-- Select --</option>
                                    <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                        {{shipper.shipper_name1 + ' ' + shipper.shipper_name2}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block p-1">Search</button>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block p-1">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ejs-grid ref="grid" id="Grid" :dataSource="data"
                  :allowSorting="true" :editSettings="editSettings" :height="270"
                  :actionBegin="actionBegin" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='vehicle_type' headerText='Car type' :editTemplate="vehicleTypeEditTemplate"
                          width="200"></e-column>
                <e-column field='shipper_name1' headerText='Shipper' :editTemplate="shipperEditTemplate"
                          width="200"></e-column>
                <e-column field='stack_point' headerText='Loading port' width="200"></e-column>
                <e-column field='down_point' headerText='Drop off' width="200"></e-column>
                <e-column field='type' headerText='Type' width="100"></e-column>
                <e-column field='price' headerText='Unit price' width="100"></e-column>
                <e-column field='price_id' headerText='Unit Price ID' width="5" :isPrimaryKey="true"
                          :visible=false></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>s

<script>
    import Vue from "vue";
    import {Edit, Freeze, GridPlugin, Sort, Toolbar} from '@syncfusion/ej2-vue-grids';
    import {DropDownListPlugin} from '@syncfusion/ej2-vue-dropdowns';

    Vue.use(GridPlugin);
    Vue.use(DropDownListPlugin);
    export default {
        name: "UnitPriceTable",
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true}
        },
        data() {
            return {
                mode: 'normal',
                toolbarBtns: null,
                editSettings: {
                    allowEditing: true,
                    allowAdding: true,
                    allowDeleting: true,
                    showDeleteConfirmDialog: true,
                },
                shippers: [],
                data: []
            };
        },
        mounted() {
            this.fetchData(this.resourceUrl);
            this.fetchShipperNames(`${this.resourceUrl}/shipper-names`);
            this.$refs.grid.hideSpinner();
        },
        methods: {
            vehicleTypeEditTemplate() {
                return {
                    template: Vue.component('vehicle-types', {
                        template: `
                            <ejs-dropdownlist id='dropdownlist' placeholder='Select vehicle type'
                                              :dataSource='vehicle_type' :fields='fields'></ejs-dropdownlist>
                        `,
                        data() {
                            return {
                                vehicle_type: [],
                                fields: {text: 'VehicleType', value: 'Id'},
                            };
                        },
                        beforeMount() {
                            this.fetchVehicleTypes(`/api/unit-price/vehicle-types`);
                        },
                        methods: {
                            fetchVehicleTypes(url) {
                                axios.get(url)
                                    .then(response => {
                                        this.vehicle_type = response.data.map(e => {
                                            return {VehicleType: e.vehicle_type, Id: e.driver_id};
                                        });
                                    })
                                    .catch(err => {
                                        alert('Bu yer ' + err);
                                    });
                            },
                        }
                    })
                };
            },
            shipperEditTemplate() {
                return {
                    template: Vue.component('shipper-names', {
                        template: `
                            <ejs-dropdownlist id='shipperdrpdwn' placeholder='Select shipper'
                                              :dataSource='shippers' :fields='fields'></ejs-dropdownlist>
                        `,
                        data() {
                            return {
                                shippers: [],
                                fields: {text: 'Shipper', value: 'Id'},
                            };
                        },
                        beforeMount() {
                            this.fetchVehicleTypes(`/api/unit-price/shipper-names`);
                        },
                        methods: {
                            fetchVehicleTypes(url) {
                                axios.get(url)
                                    .then(response => {
                                        this.shippers = response.data.map(e => {
                                            return {Shipper: `${e.shipper_name1} ${e.shipper_name2}`, Id: e.shipper_id};
                                        });
                                    })
                                    .catch(err => {
                                        alert(err);
                                    });
                            },
                        }
                    })
                };
            },
            register() {
                this.$refs.grid.addRecord();
            },

            edit() {
                this.toolbarBtns = ['Edit', 'Delete', 'Update', 'Cancel'];
                this.mode = 'editing';
                this.editSettings.allowEditing = true;
                this.editSettings.allowDeleting = true;
            },
            fetchData(url) {
                axios.get(url)
                    .then(response => {
                        if (response.data && response.data.data && response.data.data.length > 0) {
                            this.data = response.data.data.map(e => {
                                return {
                                    price_id: e.price_id,
                                    vehicle_type: e.driver.vehicle_type,
                                    shipper_name1: e.shipper.shipper_name1 + ' ' + e.shipper.shipper_name2,
                                    stack_point: e.item.stack_point,
                                    down_point: e.item.down_point,
                                    type: e.type,
                                    price: e.price
                                };
                            });
                        }
                    })
                    .catch(err => {
                        alert(err);
                    });
            },
            fetchShipperNames(url) {
                axios.get(url)
                    .then(response => {
                        this.shippers = response.data;
                    })
                    .catch(err => {
                        alert(err);
                    });
            },
            actionBegin(args) {
                if (args.requestType === 'save') {
                    args.cancel = true;
                }
            }

        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-dropdowns/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-inputs/styles/bootstrap.css";
</style>
