<template>
    <div>
        <!--form action="#" class="form-inline" @submit.prevent="register"-->
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
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register">Register</button>
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="clear">Clear</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                        <tr></tr>
                        </thead>
                        <tbody class="list">
                        <tr>
                            <td class="orders-order text-right"><span class="c24966">Stack Date</span></td>
                            <td>
                                <select name="stack_date" id="stack_date" v-model="itemData.stack_date"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <td class="text-right"><span class="c25479">Stack Time</span></td>
                            <td class="stack_time_hour">
                                <select name="stack_time_hour" id="stack_time_hour" v-model="itemData.stack_time_hour"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-date">
                                <select name="stack_time_min" id="stack_time_min" v-model="itemData.stack_time_min"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <td class="orders-total"><span class="c25479">Billing</span></td>
                            <td class="orders-status"></td>
                            <td class="orders-method">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="billing"
                                           v-model="itemData.billing">
                                    <label class="custom-control-label" for="billing"></label>
                                </div>
                            </td>
                            <td class="text-right">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Down Date</span></td>
                            <td class="orders-order">
                                <select name="down_date" id="down_date" v-model="itemData.down_date"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">Down Time</span></td>
                            <td class="orders-date">
                                <select name="down_time_hour" id="down_time_hour" v-model="itemData.down_time_hour"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-total">
                                <select name="down_time_min" id="down_time_min" v-model="itemData.down_time_min"
                                        class="form-control" required>
                                    <option value=""></option>
                                </select>
                            </td>
                            <td class="item-status">
                                <div class="badge badge-success"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Vehicle Model</span></td>
                            <td class="orders-order">
                                <select name="item_vehicle" id="item_vehicle" v-model="itemData.item_vehicle"
                                        class="form-control" required>
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.id">
                                        {{ vehicle.company_name }}
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
                                       id="stack_point"/>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">~  Down Point</span>
                            </td>
                            <td class="orders-date">
                                <input id="down_point" for="stack_point" type="text" placeholder="" class="form-control"
                                       required/>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">T numer</span></td>
                            <td class="orders-order">
                                <input id="tnumer" type="text" placeholder="" class="form-control"/>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">t     Empty PL</span>
                            </td>
                            <td class="orders-date">
                                <select name="emptypl" id="emptypl" v-model="itemData.emptypl" class="form-control">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Per ton</span></td>
                            <td class="orders-order">
                                <input id="perton" type="text" placeholder="" class="form-control"/>
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
                                <input type="text" placeholder="" class="form-control" id="pervehicle"/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen     x</span></td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="x2"/>
                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Amount of Money</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="amountofmoney" readonly/>
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
                                <input type="text" placeholder="Default input" class="form-control" id="vehicle_no"/>
                            </td>
                            <td class="orders-product text-right"><span class="c24966">Driver Name</span></td>
                            <td class="orders-date">
                                <select name="driver_id" id="driverid" v-model="itemData.driverid" class="form-control">
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
                                        v-model="itemData.charteredvehicle" class="form-control">
                                    <option value=""></option>
                                    <option v-for="vehicle in vehicles" :value="vehicle.vehicle_id">
                                        {{ vehicle.vehicle_no }}
                                    </option>
                                </select>
                            </td>
                            <td class="orders-product text-right"><span class="c24966">Rental Vehicle <br/>Payment<br/></span>
                            </td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="vehicle_payment"/>
                            </td>
                            <td class="orders-total"><span class="c25479 text-right">yen</span></td>
                            <td class="orders-sratus">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Remarks</span></td>
                            <td colspan="6" class="orders-order">
                                <textarea rows="3" class="form-control" id="remarks"
                                          v-model="itemData.remarks"></textarea>
                            </td>
                            <td class="orders-product"></td>
                            <td class="orders-date"></td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/form-->
    </div>

</template>

<script>
    export default {
        props: {
            backUrl: {type: String, required: true},
            shipperUrl: {type: String, required: true},
            title: {type: String, required: true},
        },
        data() {
            return {
                itemData: {
                    stack_date: '',
                    stack_time_hour: '',
                    stack_time_min: '',
                    billing: '',
                    down_date: '',
                    down_time_hour: '',
                    down_time_min: '',
                    item_vehicle: '',
                    shipper_id: '',
                    emptypl: '',
                    driverid: '',
                    charteredvehicle: '',
                    remarks: '',
                },
                shippers: [],
                drivers: [],
                vehicles: []
            }
        },
        mounted() {
//            alert('Mounted');
            this.fetchShippers(this.shipperUrl);
        },
        methods: {
            register(){
                alert('register');
            },
            clear(){
                alert('clear action');
            },
            fetchShippers(url) {
                axios.get(url)
                    .then(shippers => {
                        this.shippers = shippers.data
                    });
            }
        }
    }
</script>
