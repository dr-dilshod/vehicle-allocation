<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" ref="editTitle">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" ref="registerBtn">Register
                </button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" ref="editBtn">Edit</button>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-md-9 offset-1">
                <div class="form-row form-horizontal">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="shipperSelect" class="col-4 col-form-label ">Shipper</label>
                            <div class="col-8">
                                <select name="shipper" id="shipperSelect" ref="shipperSelect" class="form-control">
                                    <option value="0">-- Select --</option>
                                    <option v-for="shipper in shippers" :value="shipper.id">
                                        {{shipper.shipper}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button v-on:click="search" class="btn btn-lg btn-primary btn-block p-1">Search</button>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button v-on:click="clear" class="btn btn-lg btn-primary btn-block p-1">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ejs-grid ref="grid" id="Grid" :dataSource="data"
                  :allowSorting="true" :editSettings="editSettings" :height="270"
                  :actionBegin="actionBegin" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='car_type' headerText='Car type'
                          editType='dropdownedit'
                          :edit="params.vehicleTypesParams"
                          :validationRules="rules.car_type"
                          width="200"></e-column>
                <e-column field='shipper_id' headerText='Shipper' editType='dropdownedit'
                          :edit="params.shippersParams"
                          width="200"></e-column>
                <e-column field='stack_point' headerText='Loading port' width="200"></e-column>
                <e-column field='down_point' headerText='Drop off' width="200"></e-column>
                <e-column field='type' headerText='Type' width="100"></e-column>
                <e-column field='price' headerText='Unit price' width="100"></e-column>
                <e-column field='price_id' headerText='Unit Price ID' width="5" :isPrimaryKey="true"
                          :visible=false></e-column>
                <e-column field='shipperId' headerText='Shipper ID' width="5"
                          :visible=false></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>

<script>
    import Vue from "vue";
    import {Edit, Freeze, GridPlugin, Sort, Toolbar} from '@syncfusion/ej2-vue-grids';
    import {DropDownListPlugin} from '@syncfusion/ej2-vue-dropdowns';
    import { Query } from '@syncfusion/ej2-data';
    import {TableUtil} from "../utils/TableUtil";
    Vue.use(GridPlugin);
    Vue.use(DropDownListPlugin);
    let shippers = [];
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
                tableUtil: null,
                toolbarBtns: null,
                editSettings: {
                    allowEditing: false,
                    allowAdding: false,
                    allowDeleting: false,
                    showDeleteConfirmDialog: true,
                },
                shippers: [],
                vehicle_type: [],
                data: [],
                params: {
                    shippersParams: {
                        params: {
                            allowFiltering: true,
                            dataSource: this.shippers,
                            fields: {text: "shipper", value: "id"},
                            query: new Query()
                        }
                    },
                    vehicleTypesParams: {
                        params: {
                            allowFiltering: true,
                            dataSource: this.vehicle_type,
                            fields: {text: "vehicle", value: "vehicle"},
                            query: new Query()
                        }
                    }
                },
                rules: {
                    car_type: {required: true}
                }
            }
        },
        created() {
            this.fetchShipperNames(`${this.resourceUrl}/shipper-names`);
            this.fetchVehicleTypes(`${this.resourceUrl}/vehicle-types`);
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.$refs.grid.hideSpinner();
        },
        methods: {
            search() {
                let id = this.$refs.shipperSelect.value;
                axios.get(`${this.resourceUrl}/${id}`)
                    .then(response => {
                        if (response.data && response.data.length > 0) {
                            this.data = response.data.map(e => {
                                return {
                                    price_id: e.price_id,
                                    car_type: e.car_type,
                                    shipperId: e.shipper_id,
                                    shipper_id: e.shipper.shipper_name1 + ' ' + e.shipper.shipper_name2,
                                    stack_point: e.stack_point,
                                    down_point: e.down_point,
                                    type: e.type,
                                    price: e.price
                                };
                            });
                            this.$refs.grid.refresh();
                        }
                    })
                    .catch(err => {
                        alert('aaa' + err);
                    });
            },
            clear() {
                this.$refs.shipperSelect.value = 0;
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
            fetchShipperNames(url) {
                axios.get(url)
                    .then(response => {
                        if (response.data.length > 0) {
                            this.shippers = response.data.map(e => {
                                return {shipper: e.shipper_name1 + ' ' + e.shipper_name2, id: e.shipper_id};
                            });
                        }
                    })
                    .catch(err => {
                        alert('wtf' + err);
                    });
            },
            fetchVehicleTypes(url) {
                axios.get(url)
                    .then(response => {
                        this.vehicle_type = response.data.map(e => {
                            return {
                                vehicle: e.vehicle_type
                            };
                        });
                    })
                    .catch(err => {
                        alert('Bu yer ' + err);
                    });
            },
            insertData(unitPrice) {
                axios.post(this.resourceUrl, unitPrice)
                    .then(response =>{
                        document.querySelector('#shipperSelect [value="' + response.data.shipper_id + '"]').selected = true;
                        this.search();
                        this.tableUtil.endEditing();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            updateData(unitPrice) {
                unitPrice = unitPrice.data;
                unitPrice.shipper_id = unitPrice.shipperId;
                axios.post(this.resourceUrl + '/' + unitPrice.price_id, unitPrice)
                    .then(response =>{
                        document.querySelector('#shipperSelect [value="' + response.data.shipper_id + '"]').selected = true;
                        this.search();
                        this.tableUtil.endEditing();
                    })
                    .catch(function(error){
                        alert(error)
                    });
            },
            deleteData(id) {
                let tableUtil = this.tableUtil;
              axios.delete(this.resourceUrl + '/' + id)
              .then(response => {
                    this.tableUtil.endEditing();
              }).catch(err => {
                    alert(err);
              })
            },
            actionBegin(args) {
                console.log(args.requestType);
                if (args.requestType === 'save') {
                    if (args.hasOwnProperty('data') && args.data.hasOwnProperty('price_id') && args.data.price_id === undefined) {
                        this.insertData(args.data);
                    } else {
                        console.log(args);
                        this.updateData(args);
                    }
                } else if (args.requestType === 'delete') {
                    if(args.data[0].price_id !== undefined){
                        this.deleteData(args.data[0].price_id);
                    }
                } else if (args.requestType === 'beginEdit' || args.requestType === 'add') {
                    this.$refs.grid.getColumnByField('shipper_id').edit.params.dataSource = this.shippers;
                    this.$refs.grid.getColumnByField('car_type').edit.params.dataSource = this.vehicle_type;
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
