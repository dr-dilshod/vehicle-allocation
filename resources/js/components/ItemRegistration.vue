<template>
    <form action="#" class="" @submit.prevent="register">
    <div>
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h6 class="text-center text-danger">* - required</h6>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
                <button type="submit" class="btn btn-lg btn-danger p-1 pl-2 pr-2">{{operation}}</button>
                <button type="reset" class="btn btn-lg btn-danger p-1 pl-4 pr-5" @click.prevent="clear">{{clearing}}</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <br>
                    <table class="table table-sm table-nowrap card-table">
                        <thead>
                         <tr></tr>
                        </thead>
                        <tbody class="list">
                        <tr>
                            <td class="orders-order text-right"><span>Stack Date</span><span class="required"> *</span></td>
                            <td>
                                <div class="input-group">
                                        <input  type="date" placeholder="" class="form-control" for="stack_date"
                                                id="stack_date" v-model="itemData.stack_date" required/>
                                    </div>
                            </td>
                            <td class="text-right"><span class="c25479">Stack Time</span><span class="required"> *</span></td>
                            <td class="stack_time_hour">
                                <select name="stack_time_hour" id="stack_time_hour" v-model="stack_time_hour"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="hour in 23" :value="hour">
                                        {{ hour }}
                                    </option>
                                </select>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-date">
                                <select name="stack_time_min" id="stack_time_min" v-model="stack_time_min"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="min in 59" :value="min">
                                        {{ min }}
                                    </option>
                                </select>
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
                            <td class="text-right"><span class="c24966">Down Date</span><span class="required"> *</span></td>
                            <td class="orders-order">
                                <div class="input-group">
                                    <input type="date" placeholder="" class="form-control" for="down_date"
                                       id="down_date" v-model="itemData.down_date" required/>
                                </div>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">Down Time</span><span class="required"> *</span></td>
                            <td class="orders-date">
                                <select name="down_time_hour" id="down_time_hour" v-model="down_time_hour"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="hour in 23" :value="hour">
                                        {{ hour }}
                                    </option>
                                </select>
                            </td>
                            <th><span class="c25479">:</span></th>
                            <td class="orders-total">
                                <select name="down_time_min" id="down_time_min" v-model="down_time_min"
                                        v-on:input="timeFormatter" class="form-control" required>
                                    <option v-for="min in 59" :value="min">
                                        {{ min }}
                                    </option>
                                </select>
                            </td>
                            <td class="item-status">
                                <div class="badge badge-success"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Vehicle Model</span><span class="required"> *</span></td>
                            <td class="orders-order">
                                <select name="item_vehicle" id="item_vehicle" v-model="itemData.item_vehicle"
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
                            <td class="text-right"><span class="c24966">Shipper</span><span class="required"> *</span></td>
                            <td class="orders-order">
                                <select name="shipper" id="shipper_id" v-model="itemData.shipper_id"
                                        class="form-control" v-on:change="setShipperName" required>
                                    <option value=""></option>
                                    <option v-for="shipper in shippers" :value="shipper.shipper_id">
                                        {{ shipper.shipper_name1 + " " + shipper.shipper_name2}}
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
                            <td class="text-right"><span class="c24966">Stack Point</span><span class="required"> *</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" for="stack_point"
                                       v-model="itemData.stack_point" id="stack_point" required/>
                            </td>
                            <td class="orders-product text-right"><span class="c25479 text-right">~  Down Point</span>
                                <span class="required"> *</span>
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
                                <input id="per_ton" type="text" placeholder="" class="form-control"
                                       v-on:input="perTonChange" v-model="per_ton"/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen     x</span></td>
                            <td class="orders-date">
                                <input type="text" placeholder="" class="form-control" id="ton"
                                       v-on:input="perTonChange" v-model="ton" value=""/>
                            </td>
                            <td class="orders-total"><span class="c25479 text-right">t</span></td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Per vehicle</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="per_vehicle"
                                       v-on:input="perVehicleChange" :disabled="isDisabled" v-model="per_vehicle"/>
                            </td>
                            <td class="orders-product"><span class="c25479 text-right">yen</span></td>
                            <td class="orders-date">

                            </td>
                            <td class="orders-total"></td>
                            <td class="orders-status">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><span class="c24966">Amount of Money</span></td>
                            <td class="orders-order">
                                <input type="text" placeholder="" class="form-control" id="item_price"
                                       v-model="itemData.item_price" value="" readonly/>
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
                                <select name="driver_id" id="driver_id" v-on:change="setDriverName"
                                        v-model="itemData.driver_id" class="form-control">
                                    <option value=""></option>
                                    <option v-for="driver in drivers" :value="driver.driver_id">
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
                                        v-model="itemData.vehicle_no" class="form-control">
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
                </div>
            </div>
        </div>
    </div>
    </form>
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
            operation: {type: String, required: true},
            clearing: {type: String, required: true},
            item_id: {type: String},
        },
        data() {
            return {
                itemData: {
                    item_id: '',
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
                    delete_flg: 0,
                    create_id: '',
                    update_id: '',
                    remember_token:'',
                },
                isDisabled: false,
                shippers: [],
                drivers: [],
                vehicles: [],
                per_ton: '',
                per_vehicle: '',
                ton: '',
                stack_time_hour: '',
                stack_time_min: '',
                down_time_hour: '',
                down_time_min: ''
            }
        },
        mounted() {
            this.fetchShippers(this.shipperUrl);
            this.fetchDrivers(this.driverUrl);
            this.fetchVehicles(this.vehicleUrl);
            this.isEdit(this.resourceUrl);
        },

        methods: {
            isEdit(url){
                axios.get(url + "/" + new URL(location.href).searchParams.get('item_id'))
                    .then(response => {
                        alert(response.data.data);
                        this.itemData = response.data;
                    })
            },
            setDriverName() {
                for (let i = 0; i < this.drivers.length; i++) {
                    if(this.itemData.driver_id === this.drivers[i].driver_id){
                        this.itemData.item_driver_name = this.drivers[i].driver_name;
                        this.itemData.vehicle_no3 = this.drivers[i].vehicle_no3;
                    }
                }
            },
            setShipperName() {
                for (let i = 0; i < this.shippers.length; i++) {
                    if(this.itemData.shipper_id === this.shippers[i].shipper_id){
                        this.itemData.shipper_name = this.shippers[i].shipper_name1 + " " + this.shippers[i].shipper_name2;
                    }
                }
            },
            fetchCurrentDate(){
                let currentDate = new Date();
                this.itemData.item_completion_date = currentDate;
            },
            perTonChange() {
                if ((this.per_ton == '')
                    && (this.ton == '')) {
                    document.getElementById('per_vehicle').disabled = false;
                } else {
                    document.getElementById('per_vehicle').disabled = true;
                    if (this.ton == '') {
                        this.ton = 1;
                        this.itemData.item_price = this.per_ton;
                    } else {
                        this.itemData.item_price = this.per_ton * this.ton;
                    }
                }
            },
            perVehicleChange() {
                if (this.per_vehicle == '') {
                    document.getElementById('per_ton').disabled = false;
                    document.getElementById('ton').disabled = false;
                } else {
                    document.getElementById('per_ton').disabled = true;
                    document.getElementById('ton').disabled = true;
                    this.itemData.item_price = this.per_vehicle;
                }
            },
            timeFormatter() {
                this.itemData.stack_time = document.getElementById('stack_time_hour').value
                    + ':' + document.getElementById('stack_time_min').value
                    + ':00';
                this.itemData.down_time = document.getElementById('down_time_hour').value
                    + ':' + document.getElementById('down_time_min').value
                    + ':00';
            },
            clear(){
                this.itemData.shipper_id = '',
                this.itemData.driver_id = '',
                this.itemData.vehicle_no = '',
                this.itemData.stack_date = '',
                this.itemData.stack_time = '',
                this.itemData.down_date = '',
                this.itemData.down_time = '',
                this.itemData.down_invoice = '',
                this.itemData.stack_point = '',
                this.itemData.down_point = '',
                this.itemData.weight = '',
                this.itemData.empty_pl = '',
                this.itemData.item_price = '',
                this.itemData.item_driver_name = '',
                this.itemData.vehicle_no3 = '',
                this.itemData.shipper_name = '',
                this.itemData.item_vehicle = '',
                this.itemData.vehicle_payment = '',
                this.itemData.item_completion_date = '',
                this.itemData.item_remark = '',
                this.itemData.remember_token = '',
                this.per_ton = '',
                this.per_vehicle = '',
                this.ton = '',
                this.stack_time_hour = '',
                this.stack_time_min = '',
                this.down_time_hour = '',
                this.down_time_min = ''
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
                const itemRegistration = this;
                axios.post(this.resourceUrl,this.itemData)
                    .then(function(response){
                        console.log("Insert data success");
                        this.$alert("Creation Successful!");
                        window.location.href = '/item';
                    })
                    .catch(function(error){
                        itemRegistration.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            updateItem(item){
                let id = item.item_id;
                const itemRegistration = this;
                axios.put(this.resourceUrl+'/'+id, item)
                    .then(function(response){
                        this.$alert('Update is successful!');
                        window.location.href = '/item';
                    })
                    .catch(function(error){
                        itemRegistration.showDialog(error.response.data);
                    });
            },
            deleteItem(item_id){
                const itemRegistration = this;
                axios.delete(this.resourceUrl+'/'+item_id)
                    .then(function(response){
                        this.$alert('Deletion is successful!');;
                    })
                    .catch(function(error){
                        itemRegistration.showDialog(error.response.data);
                        return false;
                    });
                return true;
            },
            showDialog(response) {
                let message = response.message + ': ';
                let errors = response.errors;
                $.each( errors, function( key, value ) {
                    message += value[0]; //showing only the first error.
                });
                this.$alert(message);
            },
        }
    }
</script>
<style>
    .required {
        color: red;
    }
</style>
