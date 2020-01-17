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
                <button class="btn btn-lg btn-warning btn-block">Sign up</button>
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
                                <td class="orders-order text-right"><span class="c24966">Weekday</span></td>
                                <td>

                                    <div class="input-group">
                                        <input type="date" placeholder="" class="form-control" for="week_day"
                                               id="week_day" v-model="data.week_day" required/>
                                        <a href="#" class="input-group-addon"><span
                                                class="glyphicon glyphicon-calendar"></span></a>
                                    </div>
                                </td>
                                <td class="text-right"><span class="c24966">Shipper</span></td>
                                <td class="orders-order">
                                    <select name="selectedShipper" id="selectedShipper" v-model="data.selectedShipper"
                                            class="form-control">
                                        <option value=""></option>
                                        <option v-for="name in shipperNames" :value="name">
                                            {{ name }}
                                        </option>
                                    </select>
                                </td>
                                <td class="text-right"><span class="c24966">Status</span></td>
                                <td class="orders-order">
                                    <select name="status" id="status" v-model="data.status"
                                            class="form-control" required>
                                        <option value=""></option>
                                        <option value="complete"></option>
                                        <option value="incomplete"></option>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td class="text-right"><span class="c24966">Stack Point</span></td>
                                <td class="orders-order">
                                    <input type="text" placeholder="" class="form-control" for="stack_point"
                                           v-model="data.stack_point"
                                           id="stack_point"/>
                                </td>
                                <td class="orders-product text-right"><span
                                        class="c25479 text-right">~  Down Point</span>
                                </td>
                                <td class="orders-date">
                                    <input id="down_point" for="down_point" type="text" placeholder=""
                                           class="form-control"
                                           v-model="data.down_point" required/>
                                </td>
                                <td class="text-right"><span class="c24966">Vehicle No.</span></td>
                                <td class="orders-order">
                                    <select type="text" placeholder="" class="form-control" id="vehicle_no"
                                           v-model="data.vehicle_no"/>
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
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="270">
            <e-columns>
                <e-column field='item_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
                <e-column field='status' headerText='Status' width="100"></e-column>
                <e-column field='stack_date' headerText='Stack date' width="150"></e-column>
                <e-column field='stack_time' headerText='Stack Time' width="150"></e-column>
                <e-column field='shipper_name' headerText='Shipper name'  width="150"></e-column>
                <e-column field='stack_point' textAlign="Stack point" headerText='Stack point'  editType= 'numericedit' width="150"></e-column>
                <e-column field='down_point' headerText='Down point' width="200"></e-column>
                <e-column field='item_price' headerText='Item price' width="200"></e-column>
                <e-column field='item_remarks' headerText='Remarks' width="200"></e-column>

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
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            shipperNameUrl: {type: String, required: true},
            vehicleUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
        },
        data() {
            return {
                data: {
                    vehicle_no: '',
                    status: '',
                    week_day: '',
                    stack_point: '',
                    down_point: '',
                    selectedShipper: '',
                    shipperNames: [],
                    item_remark: '',
                    remember_token: '',
                    mode: 'normal',
                },
                shippers: [],
                vehicles: [],
            }

        },
        mounted() {
            alert("ishladi");
            this.fetchData(this.resourceUrl);
            this.fetchShippers(this.shipperNameUrl);
            this.fetchVehicles(this.vehicleUrl);
        },
        methods: {

            fetchShippers(url) {
                axios.get(url)
                    .then(response => {
                        this.shippers = response.data;
                    });
            },
            fetchVehicles(url) {
                axios.get(url)
                    .then(response => {
                        this.vehicles = response.data
                    });
            },
             search(){
             return this.fetchData(this.resourceUrl+'?name='+this.selectedShipper
             );
             },
             clear(){
             this.selectedShipper = '';

             },

        }
    }
</script>
<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";

</style>