<template>
    <div>
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <form action="#" class="form-inline" @submit.prevent="register">
                    <div class="col-8"></div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-lg btn-danger p-1 pl-2 pr-2">Register</button>
                        <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="clear">Clear</button>
                    </div>
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                         <tr></tr>
                        </thead>
                        <tbody class="list">
                        <tr>
                            <td class="orders-order text-right"><span class="c24966">Stack Date</span></td>
                            <td>
                                <div class="input-group">
                                        <input  type="date" placeholder="" class="form-control" for="stack_date"
                                                id="stack_date" v-model="itemData.stack_date" required/>
                                    </div>
                            </td>
                            <td class="text-right"><span class="c25479">Stack Time</span></td>
                            <td class="stack_time_hour">
                                <input type="time" placeholder="" class="form-control" for="stack_time"
                                       id="stack_time" v-model="itemData.stack_time" required/>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-date">
                            </td>
                            <td class="orders-total"><span class="c25479">Billing</span></td>
                            <td class="orders-status"></td>
                            <td class="orders-method">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="billing"
                                           v-model="itemData.down_invoice">
                                    <label class="custom-control-label" for="billing"></label>
                                </div>
                            </td>
                            <td class="text-right">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Down Date</span></td>
                            <td class="orders-order">
                                <div class="input-group">
                                    <input type="date" placeholder="" class="form-control" for="down_date"
                                       id="down_date" v-model="itemData.down_date" required/>
                                </div>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">Down Time</span></td>
                            <td class="orders-date">
                                <input type="time" placeholder="" class="form-control" for="down_time"
                                       id="down_time" v-model="itemData.down_time" required/>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-total">
                            </td>
                            <td class="item-status">
                                <div class="badge badge-success"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Vehicle Model</span></td>
                            <td class="orders-order">
                                <select name="vehicle_model" id="vehicle_model" v-model="itemData.vehicle_model"
                                        class="form-control" required>
                                    <option value=""></option>
                                    <option value="Wing">Wing</option>
                                    <option value="Flat">Flat</option>
                                    <option value="Trailer">Trailer</option>
                                    <option value="Bulk">Bulk</option>
                                </select>
                            </td>
                            <td class="orders-product"></td>
                            <td class="orders-date"></td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Shipper</span></td>
                            <td class="orders-order">
                                <select name="shipper" id="shipper_id" v-model="itemData.shipper_id"
                                        class="form-control" required>
                                    <option value=""></option>
                                    <option v-for="shipper in shippers" :value="shipper.id">
                                        {{ shipper.shipper_name1 }}
                                    </option>
                                </select>
                            </td>
                            <td class="orders-product"></td>
                            <td class="orders-date"></td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Stack Point</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" for="stack_point"
                                       v-model="itemData.stack_point" id="stack_point" required/>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">~  Down Point</span>
                            </td>
                            <td class="orders-date">
                                <input id="down_point" for="down_point" type="text" placeholder="" class="form-control"
                                      v-model="itemData.down_point" required/>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Number (t)</span></td>
                            <td class="orders-order">
                                <input id="weight" type="text" placeholder="" class="form-control" v-model="itemData.weight"/>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">t     Empty PL</span>
                            </td>
                            <td class="orders-date">
                                <select name="empty_pl" id="empty_pl" v-model="itemData.empty_pl" class="form-control">
                                    <option value=""></option>
                                    <option value="1">Yes</option>
                                    <option value="0">None</option>
                                </select>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Per ton</span></td>
                            <td class="orders-order">
                                <input id="per_ton" type="text" placeholder="" class="form-control" v-model="itemData.item_price"/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen     x</span></td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="x"/>
                            </td>
                            <td class="orders-total"><span class="c25479 text-right">t</span></td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Per vehicle</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="per_vehicle"
                                       v-model="itemData.vehicle_payment"/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen     x</span></td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="x2" />
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Amount of Money</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="amount"
                                       v-model="itemData.down_invoice" readonly/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen</span></td>
                            <td class="orders-date"></td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Vehicle No.</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="vehicle_no"
                                       v-model="itemData.vehicle_no"/>
                            </td>
                            <td class="orders-product text-right"><span class="c24966">Driver Name</span></td>
                            <td class="orders-date">
                                <select name="driver_id" id="driver_id" v-model="itemData.driver_id" class="form-control">
                                    <option value=""></option>
                                    <option v-for="driver in drivers" :value="driver.id">
                                        {{ driver.driver_name }}
                                    </option>
                                </select>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Chartered Vehicle</span></td>
                            <td class="orders-order">
                                <select name="chartered_vehicle" id="chartered_vehicle"
                                        v-model="itemData.item_vehicle" class="form-control">
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                        {{ vehicle.company_name  }}
                                    </option>
                                </select>
                            </td>
                            <td class="orders-product text-right"><span class="c24966">Rental Vehicle <br/>Payment<br/></span>
                            </td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="vehicle_payment"
                                       v-model="itemData.vehicle_payment"/>
                            </td>
                            <td class="orders-total"><span class="c25479 text-right">yen</span></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Remarks</span></td>
                            <td colspan="6" class="orders-order">
                                <textarea rows="3" class="form-control" id="item_remark"
                                          v-model="itemData.item_remark"></textarea>
                            </td>
                            <td class="orders-product"></td>
                            <td class="orders-date"></td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>



    export default {
        props: {
            backUrl: {type: String, required: true},
            shipperUrl: {type: String, required: true},
            driverUrl: {type: String, required: true},
            vehicleUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true},
        },
        data() {
            return {
                itemData: {
                    shipper_id: '',
                    driver_id: '',
                    vehicle_no: '',
                    status: 0,
                    stack_date: '',
                    stack_time: '',
                    down_date: '',
                    down_time: '',
                    down_invoice: '',
                    stack_point: '',
                    down_point: '',
                    weight: '',
                    empty_pl: '',
                    item_price: '',
                    item_driver_name: '',
                    vehicle_no3: '',
                    shipper_name: '',
                    item_vehicle: '',
                    vehicle_payment: '',
                    item_completion_date: '',
                    item_remark: '',
                    delete_flg: '',
                    create_id: '',
                    update_id: '',
                    remember_token:''
                },
                shippers: [],
                drivers: [],
                vehicles: []
            }
        },
        mounted() {
//            alert('Mounted');
            this.fetchShippers(this.shipperUrl);
            this.fetchDrivers(this.driverUrl);
            this.fetchVehicles(this.vehicleUrl);
        },
        methods: {
            clear(){
                alert('clear action');
            },
            fetchShippers(url) {
                axios.get(url)
                    .then(shippers => {
                        this.shippers = shippers.data
                    });
            },
            fetchDrivers(url) {
                axios.get(url)
                    .then(response => {
                        this.drivers = response.data
                    });
            },
            fetchVehicles(url) {
                axios.get(url)
                    .then(response => {
                        this.vehicles = response.data
                    });
            },
            register(){
                console.log("this is data sent ==== " + this.itemData + " == " + this.itemData.item_vehicle);
                console.log("this is url ====" + this.resourceUrl);
                axios.post(this.resourceUrl,this.itemData)
                    .then(function(response){
                        console.log("Insert data success");
                        console.log(response);
                    })
                    .catch(function(error){
                        console.log("Insert data error");
                        console.log(error.response);
                        return false;
                    });
                return true;
            },
        }
    }
</script>
